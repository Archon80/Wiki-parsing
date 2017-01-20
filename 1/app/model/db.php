<?php       
class DB {
    private $host     = '';
    private $login    = '';
    private $password = '';
    private $db_name  = '';
    private $db       = '';

    public function __construct($db_data) {
        $this->host     = $db_data['host'];
        $this->login    = $db_data['login'];
        $this->password = $db_data['password'];
        $this->db_name  = $db_data['db_name'];
        $this->db       = $this->dbSafeConnect();
    }

    // получение всех слов
    public function getAllArticles()
    {
        return $this->db->getAll("SELECT * FROM ?n", 'articles');
    }

    // выборка статей из БД по ключевому слову
    public function getSomeWords($wordName)
    {
        $wordName = $this->clearData($wordName);

        $q =   "SELECT articles.id_article, articles.name, articles.content,
                       articles_words.id_article, articles_words.id_word, articles_words.count,
                       words.id_word, words.word
                FROM   ?n, ?n, ?n
                WHERE  words.word=?s
                AND    articles.id_article = articles_words.id_article
                AND    words.id_word = articles_words.id_word
                GROUP BY articles.name
                ORDER BY articles_words.count
                DESC";

        return $this->db->getAll($q, 'articles', 'articles_words', 'words', $wordName);
    }

    public function addArticleInDB($arrArticle, $arrWords)
    {
        // добавление статьи в БД Articles
        $name    = $this->clearData($arrArticle['name']);
        $content = $this->clearData($arrArticle['content']);
        $link    = $this->clearData($arrArticle['link']);
        $size    = $this->clearData($arrArticle['size'], 'i');
        $count   = $this->clearData($arrArticle['count'], 'i');

        $sql  = "INSERT INTO ?n SET name=?s, content=?s, link=?s, size=?i, count=?i";
        $this->db->query($sql, 'articles', $name, $content, $link, $size, $count);
        $id_article = intval($this->db->insertId());

        // для каждого слова из массива слов статьи
        $l = count($arrWords);
        foreach($arrWords as $k => $v) {
            $k = $this->clearData($k);
            $v = $this->clearData($v, 'i');

            $sql  = "INSERT INTO ?n SET word=?s";
            $this->db->query($sql, 'words', $k);
            $id_word = intval($this->db->insertId());

            $sql  = "INSERT INTO ?n SET id_article=?i, id_word=?i, count=?i";
            $this->db->query($sql, 'articles_words', $id_article, $id_word, $v);
        }

        return true;
    } // addArticleInDB

    private function dbSafeConnect()
    {
        $opts = [
            'user' => $this->login,
            'pass' => $this->password,
            'db' => $this->db_name,
            'charset' => 'utf8'
        ];

        return new SafeMySQL($opts);
    }

    private function clearData($data, $type="s")
    {
        switch ($type)
        {
            case 's':   return trim(htmlspecialchars($data));
            case 'i':   return abs( (int) $data);
        }
    }
}

$DB = new DB($db_data);