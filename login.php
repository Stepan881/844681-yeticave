<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/validate_login.php');
require_once('functions/main.php');
$config = require('config.php');

session_start();

$connection = db_connect($config['db']);

$categories = get_categories($connection);
$errors = [];
$user = null;
$user_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_data = $_POST;

  $user = get_user_by_email($connection, $user_data['email']);
  $errors = validate_login($user_data, $user);

  if (!$errors) {
    $_SESSION['user_id'] = get_value($user, 'id');
    header('Location: index.php');
    exit();
  } else {
    $user = null;
  }
}

$content = include_template('login.php', [
  'user_data' => $user_data,
  'errors' => $errors,
  'categories' => $categories
]);

$layout_content = include_template('layout.php', [
  'title' => 'Авторизация',
  'content' => $content,
  'user' => $user,
  'categories' => $categories
]);

print $layout_content;