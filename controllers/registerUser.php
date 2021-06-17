<?php
session_start();
require_once '../../controllers/UserController.php';

$_SESSION['temp'][0] = $_POST['name'];
$_SESSION['temp'][1] = $_POST['email'];

use user\User as User;


function uploadPhoto()
{
  if (isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $filename = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 1000000) {
          $fileNewName = uniqid(date('YmdHis'), true) . '.' . $fileActualExt;
          $fileDestination = './src/uploads/' . $fileNewName;
          move_uploaded_file($fileTmpName, $fileDestination);
          return $fileDestination;
        } else {
          header('location: register.php?fileTooLarge');
        }
      } else {
        header('location: register.php?errorUploading');
      }
    } else {
      print_r($file);
      /* header('location: register.php?fileTypeNotAllowed'); */
    }
  } else {
    return null;
  }
}

if ($_POST['name'][0] == null || $_POST['email'][0] == null || $_POST['password'][0] == null && $_POST['checkPassword'][0] == null) {
  return header('location: register.php?inputsCannotBeNull');
} else if (User::checkIfUserExists($_POST['email']) != null) {
  return header('location: register.php?userAlreadyExists');
} else if ($_POST['password'] !== $_POST['checkPassword']) {
  return header('location: register.php?passwordsNotEqual');
} else {
  User::create($_POST['name'], $_POST['email'], $_POST['password'], uploadPhoto());
  require_once '../../controllers/authenticate.php';
}
