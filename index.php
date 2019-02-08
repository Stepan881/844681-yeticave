<?php
date_default_timezone_set('Europe/Moscow');
require_once('functions.php');

$is_auth = rand(0, 1);
$user_name = 'Степан'; // укажите здесь ваше имя1
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'cate' => 'Доски и лыжи',
        'price' => 10999,
        'image' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'cate' => 'Доски и лыжи',
        'price' => 159999,
        'image' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cate' => 'Крепления',
        'price' => 8000,
        'image' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'cate' => 'Ботинки',
        'price' => 10999,
        'image' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cate' => 'Одежда',
        'price' => 7500,
        'image' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'cate' => 'Разное',
        'price' => 5400,
        'image' => 'img/lot-6.jpg'
    ]
];

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'time' => time_tomorrow()
]);

$layout_content = include_template('layout.php', [
    'title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $content,
    'categories' => $categories
]);

print $layout_content;