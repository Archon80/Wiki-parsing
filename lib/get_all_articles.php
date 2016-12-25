<?php       
/*
    Сервер для считывания названий статей из директории source
*/
require_once 'Tools.trait.php';
require_once 'db.php';

$articles = DB::getAllArticles();
// echo '<pre>';print_r($articles);echo '</pre>';
echo json_encode($articles);