<?php
class SuQLQuery {
  use syntax\SuQL;

  private $syntax;

  function __construct($syntax) {
    if (SuQLSyntax::support($syntax))
      $this->syntax = $syntax;
  }

  public function exec($name) {
    if (!$this->suql->hasQuery($name)) return false;

    if ($this->suql->getQuery($name)->getSemantic() === 'sql')
      return $this->execSQL($name);
    else if ($this->suql->getQuery($name)->getSemantic() === 'cmd')
      return $this->execCMD($name);
    else
      return false;
  }

  private function execSQL($name) {
    $this->db->setQuery($this->suql->getSQL([$name]));

    if (!empty($this->params))
      $this->db->bindParams($this->params);

    return $this->db->exec();
  }

  private function execCMD($name) {
    $data = [];

    $instruction = $this->suql->getQuery($name)->getInstruction();
    $args = $this->suql->getQuery($name)->getArgs();

    foreach ($args as $query) {
      $data[] = $this->exec($query);
    }

    $commandClass = $this->suql->getCommandClass();
    return call_user_func_array([new $commandClass, $instruction], $data);
  }
}
