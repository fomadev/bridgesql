# BridgeSQL v2

**BridgeSQL** is a lightweight, universal PHP library designed to simplify the use of PDO. It acts as a robust bridge between your code and **10 different database management systems (DBMS)**, automating connection configuration and data type management.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.0-blue.svg)](https://www.php.net/)

## Features

- **Multi-DBMS Support**: A single interface for 10 SQL engines (MySQL, PostgreSQL, SQLite, Oracle, SQL Server, etc.).
- **Auto-Typing**: Automatic detection of PDO types (Integer, Boolean, String, Null) via PHP 8 `match`.
- **Parameter Flexibility**: Supports named (`:id`) and indexed (`?`) parameters.
- **Security**: Systematic use of prepared statements with emulation disabled for maximum security.
- **Lightweight**: No external dependencies required for basic operation.

## Installation

Use [Composer](https://getcomposer.org/) to install the library:

```bash
composer require fomadev/bridgesql
```

## Supported DBMS

BridgeSQL facilitates connection to the following systems :

1. **MySQL**

2. **MariaDB**

3. **PostgreSQL**

4. **SQLite** (Local file)

5. **Microsoft SQL Server**

6. **Oracle** (OCI)

7. **IBM DB2**

8. **Firebird**

9. **Informix**

10. **Sybase** (SAP ASE)

## Quick Use

### Configuration

Create a configuration file (e.g., `config/database.php`):

```php
return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'dbname'   => 'ma_base',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4'
];
```

### Query execution

```php
require 'vendor/autoload.php';

use BridgeSQL\BridgeSQL;

$config = require 'config/database.php';
$db = new BridgeSQL($config);

// Retrieve a single line
$user = $db->fetch("SELECT * FROM users WHERE id = :id", ['id' => 1]);

// Retrieve all the lines
$users = $db->fetchAll("SELECT * FROM users WHERE status = ?", ["active"]);

// Insert data
$db->execute("INSERT INTO users (name, email) VALUES (?, ?)", ["Molengo", "fordi@fomadev.com"]);
$lastId = $db->lastInsertId();
```