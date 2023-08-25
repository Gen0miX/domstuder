<?php

require_once "models/articles/ArticlesManager.class.php";
require_once "models/categories/CategoriesManager.class.php";
require_once "models/images/ImageManager.class.php";

class ControlPanelController
{
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
    public function showArticles()
    {
        $articles = $this->articlesManager->getArticles();
        require "views/admin/controlPanel.view.php";
    }
    public function modifyArticle($id){
        $article = $this->articlesManager->getArticleById($id);
        $categories = $this->categoriesManager->getCategories();
        require "views/admin/modifyArticle.view.php";
    }

    public function modifyArticleValidate($artId) {
        $this->articlesManager->modifyArticleBd($artId, $_POST['title'], $_POST['description'], $_POST['category']);
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    public function deleteImage($id, $artId) {
       $this->imagesManager->deleteImage($id);
       $imageToDelete = $this->imagesManager->getImageById($id);
       unlink("public/images/img-art/".$imageToDelete->getPath());
       header('Location: '.URL."admin/cp/m/".$artId);
    }

    public function changeImageMain($id, $artId) {
        if($this->imagesManager->getImageById($id)->getIsMain() == true) {
            header('Location: '.URL."admin/cp/m/".$artId);
        }
        $oldImageMainId= $this->imagesManager->getImageMainByArtId($artId)->getId();
        $this->imagesManager->updateImageMain($id, $oldImageMainId);
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    public function addImages($artId) {
        if(!empty($_FILES['images']['name'][0])) {
            $images = $this->reArrayFiles($_FILES['images']);
            foreach($images as $img) {
                $rep = "public/images/img-art/".$artId."/";
                $fileName = $this->addImage($img, $rep);
                $path = $artId."/".$fileName;
                $this->imagesManager->addImageBD($path, $artId);
            }
        }
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    private function addImage($file, $dir)
    {
        if (!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        if (!file_exists($dir))
            mkdir($dir, 0777);

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $random = rand(0, 99999);
        $target_file = $dir . $random . "_" . $file['name'];

        if (!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if (file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if ($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if (!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else
            return ($random . "_" . $file['name']);
    }

    private function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
}