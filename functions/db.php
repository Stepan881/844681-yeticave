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

function add_lot($connection, $lot_data) {
  $sql = 'INSERT INTO lots (img, name, сategory_id, description, start_price, step, end_time, owner_id)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
  $stmt = db_get_prepare_stmt($connection, $sql, [
    $lot_data['img'],
    $lot_data['name'],
    $lot_data['category_id'],
    $lot_data['description'],
    $lot_data['start_price'],
    $lot_data['step'],
    date ('Y-m-d H:i:s', strtotime($lot_data['end_time'])),
    $lot_data['owner_id']  = 2
  ]);

  $res = mysqli_stmt_execute($stmt);

  if (!$res) {
    die(mysqli_error($connection));
  }
  $lot_id = mysqli_insert_id($connection);
  return $lot_id;
}

function isset_email($mail, $connection) {
  $email = mysqli_real_escape_string($connection, $mail);
  $sql = "SELECT email FROM users WHERE email = '$email'";
  $res = mysqli_query($connection, $sql);
  return mysqli_num_rows($res);
}

function add_user($connection, $user_data) {
  $sql = 'INSERT INTO users (email, password, name, contacts, avatar)
          VALUES (?, ?, ?, ?, ?)';
  $stmt = db_get_prepare_stmt($connection, $sql, [
    $user_data['email'],
    $user_data['password'],
    $user_data['name'],
    $user_data['contacts'],
    $user_data['avatar'],
  ]);

  $res = mysqli_stmt_execute($stmt);

  if (!$res) {
    die(mysqli_error($connection));
  }
  return $res;
}

function validate_login_email_db($connection, $form) {
  $email = mysqli_real_escape_string($connection, $form['email']);
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $res = mysqli_query($connection, $sql);
  $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
  return $user;
}






















