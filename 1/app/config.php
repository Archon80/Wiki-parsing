<?php
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');

// учетные данные для подключения к БД
$db_data = [
	'host'     => 'localhost',
    'login'    => 'root',
    'password' => '290980',
    'db_name'  => 'CUBA'
];

