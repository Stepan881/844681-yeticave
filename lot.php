<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions.php');
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

  echo include_template('lot.php',
    [
      'lot' => $lot,
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $categories
    ]
  );
} else {
  header("HTTP/1.0 404 Not Found");
  echo include_template('error.php',
    [

      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $categories
    ]
  );
}



