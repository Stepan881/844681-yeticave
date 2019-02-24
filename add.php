<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions.php');
$config = require('config.php');

$is_auth = rand(0, 1);
$user_name = 'Степан';

$connection = db_connect($config['db']);
$categories = get_categories($connection);

$content = include_template('add-lot.php', [
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $img = $_POST['lot-image'];

  $name = strip_tags($_POST['lot-name']);
  $categories_id = $_POST['lot-category'];
  $descriptions = strip_tags($_POST['lot-message']);
  $start_price = $_POST['lot-rate'];
  $step = $_POST['lot-step'];
  $end_time = $_POST['lot-date'];


  $filename = uniqid() . '.gif';
  $img['path'] = $filename;
  $url = move_uploaded_file($_FILES['lot-image']['tmp_name'], 'img/' . $filename);



  $sql = 'INSERT INTO lots (create_time, img, name, сategory_id, description, start_price, step, end_time, owner_id) 
          VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';

    $stmt = db_get_prepare_stmt($connection, $sql, [$filename, $name, $categories_id, $descriptions, $start_price, $step, $end_time]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      $gif_id = mysqli_insert_id($connection);
      print ($filename.' '.$name.' '.categories_id.' '.$descriptions.' '.$start_price.' '.$step.' '.$end_time.' ');
      header("Location: lot.php?lot_id=" . $gif_id);
    }
    else {
     print_r ($stmt);
    }
}
