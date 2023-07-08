<?php

class Article
{

    private $id;
    private $title;
    private $description;
    private $images;
    private $imageMain;
    private $category;

    public function __construct($id, $title, $description, $images, $imageMain, $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->images = $images;
        $this->imageMain = $imageMain;
        $this->category = $category;
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
    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function getImages()
    {
        return $this->images;
    }
    public function setImages($images)
    {
        $this->images = $images;
    }
    public function getImageMain()
    {
        return $this->imageMain;
    }
    public function setImageMain($imageMain)
    {
        $this->imageMain = $imageMain;
    }
}