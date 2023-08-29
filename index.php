<?php
session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/admin/LoginController.controller.php";
require_once "controllers/admin/ControlPanelController.controller.php";

$loginController = new LoginController;
$controlController = new ControlPanelController;

if(!empty($_GET['page'])) {
    $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
}

if(isset($_POST['action']) && $_POST['action'] == "back_click") {
    $postUrl = $_POST['url'];
    if(strpos($postUrl, 'a') !== false){
        $this->console_log("BACK BUTTON CLICKED");
    }
}

try {
    if (empty($_GET['page'])) {
        require "views/main/home.view.php";
    } else {
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
                                                        if(isset($_POST['delete_main'])) {
                                                            $controlController->deleteImage($url[5], $url[3]);
                                                        }else if (isset($_POST['delete_tmp'])) {
                                                            $controlController->deleteImageTmpModify($url[5], $url[3]);
                                                        }
                                                        break;
                                                    case "iv":
                                                        $controlController->addImages($url[3]);
                                                        break;
                                                    case "av":
                                                        if(isset($_POST['validate_button'])) {
                                                            $controlController->modifyArticleValidate($url[3]);
                                                        }else if (isset($_POST['cancel_button'])) {
                                                            $controlController->cancelModifyArticle($url[3]);
                                                        } else if (isset($_POST['delete_button'])) {
                                                            $controlController->deleteArticle($url[3]);
                                                        }
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
                                                        if(isset($_POST['validate_button'])) {
                                                            $controlController->addArticleValidate();
                                                        }else if (isset($_POST['cancel_button'])) {
                                                            $controlController->cancelAddArticle();
                                                        }
                                                        break;
                                                    case "cim" :
                                                        $controlController->changeImageTempMain($url[4]);
                                                        break;
                                                    case "d" :
                                                        $controlController->deleteImageTmpAdd($url[4]);
                                                        break;
                                                    default:
                                                    throw new Exception("La page n'existe pas");
                                                }
                                            }
                                            break;
                                        case "d" :
                                            $controlController->deleteArticle($url[3]);
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

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}