<?php
/**
 * Функция шаблонизатор
 *
 * @param $name string имя файла шаблона
 * @param $data array ассоциативный массив с данными для этого шаблона.
 * @return string итоговый HTML-код с подставленными данными.
 */
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
/**
 * Форматирование цены, отделение тысяч пробелом + знак рубля
 *
 * @param string $number цена
 * @return string
 */
function format_price($number){
  $number = ceil($number);
  if ($number >= 1000) {
    return number_format($number, 0, null, ' ') . ' &#8381;';
  }
  return $number . ' &#8381;';
}
/**
 * форматирование окончание таймера
 *
 * @throws string $data_end время лота
 * @param string $data_end
 * @return string
 */
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
