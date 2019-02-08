<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
    return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format($number) {
    $number = ceil($number);
    if ($number >= 1000) {
        return number_format($number, 0, null, ' ') . ' &#8381;';
    }
    return $number . ' &#8381;';
}

function time_tomorrow() {
    $ts_midnight = strtotime('tomorrow midnight');
    $secs_to_midnight = $ts_midnight - time();
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    $result = sprintf( '%02d:%02d', $hours, $minutes) ;
    return $result;
}