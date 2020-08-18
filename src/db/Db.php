<?php
class Db implements IDb {
  private $connection;
  private $sth;

  function __construct($config) {
    $this->connection = new PDO(
      "{$config['driver']}:host={$config['host']};dbname={$config['name']}",
      $config['user'],
      $config['pass']
    );
  }

  public function setQuery($query) {
    $this->sth = $this->connection->prepare($query);
  }

  public function bindParams($params) {
    foreach ($params as $param => $value) {
      $this->sth->bindValue($param, $value, $this->gettype($value));
    }
  }

  public function exec() {
    $this->sth->execute();
    return $this->sth->fetchAll(PDO::FETCH_ASSOC);
  }

  private function gettype($var) {
    switch (gettype($var)) {
      case 'integer':
        return PDO::PARAM_INT;
      case 'string':
        return PDO::PARAM_STR;
      default:
        return PDO::PARAM_STR;
    }
  }
}
