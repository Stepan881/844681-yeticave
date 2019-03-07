<?php
/**
 * Created by PhpStorm.
 * User: Sss
 * Date: 04.03.2019
 * Time: 10:11
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Europe/Moscow');
require_once('functions/main.php');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate_user.php');

$config = require('config.php');

$connection = db_connect($config['db']);

$categories = get_categories($connection);
$user_data = [];
$user = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_data = $_POST;
  $file_data = $_FILES['img'];

  $errors = validate_user($connection, $user_data, $file_data);

  if (!$errors) {
    $user_data['avatar'] = '';
    if (!$_FILES['img']['name']) {
      $user_data['avatar'] = (upload_img($file_data['tmp_name'], $file_data['name']));
    }
    $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
    $user_id = add_user($connection, $user_data);
    if ($user_id) {
      header('Location: login.php');
      exit();
    }
  }
}

$content = include_template('sign-up.php', [
  'errors' => $errors,
  'categories' => $categories,
  'user_data' => $user_data
]);

echo include_template('layout.php',
  [
    'title' => 'Регистрация',
    'content' => $content,
    'user' => $user,
    'categories' => $categories
  ]
);
