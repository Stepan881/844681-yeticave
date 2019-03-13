<?php
/**
 * Валидация юзера при регистрации
 *
 * @param mysqli $connection Соединение с базой
 * @param array $user_data данные юзера с формы
 * @param array $file_data фотография(аватарка)
 * @return array описание ошибок
 */
function validate_user($connection, $user_data, $file_data){
  $errors = [];
  if ($error = validate_email(get_value($user_data, 'email'), $connection)) {
    $errors['email'] = $error;
  }
  if ($error = validate_password(get_value($user_data, 'password'))) {
    $errors['password'] = $error;
  }
  if ($error = validate_name(get_value($user_data, 'name'))) {
    $errors['name'] = $error;
  }
  if ($error = validate_contacts(get_value($user_data, 'contacts'))) {
    $errors['contacts'] = $error;
  }
  if ($error = validate_avatar_img($file_data)) {
    $errors['avatar'] = $error;
  }
  return $errors;
}
/**
 * Валидация емайла
 *
 * @param mysqli $connection Соединение с базой
 * @param string $email email юзера с формы
 * @return string описание ошибки
 */
function validate_email($email, $connection){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 'E-mail адрес указан не верно.';
  }
  if (isset_email($email, $connection)){
    return 'Пользователь с этим email уже зарегистрирован';
  }
  return null;
}
/**
 * Валидация пароля
 *
 * @param string $password пароль юзера с формы
 * @return string описание ошибки
 */
function validate_password($password){
  if($password === ''){
    return 'Заполните пароль!';
  }
  if(mb_strlen($password) > 100 ){
    return 'Пароль не должен превышать 100 символов!';
  }
  return null;
}
/**
 * Валидация пароля
 *
 * @param string $name имя юзера с формы
 * @return string описание ошибки
 */
function validate_name($name){
  if($name === ''){
    return 'Введите Имя!';
  }
  if(mb_strlen($name) > 100 ){
    return 'Имя не должно превышать 100 символов!';
  }
  return null;
}
/**
 * Валидация контактных данных
 *
 * @param string $contacts Контактные данные с формы
 * @return string описание ошибки
 */
function validate_contacts($contacts){
  if($contacts === ''){
    return 'Введите Контактные данные!';
  }
  if(mb_strlen($contacts) > 255 ){
    return 'Контактные данные не должны превышать 255 символов!';
  }
  return null;
}
/**
 * Валидация типа файла, проверяет является фаил jpg, png, gif
 * не обьязательный выбор файла
 * @param array $file_data тип файла
 * @return string описание ошибки
 */
function validate_avatar_img($file_data){
  if (!empty(get_value($file_data, 'tmp_name'))){
    if (!is_image(get_value($file_data, 'type'))){
      return 'Загрузите jpg, png, jpeg';
    }
  }
  return null;
}