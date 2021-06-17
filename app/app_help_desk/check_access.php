<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] == false) {
  header('location: index.php?authentication=error');
};
