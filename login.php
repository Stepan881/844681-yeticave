<?php
require_once('init.php');
require_once('functions/validate_login.php');
if (get_value($_SESSION, 'user_id')) {
  header('Location: index.php');
}
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