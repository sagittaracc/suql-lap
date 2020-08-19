# SuQL Lap

SuQL Lap is a database management system that supports [SuQL](https://github.com/sagittaracc/suql).

Example:
```php
$lap = new SuQLLap('mysql', 'localhost', 'root', '', 'db');

$suql = $lap->setSyntax(SuQLSyntax::SUQL_SYNTAX);

$test = $suql->query('
  select from users
    *
  where login = :login;
')->exec('main', [':login' => 'admin']);

var_dump($test);
```
