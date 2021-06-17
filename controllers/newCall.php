<?php
session_start();
require_once '../../controllers/CallController.php';

use call\Call as Call;

if ($_POST['title'] == null) {
  return header('location: open_call.php?missingParameters');
}

if ($_POST['description'] == null) {
  return header('location: open_call.php?missingParameters');
}


Call::create($_SESSION['userId'], $_POST['title'], $_POST['category'], $_POST['description']);

header('location: view_calls.php');
