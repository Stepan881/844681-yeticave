<?php

function get_value($array, $key) {
  if (!isset($array[$key])) {
    return null;
  }
  return $array[$key];
}

function is_image($mime_type){
  $allow_types = [
    'image/jpeg',
    'image/png',
    'image/gif'
  ];
  return (array_search($mime_type, $allow_types) !== false);
}

function get_lot_minimum_rate($lot) {
  if ($lot['last_bet_amount'] === NULL) {
    $lot['last_bet_amount'] = $lot['start_price'];
  }
  return get_value($lot, 'last_bet_amount') + get_value($lot, 'step');
}
