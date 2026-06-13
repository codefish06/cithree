# Repository Guidelines

## Project Structure & Module Organization
This repository is a CodeIgniter 3 application. Put application code in `application/` and treat `system/` as framework code that should stay unchanged unless you are intentionally patching CodeIgniter itself. Core MVC files live in `application/controllers/`, `application/models/`, and `application/views/`. Frontend assets live in `application/assets/` with CSS in `application/assets/css/`, JavaScript in `application/assets/js/`, and copied vendor files in `application/assets/vendor/`.

## Build, Test, and Development Commands
- `composer install`: install PHP dependencies.
- `npm install`: install frontend packages used for vendor asset copies.
- `npm run copy-asset:jquery`: copy jQuery into `application/assets/vendor/jquery`.
- `npm run copy-asset:select2`: copy Select2 into `application/assets/vendor/select2`.
- `npm run build:css`: confirms the CSS workflow; styles are edited directly, not compiled.
- `php -S 127.0.0.1:8000`: run a simple local PHP server from the repo root.

Update `application/config/config.php` and `application/config/database.php` for local setup before running the app.

## Coding Style & Naming Conventions
Match the surrounding file style instead of forcing one global formatter. Existing PHP files use CodeIgniter conventions: controller classes such as `Appearance` and `Content_block` extend `CI_Controller`, and view files stay lowercase in `application/views/`. JavaScript in `application/assets/js/` currently uses plain browser APIs and self-contained files. CSS is hand-maintained in `application/assets/css/output.css` and `grid-layout.css`; do not introduce Tailwind-specific build steps.

## Testing Guidelines
There is no active app-level automated test suite in this repository. `npm test` is a placeholder and currently fails by design. If you add tests, keep them isolated, document how to run them, and prefer framework-appropriate PHP tests over ad hoc scripts. At minimum, manually verify the affected route, layout, and asset behavior in the browser before opening a PR.

## Commit & Pull Request Guidelines
Recent history uses Conventional Commit prefixes such as `feat:` and `refactor:`. Follow that pattern with short, imperative subjects, for example `feat: add appearance theme toggle`. Pull requests should include a concise summary, note any config or asset-copy steps, link related issues when applicable, and include screenshots for UI changes.

## Configuration & Safety
Do not commit secrets or environment-specific credentials. Avoid editing generated cache/log files in `application/cache/` and `application/logs/`. Keep vendor updates deliberate and note any copied asset changes in the PR.
