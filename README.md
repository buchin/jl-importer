# Jl Importer
Import existing JSON Lines into MySQL database

## Installation
composer require buchin/jl-importer
## Usage

```php
<?php
use Buchin\Jl\Importer;

// Initialize importer
$importer = new Importer;

// define parameters
$source = '/Path/to/jlfile.jl';
$dsn = 'mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname=test';
$user = 'mysql_user';
$password = 'mysql_password';

// start importing
$importer->import($source, $dsn, $user, $password);
```

## Test
```shell
./vendor/bin/kahlan --reporter=verbose
```