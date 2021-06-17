<?php

require_once '../../controllers/CallController.php';

use call\Call as Call;

Call::delete($_POST['callId']);

header('location: view_calls.php');
