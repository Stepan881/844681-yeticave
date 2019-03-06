<?php

function validate_login($connection, $form, $user){
  $errors = [];
  if ($error = validate_login_email($form['email'], $user)) {
    $errors['email'] = $error;
  }
  if ($error = validate_login_password($form['password'], $user)) {
    $errors['password'] = $error;
  }

  return $errors;
}

function validate_login_email($email, $user){
  if($email === ''){
    return 'Введите email!';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 'E-mail адрес указан не верно.';
  }
  if (!$user['email']) {
    return 'Нет такого майла!';
  }
  return null;
}

function validate_login_password($password, $user){
  if($password === ''){
    return 'Введите пароль!';
  }
  if (!password_verify($password, $user['password'])) {
    return 'Не верный пароль!';
  }
  return null;
}

