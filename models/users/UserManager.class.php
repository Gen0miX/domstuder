<?php
require_once "models/Model.class.php";
require_once "User.class.php";

class UserManager extends Model
{
    private $userConnected;

    public function getUserConnected()
    {
        return $this->userConnected;
    }
    public function login($username, $password)
    {
        $req = "SELECT * FROM users 
                WHERE username = :username";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();


        if (is_array($data)) {
            if (password_verify($password, $data['password'])) {
                $user = new User($data['id'], $data['username'], $data['password'], $data['email']);
                $this->userConnected = $user;
            } else {
                echo "Le mot de passe entré n'est pas correct !";
            }
        } else {
            echo "Le nom d'utilisateur entré n'est pas correct !";
        }

    }
}