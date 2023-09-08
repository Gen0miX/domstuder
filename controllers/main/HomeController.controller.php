<?php

require_once "models/articles/ArticlesManager.class.php";
require_once "models/categories/CategoriesManager.class.php";
require_once "models/images/ImageManager.class.php";

class HomeController {

    private $articlesManager;
    private $categoriesManager;
    private $imagesManager;

    public function __construct()
    {
        $this->imagesManager = new ImageManager();
        $this->imagesManager->loadImages();
        $this->categoriesManager = new CategoriesManager();
        $this->categoriesManager->loadCategories();
        $this->articlesManager = new ArticlesManager($this->imagesManager, $this->categoriesManager);
        $this->articlesManager->loadArticles();
    }

    public function showHome() {
        $graphics = $this->articlesManager->getLastEntriesArticlesByCatId(1);
        $illustrations = $this->articlesManager->getLastEntriesArticlesByCatId(2);
        $paintings = $this->articlesManager->getLastEntriesArticlesByCatId(3);
        require "views/main/home.view.php";
    }
    
}