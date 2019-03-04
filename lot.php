<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
$config = require('config.php');

$is_auth = rand(0, 1);
$user_name = 'Степан';

if (!isset($_GET['lot_id'])) {
  die('Отсутствует id лота в строке запроса');
}

$lot_id = $_GET['lot_id'];
if (!is_numeric($lot_id)) {
  die('Параметр id лота не является числом');
}
$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot = get_lot($connection, $lot_id);

if ($lot) {
  $content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot
  ]);
} else {
  $content = include_template('error.php', [
    'categories' => $categories,
    'lot' => $lot
  ]);
  header("HTTP/1.0 404 Not Found");
}

echo include_template('layout.php',
  [
    'title' => $lot['name'],
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
  ]
);

