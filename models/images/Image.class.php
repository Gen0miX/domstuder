<?php

class Image
{
    private $id;
    private $path;
    private $artId;
    private $isMain;

    public function __construct($id, $path, $artId, $isMain)
    {
        $this->id = $id;
        $this->path = $path;
        $this->artId = $artId;
        $this->isMain = $isMain;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function setPath($path)
    {
        $this->path = $path;
    }
    public function getArtId()
    {
        return $this->artId;
    }
    public function setArtId($artId)
    {
        $this->artId = $artId;
    }
    public function getIsMain()
    {
        return $this->isMain;
    }
    public function setIsmain($isMain)
    {
        $this->isMain = $isMain;
    }
}