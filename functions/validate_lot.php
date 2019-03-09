<?php
/**
 * функция валидации данных формы добавления лота
 * @param array $lot_data данные полученные из формы
 * @param array $file_data данные полученные из формы (Фото)
 * @return array массив ошибок
 */
function validate_lot($lot_data, $file_data){
  $errors = [];

  if ($error = validate_lot_name(get_value($lot_data, 'name'))) {
    $errors['name'] = $error;
  }

  if ($error = validate_lot_description(get_value($lot_data, 'description'))) {
    $errors['description'] = $error;
  }

  if ($error = validate_lot_start_price(get_value($lot_data, 'start_price'))) {
    $errors['start_price'] = $error;
  }

  if ($error = validate_lot_step(get_value($lot_data, 'step'))) {
    $errors['step'] = $error;
  }
  if ($error = validate_category_id(get_value($lot_data, 'category_id'))) {
    $errors['category_id'] = $error;
  }

  if ($error = validate_end_time(get_value($lot_data, 'end_time'))) {
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

function validate_lot_description($description){
  if($description === '') {
    return 'Заполните описание лота!';
  }
  if(mb_strlen($description) > 255 ){
    return 'Описание не должно превышать 255 символов!';
  }
  return null;
}

function validate_lot_start_price($start_price){
  if($start_price === ''){
    return 'Заполните цену лота!';
  }
  if($start_price <= 0 ){
    return 'Цена не должна быть 0!';
  }
  return null;
}

function validate_lot_step($lot_step){
  if($lot_step === ''){
    return 'Введите шаг ставки!';
  }
  if($lot_step <= 0 ){
    return 'Шаг не должн быть 0!';
  }
  return null;
}

function validate_category_id($category_id){
  if($category_id == 0){
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
  if (preg_match($regexp, $date, $parts) && count($parts) === 4) {
    $result = checkdate($parts[2], $parts[3], $parts[1]);
  }
  return $result;
}

function validate_file_img($file_data){
  if (empty(get_value($file_data, 'tmp_name'))){
    return 'Вы не выбрали фаил';
  }
  if (!is_image(get_value($file_data, 'type'))){
    return 'Загрузите jpg, png, gif';
  }
  return null;
}

