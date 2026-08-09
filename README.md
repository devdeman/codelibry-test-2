# Codelibry Test 2

WordPress test project.

## Database

Database dump:

`database/database.sql`

Local database configuration:

- Database: `codelibry2`
- User: `codelibry2`
- Host: `localhost`
- Password: `666`

## Installation

1. Clone the repository.
2. Create a local MySQL database named `codelibry2`.
3. Import the database:

    mysql -u codelibry2 -p codelibry2 < database/database.sql

4. Create `wp-config.php` using `wp-config-sample.php`.
5. Add the database credentials.
6. Update the local site URL if necessary.

## Notes

`wp-config.php` is intentionally excluded from Git.
