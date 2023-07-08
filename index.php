<?php
session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/admin/LoginController.controller.php";
require_once "controllers/admin/ControlPanelController.controller.php";

$loginController = new LoginController;
$controlController = new ControlPanelController;

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
                if (isset($_SESSION['Username'])) {
                    if (empty($url[1])) {
                        $controlController->showArticles();
                    } else if ($url[1] === "cp") {
                        $controlController->showArticles();
                    } else if ($url[1] === "dc") {
                        $loginController->disconnect();
                    } else {
                        throw new Exception("La page n'existe pas");
                    }
                } else {
                    if (empty($url[1])) {
                        require "views/admin/login.view.php";
                    } else if ($url[1] === "lv") {
                        $loginController->loginValidate();
                    } else {
                        throw new Exception("La page n'existe pas");
                    }
                }
                break;
            default:
                throw new Exception("La page n'existe pas !");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    // REQUIRE VIEW ERREUR 404
}