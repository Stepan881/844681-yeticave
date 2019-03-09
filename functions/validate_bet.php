<?php

function validate_bet($bet_field, $lot) {
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


function restrictions($user, $lot, $last_bet_user_id) {
  if (!$user) {
    return 'Войдите в свой аккаунт!';
  }
  if($lot['end_time'] < date("Y-m-d H:i:s")){
    return 'Срок лота истек!';
  }
  if($lot['owner_id'] === $user['id']){
    return 'Нельзя ставить на свои лоты!';
  }
  if($user['id'] === $last_bet_user_id){
    return 'Вы уже сделали ставку!';
  }

  return null;
}
