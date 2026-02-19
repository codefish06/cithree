## Overview
This is a CodeIgniter 3 playground project designed for development and testing purposes. It contains the full CodeIgniter framework structure with application and system directories.

## Project Structure

```
Coal/
├── application/              # Your application code
│   ├── cache/               # Cached data storage
│   ├── config/              # Configuration files
│   ├── controllers/         # Application controllers
│   ├── core/                # Core custom classes
│   ├── helpers/             # Custom helper functions
│   ├── hooks/               # Application hooks
│   ├── language/            # Language files
│   ├── libraries/           # Custom libraries
│   ├── logs/                # Application logs
│   ├── models/              # Data models
│   ├── third_party/         # Third-party libraries
│   └── views/               # View templates
│
├── system/                   # CodeIgniter framework (do not modify)
│   ├── core/                # Core framework classes
│   │   ├── Benchmark.php
│   │   ├── CodeIgniter.php
│   │   ├── Common.php
│   │   ├── Config.php
│   │   ├── Controller.php
│   │   ├── Exceptions.php
│   │   ├── Hooks.php
│   │   ├── Input.php
│   │   ├── Lang.php
│   │   ├── Loader.php
│   │   ├── Log.php
│   │   ├── Model.php
│   │   ├── Output.php
│   │   ├── Router.php
│   │   ├── Security.php
│   │   ├── URI.php
│   │   ├── Utf8.php
│   │   └── compat/          # Compatibility layer
│   │
│   ├── database/            # Database library
│   │   ├── DB_cache.php
│   │   ├── DB_driver.php
│   │   ├── DB_forge.php
│   │   ├── DB_query_builder.php
│   │   ├── DB_result.php
│   │   ├── DB_utility.php
│   │   ├── DB.php
│   │   └── drivers/         # Database drivers
│   │
│   ├── fonts/               # Font files
│   │
│   ├── helpers/             # Framework helpers
│   │   ├── array_helper.php
│   │   ├── captcha_helper.php
│   │   ├── cookie_helper.php
│   │   ├── date_helper.php
│   │   ├── directory_helper.php
│   │   ├── download_helper.php
│   │   ├── email_helper.php
│   │   ├── file_helper.php
│   │   ├── form_helper.php
│   │   ├── html_helper.php
│   │   ├── inflector_helper.php
│   │   ├── language_helper.php
│   │   ├── number_helper.php
│   │   ├── path_helper.php
│   │   ├── security_helper.php
│   │   ├── smiley_helper.php
│   │   ├── string_helper.php
│   │   ├── text_helper.php
│   │   ├── typography_helper.php
│   │   ├── url_helper.php
│   │   └── xml_helper.php
│   │
│   ├── language/            # Language files
│   │   └── english/
│   │
│   └── libraries/           # Framework libraries
│       ├── Calendar.php
│       ├── Cart.php
│       ├── Driver.php
│       ├── Email.php
│       ├── Encrypt.php
│       ├── Encryption.php
│       ├── Form_validation.php
│       ├── Ftp.php
│       ├── Image_lib.php
│       ├── Javascript.php
│       ├── Migration.php
│       ├── Pagination.php
│       ├── Parser.php
│       ├── Profiler.php
│       ├── Table.php
│       ├── Trackback.php
│       ├── Typography.php
│       ├── Unit_test.php
│       ├── Upload.php
│       ├── User_agent.php
│       ├── Xmlrpc.php
│       ├── Xmlrpcs.php
│       ├── Zip.php
│       ├── Cache/
│       ├── Javascript/
│       └── Session/
│
├── composer.json            # Composer configuration
├── index.php               # Application entry point
├── LICENSE.txt             # License information
├── README.md               # This file
└── readme.rst              # CodeIgniter documentation
```

## Key Directories

### Application Directory (`application/`)
Contains your custom application code:
- **config/**: Configuration files for your application
- **controllers/**: MVC controllers
- **models/**: Data models
- **views/**: View templates
- **libraries/**: Custom libraries for your application
- **helpers/**: Custom helper functions
- **cache/**: Cache storage
- **logs/**: Application logs

### System Directory (`system/`)
CodeIgniter framework files. Typically not modified during development.

## Requirements

- PHP version 5.6 or newer (5.3.7+ minimum, though older versions have security risks)
- Web server (Apache, Nginx, etc.)
- Node.js (v14+) and npm (for Tailwind CSS and frontend tools)
- Composer (for PHP dependency management)

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/codefish06/cithree.git
cd Coal
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Build Tailwind CSS

For production build:
```bash
npm run build:css
```

For development with watch mode (recompiles on file changes):
```bash
npm run watch:css
```

### 5. Configure Your Environment

Update the following configuration files in `application/config/`:
- `config.php` - Set `base_url` to your local environment
- `database.php` - Configure your database connection

### 6. Set Up Web Server

Configure your web server (Apache/Nginx) to point to the project root directory.

### 7. Start Development

- Access your application at `http://localhost/coal/` (adjust based on your setup)
- Keep the Tailwind CSS watch process running: `npm run watch:css`
- Modify views and Tailwind classes as needed

## Project Dependencies

### Node Packages (Frontend)
- **tailwindcss** (^4.1.18) - Utility-first CSS framework
- **jquery** (^4.0.0) - JavaScript library
- **select2** (^4.1.0-rc.0) - jQuery plugin for enhanced select boxes

### Scripts

- `npm run build:css` - Compiles Tailwind CSS from `application/assets/css/input.css` to `application/assets/css/output.css`
- `npm run watch:css` - Watches for CSS changes and automatically recompiles
- `npm run copy-asset:select2` - Copies Select2 vendor files to assets
- `npm run copy-asset:jquery` - Copies jQuery vendor files to assets

## Tailwind CSS Integration

This project uses **Tailwind CSS v4** for styling. The configuration is handled through:

- **Input file**: `application/assets/css/input.css`
- **Output file**: `application/assets/css/output.css` (compiled)
- **Config file**: `tailwind.config.js` (root directory)

All views are styled using Tailwind utility classes instead of inline CSS.

## Getting Started

1. Clone or download this repository (see Installation & Setup section above)
2. Install dependencies: `npm install` and `composer install`
3. Build CSS: `npm run build:css`
4. Configure your web server to point to the project root
5. Update `application/config/config.php` and `application/config/database.php` as needed
6. Start the Tailwind watch process: `npm run watch:css` (optional, for development)
7. Begin building your application in the `application/` directory

## License

CodeIgniter is released under the MIT License. See LICENSE.txt for details.

## Resources

- [CodeIgniter User Guide](https://codeigniter.com/userguide3/)
- [CodeIgniter Forum](http://forum.codeigniter.com/)
- [GitHub Repository](https://github.com/bcit-ci/CodeIgniter)
