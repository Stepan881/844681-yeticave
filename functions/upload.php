<?php

/**
 * Загрузка файла на сервер
 * @param string $tmp_path временный путь до файла
 * @param string $filename реальное имя файла {для извлечения расширения}
 * @return string путь до загруженного файла
 */
function upload_img($tmp_path, $filename) {
  $ext = parse_extension($filename);
  $path = 'uploads/' . uniqid() . '.' . $ext;
  if (!move_uploaded_file($tmp_path, $path)) {
    die('Не найдена папка uploads или отсутствуют права на запись в неё');
  }
  return $path;
}
/**
 * функция парсит разширение у файла
 * @param string $filename имя файла
 * @return string
 */
function parse_extension($filename) {
  $info = new SplFileInfo($filename);
  return $info->getExtension();
}