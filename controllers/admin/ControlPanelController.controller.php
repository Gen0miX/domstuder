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
        $this->imagesManager->loadImagesTmp();
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
    public function deleteArticle($id) {
        $this->imagesManager->deleteImageByArtId($id);
        $this->articlesManager->deleteArticleBd($id);
        $imgFolderPath = "public/images/img-art/".$id ;
        array_map('unlink', glob("$imgFolderPath/*.*"));
        rmdir($imgFolderPath);
        header('Location: '.URL."admin/cp/");
    }

    // Méthodes pour la page d'ajout d'articles
    public function addArticle() {
        $tmpPath = "public/images/img-art/tmp/".session_id()."/";
        if(!is_null($this->imagesManager->getImagesTmp())) {
            $images = $this->imagesManager->getImagesTmp();
        } else {
            $images = array();
        }
        $categories = $this->categoriesManager->getCategories();
        $addUrl = URL . "admin/cp/a";
        require "views/admin/addArticle.view.php";
    }
    public function addArticleValidate() {
        $artId = $this->articlesManager->addArticleBd($_POST['title'], $_POST['description'], $_POST['category']);
        $imagesTemp = $this->imagesManager->getImagesTmp() ;
        foreach($imagesTemp as $imgTmp) {
            $this->imagesManager->addImageBDWMain($artId."/".$imgTmp->getPath(), $artId, $imgTmp->getIsMain()) ;
        }
        $this->imagesManager->deleteAllRecordsImgTmp();
        $this->moveTmpFiles($artId);
        header('Location: '.URL."admin/cp/");
    }
    public function cancelAddArticle() {
        $this->imagesManager->deleteAllRecordsImgTmp();
        $this->deleteTmpFiles();
        header('Location: '.URL."admin/cp/");
    }
    public function addImagesTemp() {
        if(!empty($_FILES['images']['name'][0])) {
            $images = $this->reArrayFiles($_FILES['images']);
            foreach($images as $img) {
                $rep = "public/images/img-art/tmp/".session_id()."/";
                $fileName = $this->addImage($img, $rep);
                $path = $fileName;
                $this->imagesManager->addImageTmpBD($path);
            }
        }
        header('Location: '.URL."admin/cp/a");
    }
    public function changeImageTempMain($id) {
        if($this->imagesManager->getImageTmpById($id)->getIsMain() == true) {
            header('Location: '.URL."admin/cp/a/");
        }
        if(is_null($this->imagesManager->getImageMainTmp())) {
            $this->imagesManager->setImageTmpMain($id);
        } else {
            $oldImageTmpMainId = $this->imagesManager->getImageMainTmp()->getId();
            $this->imagesManager->updateImageTmpMain($id, $oldImageTmpMainId);
        }
        header('Location: '.URL."admin/cp/a/");
    }
    public function deleteImageTmpAdd($id) {
        $this->imagesManager->deleteImageTmp($id);
        $imageToDelete = $this->imagesManager->getImageTmpById($id);
        unlink("public/images/img-art/tmp/".session_id()."/".$imageToDelete->getPath());
        header('Location: '.URL."admin/cp/a/");
    }

    // Méthodes pour la page de modification d'articles
    public function modifyArticle($id){
        $tmpPath = "public/images/img-art/tmp/".session_id()."/";
        $article = $this->articlesManager->getArticleById($id);
        $categories = $this->categoriesManager->getCategories();
        if(isset($_POST['oldImageMainId'])){
            $_SESSION['firstImgMainId'] = $_POST['oldImageMainId'];
        }
        if(!is_null($this->imagesManager->getImagesTmp())) {
            $imagesTmp = $this->imagesManager->getImagesTmp();
        } else {
            $imagesTmp = array();
        }
        require "views/admin/modifyArticle.view.php";
    }

    public function modifyArticleValidate($artId) {
        
        $this->articlesManager->modifyArticleBd($artId, $_POST['title'], $_POST['description'], $_POST['category']);
        $imagesTemp = $this->imagesManager->getImagesTmp() ;
        foreach($imagesTemp as $imgTmp) {
            $this->imagesManager->addImageBDWMain($artId."/".$imgTmp->getPath(), $artId, $imgTmp->getIsMain()) ;
        }
        $this->imagesManager->deleteAllRecordsImgTmp();
        $this->moveTmpFiles($artId);
        header('Location: '.URL."admin/cp");
    }

    public function cancelModifyArticle($artId) {
        
        if (!is_null($this->imagesManager->getImageMainByArtId($artId))) {
            $this->imagesManager->updateImageMain($_SESSION['firstImgMainId'], $this->imagesManager->getImageMainByArtId($artId)->getId());
        }else if (!is_null($this->imagesManager->getImageMainTmp())) {
            $this->imagesManager->updateImageMainOldTmp($_SESSION['firstImgMainId'], $this->imagesManager->getImageMainTmp()->getId());
        }

        if(!is_null($this->imagesManager->getImagesTmp())) {
            $this->imagesManager->deleteAllRecordsImgTmp();
            $this->deleteTmpFiles();
        }

        header('Location: '.URL."admin/cp/");
    }

    public function deleteImage($id, $artId) {
       $this->imagesManager->deleteImage($id);
       $imageToDelete = $this->imagesManager->getImageById($id);
       unlink("public/images/img-art/".$imageToDelete->getPath());
       header('Location: '.URL."admin/cp/m/".$artId);
    }
    public function deleteImageTmpModify($id, $artId) {
        $this->imagesManager->deleteImageTmp($id);
        $imageToDelete = $this->imagesManager->getImageTmpById($id);
        unlink("public/images/img-art/tmp/".session_id()."/".$imageToDelete->getPath());
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    public function changeImageMain($id, $artId) {
        if(isset($_POST["main_img"])) {
            if($this->imagesManager->getImageById($id)->getIsMain() == true) {
                header('Location: '.URL."admin/cp/m/".$artId);
            }
            if(is_null($this->imagesManager->getImageMainByArtId($artId)) && is_null($this->imagesManager->getImageMainTmp())){
                $this->imagesManager->setImageMain($id);
            } else {
                if (!is_null($this->imagesManager->getImageMainByArtId($artId))) {
                    $oldImageMainId= $this->imagesManager->getImageMainByArtId($artId)->getId();
                    $this->imagesManager->updateImageMain($id, $oldImageMainId);
                }else if (!is_null($this->imagesManager->getImageMainTmp())) {
                    $oldImageMainId = $this->imagesManager->getImageMainTmp()->getId();
                    $this->imagesManager->updateImageMainOldTmp($id, $oldImageMainId);
                }
            }
        }else if (isset($_POST["main_tmp"])) {
            if($this->imagesManager->getImageTmpById($id)->getIsMain() == true) {
                header('Location: '.URL."admin/cp/m/".$artId);
            }
            if(is_null($this->imagesManager->getImageMainByArtId($artId)) && is_null($this->imagesManager->getImageMainTmp())){
                $this->imagesManager->setImageTmpMain($id);
            } else {
                if (!is_null($this->imagesManager->getImageMainByArtId($artId))) {
                    $oldImageMainId= $this->imagesManager->getImageMainByArtId($artId)->getId();
                    $this->imagesManager->updateImageMainOldMain($id, $oldImageMainId);
                }else if (!is_null($this->imagesManager->getImageMainTmp())) {
                    $oldImageMainId = $this->imagesManager->getImageMainTmp()->getId();
                    $this->imagesManager->updateImageTmpMain($id, $oldImageMainId);
                }
            }
        }
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    public function addImages($artId) {
        if(!empty($_FILES['images']['name'][0])) {
            $images = $this->reArrayFiles($_FILES['images']);
            foreach($images as $img) {
                $rep = "public/images/img-art/tmp/".session_id()."/";
                $fileName = $this->addImage($img, $rep);
                $path = $fileName;
                $this->imagesManager->addImageTmpBD($path);
            }
        }
        header('Location: '.URL."admin/cp/m/".$artId);
    }

    //Méthodes générales
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

    private function moveTmpFiles($artId) {

        if(!file_exists("public/images/img-art/".$artId)){
            mkdir("public/images/img-art/".$artId);
        }
    
        // Get array of all source files
        $files = scandir("public/images/img-art/tmp/".session_id()."/");
        // Identify directories
        $source = "public/images/img-art/tmp/".session_id()."/";
        $destination = "public/images/img-art/".$artId."/";
        // Cycle through all source files
        foreach ($files as $file) {
            if (in_array($file, array(".",".."))) continue;
            // If we copied this successfully, mark it for deletion
            if (copy($source.$file, $destination.$file)) {
            $delete[] = $source.$file;
            }
        }
        // Delete all successfully-copied files
        foreach ($delete as $file) {
            unlink($file);
        }
        rmdir($source);
    }
    private function deleteTmpFiles() {
        $files = glob("public/images/img-art/tmp/".session_id()."/*");
        foreach ($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
        rmdir("public/images/img-art/tmp/".session_id()."/");
    }
}