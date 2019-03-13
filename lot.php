<?php
require_once('init.php');
require_once('functions/validate_bet.php');

$user_name = '';
$user = null;
$errors = [];
$bet_field = null;
$minimum_rate = '';
$lot['name'] = '';
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
$lot['current_price'] = get_current_price($lot);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bet_field = get_value($_POST, 'bet');

  $errors = validate_bet($bet_field, $lot);

  if (!$errors) {
    add_bet($connection, $bet_field, $user_id, $lot_id);
    header("refresh: 0;");
  }
}

$error = [
  'title' => '404 Страница не найдена',
  'description' => 'Данной страницы не существует на сайте.'
];

if (isset($lot['name'])) {

  $bets = get_bets($connection, $lot_id);
  $last_bet_user_id = get_last_bet_user_id($bets);

  $restrictions = restrictions($user, $lot, $last_bet_user_id);
  get_current_price($lot);

  $content = include_template('lot.php', [
    'restrictions' => $restrictions,
    'categories' => $categories,
    'lot' => $lot,
    'lot_id' => $lot_id,
    'bets' => $bets,
    'user' => $user,
    'bet_field' => $bet_field,
    'errors' => $errors
  ]);

} else {
  $lot['name'] = '404 Страница не найдена';
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
