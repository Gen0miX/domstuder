<?php

require_once "models/users/UserManager.class.php";

class LoginController
{
    private $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    public function loginValidate()
    {
        $this->userManager->login($_POST['uname'], $_POST['psw']);
        $user = $this->userManager->getUserConnected();

        if (!is_null($user)) {
            $_SESSION['Username'] = $user->getUsername();
            header('Location: ' . URL . "admin/cp");
        } else {

        }
    }
    public function disconnect()
    {
        session_destroy();
        header('Location: ' . URL . "admin");
    }

}