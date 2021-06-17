<?php

namespace database;

class Database
{
  protected static $con;

  protected static function connect()
  {
    $serverName = "DESKTOP-TBTEQH7\SQLEXPRESS";
    $connectionInfo = array('Database' => 'HelpDesk', 'UID' => 'iwo', 'PWD' => '123');
    $connection = sqlsrv_connect($serverName, $connectionInfo);
    if ($connection) {
      self::$con = $connection;
      return self::$con;
    } else {
      echo "Connection could not be established.<br />";
      die(print_r(sqlsrv_errors(), true));
    }
  }

  public static function getConnection()
  {
    return self::connect();
  }

  public static function disconnect($con)
  {
    return sqlsrv_close($con);
  }
}
