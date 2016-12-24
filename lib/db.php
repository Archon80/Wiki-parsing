<?php       
/*
    Класс для работы с БД
*/
class DB {
    use Tools;

    private static function dbConnect()
    {
        $host     = 'localhost';
        $login    = 'root';
        $password = '290980';
        $db_name  = 'CUBA';

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $db = new PDO('mysql:host='.$host.';dbname='.$db_name, $login, $password, $options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES utf8');

        return $db;
    }

    public static function add($arrArticle, $arrWords)
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {
            // выполняем проверки для массива статьи и массива слов из статьи
            $checkArticle = self::checkArticle($arrArticle);
            if ($checkArticle !== 0) {
                throw new PDOException($checkArticle);
            }
            $checkWords = self::checkWords($arrWords);
            if ($checkWords !== 0) {
                throw new PDOException($checkWords);
            }

            // устанавливаем соединение и открываем транзакцию
            $db = self::dbConnect();
            $db->beginTransaction();
            
            // добавление статьи в БД Articles
            $name    = self::clearData($arrArticle['name']);
            $content = self::clearData($arrArticle['content']);
            $link    = self::clearData($arrArticle['link']);
            $size    = self::clearData($arrArticle['size'], 'i');
            $count   = self::clearData($arrArticle['count'], 'i');

            $arrToClient = ["name"=>$name, "link"=>$link, "size"=>$size, "count"=>$count];

            $q =    "INSERT INTO articles(`name`,    `content`,    `link`,    `size`,    `count`)
                                  VALUES (\"$name\", \"$content\", \"$link\", \"$size\", \"$count\")";
            $query = $db->prepare($q);
            $query->execute();
            $id_article = intval($db->lastInsertId());
            
            // для каждого слова из массива слов статьи
            $l = count($arrWords);
            foreach($arrWords as $k => $v) {
                // безопасная обработка данных
                $k = self::clearData($k);
                $v = self::clearData($v, 'i');

                // добавляем слово-атом в таблицу Words
                $q = "INSERT INTO words(`word`) VALUES (\"$k\")";
                $query = $db->prepare($q);
                $query->execute();
                $id_word = intval($db->lastInsertId());

                // добавляем запись в таблицу связей
                $q = "INSERT INTO articles_words(`id_article`, `id_word`, `count`)
                    VALUES (\"$id_article\", \"$id_word\", \"$v\")";
                $query = $db->prepare($q);
                $query->execute();
            }

            $db->commit();
            $answer["success"] = true;
            $answer["body"] = $arrToClient;
            // self::showDev($arrToClient);exit();
        }  
        catch(PDOException $e) {  
            $db->rollBack();
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }

    }

    public static function checkArticle($arrArticle)
    {
        // общий параметр
        if(!isset($arrArticle)) {
            return 'В класс для работы с БД не пришел параметр arrArticle.';
        }
        if(getType($arrArticle) !== 'array') {
            return 'В класс для работы с БД 1-ым параметром пришел не массив.';
        }
        // проверяем параметр "имя статьи"
        if(!isset($arrArticle['name'])) {
            return "В классе для работы с БД в массиве arrArticle отсутствует поле arrArticle['name'].";
        }
        if(getType($arrArticle['name']) !== 'string') {
            return "В классе для работы с БД параметр arrArticle['name'] - не строка.";
        }
        // проверяем параметр "текст статьи"
        if(!isset($arrArticle['content'])) {
            return "В классе для работы с БД в массиве arrArticle отсутствует поле arrArticle['content'].";
        }
        if(getType($arrArticle['content']) !== 'string') {
            return "В классе для работы с БД параметр arrArticle['content'] - не строка.";
        }
        // проверяем параметр "ссылка на статью"
        if(!isset($arrArticle['link'])) {
            return "В классе для работы с БД в массиве arrArticle отсутствует поле arrArticle['link'].";
        }
        if(getType($arrArticle['link']) !== 'string') {
            return "В классе для работы с БД параметр arrArticle['link'] - не строка.";
        }
        // проверяем параметр "размер статьи"
        if(!isset($arrArticle['size'])) {
            return "В классе для работы с БД в массиве arrArticle отсутствует поле arrArticle['size'].";
        }
        if(getType($arrArticle['size']) !== 'integer') {
            return "В классе для работы с БД параметр arrArticle['link'] - не целочисленное значение.";
        }
        // проверяем параметр "число слов в статье"
        if(!isset($arrArticle['count'])) {
            return "В классе для работы с БД в массиве arrArticle отсутствует поле arrArticle['count'].";
        }
        if(getType($arrArticle['size']) !== 'integer') {
            return "В классе для работы с БД параметр arrArticle['link'] - не целочисленное значение.";
        }
        return 0;
    } // checkArticle

    public static function checkWords($arrWords)
    {
        if(!isset($arrWords)) {
            return 'В класс для работы с БД не поступил параметр arrWords.';
        }
        if(getType($arrWords) !== 'array') {
            return 'В класс для работы с БД в параметре arrWords пришел не массив.';
        }
        if(count($arrWords) == 0) {
            return 'В класс для работы с БД в параметре arrWords пришел пустой массив.';
        }

        return 0;
    } // checkWords

    // получение всех слов
    public static function getAllArticles()
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {
            $db = self::dbConnect();

            $q = "SELECT name, link, size, count FROM `articles`";

            $query = $db->prepare($q);
            $query->execute();

            $res = $query->fetchAll();

            $answer["success"] = true;
            $answer["body"]    = $res;
        }  
        catch(PDOException $e) {  
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // getAllArticles

    // получение всех слов
    public static function getOneArticle($articleName)
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {
            // выполняем необходимые проверки
            if(!isset($articleName)) {
                throw new PDOException('В функцию getOneArticle не пришел параметр articleName.');
            }
            if(getType($articleName) !== 'string') {
                throw new PDOException('В функцию getOneArticle в качестве параметра articleName пришла не строка.');
            }
            $articleName = self::clearData($articleName);

            $db = self::dbConnect();

            $q = "SELECT content FROM `articles` WHERE name=\"$articleName\"";

            $query = $db->prepare($q);
            $query->execute();

            $res = $query->fetchAll();

            $answer["success"] = true;
            $answer["body"]    = $res[0];
        }  
        catch(PDOException $e) {  
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // getOneArticle

    // получение всех слов
    public static function getSomeWords($wordName)
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {
            // выполняем необходимые проверки
            if(!isset($wordName)) {
                throw new PDOException('В функцию getSomeWords не пришел параметр wordName.');
            }
            if(getType($wordName) !== 'string') {
                throw new PDOException('В функцию getSomeWords в качестве параметра wordName пришла не строка.');
            }
            $wordName = self::clearData($wordName);

            $db = self::dbConnect();

            $q =   "SELECT articles.id_article, articles.name, articles.content,
                           articles_words.id_article, articles_words.id_word, articles_words.count,
                           words.id_word, words.word
                    FROM   `articles`, `articles_words`, `words`
                    WHERE  articles.id_article = articles_words.id_article
                    AND    articles_words.id_word = words.id_word
                    AND    words.word=\"$wordName\"
                    ORDER BY articles_words.count DESC";

            $query = $db->prepare($q);
            $query->execute();

            $res = $query->fetchAll();
            // self::showDev($res);exit();

            $answer["success"] = true;
            $answer["body"]    = $res;
        }  
        catch(PDOException $e) {  
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // getSomeWords

    // получение всех слов
    public static function getAllWords()
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {
            $db = self::dbConnect();

            $q = "SELECT word FROM `words`";

            $query = $db->prepare($q);
            $query->execute();

            $res = $query->fetchAll();

            $answer["success"] = true;
            $answer["body"]    = $res;
        }  
        catch(PDOException $e) {  
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // getAllWords
    

    
/*
    public static function addWords($arrWords)
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"   => ''
        ];

        try {

            // общий параметр
            if(!isset($arrArticle)) {
                throw new PDOException('В функцию add не пришел параметр arrArticle.');
            }
            if(getType($arrArticle) !== 'array') {
                throw new PDOException('В функцию add 1-ым параметром пришел не массив.');
            }
            // проверяем параметр "имя статьи"
            if(!isset($arrArticle['name'])) {
                throw new PDOException("В функции add в массиве arrArticle отсутствует поле arrArticle['name'].");
            }
            if(getType($arrArticle['name']) !== 'string') {
                throw new PDOException("В функции add параметр arrArticle['name'] - не строка.");
            }
            // проверяем параметр "текст статьи"
            if(!isset($arrArticle['content'])) {
                throw new PDOException("В функции add в массиве arrArticle отсутствует поле arrArticle['content'].");
            }
            if(getType($arrArticle['content']) !== 'string') {
                throw new PDOException("В функции add параметр arrArticle['content'] - не строка.");
            }
            // проверяем параметр "ссылка на статью"
            if(!isset($arrArticle['link'])) {
                throw new PDOException("В функции add в массиве arrArticle отсутствует поле arrArticle['link'].");
            }
            if(getType($arrArticle['link']) !== 'string') {
                throw new PDOException("В функции add параметр arrArticle['link'] - не строка.");
            }
            // проверяем параметр "размер статьи"
            if(!isset($arrArticle['size'])) {
                throw new PDOException("В функции add в массиве arrArticle отсутствует поле arrArticle['size'].");
            }
            if(getType($arrArticle['size']) !== 'integer') {
                throw new PDOException("В функции add параметр arrArticle['link'] - не целочисленное значение.");
            }
            // проверяем параметр "число слов в статье"
            if(!isset($arrArticle['count'])) {
                throw new PDOException("В функции add в массиве arrArticle отсутствует поле arrArticle['count'].");
            }
            if(getType($arrArticle['size']) !== 'integer') {
                throw new PDOException("В функции add параметр arrArticle['link'] - не целочисленное значение.");
            }


            $name     = self::clear_data($arrArticle['name'],    's');
            $content  = self::clear_data($arrArticle['content'],    's');

            if(self::checkNewUserName($name)) {
              $answer["success"] = false;
              $answer["body"]    = 'Пользователь с таким именем уже существует';
            }
            else if(self::checkNewUserEmail($email)) {
              $answer["success"] = false;
              $answer["body"]    = 'Пользователь с такой почтой уже существует';
            }
            else {
              $db = self::db_connect();

              $q = "INSERT INTO users(`name`, `email`, `password`)
                  VALUES (\"$name\", \"$email\", \"$password\")";

              // self::showDev($q);
              // exit();

              $query = $db->prepare($q);
              $query->execute();

              $answer["success"] = true;
              $answer["body"]    = intval($db->lastInsertId());
            }     

        }  
        catch(PDOException $e) {  
            $answer["error"] = $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // addWords
*/
}