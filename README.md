## Overview
This is a CodeIgniter 3 playground project. It runs directly from the repository root with PHP's built-in server and serves its CSS, JavaScript, and vendored browser assets from `application/assets/`.

## Local Run

### Requirements

- PHP 5.6+ for the application runtime
- A configured database only if you are using DB-backed routes

### Start The App

From the repository root:

```bash
php -S 127.0.0.1:8000
```

Then open:

```text
http://127.0.0.1:8000/
```

This repo keeps `index.php` in generated URLs, so existing controller routes continue to work with the built-in server, for example:

```text
http://127.0.0.1:8000/index.php/vendor/select2
```

## Configuration

Update the files in `application/config/` as needed:

- `config.php`: in `development`, `base_url` is derived from the current request host so local runs work without manual edits
- `database.php`: configure credentials if the route you are testing uses the database

CodeIgniter Composer autoloading is currently disabled via `$config['composer_autoload'] = FALSE`, so Composer packages are not required to boot the app.

## Assets

- Primary stylesheet: `application/assets/css/output.css`
- Layout stylesheet: `application/assets/css/grid-layout.css`
- Vendored browser assets: `application/assets/vendor/`

The app uses hand-maintained CSS and checked-in frontend vendor files. Node.js is not required for local development or runtime.

## Optional Composer Tooling

`composer.json` is present for framework and dev tooling, not for normal local app startup. You only need `composer install` if you specifically want those Composer-managed tools.

## Project Structure

```text
application/   Application code, assets, views, controllers, models, config
system/        CodeIgniter 3 framework code
index.php      Front controller
composer.json  Optional Composer/dev tooling metadata
README.md      Project documentation
```

## Resources

- [CodeIgniter User Guide](https://codeigniter.com/userguide3/)
- [CodeIgniter GitHub Repository](https://github.com/bcit-ci/CodeIgniter)
