<?php
require_once '../../controllers/UserController.php';

use user\User as User;

$admin = User::checkIfUserExists('helpdesk@admin.com');

if ($admin === null) {
  User::create('Help Desk', 'helpdesk@admin.com', 'helpdesk', './src/img/logo.png');
}
