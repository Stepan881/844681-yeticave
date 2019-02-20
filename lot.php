<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions.php');
$config = require('config.php');

$is_auth = rand(0, 1);
$user_name = 'Степан';

$id_lot = $_GET['lot_id'];

if (is_numeric($id_lot)) {
$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot = get_lot($connection, $id_lot);
$header = 'HTTP/1.0 404 Not Found';
}

if ($lot) {
  if (isset($id_lot)) {
    print($lot['lot_name']);
    echo include_template('lot.php',
      [
        'lot' => $lot,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'categories' => $categories
      ]
    );
  }
} else {
    echo include_template('error.php',
      [
        'header' => $header,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'categories' => $categories
      ]
    );
  }




