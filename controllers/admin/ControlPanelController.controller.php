<?php

require_once "models/articles/ArticlesManager.class.php";

class ControlPanelController
{
    private $articlesManager;

    public function __construct()
    {
        $this->articlesManager = new ArticlesManager();
        $this->articlesManager->loadArticles();
    }
    public function showArticles()
    {
        $articles = $this->articlesManager->getArticles();
        require "views/admin/controlPanel.view.php";
    }
}