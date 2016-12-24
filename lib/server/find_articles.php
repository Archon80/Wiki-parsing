<?php       
/*
    Сервер для считывания названий статей из директории source
*/
require_once '../start.php';
// showDev($_POST);exit();

function is_txt($name)
{
   $arr =  explode('.', $name);
   return $arr[count($arr) - 1] === 'txt';
}
function findArticles($dir)
{
   $odir = opendir($dir);
   $arrFiles = [];
   
   while($file = readdir($odir))
   {
        $full = $dir.DIRECTORY_SEPARATOR.$file;

        if (is_file($full) && is_txt($full)) {
            $arrFiles[] = $file;
        }
    }
    closedir($odir);

    return $arrFiles;
}

$arrArticles = findArticles('../../source');

echo json_encode($arrArticles);