<?php

class Article
{

    private $id;
    private $title;
    private $description;
    private $catId;

    public function __construct($id, $title, $description, $catId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->catId = $catId;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getCatId()
    {
        return $this->catId;
    }
    public function setCatId($catId)
    {
        $this->catId = $catId;
    }

}