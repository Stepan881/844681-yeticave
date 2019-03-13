<?php
require_once('init.php');

$categories = get_categories($connection);
$lots = get_lots($connection);
$user = null;

if ($user_id = get_value($_SESSION, 'user_id')) {
  $user = get_user_by_id($connection, $user_id);
}

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