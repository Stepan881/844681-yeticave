<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('functions/db.php');
if (!file_exists('config.php')) {
  die('Создайте файл config.php на основе config.sample.php');
}
$config = require('config.php');

unset($_SESSION['user_id']);
header("Location: /index.php");
