<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Moscow');

session_start();

require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/main.php');
$config = require('config.php');

$connection = db_connect($config['db']);

$categories = get_categories($connection);
$lots = get_lots($connection);
$user = null;

if ($user_id = get_value($_SESSION, 'user_id')) {
  $user = get_user_by_id($connection, $user_id);
}

var_dump($user);

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'user' => $user
]);

$layout_content = include_template('layout.php', [
    'title' => 'Главная',
    'user' => $user,
    'content' => $content,
    'categories' => $categories
]);

print $layout_content;