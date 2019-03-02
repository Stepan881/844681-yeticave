<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate.php');
$config = require('config.php');

$is_auth = rand(0, 1);
$user_name = 'Степан';

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot_data = [];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot_data = $_POST;

  $filename = $_FILES['img']['name'];
  $path = $_FILES['img']['tmp_name'];
  $image = (upload_img($path, $filename));

  validate_lot($lot_data);

  var_dump($lot_data);


  // TODO: проверить существование фала в массиве _FILES
  // TODO: если фаил есть загружаем
  // TODO: валидация данных формы
  // TODO: если валид. проходит сохраняем лот, и редирект на лот
  // TODO: если валид. не прохолдит, формас ошибкой
  if (!isset($_FILES['img'])) {
    die();
  }

  $filename = $_FILES['img']['name'];
  $path = $_FILES['img']['tmp_name'];
  $image = (upload_img($path, $filename));

  // TODO: Проверка на пустые поля




print_r($error);
  $lot_id = add_lot($connection, $lot_data, $image);
  if ($lot_id) {
    header("Location: lot.php?lot_id=" . $lot_id);
    exit();
  } else {
  print_r ($_FILES);
  }
}


$content = include_template('add-lot.php', [
  'errors' => $errors,
  'categories' => $categories,
  'lot' => $lot
]);

echo include_template('layout.php',
  [
    'title' => 'Добавить лот',
    'categories' => $categories,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name
  ]
);

