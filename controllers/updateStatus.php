<?php
require_once '../../controllers/CallController.php';

use call\Call as Call;

Call::setStatus($_POST['callId']);

header('location: view_calls.php');
