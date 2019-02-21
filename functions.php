<?php
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format($number)
{
    $number = ceil($number);
    if ($number >= 1000) {
        return number_format($number, 0, null, ' ') . ' &#8381;';
    }
    return $number . ' &#8381;';
}

function time_tomorrow()
{
    $ts_midnight = strtotime('tomorrow midnight');
    $secs_to_midnight = $ts_midnight - time();
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    $result = sprintf('%02d:%02d', $hours, $minutes);
    return $result;
}

function db_connect($db_config)
{
    $connection = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['database']);

    if (!$connection) {
        die('Ошибка подключение: ' . mysqli_connect_error());
    }
    mysqli_set_charset($connection, "utf8");
    return $connection;

}

function get_categories($connection) {
    $sql = 'SELECT id, name FROM categories';
    $result = mysqli_query($connection, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $categories;
}

function get_lots($connection) {
    $sql = '
        SELECT lots.name, lots.start_price, lots.img, lots.id, lots.end_time, categories.name AS category_name
        FROM lots
        JOIN categories
        ON lots.сategory_id = categories.id
        ORDER BY lots.end_time DESC;
    ';
    $result = mysqli_query($connection, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $lots;
}

function get_lot($connection, $id) {
    $sql = '
    SELECT lots.name AS name, lots.img, categories.name AS category_name, lots.description
    FROM lots
    JOIN categories
    ON lots.сategory_id = categories.id
    WHERE lots.id = '.$id.';
    ';
    $result = mysqli_query($connection, $sql);
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!$lot) {
      return null;
    }
    return $lot[0];
}

function time_to_end($data_end) {
  $now = new DateTime(); // текущее время на сервере
  $date = date_create_from_format("Y-m-d H:i:s", $data_end); // задаем дату в любом формате
  if ($now < $date){
    $interval = $now->diff($date); // получаем разницу в виде объекта DateInterval
    $result = sprintf('%02d:%02d', $interval->h, $interval->i);
    return $result;
  }
  return '00:00';
}