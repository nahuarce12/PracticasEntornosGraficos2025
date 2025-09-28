---
applyTo: '**/*.php'
---

# PHP Development Instructions for GitHub Copilot

This file provides custom instructions for GitHub Copilot in this repository. Follow these guidelines strictly when generating, suggesting, or reviewing PHP code. These instructions ensure consistency, security, and adherence to modern PHP best practices (PHP 8.3+). Use PSR-12 for coding style, strict typing, and prioritize readability, security, and testability.

## Project Overview

This is a PHP-based web application (or library) focused on [briefly describe your project, e.g., "building scalable APIs and services for e-commerce"]. It serves developers and end-users by providing robust, maintainable code. Key features include user authentication, data processing, and integration with databases/APIs. Always generate code that is modular, secure, and follows OOP principles.

## Tech Stack

### Backend

- PHP 8.3+ with `declare(strict_types=1);` in all files.
- Composer for dependency management (e.g., `composer require` for libraries like PDO, Monolog).
- Frameworks: Laravel if applicable; otherwise, plain PHP with PSR standards.
- Database: MySQL via PDO with prepared statements. Use Eloquent ORM if in Laravel.
  - Separate environments: dev (SQLite for testing), staging/prod (MySQL).
- Logging: Monolog for error and info logs.
- HTTP: Use Guzzle for clients (PSR-18 compliant).

### Frontend (if integrated)

- Bootstrap for styling and responsive design.

### Testing

- PHPUnit for unit and integration tests (coverage >80%).
- PHP CS Fixer and PHP CodeSniffer for linting (@PSR12 rules).
- For testing: Create in-memory DB, run tests, clean up.

### Tools

- VSCode with extensions: PHP Intelephense, GitHub Copilot, PHP CS Fixer.
- No external installs in code; assume Composer handles deps.

## Coding Guidelines

- **Style**: Strictly follow PSR-12. Use 4-space indentation, 120-char lines max, short array syntax `[]`, no closing `?>`.
- **Typing**: Always use strict types (`declare(strict_types=1);`). Specify types for params, returns, and properties (e.g., `public function getUser(int $id): ?User`).
- **Naming**: Classes: `StudlyCaps` (e.g., `UserService`). Methods/Vars: `camelCase` (e.g., `getUserId()`). Constants: `UPPER_CASE`. Namespaces: `Vendor\Project\Module`.
- **Structures**:
  - Classes: One per file, named after class. Use constructor property promotion (PHP 8+): `public function __construct(private string $name) {}`.
  - Control: Braces on new lines, spaces around operators. Avoid nested ternaries; use if/else.
  - Arrays: Associative for configs; immutable where possible.
- **Security**:
  - Validate/sanitize inputs: `filter_var()`, `htmlspecialchars()`.
  - SQL: PDO prepared statements only; no raw queries.
  - Auth: `password_hash()`/`password_verify()`; sessions with CSRF tokens.
  - Avoid: `eval()`, `$_GET` direct use; escape outputs.
- **Errors/Exceptions**: Catch and log (Monolog), re-throw if needed. Use built-ins like `InvalidArgumentException`. No suppressing errors.
- **Performance**: Use generators for large data; cache with APCu/Redis. Avoid deprecated functions (e.g., `mysql_*`).
- **Documentation**: Generate full PHPDoc for public methods/classes: `@param`, `@return`, `@throws`. Omit if native types suffice.
- **Best Practices**:
  - Dependency Injection: Prefer constructor injection.
  - Single Responsibility: Keep classes/methods focused.
  - No globals; use services.
  - Tests: Always suggest accompanying PHPUnit tests for new code.
- **Avoid**: Magic numbers (use constants), long methods (>50 lines), duplicate code.

Example Code Snippet to Follow:

```php
<?php

declare(strict_types=1);

namespace App\Services;

use PDO;
use Psr\Log\LoggerInterface;
use App\Models\User;
use InvalidArgumentException;

class UserService
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * Retrieves a user by ID.
     *
     * @param int $id User ID
     * @return User|null
     * @throws InvalidArgumentException If ID is invalid
     */
    public function getUser(int $id): ?User
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid user ID');
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $this->logger->info('User fetched', ['id' => $id]);

        return new User($data);
    }
}
```

## Project Structure

Follow this standard PSR-4 autoload structure:

```
project/
├── src/
│   ├── Controllers/     # HTTP controllers
│   ├── Models/          # Data models/entities
│   ├── Services/        # Business logic
│   ├── Repositories/    # Data access
│   └── Utils/           # Helpers
├── tests/
│   ├── Unit/            # PHPUnit unit tests
│   └── Integration/     # DB/API tests
├── config/              # Config files (e.g., database.php)
├── public/              # Entry point (index.php)
├── vendor/              # Composer deps (gitignored)
├── .github/             # Workflows, this instructions file
├── composer.json        # Autoload: PSR-4 "App\\": "src/"
└── phpunit.xml          # Test config
```

- Use `composer dump-autoload` for changes.
- Routes in `public/index.php` or framework-specific.

## Resources

- **Scripts**:
  - `composer install` for deps.
  - `vendor/bin/phpunit` for tests.
  - `php-cs-fixer fix` for formatting (@PSR12).
- **Documentation**: Refer to PHP-FIG PSR standards (psr.php-fig.org). For Laravel: laravel.com/docs.
- **External**: Use PDO for DB, Guzzle for HTTP. No internet in code; assume local.
- **Validation**: After generation, run `phpcs` and suggest fixes if needed.
- **Copilot-Specific**: When suggesting code, include PHPDoc and tests. Prioritize secure, readable suggestions over brevity.

Update this file as the project evolves. For questions, reference these instructions in Copilot Chat prompts.
