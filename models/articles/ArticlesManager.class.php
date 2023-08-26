<?php
require_once "models/Model.class.php";
require_once "Article.class.php";
require_once "models/images/ImageManager.class.php";
require_once "models/categories/CategoriesManager.class.php";

class ArticlesManager extends Model
{
    private $articles;
    private $imagesManager;
    private $categoriesManager;

    public function __construct(ImageManager $imageManager, CategoriesManager $categoryManager)
    {
        $this->imagesManager = $imageManager;
        $this->categoriesManager = $categoryManager;
    }

    public function addArticle($article)
    {
        $this->articles[] = $article;
    }
    public function getArticles()
    {
        return $this->articles;
    }
    public function loadArticles()
    {
        $req = $this->getBdd()->prepare("SELECT * FROM d_art");
        $req->execute();
        $articles = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($articles as $article) {
            $a = new Article(
                $article['a_id'],
                $article['titre'],
                $article['description'],
                $this->imagesManager->getImageMainByArtId($article['a_id']),
                $this->imagesManager->getImagesByArtId($article['a_id']),
                $this->categoriesManager->getCategoryById($article['cat_id'])
            );
            $this->addArticle($a);
        }
    }
    public function getArticleById($id)
    {
        for ($i = 0; $i < count($this->articles); $i++) {
            if ($this->articles[$i]->getId() == $id) {
                return $this->articles[$i];
            }
        }
        throw new Exception("L'article n'existe pas !");
    }
    public function addArticleBd($title, $description, $catId)
    {
        $req = "INSERT INTO d_art (titre, description, cat_id)
                VALUES (:titre, :description, :cat_id)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":titre", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":cat_id", $catId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            return $this->getBdd()->lastInsertId();
        }
    }
    public function deleteArticleBd($id)
    {
        $req = "DELETE FROM d_art where a_id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if ($resultat > 0) {
            $article = $this->getArticleById($id);
            unset($article);
        }
    }
    public function modifyArticleBd($id, $title, $description, $catId)
    {
        $req = "UPDATE d_art 
                set titre = :titre, description = :description, cat_id = :cat_id
                WHERE a_id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":cat_id", $catId, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if ($resultat > 0) {
            $this->getArticleById($id)->setTitle($title);
            $this->getArticleById($id)->setDescription($description);
            $this->getArticleById($id)->setCategory($catId);

        }
    }
}