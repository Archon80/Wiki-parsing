<?php       
/*
    Сервер для считывания названий статей из директории source
*/
include '../start.php';
require '../Tools.trait.php';
require '../db.php';

$articles = DB::getAllArticles();
// echo '<pre>';print_r($articles);echo '</pre>';
echo json_encode($articles);