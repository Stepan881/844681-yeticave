<?php
/**
 * функция валидации соответствия пароля к почте
 * @param array $form данные полученные из формы
 * @param array $user данные полученные из базы
 * @return array массив ошибок
 */
function validate_login($form, $user){
  $errors = [];
  if ($error = validate_login_email(get_value($form, 'email'), $user)) {
    $errors['email'] = $error;
  }
  if ($error = validate_login_password(get_value($form, 'password'), $user)) {
    $errors['password'] = $error;
  }

  return $errors;
}
/**
 * функция валидации емфил
 * @param string $email данные полученные из формы
 * @param array $user данные пользователя из бд
 * @return string описание ошибки
 */
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
/**
 * функция валидации емфил
 * @param string $password данные полученные из формы
 * @param array $user данные пользователя из бд
 * @return string описание ошибки
 */
function validate_login_password($password, $user){
  if($password === ''){
    return 'Введите пароль!';
  }
  if (!password_verify($password, get_value($user, 'password'))) {
    return 'Не верный пароль!';
  }
  return null;
}

