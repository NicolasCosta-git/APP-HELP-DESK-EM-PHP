<?php

namespace call;

require_once '../../controllers/database.php';

use database\Database as DB;

class Call
{
  protected static $table = 'Calls';
  protected static $joinTable = 'Users';
  protected static $connection;
  protected static $sql = null;
  protected static $params = null;

  function __construct()
  {
    self::$connection = DB::getConnection();
  }

  function __destruct()
  {
    DB::disconnect(self::$connection);
  }

  public static function create($userId, $title, $type, $description, $status = 0)
  {
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d-m-Y - H:i');
    self::$sql = 'insert into Calls(userId, title, type, description, status, createdAt) values (?, ?, ?, ?, ?, ?)';
    self::$params = array($userId, $title, $type, $description, $status = 0, $date);
    self::executeQuery();
  }

  public static function getAll()
  {
    self::$sql = 'select Calls.id, userId, name ,title, type, description, status, createdAt, closedAt from Calls inner
    join Users on Calls.userId = Users.id order by Id desc';
    $data = self::executeQuery();
    $calls = null;
    while ($call = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $calls[] = $call;
    }
    return $calls;
  }

  public static function getByUserId($id)
  {
    self::$sql = 'select Calls.id, userId, name ,title, type, description, status, createdAt, closedAt from Calls inner
    join Users on Calls.userId = Users.id where userId = ? order by id desc';
    self::$params = array($id);
    $data = self::executeQuery();
    $acall = null;
    while ($call = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $acall[] = $call;
    }
    return $acall;
  }

  public static function getById($id)
  {
    self::$sql = 'select  Calls.id as id, userId, name ,title, type, description, status, createdAt, closedAt from Calls
     inner join Users on Calls.userId = Users.id where Calls.id = ?';
    self::$params = array($id);
    $data = self::executeQuery();
    $acall = null;
    while ($call = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $acall[] = $call;
    }
    return $acall;
  }

  public static function setStatus($id)
  {
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d-m-Y - H:i');
    self::$sql = 'update Calls set status = ?, closedAt = ? where id = ?';
    self::$params = array(1, $date, $id);
    self::executeQuery();
  }

  public static function delete($id)
  {
    self::$sql = 'delete from Calls where id = ?';
    self::$params = array($id);
    self::executeQuery();
  }

  protected static function executeQuery()
  {
    $query = sqlsrv_query(self::$connection, self::$sql, self::$params);
    self::$sql = null;
    self::$params = null;
    if ($query == false) {
      die(print_R(sqlsrv_errors(), true));
    }
    return $query;
  }
}

$Call = new Call();
