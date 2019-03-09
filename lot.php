<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/main.php');
require_once('functions/validate_bet.php');
$config = require('config.php');
$user_name = '';

$connection = db_connect($config['db']);
$user = null;
$errors = [];
$bet_field = null;
$minimum_rate = '';
$categories = get_categories($connection);

if ($user_id = get_value($_SESSION, 'user_id')) {
  $user = get_user_by_id($connection, $user_id);
}

if (!get_value($_GET, 'lot_id')) {
  die('Отсутствует id лота в строке запроса');
}

$lot_id = get_value($_GET,'lot_id');
if (!is_numeric($lot_id)) {
  die('Параметр id лота не является числом');
}

$lot = get_lot($connection, $lot_id);
$lot['minimum_rate'] = get_lot_minimum_rate($lot);

$minimum_rate = get_lot_minimum_rate($lot);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bet_field = get_value($_POST, 'bet');

  //TODO:
  // Валидация поля, значение
  // запись в базу
  // обновить данные лота

  $errors = validate_bet($bet_field, $lot, $user);

  if (!$errors) {
    add_bet($connection, $bet_field, $user_id, $lot_id);
    header("refresh: 0;");
  }

}

$rates = get_rates($connection, $lot_id);
var_dump(count($rates));
$error = [
  'title' => '404 Страница не найдена',
  'description' => 'Данной страницы не существует на сайте.'
];

if ($lot) {
  $content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'lot_id' => $lot_id,
    'minimum_rate' => $minimum_rate,
    'rates' => $rates,
    'user' => $user,
    'bet_field' => $bet_field,
    'errors' => $errors
  ]);
} else {
  $content = include_template('error.php', [
    'categories' => $categories,
    'lot' => $lot,
    'error' => $error
  ]);
  header("HTTP/1.0 404 Not Found");
}

echo include_template('layout.php',
  [
    'title' => $lot['name'],
    'content' => $content,
    'user' => $user,
    'user_name' => $user_name,
    'categories' => $categories
  ]
);

