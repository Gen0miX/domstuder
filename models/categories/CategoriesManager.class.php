<?php
require_once "models/Model.class.php";
require_once "Category.class.php";

class CategoriesManager extends Model
{
    private $categories;

    public function addCategory($category)
    {
        $this->categories[] = $category;
    }
    public function getCategories()
    {
        return $this->categories;
    }
    public function getCategoryById($id)
    {
        for ($i = 0; $i < count($this->categories); $i++) {
            if ($this->categories[$i]->getId() == $id) {
                return $this->categories[$i];
            }
        }
        throw new Exception("La catégorie n'existe pas !");
    }

    public function loadCategories()
    {
        $req = $this->getBdd()->prepare("SELECT * FROM d_cat");
        $req->execute();
        $categories = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($categories as $category) {
            $c = new Category($category['c_id'], $category['categorie']);
            $this->addCategory($c);
        }
    }
}