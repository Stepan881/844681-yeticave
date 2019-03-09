<?php

function validate_bet($bet_field, $lot, $user) {
  if ($lot['last_bet_amount'] === NULL) {
    $lot['last_bet_amount'] = $lot['start_price'];
  }
  $errors = [];

  if ($error = validate_bet_field($bet_field)) {
    $errors['bet'] = $error;
  }
  if ($error = validate_bet_size($lot, $bet_field)) {
    $errors['bet'] = $error;
  }
  if ($error = validate_bet_by_user($lot, $user)) {
    $errors['bet'] = $error;
  }

  return $errors;
}

function validate_bet_field($bet_field) {

  if($bet_field === ''){
    return 'Заполните размер ставки!';
  }
  if($bet_field <= 0){
    return 'Ставка должна быть больше нуля!';
  }
  return null;
}

function validate_bet_size($lot, $bet_field) {
  $bet = get_value($lot, 'last_bet_amount') + get_value($lot, 'step');
  if($bet_field < $bet){
    return 'Минимальная ставка ' . $bet .'p.' ;
  }
  return null;
}

function validate_bet_by_user($lot, $user) {
  if($lot['owner_id'] === $user['id']){
    return 'Нельзя ставить на свои лоты!' ;
  }
  return null;
}

