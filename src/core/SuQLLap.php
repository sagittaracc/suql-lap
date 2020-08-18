<?php
class SuQLLap {
  private $driver;
  public $db;
  private $syntax;

  function __construct($driver, $host, $username, $passwd, $dbname) {
    $this->driver = $driver;
    $this->db = new Db([
      'driver' => $driver,
      'host' => $host,
      'user' => $username,
      'pass' => $passwd,
      'name' => $dbname
    ]);
  }

  public function setSyntax($syntax) {
    if (SuQLSyntax::support($syntax)) {
      $handler = SuQLSyntax::getHandler($syntax);
      return (new $handler($this))->setAdapter($this->driver);
    }
  }
}
