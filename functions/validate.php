<?php
/**
 * функция валидации данных формы добавления лота
 * @param array $lot_data данные полученные из формы
 * @param array $file_data данные полученные из формы (Фото)
 * @return array массив ошибок
 */
function validate_lot($lot_data, $file_data){
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
  if ($error = validate_file_img($file_data)) {
    $errors['img'] = $error;
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
    return 'Введите шаг ставки!';
  }
  if($name <= 0 ){
    return 'Шаг не должн быть 0!';
  }
  return null;
}

function validate_category_id($name){
  if($name == 0){
    return 'Выберите категорию!';
  }
  return null;
}

function validate_end_time($end_time){

  if (!check_date_format($end_time)){

    return 'Неверный формат даты';
  }
  if ($end_time <= date('Y-m-d')){
    return 'Дата окончания аукциона должна быть больше текущей!';
  }
  return null;
}

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $date строка с датой
 * @return bool
 */
function check_date_format($date) {
  $result = false;
  $regexp = '/(\d{4})\-(\d{2})\-(\d{2})/m';
  if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
    $result = checkdate($parts[3], $parts[2], $parts[1]);
  }
  return $result;
}

function validate_file_img($file_data){
  if (empty($file_data['tmp_name'])){
    return 'Вы не выбрали фаил';
  }
  if (!is_image($file_data['type'])){
    return 'Загрузите jpg, png, gif';
  }
  return null;
}

function is_image($mime_type){
  $allow_types = [
    'image/jpeg',
    'image/png',
    'image/gif'
  ];
  return (array_search($mime_type, $allow_types) !== false);
}

function validate_user($connection, $user_data){
  $errors = [];
  if ($error = validate_email($user_data['email'], $connection)) {
    $errors['email'] = $error;
  }
  if ($error = validate_password($user_data['password'])) {
    $errors['password'] = $error;
  }
  if ($error = validate_name($user_data['name'])) {
    $errors['name'] = $error;
  }
  if ($error = validate_contacts($user_data['contacts'])) {
    $errors['contacts'] = $error;
  }

  return $errors;
}

function validate_email($name ,$connection){
  $email = validate_user_email($name, $connection);

  if ($email){
    return 'Пользователь с этим email уже зарегистрирован';
  }
  if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
    return 'E-mail адрес указан не верно.';
  }
return null;
}

function validate_password($name){
  if($name === ''){
    return 'Заполните пароль!';
  }
  if(mb_strlen($name) > 100 ){
    return 'Пароль не должен превышать 100 символов!';
  }

  return null;
}

function validate_name($name){
  if($name === ''){
    return 'Введите Имя!';
  }
  if(mb_strlen($name) > 100 ){
    return 'Имя не должно превышать 100 символов!';
  }
  return null;
}

function validate_contacts($name){
  if($name === ''){
    return 'Введите Контактные данные!';
  }
  if(mb_strlen($name) > 255 ){
    return 'Контактные данные не должны превышать 255 символов!';
  }
  return null;
}
function validate_avatar_img($file_data){
  if (!empty($file_data['tmp_name'])){
    if (!is_image($file_data['type'])){
      return 'Загрузите jpg, png, gif';
    }
  }
  return null;
}