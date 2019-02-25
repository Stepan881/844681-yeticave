<?php

function db_get_prepare_stmt($link, $sql, $data = []) {
  $stmt = mysqli_prepare($link, $sql);
  if ($data) {
    $types = '';
    $stmt_data = [];
    foreach ($data as $value) {
      $type = null;
      if (is_int($value)) {
        $type = 'i';
      }
      else if (is_string($value)) {
        $type = 's';
      }
      else if (is_double($value)) {
        $type = 'd';
      }
      if ($type) {
        $types .= $type;
        $stmt_data[] = $value;
      }
    }
    $values = array_merge([$stmt, $types], $stmt_data);
    $func = 'mysqli_stmt_bind_param';
    $func(...$values);
  }
  return $stmt;
}

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
    SELECT lots.name AS name, lots.img, categories.name AS category_name, lots.description, lots.end_time
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
  $now = new DateTime();
  $date = date_create_from_format("Y-m-d H:i:s", $data_end);
  if ($now < $date) {
    $interval= $now->diff($date);
    $interval_i = sprintf('%02d',  $interval->i);
    $result =  ($interval->days * 24) + $interval->h . ':' . $interval_i;
    return $result;
  }
  return '00:00';
}

function add_lot($connection, $lot_data ,$img) {
  $sql = "INSERT INTO lots (img, name, сategory_id, description, start_price, step, end_time, owner_id)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = db_get_prepare_stmt($connection, $sql, [
  $lot_data['img'] = $img,
  $lot_data['lot-name'],
  $lot_data['lot-category'],
  $lot_data['lot-message'],
  $lot_data['lot-rate'],
  $lot_data['lot-step'],
  date ('Y-m-d H:i:s', strtotime($lot_data['lot-date'] . ' 22:45:59')),
  $lot_data['owner_id']  = 2
  ]);

  $res = mysqli_stmt_execute($stmt);

  if (!$res) {
    die(mysqli_error($connection));
  }
  $lot_id = mysqli_insert_id($connection);
  return $lot_id;
}

function validate_lot($lot_data){

  return $result;
}

function parse_extension($filename) {
  $info = new SplFileInfo($filename);
  return $info->getExtension();
}

/**
 * Загрузка файла на сервер
 *
 * @param $tmp_path string временный путь до файла
 * @param $filename string реальное имя файла {для извлечения расширения}
 *
 * @return string путь до загруженного файла
 */

function upload_img($tmp_path, $filename) {
  // TODO: Получить расширение файла
  // TODO: сформировать переменную path имени файла и расширения
  $ext = parse_extension($filename);
  $path = 'img/' . uniqid() . '.' . $ext;
  // TODO: передать вторым аргументам url
  move_uploaded_file($tmp_path, $path);
  return $path;
}

