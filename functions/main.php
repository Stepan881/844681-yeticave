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
  return get_current_price($lot) + get_value($lot, 'step');
}

function get_current_price($lot) {
  if ($bet_amount = get_value($lot, 'last_bet_amount')) {
    return $bet_amount;
  }
  return get_value($lot, 'start_price');
}

function get_last_bet_user_id($bets){
  if (isset($bets[0]['owner_id'])){
    return $bets[0]['owner_id'];
  }
  return null;
}