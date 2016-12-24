<?php       
/*
    Сервер для считывания названий статей из директории source
*/
include '../start.php';
require '../Tools.trait.php';
require '../db.php';

// в данный контроллер с клиента должен поступить конкретный параметр
if ( !( isset($_POST['wordName']) && $_POST['wordName'] != '') ) {
    exit('В массив POST не поступил параметр $_POST["wordName"]');
}

$articles = DB::getSomeWords($_POST['wordName']);
// echo '<pre>';print_r($articles);echo '</pre>';
echo json_encode($articles);