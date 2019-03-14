<?php
require_once('init.php');
require_once('functions/upload.php');
require_once('functions/validate_user.php');
if (get_value($_SESSION, 'user_id')) {
  header('Location: index.php');
}
$categories = get_categories($connection);
$user_data = [];
$user = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $user_data = $_POST;
  $file_data = get_value($_FILES, 'img');
  $errors = validate_user($connection, $user_data, $file_data);

  if (!$errors) {
    $user_data['avatar'] = '';
    if ($_FILES['img']['name']) {
      $user_data['avatar'] = (upload_img(get_value($file_data, 'tmp_name'), get_value($file_data, 'name')));
    }
    $user_data['password'] = password_hash(get_value($user_data, 'password'), PASSWORD_DEFAULT);
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
