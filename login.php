<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/validate_login.php');
$config = require('config.php');

session_start();

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $form = $_POST;

  $errors = validate_login($form);

  if (!$errors) {
    $user = validate_login_email_db($connection, $form);
    if (!$user['email']) {
      $errors['email'] = 'Нет такого майла!';
    }
    if (password_verify($form['password'], $user['password'])) {
      $_SESSION['user'] = $user;
      header('Location: index.php');
      exit();
    } else {
      $errors['password'] = 'Не верный пароль!';
    }
  }
}

$content = include_template('login.php', [
  'form' => $form,
  'errors' => $errors,
  'categories' => $categories
]);

$layout_content = include_template('layout.php', [
  'title' => 'Авторизация',
  'content' => $content,
  'categories' => $categories
]);

print $layout_content;