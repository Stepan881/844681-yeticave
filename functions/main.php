<?php
/**
 * Валидация данных на существование
 *
 * @param array $array массив
 * @param string $key ключ
 * @return string
 */
function get_value($array, $key) {
  if (!isset($array[$key])) {
    return null;
  }
  return $array[$key];
}
/**
 * Валидация типа файла
 *
 * @param string $mime_type получение файла с формы
 * @return bool
 */
function is_image($mime_type){
  $allow_types = [
    'image/jpeg',
    'image/png'
  ];
  return (array_search($mime_type, $allow_types) !== false);
}
/**
 * Функция сложение последний ставки лота + шаг цены лота
 *
 * @param array $lot данные лота
 * @return int
 */
function get_lot_minimum_rate($lot) {
  return (int)get_current_price($lot) + (int)get_value($lot, 'step');
}
/**
 * Получение последней ставки на лоте
 *
 * @param array $lot данные лота
 * @return string
 */
function get_current_price($lot) {
  if ($bet_amount = get_value($lot, 'last_bet_amount')) {
    return $bet_amount;
  }
  return get_value($lot, 'start_price');
}
/**
 * Получение последней ставки
 *
 * @param array $bets данные ставки
 * @return string
 */
function get_last_bet_user_id($bets){
  if (isset($bets[0]['owner_id'])){
    return $bets[0]['owner_id'];
  }
  return null;
}
/**
 * Форматирование времени
 *
 * @throws
 * @param string $data получение даты\время
 * @return string
 */
function format_data($data) {
  $data_unix = strtotime($data);
  $new_data_unix = date_create();
  $new_data_unix = date_timestamp_get($new_data_unix);
  $data_unix = $new_data_unix - $data_unix  ;

  if ($data_unix < 300 ) {
    return '5 минут назад';
  }
  if ($data_unix < 1200 ) {
    return '20 минут назад';
  }
  if ($data_unix < 3600 ) {
    return 'Час назад';
  }
  return date_format(new DateTime($data), 'd.m.y') . ' в ' . date_format(new DateTime($data), 'H:m');
}
/**
 * функция парсит символы от xss атак
 *
 * @throws
 * @param string $key получение даты\время
 * @return string
 */
function data_xss($key){
  $key = stripslashes($key);
  $key = strip_tags($key);
  $key = htmlspecialchars($key);
  return $key;
}
