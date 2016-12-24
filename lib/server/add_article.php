<?php       
/*
    Сервер для считывания названий статей из директории source
*/
include '../start.php';
require '../Tools.trait.php';
require '../db.php';
// showDev($_POST);exit();


class AddArticles {
    use Tools;

    // обрабатываем данные с клиента
    public static function checkUserData()
    {
        // в данный контроллер с клиента должен поступить конкретный параметр
        if ( !( isset($_POST['fname']) && $_POST['fname'] != '') ) {
            exit('В массив POST не поступил параметр $_POST["fname"]');
        }
        // по указанному пути должен существовать файл (это временное решение)
        if (!file_exists($_POST['fname'])) {
            exit('Не найден файл - '.$_POST['fname']);
        }
        // соображения безопасности
        return self::clearData($_POST['fname']);
    }

    // функция получает извне полный текст статьи
    public static function getFullArticleInfo($path)
    {
        return explode('#', file_get_contents($path));
    }

    // функция получает текст статьи в строковом виде
    // возвращает массив данных о статье для занесения статьи в БД
    public static function getArrayForArticle($temp)
    {
        $arrArticle = [];// объект, который будет передан классу для работы с БД
        $arrArticle['name']    = $temp[0];                 // название статьи
        $arrArticle['content'] = strip_tags($temp[1]);     // пока так, а потом - подготовленный PDO-запрос
        $arrArticle['link']    = "temp";                   // ссылка на статью
        $arrArticle['size']    = filesize($_POST['fname']);// размер статьи в байтах
        
        $arrWords = explode(' ', self::clearStr($arrArticle['content']));// массив  слов
        $arrArticle['count']   = count($arrWords);         // подсчитали длину статьи

        return $arrArticle;
    }

    // функция получает текст статьи в строковом виде
    // убирает оттуда лишние символы и возвращает массив уникальных слов из статьи
    public static function getArrayForWords($strWords)
    {
        return AddArticles::getUniqueArr( explode(' ', self::clearStr(strip_tags($strWords))) );
    }

    

    // убрать из строки все символы, кроме любых букв и цифр
    private static function clearStr($s)
    {
        return preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/ui", "", $s);
    }

    // убрать повторяющиеся элементы из массива
    private static function getUniqueArr($arr)
    {
        $end = count($arr);
        $arrFinal = [];
        
        for($i = 0; $i < $end; $i++){
            $word = strtolower($arr[$i]);

            if (!array_key_exists($word, $arrFinal)) {
                $arrFinal[$word] = 1;
            } else {
                $arrFinal[$word]++;
            }
        }
        return $arrFinal;
    }
}
/////////////////////////////////////////////////////////////////////

$fname = AddArticles::checkUserData();               // получение и обработка данных от клиента
$temp = AddArticles::getFullArticleInfo($fname);     // получаем текст статьи - откуда-то...

$arrArticle = AddArticles::getArrayForArticle($temp);// информация о статье (в виде массива) - для добавления в БД
$arrWords = AddArticles::getArrayForWords($temp[1]); // массив уникальных слов из статьи - для добавления в БД

// echo '<pre>';print_r($arrArticle);echo '</pre>';
// echo '<pre>';print_r($arrWords);echo '</pre>';exit();
$res = DB::add($arrArticle, $arrWords);

echo json_encode($res);