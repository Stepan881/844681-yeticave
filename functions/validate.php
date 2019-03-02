<?php
/**
 * функция валидации данных формы добавления лота
 * @param array $lot_data данные полученные из формы
 * @return array массив ошибок
 */
function validate_lot($lot_data){
 /* array(6) { ["name"]=> string(2) "12" ["category_id"]=> string(1) "4" ["description"]=> string(2) "12"
  ["start_price"]=> string(2) "12" ["step"]=> string(2) "12" ["end_time"]=> string(10) "2020-12-12" }*/
  $errors = [];


  if ($error = validate_lot_name($lot_data['name'])) {
    $errors['name'] = $error;
  }

  if ($error = validate_lot_description($lot_data['description'])) {
    $errors['description'] = $error;
  }

  if ($error = validate_lot_start_price($lot_data['start_price'])) {
    $errors['start_price'] = $error;
  }

  if ($error = validate_lot_step($lot_data['step'])) {
    $errors['step'] = $error;
  }
  if ($error = validate_category_id($lot_data['category_id'])) {
    $errors['category_id'] = $error;
  }

  if ($error = validate_end_time($lot_data['end_time'])) {
    $errors['end_time'] = $error;
  }

  return $errors;
}


function validate_lot_name($name){
  if($name === ''){
    return 'Заполните название лота!';
  }
  if(mb_strlen($name) > 100 ){
    return 'Название не должно превышать 100 символов!';
  }
  return null;
}


function validate_lot_description($name){
  if($name === '') {
    return 'Заполните описание лота!';
  }
  if(mb_strlen($name) > 255 ){
    return 'Описание не должно превышать 255 символов!';
  }
  return null;
}

function validate_lot_start_price($name){
  if($name === ''){
    return 'Заполните цену лота!';
  }
  if($name <= 0 ){
    return 'Цена не должна быть 0!';
  }
  return null;
}

function validate_lot_step($name){
  if($name === ''){
    return 'Шаг ставки!';
  }
  if($name <= 0 ){
    return 'Шаг не должн быть 0!';
  }
  return null;
}

function validate_category_id($name){
  if($name === 0){
    return 'Выберите категорию!';
  }
  return null;
}

function validate_end_time($end_time){
  $date1 = strtotime(date('d.m.Y'));
  $dateTime = new DateTime($end_time);
  $date2 = $dateTime->format('U');

  if ($date1+86400 > $date2) {
    return 'Дата должна быть на сутки больше текущей!';
  }
  if ($date1+2419200 < $date2) {
    return 'Дата должна быть на больше месяца!';
  }

  return null;
}
