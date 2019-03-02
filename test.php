<?php
require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/upload.php');
require_once('functions/validate.php');

$img = '';

$lot_data = [
  'name' => 'sdf',
  'category_id' => 7,
  'end_time' => '30.02.2019',
  'description' => 'description',
  'start_price' => 12,
  'step' => 4
];

$errors = validate_lot($lot_data, $img);


var_dump($errors);






//$connection = db_connect($config['db']);
//$lot_data = [];
//
//$lot_data['img'] = '123.jpg';
//$lot_data['name'] = '123';
//$lot_data['category_id'] = 1;
//$lot_data['description'] = '111231223';
//$lot_data['start_price'] = 2;
//$lot_data['step'] = 2;
//$lot_data['end_time'] = '2019-02-25 21:21:12';
//$lot_data['owner_id']  = 2;
//
//
//
//
//$lot_id = add_lot($connection, $lot_data);
//
//echo $lot_id;
