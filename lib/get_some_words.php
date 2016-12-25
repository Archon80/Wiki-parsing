<?php       
/*
    Сервер для считывания названий статей из директории source
*/
require 'Tools.trait.php';
require 'db.php';

$answer = [
    "success" => false,
    "body"    => '',
    "error"   => ''
];

// если не поступил параметр, т.е. юзер отключил javascript у себя в браузере
// и все же послал "пустой" запрос, не ожидая, что мы и на сервере все проверяем...
if ( !( isset($_POST['wordName']) && $_POST['wordName'] != '') ) {
    $answer['error'] = 'В массив POST не поступил параметр $_POST["wordName"]';
    echo json_encode($answer);
}
// если запрос поступил нормально
else {
	$articles = DB::getSomeWords($_POST['wordName']);
	// echo '<pre>';print_r($articles);echo '</pre>';
	echo json_encode($articles);
}