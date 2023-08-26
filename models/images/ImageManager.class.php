<?php
require_once "models/Model.class.php";
require_once "Image.class.php";

class ImageManager extends Model
{

    private $images;
    private $imagesTemp;

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

    public function getImagesByArtId($artId) {
        $imagesArt = array();
        for ($i = 0; $i < count($this->images); $i++) {
            if($this->images[$i]->getArtId() == $artId) {
                $imagesArt[] = $this->images[$i];
            }
        }
        return $imagesArt;
    }

    public function getImageMainByArtId($artId) {
        for($i = 0; $i < count($this->images); $i++) {
            if($this->images[$i]->getArtId() == $artId && $this->images[$i]->getIsMain() == true) {
                return $this->images[$i];
            }
        }
        $dummyImg = new Image("0", "dummy-image.jpg", $artId, true);
        return $dummyImg;
    }

    public function addImageBD($path, $a_id)
    {
        $req = "INSERT INTO d_img (path, a_id, isMain)
                values (:path, :a_id, :isMain)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":path", $path, PDO::PARAM_STR);
        $stmt->bindValue(":a_id", $a_id, PDO::PARAM_INT);
        $stmt->bindValue("isMain", false, PDO::PARAM_BOOL);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = new Image($this->getBdd()->lastInsertId(), $path, $a_id, false);
        }
        $this->addImage($img);
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
    public function updateImageMain($newMainId, $oldMainId)
    {
        $req = "UPDATE d_img
                set isMain = false
                WHERE i_id = :oldid;
                UPDATE d_img
                set isMain = true
                WHERE i_id = :newid;";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("oldid", $oldMainId, PDO::PARAM_INT);
        $stmt->bindValue("newid", $newMainId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result > 0) {
            $this->getImageById($oldMainId)->setIsMain(false);
            $this->getImageById($newMainId)->setIsMain(true);
        }
    }
  
    public function loadImagesTmp()
    {
        $req = "SELECT * FROM d_img_tmp";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $imagesMain = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($imagesMain as $image) {
            $i = new Image($image['i_id'], $image['path'], 0, $image['isMain']);
            $this->addImageTmp($i);
        }
    }

    public function addImageTmp($image)
    {
        $this->imagesTemp[] = $image;
    }

    public function getImagesTmp()
    {
        return $this->imagesTemp;
    }

    public function getImageTmpById($id)
    {
        for ($i = 0; $i < count($this->imagesTemp); $i++) {
            if ($this->imagesTemp[$i]->getId() == $id) {
                return $this->imagesTemp[$i];
            }
        }
        throw new Exception("L'image n'existe pas !");
    }
    public function addImageTmpBD($path)
    {
        $req = "INSERT INTO d_img_tmp (path, isMain)
                values (:path, :isMain)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":path", $path, PDO::PARAM_STR);
        $stmt->bindValue("isMain", false, PDO::PARAM_BOOL);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = new Image($this->getBdd()->lastInsertId(), $path, 0, false);
        }
        $this->addImageTmp($img);
    }
    public function deleteImageTmp($id)
    {
        $req = "DELETE FROM d_img_tmp 
                WHERE i_id = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = $this->getImageTmpById($id);
            unset($img);
        }
    }
    public function getImageMainTmp() {
        for($i = 0; $i < count($this->imagesTemp); $i++) {
            if( $this->imagesTemp[$i]->getIsMain() == true) {
                return $this->imagesTemp[$i];
            }
        }
       return null ;
    }
    public function setImageTmpMain($id) {
        $req = "UPDATE d_img_tmp
                set isMain = true
                WHERE i_id = :id;";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result > 0) {
            $this->getImageTmpById($id)->setIsMain(true);
        }
    }

    public function updateImageTmpMain($newMainId, $oldMainId)
    {
        $req = "UPDATE d_img_tmp
                set isMain = false
                WHERE i_id = :oldid;
                UPDATE d_img_tmp
                set isMain = true
                WHERE i_id = :newid;";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("oldid", $oldMainId, PDO::PARAM_INT);
        $stmt->bindValue("newid", $newMainId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result > 0) {
            $this->getImageTmpById($oldMainId)->setIsMain(false);
            $this->getImageTmpById($newMainId)->setIsMain(true);
        }
    }
    public function deleteAllRecordsImgTmp() {
        $req = "DELETE FROM d_img_tmp;";
        $stmt = $this->getBdd()->prepare($req);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result > 0) {
            $this->imagesTemp = array();
        }
    }
    public function addImageBDWMain($path, $a_id, $isMain)
    {
        $req = "INSERT INTO d_img (path, a_id, isMain)
                values (:path, :a_id, :isMain)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":path", $path, PDO::PARAM_STR);
        $stmt->bindValue(":a_id", $a_id, PDO::PARAM_INT);
        $stmt->bindValue("isMain", $isMain, PDO::PARAM_BOOL);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $img = new Image($this->getBdd()->lastInsertId(), $path, $a_id, false);
        }
        $this->addImage($img);
    }
}