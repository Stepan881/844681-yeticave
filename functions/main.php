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
