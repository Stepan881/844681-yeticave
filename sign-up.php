<?php
/**
 * Created by PhpStorm.
 * User: Sss
 * Date: 04.03.2019
 * Time: 10:11
 */

date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate_user.php');
$config = require('config.php');
session_start();
$connection = db_connect($config['db']);
$categories = get_categories($connection);
$user_data = [];

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
      $users_id = validate_login_email_db($connection, $user_data);
      $_SESSION['user_id'] = $users_id;
      header('Location: index.php');
      exit();
    }
  }
}

$content = include_template('sign-up.php', [
  'errors' => $errors,
  'user_avatar' => $user_avatar,
  'categories' => $categories,
  'user_data' => $user_data
]);

echo include_template('layout.php',
  [
    'title' => 'Регистрация',
    'content' => $content,
    'categories' => $categories
  ]
);
