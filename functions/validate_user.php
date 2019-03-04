<?php

function validate_user($connection, $user_data, $file_data){
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
  if ($error = validate_avatar_img($file_data)) {
    $errors['avatar'] = $error;
  }

  return $errors;
}

function validate_email($email, $connection){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 'E-mail адрес указан не верно.';
  }
  if (isset_email($email, $connection)){
    return 'Пользователь с этим email уже зарегистрирован';
  }
  return null;
}

function validate_password($password){
  if($password === ''){
    return 'Заполните пароль!';
  }
  if(mb_strlen($password) > 100 ){
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

function validate_contacts($contacts){
  if($contacts === ''){
    return 'Введите Контактные данные!';
  }
  if(mb_strlen($contacts) > 255 ){
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