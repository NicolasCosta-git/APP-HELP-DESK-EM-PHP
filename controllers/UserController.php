<?php

namespace user;

require_once '../../controllers/database.php';

use database\Database as DB;

class User
{
  protected static $table = 'Users';
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

  public static function create($name, $email, $password, $avatar = null)
  {
    self::$sql = 'insert into Users(name, email, password, avatar) values (?, ?, ?, ?)';
    self::$params = array($name, $email, $password, $avatar);
    self::executeQuery();
  }

  public static function getAll()
  {
    self::$sql = 'select * from Users where id != 1 order by name asc';
    $data = self::executeQuery();
    $users = null;
    while ($user = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $users[] = $user;
    }
    return $users;
  }

  public static function getById($id)
  {
    self::$sql = 'select * from Users where id = ?';
    self::$params = array($id);
    $data = self::executeQuery();
    $auser = null;
    while ($user = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $auser[] = $user;
    }
    return $auser;
  }

  public static function updateEmail($email, $id)
  {
    self::$sql = 'update Users set email = ? where id = ?';
    self::$params = array($email, $id);
    self::executeQuery();
  }

  public static function updateName($name, $id)
  {
    self::$sql = 'update Users set name = ? where id = ?';
    self::$params = array($name, $id);
    self::executeQuery();
  }

  public static function updatePassword($password, $id)
  {
    self::$sql = 'update Users set password = ? where id = ?';
    self::$params = array($password, $id);
    self::executeQuery();
  }

  public static function changePassword($password, $id)
  {
    self::$sql = 'update Users set password = ? where id = ?';
    self::$params = array($password, $id);
    self::executeQuery();
  }

  public static function updateAvatar($avatar, $id)
  {
    self::$sql = 'update Users set avatar = ? where id = ?';
    self::$params = array($avatar, $id);
    self::executeQuery();
  }

  public static function authenticate($email, $password)
  {
    self::$sql = 'select id, name, email, password from Users where email = ? and password = ?';
    self::$params = array($email, $password);
    $data = self::executeQuery();
    $auser = null;
    while ($user = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $auser[] = $user;
    }
    return $auser;
  }

  public static function checkIfUserExists($email)
  {
    self::$sql = 'select email from Users where email = ?';
    self::$params = array($email);
    $data = self::executeQuery();
    $auser = null;
    while ($user = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $auser[] = $user;
    }
    return $auser;
  }

  public static function delete($id)
  {
    self::$sql = 'delete from Users where id = ?';
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

$User = new User();
