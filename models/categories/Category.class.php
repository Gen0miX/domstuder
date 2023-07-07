<?php

class Category
{
    private $id;
    private $category;

    public function __construct($id, $category)
    {
        $this->id = $id;
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
    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }
}