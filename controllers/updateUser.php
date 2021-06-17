<?php
session_start();
require_once '../../controllers/UserController.php';

use user\User as User;

if ($_SESSION['userName'] != $_POST['name']) {
  User::updateName($_POST['name'], $_SESSION['userId']);
  $_SESSION['userName'] = $_POST['name'];
}

if ($_SESSION['userEmail'] != $_POST['email']) {
  if (User::checkIfUserExists($_POST['email']) == null) {
    User::updateEmail($_POST['email'], $_SESSION['userId']);
    $_SESSION['userEmail'] = $_POST['email'];
  } else {
    return header('location: edit_profile.php?emailInUse');
  }
}

if ($_POST['currentPassword'] != null || $_POST['newPassword'] != null) {
  if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && $_POST['currentPassword'] != null && $_POST['newPassword'] != null) {
    if (User::authenticate($_SESSION['userEmail'], $_POST['currentPassword']) != null) {
      User::updatePassword($_POST['newPassword'], $_SESSION['userId']);
    } else {
      return header('location: edit_profile.php?wrongPassword');
    }
  } else {
    return header('location: edit_profile.php?missingParameters');
  }
}

if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
  print_r($_FILES);
  $UserAvatar = User::getById($_SESSION['userId'])[0]['avatar'];
  unlink($UserAvatar);
  User::updateAvatar(uploadPhoto(), $_SESSION['userId']);
}

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
          return header('location: edit_profile.php?fileTooLarge');
        }
      } else {
        return header('location: edit_profile.php?errorUploading');
      }
    } else {
      return header('location: edit_profile.php?fileTypeNotAllowed');
    }
  } else {
    return null;
  }
}

header('location: edit_profile.php');
