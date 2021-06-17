<?php

require_once '../../controllers/MessageController.php';

use message\Message as Message;

if ($_POST['message'] != null) {
  Message::create($_POST['userId'], $_POST['callId'], $_POST['message']);
  header('location: messages.php?call=' . $_POST['callId'] . '&new');
}else {
  header('location: messages.php?call=' . $_POST['callId'] . '&emptyField');
}
