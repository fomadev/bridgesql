# BridgeSQL v2.0.2

**BridgeSQL** is a lightweight, universal PHP library designed to simplify the use of PDO. It acts as a robust bridge between your code and **10 different database management systems (DBMS)**, automating connection configuration, data type management, query debugging, and transaction safety.

[![Build Status](https://github.com/fomadev/bridgesql/actions/workflows/ci.yml/badge.svg)](https://github.com/fomadev/bridgesql/actions)
[![License: FPL](https://img.shields.io/badge/License-FPL-orange.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.0-blue.svg)](https://www.php.net/)

## Features

- **Multi-DBMS Support**: A single interface for 10 SQL engines (MySQL, PostgreSQL, SQLite, Oracle, SQL Server, etc.).
- **Auto-Typing**: Automatic detection of PDO types (Integer, Boolean, String, Null) via PHP 8 `match`.
- **Parameter Flexibility**: Supports named (`:id`) and indexed (`?`) parameters.
- **Security**: Systematic use of prepared statements with emulation disabled for maximum security.
- **Logging & Debugging**: Track execution time and view interpolated SQL queries for easier debugging.
- **Transaction Management**: Secure native handling of transactional states to prevent concurrency or duplicate initialization errors.
- **Lightweight**: No external dependencies required for basic operation.

## Installation

Use [Composer](https://getcomposer.org/) to install the library:

```bash
composer require fomadev/bridgesql
```

## Supported DBMS

BridgeSQL facilitates connection to the following systems:

1. **MySQL** & **MariaDB**

2. **PostgreSQL**

3. **SQLite** (Local file or `:memory:`)

4. **Microsoft SQL Server** (MSSQL)

5. **Oracle** (OCI)

6. **IBM DB2**

7. **Firebird**

8. **Informix**

9. **Sybase** (SAP ASE)

## Quick Use

### Configuration

Create a configuration file (e.g., `config/database.php`):

```php
return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'dbname'   => 'my_database',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4'
];
```

### Query Execution & Debugging

```php
require 'vendor/autoload.php';

use BridgeSQL\BridgeSQL;

$config = require 'config/database.php';
$db = new BridgeSQL($config);

// Retrieve a single line
$user = $db->fetch("SELECT * FROM users WHERE id = :id", ['id' => 1]);

// Insert data with auto-typing
$db->execute("INSERT INTO users (name, active) VALUES (?, ?)", ["Molengo", true]);

// --- Debugging Features (New in v2.0.1) ---

// Get the last executed query with parameters injected
echo $db->getLastQuery(); 
// Output: INSERT INTO users (name, active) VALUES ('Molengo', 1)

// Get full session logs (SQL, duration, and timestamp)
$logs = $db->getDebugLog();
print_r($logs);
```

### Transactions

```php
$db->beginTransaction();

try {
    $db->execute("UPDATE accounts SET balance = balance - 100 WHERE id = 1");
    $db->execute("UPDATE accounts SET balance = balance + 100 WHERE id = 2");
    $db->commit();
} catch (Exception $e) {
    $db->rollBack();
    throw $e;
}
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the **FomaDev Public License (FPL)**. 
- **Free** for use as a dependency in personal and commercial projects.
- **Paid** license required for redistribution, derivative libraries, or competing commercial services.

See the [LICENSE](LICENSE) file for the full text.