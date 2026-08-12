export default class ArchiveMap {
	constructor({
		mapElId = 'community-map',
		dataKey = 'communityMapMarkers',
	} = {}) {
		this.mapElId = mapElId;
		this.dataKey = dataKey;

		this.map = null;
		this.markers = [];
		this.markersById = new Map();
		this.popupOverlay = null;
		this.isInitialized = false;

		this.handleMapFocusClick =
			this.handleMapFocusClick.bind(this);

		this.handleArchiveViewChange =
			this.handleArchiveViewChange.bind(this);
	}

	init() {
		if (this.isInitialized) {
			return;
		}

		const mapElement = document.getElementById(this.mapElId);

		if (!mapElement) {
			return;
		}

		if (!window.google?.maps) {
			console.error('Google Maps API is not loaded.');

			return;
		}

		const mapData = window[this.dataKey] || {};

		const markerData = Array.isArray(mapData)
			? mapData
			: mapData.markers || [];

		this.map = new window.google.maps.Map(mapElement, {
			center: {
				lat: 39.7392,
				lng: -104.9903,
			},
			zoom: 10,
			mapTypeControl: false,
			streetViewControl: false,
			fullscreenControl: false,
			mapTypeId: 'terrain',
			gestureHandling: 'cooperative',
		});

		this.isInitialized = true;

		this.updateMarkers(markerData);

		document.addEventListener(
			'click',
			this.handleMapFocusClick
		);

		document.addEventListener(
			'archive:view-change',
			this.handleArchiveViewChange
		);
	}

	handleArchiveViewChange(event) {
		const view = event.detail?.view;

		if (view === 'list') {
			this.closePopup();

			return;
		}

		if (view !== 'map' || !this.map) {
			return;
		}

		window.requestAnimationFrame(() => {
			window.google.maps.event.trigger(
				this.map,
				'resize'
			);

			this.fitMapToMarkers();
		});
	}

	handleMapFocusClick(event) {
		const focusButton = event.target.closest(
			'.js-map-focus'
		);

		if (!focusButton) {
			return;
		}

		const card = focusButton.closest('.js-map-card');
		const itemId = card?.dataset.id;

		if (
			!itemId
			|| !this.markersById.has(String(itemId))
		) {
			return;
		}

		event.preventDefault();
		event.stopPropagation();

		this.focusMarker(itemId);
	}

	async focusMarker(itemId) {
		const marker = this.markersById.get(
			String(itemId)
		);

		if (!marker || !this.map) {
			return;
		}

		const mapElement = document.getElementById(
			this.mapElId
		);

		if (!mapElement) {
			return;
		}

		const archiveView = mapElement.closest(
			'.js-archive-view'
		);

		if (archiveView) {
			archiveView.dataset.view = 'map';

			archiveView
				.querySelectorAll('.js-view-toggle')
				.forEach((toggle) => {
					toggle.setAttribute(
						'aria-label',
						'Show list view'
					);

					toggle.setAttribute(
						'aria-pressed',
						'true'
					);
				});
		}

		await this.waitForVisibleMap(mapElement);

		window.google.maps.event.trigger(
			this.map,
			'resize'
		);

		await this.nextFrame();
		await this.nextFrame();

		/*
		 * Не центруємо кожен маркер примусово.
		 * Якщо він уже видимий — popup відкриється
		 * саме у його поточній позиції.
		 */
		const mapBounds = this.map.getBounds();
		const markerPosition = marker.getPosition();

		if (
			markerPosition
			&& (
				!mapBounds
				|| !mapBounds.contains(markerPosition)
			)
		) {
			const mapSettled = this.waitForMapIdle();

			this.map.panTo(markerPosition);

			await mapSettled;
		}

		this.showPopup(
			marker,
			marker.communityData
		);

		mapElement.scrollIntoView({
			behavior: 'smooth',
			block: 'center',
		});
	}

	waitForVisibleMap(mapElement, maxFrames = 40) {
		return new Promise((resolve) => {
			let frame = 0;

			const checkSize = () => {
				const rect =
					mapElement.getBoundingClientRect();

				const isVisible =
					rect.width > 100
					&& rect.height > 100;

				if (isVisible || frame >= maxFrames) {
					resolve();

					return;
				}

				frame += 1;

				window.requestAnimationFrame(checkSize);
			};

			window.requestAnimationFrame(checkSize);
		});
	}

	waitForMapIdle(timeout = 450) {
		return new Promise((resolve) => {
			let resolved = false;

			const finish = () => {
				if (resolved) {
					return;
				}

				resolved = true;

				if (listener) {
					window.google.maps.event.removeListener(
						listener
					);
				}

				window.clearTimeout(timer);
				resolve();
			};

			const listener =
				window.google.maps.event.addListenerOnce(
					this.map,
					'idle',
					finish
				);

			const timer = window.setTimeout(
				finish,
				timeout
			);
		});
	}

	nextFrame() {
		return new Promise((resolve) => {
			window.requestAnimationFrame(resolve);
		});
	}

	showPopup(marker, item) {
		if (!this.map || !marker) {
			return;
		}

		this.closePopup();

		const popupContent =
			this.createPopupContent(item);

		this.popupOverlay =
			this.createPopupOverlay(
				marker.getPosition(),
				popupContent,
				(container) => {
					this.keepPopupInsideMap(container);

					const image =
						container.querySelector('img');

					if (image && !image.complete) {
						image.addEventListener(
							'load',
							() => {
								this.popupOverlay?.draw?.();

								window.requestAnimationFrame(
									() => {
										this.keepPopupInsideMap(
											container
										);
									}
								);
							},
							{
								once: true,
							}
						);
					}
				}
			);

		this.popupOverlay.setMap(this.map);
	}

	createPopupContent(item) {
		const title = this.escapeHtml(
			item.title || ''
		);

		const city = this.escapeHtml(
			item.city || ''
		);

		const price = this.escapeHtml(
			item.price || ''
		);

		const link = this.escapeHtml(
			item.link || '#'
		);

		const image = item.image
			? `
				<img
					src="${this.escapeHtml(item.image)}"
					alt="${title}"
				>
			`
			: '';

		const popup = document.createElement('div');

		popup.className = 'community-map-popup';

		/*
		 * Знімаємо стилі, які могли залишитися
		 * від стандартного Google InfoWindow.
		 */
		Object.assign(popup.style, {
			position: 'relative',
			width: '100%',
			maxWidth: '100%',
			margin: '0',
			left: 'auto',
			right: 'auto',
			top: 'auto',
			bottom: 'auto',
			transform: 'none',
			boxSizing: 'border-box',
		});

		popup.innerHTML = `
			${image}

			<div class="community-map-popup__content">
				<h3>${title}</h3>

				${city
					? `<p class="city">${city}</p>`
					: ''
				}

				${price
					? `<p class="price">${price}</p>`
					: ''
				}

				<a
					href="${link}"
					class="link"
					aria-label="View ${title}"
				></a>
			</div>
			<div class="gm-style">
				<div class="gm-style-iw-tc"></div>
			</div>
		`;

		return popup;
	}

	createPopupOverlay(
	position,
	popupContent,
	onFirstDraw
) {
	const overlay = new window.google.maps.OverlayView();

	const container = document.createElement('div');

	container.className = 'community-map-overlay';

	Object.assign(container.style, {
		position: 'absolute',
		boxSizing: 'border-box',
		pointerEvents: 'auto',
		visibility: 'hidden',
		zIndex: '10',
		willChange: 'transform',
		overflow: 'visible',
	});

	const pointer = document.createElement('span');

	pointer.className = 'community-map-overlay__pointer';
	pointer.setAttribute('aria-hidden', 'true');

	container.appendChild(popupContent);
	container.appendChild(pointer);

	let firstDrawCompleted = false;

	overlay.onAdd = () => {
		const panes = overlay.getPanes();

		if (!panes) {
			return;
		}

		panes.floatPane.appendChild(container);

		window.google.maps.OverlayView
			.preventMapHitsAndGesturesFrom(container);
	};

	overlay.draw = () => {
		const projection = overlay.getProjection();

		if (!projection || !this.map) {
			return;
		}

		const point = projection.fromLatLngToDivPixel(
			position
		);

		if (!point) {
			return;
		}

		const mapElement = this.map.getDiv();
		const mapWidth = mapElement.clientWidth;

		if (mapWidth <= 0) {
			container.style.visibility = 'hidden';
ф
			return;
		}

		const sidePadding = 16;

		const popupWidth = Math.min(
			320,
			Math.max(
				200,
				mapWidth - sidePadding * 2
			)
		);

		container.style.width = `${popupWidth}px`;

		const actualWidth = container.offsetWidth;
		const actualHeight = container.offsetHeight;

		/*
		 * Картка розташована зліва і трохи вище
		 * від координати маркера.
		 *
		 * Нижній правий кут картки направлений
		 * у бік маркера.
		 */
		const horizontalGap = 22;
		const verticalGap = 42;

		const left =
			point.x
			- actualWidth
			- horizontalGap;

		const top =
			point.y
			- actualHeight
			- verticalGap;

		container.style.transform = `
			translate3d(
				${Math.round(left)}px,
				${Math.round(top)}px,
				0
			)
		`;

		container.style.visibility = 'visible';

		if (
			!firstDrawCompleted
			&& typeof onFirstDraw === 'function'
		) {
			firstDrawCompleted = true;

			window.requestAnimationFrame(() => {
				onFirstDraw(container);
			});
		}
	};

	overlay.onRemove = () => {
		container.remove();
	};

	return overlay;
}

	keepPopupInsideMap(container) {
		if (
			!container?.isConnected
			|| !this.map
		) {
			return;
		}

		const mapElement = this.map.getDiv();

		const mapRect =
			mapElement.getBoundingClientRect();

		const popupRect =
			container.getBoundingClientRect();

		const padding = 16;

		const minLeft = mapRect.left + padding;
		const maxRight = mapRect.right - padding;
		const minTop = mapRect.top + padding;
		const maxBottom = mapRect.bottom - padding;

		let panX = 0;
		let panY = 0;

		/*
		 * Не рухаємо popup окремо.
		 * Рухаємо карту, тому popup залишається
		 * над своїм маркером.
		 */
		if (popupRect.left < minLeft) {
			panX = popupRect.left - minLeft;
		} else if (popupRect.right > maxRight) {
			panX = popupRect.right - maxRight;
		}

		if (popupRect.top < minTop) {
			panY = popupRect.top - minTop;
		} else if (popupRect.bottom > maxBottom) {
			panY = popupRect.bottom - maxBottom;
		}

		if (panX === 0 && panY === 0) {
			return;
		}

		this.map.panBy(
			Math.round(panX),
			Math.round(panY)
		);
	}

	closePopup() {
		if (!this.popupOverlay) {
			return;
		}

		this.popupOverlay.setMap(null);
		this.popupOverlay = null;
	}

	updateMarkers(markerData = []) {
		if (!this.map) {
			return;
		}

		this.clearMarkers();

		const bounds =
			new window.google.maps.LatLngBounds();

		markerData.forEach((item) => {
			const lat = Number.parseFloat(item.lat);
			const lng = Number.parseFloat(item.lng);

			if (
				!Number.isFinite(lat)
				|| !Number.isFinite(lng)
			) {
				return;
			}

			const position = {
				lat,
				lng,
			};

			const marker =
				new window.google.maps.Marker({
					position,
					map: this.map,
					title: item.title || '',
					icon: {
						url: `${window.site.theme_url}/assets/icons/pin.svg`,
						scaledSize:
							new window.google.maps.Size(
								26,
								33
							),
						anchor:
							new window.google.maps.Point(
								13,
								33
							),
					},
				});

			marker.communityData = item;

			if (
				item.id !== undefined
				&& item.id !== null
			) {
				this.markersById.set(
					String(item.id),
					marker
				);
			}

			marker.addListener('click', () => {
				this.showPopup(marker, item);
			});

			this.markers.push(marker);
			bounds.extend(position);
		});

		if (this.markers.length === 1) {
			this.map.setCenter(
				this.markers[0].getPosition()
			);

			this.map.setZoom(13);

			return;
		}

		if (this.markers.length > 1) {
			this.map.fitBounds(bounds);
		}
	}

	fitMapToMarkers() {
		if (!this.map || this.markers.length === 0) {
			return;
		}

		this.closePopup();

		if (this.markers.length === 1) {
			this.map.setCenter(
				this.markers[0].getPosition()
			);

			this.map.setZoom(13);

			return;
		}

		const bounds =
			new window.google.maps.LatLngBounds();

		this.markers.forEach((marker) => {
			bounds.extend(marker.getPosition());
		});

		this.map.fitBounds(bounds);
	}

	clearMarkers() {
		this.closePopup();

		this.markers.forEach((marker) => {
			marker.setMap(null);
		});

		this.markers = [];
		this.markersById.clear();
	}

	escapeHtml(value) {
		const element =
			document.createElement('div');

		element.textContent = String(value);

		return element.innerHTML;
	}
}