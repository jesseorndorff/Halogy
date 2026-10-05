# Halogy

Halogy is a content management system built on CodeIgniter 2.1, originally developed by Haloweb around 2011. It features Markdown content blocks, inline editing, template tags, and a suite of built-in modules: pages, blog, events, shop, forums, wiki, community, webforms, files/images, users, and multi-site management. This fork updates it to run on current PHP and MySQL/MariaDB versions.

> **Warning: Legacy Software**
>
> This is a legacy, unmaintained codebase running on a patched CodeIgniter 2.1 core. It is not recommended for production use or anything internet-facing. Use this project to explore or preserve a historical CMS. For new projects, consider modern alternatives.

## Requirements

- PHP 8.1 or later (tested on PHP 8.3) with extensions: mysqli, gd, zip, mbstring
- MariaDB 10.x or MySQL 8.x configured with `sql_mode` allowing zero dates (no strict mode)
- Apache with mod_rewrite enabled, or any server configured to rewrite requests to index.php

## Quick Start with Docker

The easiest way to run Halogy is with Docker:

```bash
docker compose up --build
```

Once running:
- Open the site at http://localhost:8080
- Access the admin panel at http://localhost:8080/admin
- Log in with username `superuser` and password `super123`
- **Change the password immediately** after first login

Uploads are stored in the `uploads` named volume and the database in `db_data`. Run `docker compose down` to stop services and preserve both volumes, or `docker compose down -v` to delete them. The compose file runs with `HALOGY_ENV=development` (all PHP errors shown); switch to `production` for anything beyond local exploration.

The image generates its own encryption key (used to sign session and remember-me cookies) at build time; set `HALOGY_ENCRYPTION_KEY` to override it, and note that rebuilding the image generates a new key and logs everyone out unless that variable is set.

## Manual Installation

If not using Docker:

1. Copy all files to your web root (including `index.php`, `.htaccess`, `halogy/`, and `static/`)
2. Create a database and import `halogy_sql_dump.sql`
3. Set the environment variables or edit `halogy/config/database.php`:
   - `HALOGY_DB_HOST`: database hostname
   - `HALOGY_DB_USER`: database user
   - `HALOGY_DB_PASS`: database password
   - `HALOGY_DB_NAME`: database name
4. Set `HALOGY_ENCRYPTION_KEY` (used to sign session and remember-me cookies). Generate a key with `php -r "echo bin2hex(random_bytes(32));"` and set it as an environment variable, or make `halogy/config` writable by the web server so the app can create `halogy/config/encryption_key.php` on first request.
5. Make `static/uploads` (and its subfolders) writable by the web server user: `chown -R www-data:www-data static/uploads`
6. (Optional) For security, move `halogy/` outside the web root to a parent directory or code repository, then update the `$application_folder` variable in `index.php` to point to it using a full server path (e.g., `$application_folder = '/var/www/halogy'`)
7. `HALOGY_ENV` defaults to `production` (hides PHP and database errors); set `HALOGY_ENV=development` to show them while developing

## Upgrading from Halogy 1.x

To upgrade an existing Halogy 1.x installation:

1. Back up your database and files
2. Replace your files with version 2.0.0
3. Run `halogy/sql/upgrade-2.0.sql` against your database to add the new `pages_navigation` permission and widen the `password` column
4. Set `HALOGY_ENCRYPTION_KEY` or make `halogy/config` writable so the app can generate it
5. Update `halogy/config/database.php` to use the `mysqli` driver and environment variables
6. All users will be logged out once (session and cookie formats have changed); they will log in again with their existing password
7. Grant the new `pages_navigation` permission to admin groups that need access to the navigation editor

See CHANGELOG.TXT for full upgrade details and known limitations.

## Extending

Halogy uses the HMVC pattern: custom modules are mini-applications placed in `halogy/modules/`. See the CodeIgniter 2 documentation for details on building modules. Access them via `yoursite.com/modulename`.

## License

See LICENSE.txt for details.

## What Changed in This Fork

- PHP 8.1-8.4 support (tested on 8.3) with MariaDB 10.x / MySQL 8
- Security hardening: password_hash() with auto-upgrade of MD5, signed session/remember-me tokens, CSRF protection, HttpOnly/SameSite cookies, signed encryption key
- Fixed hundreds of PHP 8 runtime errors across all modules
- Docker setup for one-command local development
- Environment-based database configuration

Full details, upgrade steps and known limitations: see CHANGELOG.TXT.
