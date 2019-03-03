<?php

function parse_extension($filename) {
  $info = new SplFileInfo($filename);
  return $info->getExtension();
}

/**
 * Загрузка файла на сервер
 *
 * @param $tmp_path string временный путь до файла
 * @param $filename string реальное имя файла {для извлечения расширения}
 *
 * @return string путь до загруженного файла
 */

function upload_img($tmp_path, $filename) {
  $ext = parse_extension($filename);
  $path = 'img/' . uniqid() . '.' . $ext;
  move_uploaded_file($tmp_path, $path);
  return $path;
}

