# Sd_RequestLogger

Magento 2 module that logs API request/response payloads for debugging purposes.

## Development Setup

### Requirements

- PHP (compatible with your Magento installation)
- Composer

### Install dependencies

```bash
composer install
```

### Activate the pre-commit hook

The repository ships a pre-commit hook in `.githooks/`. Register it with Git once after cloning:

```bash
git config core.hooksPath .githooks
```

After this, every commit automatically runs PHPCS and PHPStan. A failing check blocks the commit.

## Code Quality Tools

### PHPCS — coding standard

Checks code against the Magento 2 coding standard. Configuration: `phpcs.xml`.

```bash
# Check for violations
vendor/bin/phpcs

# Auto-fix violations where possible
vendor/bin/phpcbf
```

### PHPStan — static analysis

Runs static analysis at level 8. Configuration: `phpstan.neon`.

```bash
vendor/bin/phpstan analyse
```

### GrumPHP — pre-commit runner

Runs both PHPCS and PHPStan on every commit. Configuration: `grumphp.yml`.

To run the checks manually without committing:

```bash
vendor/bin/grumphp run
```
