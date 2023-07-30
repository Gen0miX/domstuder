<?php
require_once "models/Model.class.php";
require_once "Image.class.php";

class ImageManager extends Model
{

    private $images;
    private $imagesArt;
    private $imagesMain;

    public function addImageMain($image)
    {
        $this->imagesMain[] = $image;
    }
    public function getImageMainByArtId($artId){
        for ($i = 0; $i < count($this->imagesMain); $i++) {
            if ($this->imagesMain[$i]->getArtId() == $artId) {
                return $this->imagesMain[$i];
            }
        }
        $dummyImg = new Image("0", "dummy-image.jpg", $artId, true);
        return $dummyImg;
    }
    public function getImagesMain($artId)
    {
        for ($i = 0; $i < count($this->images); $i++) {
            if ($this->images[$i]->getArtId() == $artId && $this->images[$i]->getIsMain() == true) {
                return $this->images[$i];
            }
        }
        $dummyImg = new Image("0", "dummy-image.jpg", $artId, true);
        return $dummyImg;
    }
    public function loadImagesMain()
    {
        $req = "SELECT * FROM d_img 
                WHERE isMain = true";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $imagesMain = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($imagesMain as $image) {
            $i = new Image($image['i_id'], $image['path'], $image['a_id'], $image['isMain']);
            $this->addImageMain($i);
        }
    }
    public function addImage($image)
    {
        $this->images[] = $image;
    }
    public function getImages()
    {
        return $this->images;
    }
    public function getImageById($id)
    {
        for ($i = 0; $i < count($this->images); $i++) {
            if ($this->images[$i]->getId() == $id) {
                return $this->images[$i];
            }
        }
        throw new Exception("L'image n'existe pas !");
    }
    public function getImagesByArtId()
    {
        return $this->imagesArt;
    }
    public function loadImages()
    {
        $req = "SELECT * FROM d_img";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $imagesMain = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($imagesMain as $image) {
            $i = new Image($image['i_id'], $image['path'], $image['a_id'], $image['isMain']);
            $this->addImage($i);
        }
    }
    public function addImageArt($image){
        $this->imagesArt[] = $image;
    }
    public function loadImagesByArtId($artId)
    {
        $this->imagesArt = array();
        $req = "SELECT * FROM d_img 
                WHERE a_id = :a_id
                ORDER BY isMain DESC";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":a_id", $artId, PDO::PARAM_INT);
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($images as $image) {
            $i = new Image($image['i_id'], $image['path'], $image['a_id'], $image['isMain']);
            $this->addImageArt($i);
        }
    }
    public function addImageBD($path, $a_id)
    {
        $req = "INSERT INTO d_img (path, a_id, isMain)
                values (:path, :a_id, :isMain";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":path", $path, PDO::PARAM_STR);
        $stmt->bindValue(":a_id", $a_id, PDO::PARAM_INT);
        $stmt->bindValue("isMain", false, PDO::PARAM_BOOL);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = new Image($this->getBdd()->lastInsertId(), $path, $a_id, false);
            $this->addImage($img);
        }

    }
    public function deleteImage($id)
    {
        $req = "DELETE FROM d_img 
                WHERE i_id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = $this->getImageById($id);
            unset($img);
        }
    }
    public function updateImageMain($id, $bool)
    {
        if ($bool = true) {
            foreach ($this->images as $image) {
                if ($image->getIsMain = true) {
                    throw new Exception("Il ne peut y avoir qu'une seule image principale !");
                }
            }
        }

        $req = "UPDATE d_img 
                set isMain = :bool 
                WHERE i_id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("bool", $bool, PDO::PARAM_BOOL);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $this->getImageById($id)->setIsMain($bool);
        }
    }

}