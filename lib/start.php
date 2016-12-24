<?php       
// настройки соединения
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');

// отладочный вывод произвольных данных
function showDev($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}