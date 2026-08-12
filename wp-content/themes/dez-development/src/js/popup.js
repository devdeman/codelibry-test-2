/*
 * Popup
 */
function InitPopups() {

  class Popup {
    constructor(el){
      this.query(el);
      this.events();
    }

    query(el) {
      this.popup = el;
      this.closeButton = el.querySelector('.popup__close');
      this.buttons = [...document.querySelectorAll(`a[href="#${el.id}"]`)];
    }

    events() {
      this.buttons.forEach(button => button.addEventListener('click', () => this.popup.showModal()));
      this.closeButton.addEventListener('click', () => this.popup.close());
    }
  }

  window.popups = [];

  document.querySelectorAll('dialog').forEach((el) => {
    window.popups.push(new Popup(el));
  });

  // Open popup if there error and to keep open on page refresh
  window.addEventListener('load', () => {
    const hash = window.location.hash;
    if (hash && hash.startsWith('#')) {
      const popup = document.querySelector(hash);
      if (popup && typeof popup.showModal === 'function') {
        setTimeout(() => popup.showModal(), 150);
      }
    }
  });
}

export default InitPopups;