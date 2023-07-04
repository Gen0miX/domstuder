<?php

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

try {
    if (empty($_GET['page'])) {
        require "views/main/home.view.php";
    } else {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        switch ($url[0]) {
            case "home":
                require "views/main/home.view.php";
                break;
            case "admin":
                require "views/admin/login.view.php";
                break;
            default:
                throw new Exception("La page n'existe pas !");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    // REQUIRE VIEW ERREUR 404
}