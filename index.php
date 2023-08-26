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
                    if(empty($url[1])) {
                        $controlController->showArticles();
                    } else {
                        switch ($url[1]) {
                            case "cp" :
                                if(empty($url[2])) {
                                    $controlController->showArticles();
                                } else {
                                    switch ($url[2]) {
                                        //SWITCH CASE POUR PAGE CONTROL PANEL !
                                        case "m" :
                                            if(empty($url[4])){
                                                $controlController->modifyArticle($url[3]);
                                            } else {
                                                //SWITCH CASE POUR PAGE MODIFIER !
                                                switch ($url[4]) {
                                                    case "d":
                                                        $controlController->deleteImage($url[5], $url[3]);
                                                        break;
                                                    case "iv":
                                                        $controlController->addImages($url[3]);
                                                        break;
                                                    case "av":
                                                        $controlController->modifyArticleValidate($url[3]);
                                                        break;
                                                    case "cim":
                                                        $controlController->changeImageMain($url[5], $url[3]);
                                                        break;
                                                    default:
                                                    throw new Exception("La page n'existe pas");
                                                }
                                            }
                                            break;
                                        case "a" :
                                            if(empty($url[3])){
                                                $controlController->addArticle();
                                            } else {
                                                //SWITCH CASE POUR PAGE AJOUTER !
                                                switch ($url[3]) {
                                                    case "iv" :
                                                        $controlController->addImagesTemp();
                                                        break;
                                                    case "av" :
                                                        $controlController->addArticleValidate();
                                                        break;
                                                    case "cim" :
                                                        $controlController->changeImageTempMain($url[4]);
                                                        break;
                                                    case "d" :
                                                        $controlController->deleteImageTmp($url[4]);
                                                        break;
                                                    default:
                                                    throw new Exception("La page n'existe pas");
                                                }
                                            }
                                            break;
                                        default :
                                        throw new Exception("La page n'existe pas");
                                    }
                                }
                                break;
                            case "dc" :
                                $loginController->disconnect();
                                break;
                            default :
                                throw new Exception("La page n'existe pas");
                       }
                    }
                } else {
                    if(empty($url[1])){
                        require "views/admin/login.view.php";
                    } else {
                        switch ($url[1]) {
                            case "lv" :
                                $loginController->loginValidate();
                                break;
                            default :
                                throw new Exception("La page n'existe pas !");
                        }
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