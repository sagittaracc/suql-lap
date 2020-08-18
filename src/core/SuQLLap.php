<?php
class SuQLLap {
  private $adapter;
  private $db;

  function __construct() {

  }

  public function setAdapter($adapter) {
    $this->adapter = $adapter;
  }

  public function setDb($db) {
    $this->db = $db;
  }

  public function setSyntax($syntax) {
    return new SuQLQuery($syntax);
  }
}
