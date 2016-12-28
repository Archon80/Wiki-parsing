<?php       
/*
    Класс для работы с БД
*/
class DB {
    private $host     = '';
    private $login    = '';
    private $password = '';
    private $db_name  = '';

    public function __construct($db_data) {
        $this->host = $db_data['host'];
        $this->login = $db_data['login'];
        $this->password = $db_data['password'];
        $this->db_name = $db_data['db_name'];
    }

    public function addArticleInDB($arrArticle, $arrWords)
    {
        $db = $this->dbConnect();
        $db->beginTransaction();
        
        // добавление статьи в БД Articles
        $name    = $this->clearData($arrArticle['name']);
        $content = $this->clearData($arrArticle['content']);
        $link    = $this->clearData($arrArticle['link']);
        $size    = $this->clearData($arrArticle['size'], 'i');
        $count   = $this->clearData($arrArticle['count'], 'i');

        $q =    "INSERT INTO articles(`name`,    `content`,    `link`,    `size`,    `count`)
                              VALUES (\"$name\", \"$content\", \"$link\", \"$size\", \"$count\")";
        $query = $db->prepare($q);
        $query->execute();
        $id_article = intval($db->lastInsertId());
        
        // для каждого слова из массива слов статьи
        $l = count($arrWords);
        foreach($arrWords as $k => $v) {
            // безопасная обработка данных
            $k = $this->clearData($k);
            $v = $this->clearData($v, 'i');

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
        return true;
    } // addArticleInDB

    // получение всех слов
    public function getAllArticles()
    {
        $db = $this->dbConnect();
        $q = "SELECT name, link, size, count FROM `articles`";

        $query = $db->prepare($q);
        $query->execute();

        return $query->fetchAll();
    }

    // выборка статей из БД по ключевому слову
    public function getSomeWords($wordName)
    {
        $wordName = $this->clearData($wordName);
        $db = $this->dbConnect();

        $q =   "SELECT articles.id_article, articles.name, articles.content,
                       articles_words.id_article, articles_words.id_word, articles_words.count,
                       words.id_word, words.word
                FROM   `articles`, `articles_words`, `words`
                WHERE  words.word=\"$wordName\"
                AND    articles.id_article = articles_words.id_article
                AND    words.id_word = articles_words.id_word
                ORDER BY articles_words.count DESC";

        $query = $db->prepare($q);
        $query->execute();

        return $query->fetchAll();
    }

    private function dbConnect()
    {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $db = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->login, $this->password, $options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES utf8');

        return $db;
    }

    // стандартизированная обработка данных из форм (POST-параметров из форм и GET-параметров из адресной строки)
    private function clearData($data, $type="s")
    {
        switch ($type)
        {
            case 's':   return trim(htmlspecialchars($data));   // если тип переменной - строка (по умолчанию)
            case 'i':   return abs( (int) $data);                           // если тип переменной - целое число
        }
    }
}

$DB = new DB($db_data);