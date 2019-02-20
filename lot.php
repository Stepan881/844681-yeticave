<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions.php');
$config = require('config.php');

$is_auth = rand(0, 1);
$user_name = 'Степан';

$id_lot = $_GET['lot_id'];

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot = get_lot($connection, $id_lot);

if (isset($id_lot)) {
  print $id_lot;

  echo include_template('lot.php',
    [
      'lot' => $lot,
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $categories
    ]
  );
} else {
  print 'error';
  echo include_template('error.php',
    [
      'is_auth' => $is_auth,
      'user_name' => $user_name,
      'categories' => $categories
    ]
  );
}






