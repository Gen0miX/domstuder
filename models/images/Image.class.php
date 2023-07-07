<?php

class Image
{
    private $id;
    private $path;
    private $artId;

    public function __construct($id, $path, $artId)
    {
        $this->id = $id;
        $this->path = $path;
        $this->artId = $artId;
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
}