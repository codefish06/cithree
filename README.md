## Overview
This is a CodeIgniter 3 playground project designed for development and testing purposes. It contains the full CodeIgniter framework structure with application and system directories.

## Project Structure

```
cithree/
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
- Composer (for dependency management)

## Getting Started

1. Clone or download this repository
2. Configure your web server to point to the project root
3. Update `application/config/config.php` and `application/config/database.php` as needed
4. Start building your application in the `application/` directory

## License

CodeIgniter is released under the MIT License. See LICENSE.txt for details.

## Resources

- [CodeIgniter User Guide](https://codeigniter.com/userguide3/)
- [CodeIgniter Forum](http://forum.codeigniter.com/)
- [GitHub Repository](https://github.com/bcit-ci/CodeIgniter)
