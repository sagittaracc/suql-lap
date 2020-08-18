<?php
class SuQLSyntax {
  const SUQL_SYNTAX = 'SuQL';
  const OSUQL_SYNTAX = 'OSuQL';

  public static function support($syntax) {
    return in_array($syntax, [self::SUQL_SYNTAX, self::OSUQL_SYNTAX]);
  }

  public static function getHandler($syntax) {
    return "{$syntax}Query";
  }
}
