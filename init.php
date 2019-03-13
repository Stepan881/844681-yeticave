<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Moscow');

session_start();

require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/main.php');
if (!file_exists('config.php')) {
  die('Создайте файл config.php на основе config.sample.php');
}
$config = require('config.php');
$connection = db_connect($config['db']);
