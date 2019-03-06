<?php

function validate_login($form){
  $errors = [];
  if ($error = validate_login_email($form['email'])) {
    $errors['email'] = $error;
  }

  if ($error = validate_login_password($form['password'])) {
    $errors['password'] = $error;
  }
  return $errors;
}

function validate_login_email($email){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 'E-mail адрес указан не верно.';
  }
  if($email === ''){
    return 'Введите email!';
  }
  return null;
}

function validate_login_password($password){
  if($password === ''){
    return 'Введите пароль!';
  }
  return null;
}

