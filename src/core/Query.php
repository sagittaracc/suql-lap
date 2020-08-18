<?php
trait Query {
  private $lap;

  function __construct($lap) {
    $this->lap = $lap;
  }

  public function exec($name, $params = []) {
    if (!$this->hasQuery($name)) return false;

    if ($this->getQuery($name)->getSemantic() === 'sql')
      return $this->execSQL($name, $params);
    else if ($this->getQuery($name)->getSemantic() === 'cmd')
      return $this->execCMD($name);
    else
      return false;
  }

  private function execSQL($name, $params) {
    $this->lap->db->setQuery($this->getSQL([$name]));

    if (!empty($params))
      $this->lap->db->bindParams($params);

    return $this->lap->db->exec();
  }

  private function execCMD($name) {
    $data = [];

    $instruction = $this->getQuery($name)->getInstruction();
    $args = $this->getQuery($name)->getArgs();

    foreach ($args as $query) {
      $data[] = $this->exec($query);
    }

    $commandClass = $this->getCommandClass();
    return call_user_func_array([new $commandClass, $instruction], $data);
  }
}
