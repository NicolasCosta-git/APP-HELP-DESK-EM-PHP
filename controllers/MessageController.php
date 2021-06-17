<?php

namespace message;

require_once '../../controllers/database.php';

use database\Database as DB;

class Message
{
  protected static $table = 'Messages';
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

  public static function create($userId, $callId, $message)
  {
    self::$sql = 'insert into Messages(userId, callId, message) values (?, ?, ?)';
    self::$params = array($userId, $callId, $message);
    self::executeQuery();
  }

  public static function getAll($callId)
  {
    self::$sql = 'select Users.id as userId, Users.name, Users.avatar,
     Calls.id as callId, Messages.id as messageId,
      message from Messages inner join Users on Messages.userId = Users.id
       inner join Calls on Messages.callId = Calls.id where Calls.id = ?';
    self::$params = array($callId);
    $data = self::executeQuery();
    $messages = null;
    while ($message = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $messages[] = $message;
    }
    return $messages;
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

$Message = new Message();
