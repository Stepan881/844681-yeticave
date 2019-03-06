<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions/db.php');
require_once('functions/template.php');
$config = require('config.php');

session_start();
if (isset($_SESSION['user_id'])) {
  $is_auth = true;
  $user_name = $_SESSION['user_id']['name'];
}
else {
  $is_auth = false;
}

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lots = get_lots($connection);

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'is_auth' => $is_auth
]);

$layout_content = include_template('layout.php', [
    'title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $content,
    'categories' => $categories
]);

print $layout_content;