<?php

require_once "models/articles/ArticlesManager.class.php";
require_once "models/categories/CategoriesManager.class.php";

class ControlPanelController
{
    private $articlesManager;
    private $categoriesManager;

    public function __construct()
    {
        $this->articlesManager = new ArticlesManager();
        $this->articlesManager->loadArticles();
        $this->categoriesManager = new CategoriesManager();
        $this->categoriesManager->loadCategories();
    }
    public function showArticles()
    {
        $articles = $this->articlesManager->getArticles();
        require "views/admin/controlPanel.view.php";
    }
    public function modifyArticle($id){
        $article = $this->articlesManager->getArticleById($id);
        $images = $this->articlesManager->getImagesByArtId($id);
        $article->setImages($images);
        $categories = $this->categoriesManager->getCategories();
        require "views/admin/modifyArticle.view.php";
    }
    public function deleteImage($id, $artId) {
       $article = $this->articlesManager->getArticleById($artId);
       $images = $article->getImages();
       foreach($images as $img) {
        if($img->getId() == $id) {
            unset($img);
        }
       }
       $article->setImages($images);
       require "views/admin/modifyArticle.view.php";
    }
}