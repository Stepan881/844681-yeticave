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
require_once('functions/validate.php');
$config = require('config.php');

$connection = db_connect($config['db']);
$categories = get_categories($connection);

$user_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_data = $_POST;
  $file_data = $_FILES['img'];

  $user_avatar = validate_avatar_img($file_data);
  $errors = validate_user($user_data, $connection);


  if (!$errors and !$user_avatar) {
 //  echo 'Все OK';
    $user_avatar['img'] = (upload_img($file_data['tmp_name'], $file_data['name']));

//    $user_id = validate_user_email($connection, $user_data);

//    if ($user_id) {
//      header('Location: index.php');
//      exit();
//    }
  }
}



$content = include_template('sign-up.php', [
  'errors' => $errors,
  'user_avatar' => $user_avatar,
  'categories' => $categories
]);

echo include_template('layout.php',
  [
    'title' => 'Регистрация',
    'content' => $content,
    'categories' => $categories
  ]
);
