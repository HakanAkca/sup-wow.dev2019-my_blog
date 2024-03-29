<?php

namespace Model;

class UserManager
{
    private $DBManager;

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new UserManager();
        return self::$instance;
    }

    private function __construct()
    {
        $this->DBManager = DBManager::getInstance();
    }

    public function getUserById($id)
    {
        $id = (int)$id;
        $data = $this->DBManager->findOne("SELECT * FROM users WHERE id = " . $id);
        return $data;
    }

    public function getUserByUsername($username)
    {
        $data = $this->DBManager->findOneSecure("SELECT * FROM users WHERE username = :username",
            ['username' => $username]);
        return $data;
    }

    public function userCheckRegister($data)
    {
        $isFormGood = true;
        $errors = array();

        if (!isset($data['username']) || strlen($data['username']) < 4) {
            $errors['username'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }

        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Votre email n\'est pas valide.';
            $isFormGood = false;
        }

        if (!isset($data['password']) || strlen($data['password']) < 4) {
            $errors['password'] = 'Veuillez saisir un mots de passe de 4 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['firstname']) || strlen($data['firstname']) < 4) {
            $errors['firstname'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['lastname']) || strlen($data['lastname']) < 4) {
            $errors['lastname'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['city']) || strlen($data['city']) < 4) {
            $errors['city'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }


        if ($isFormGood) {
            echo(json_encode(array('success' => true, 'user' => $_POST)));
        } else {
            http_response_code(400);
            echo(json_encode(array('success' => false, 'errors' => $errors)));
            exit(0);
        }
        return $isFormGood;

    }

    private function userHash($pass)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT, ['salt' => 'saltysaltysaltysalty!!']);
        return $hash;
    }

    public function userRegister($data)
    {
        $user['username'] = $data['username'];
        $user['email'] = $data['email'];
        $user['password'] = $this->userHash($data['password']);
        $user['firstname'] = $data['firstname'];
        $user['lastname'] = $data['lastname'];
        $user['city'] = $data['city'];
        $this->DBManager->insert('users', $user);
        mkdir("uploads/" . $user['username']);
    }

    public function userCheckLogin($data)
    {
        $isFormGood = true;
        $errors = array();

        $user = $this->getUserByUsername($data['username']);
        $hash = $this->userHash($data['password']);

        if (empty($data['username']) OR empty($user) OR empty($data['password']) OR empty($hash)) {
            $errors['Connexion field'] = 'invalid Pseudo or Password';
            $isFormGood = false;
        }

        if ($isFormGood) {
            echo(json_encode(array('success' => true, 'user' => $_POST)));
        } else {
            http_response_code(400);
            echo(json_encode(array('success' => false, 'errors' => $errors)));
            exit(0);
        }
        return $isFormGood;
    }

    public function userLogin($username)
    {
        $data = $this->getUserByUsername($username);
        if ($data === false)
            return false;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        return true;
    }

    public function userSendArticle($data)
    {
        $user['title'] = $data['title'];
        $user['text'] = $data['commentary'];
        $user['image'] = 'uploads/' . $_SESSION['username'] . '/' . $_FILES['uploads_file']['name'];
        $user['user_id'] = $_SESSION['user_id'];
        $user['user_name'] = $_SESSION['username'];
        $this->DBManager->insert('com', $user);
        move_uploaded_file($_FILES['uploads_file']['tmp_name'], 'uploads/' . $_SESSION['username'] . '/' . $_FILES['uploads_file']['name']);
    }

    public function showArticle()
    {
        return $this->DBManager->findAllSecure("SELECT * FROM com");
    }

    public function showSpecificArticle()
    {
        $title = $_GET['article'];
        return $this->DBManager->findAllSecure("SELECT * FROM com WHERE title = :title", ['title' => $title]);
    }

    public function showAllProfil($id)
    {
        return $this->DBManager->findOneSecure("SELECT users.id, users.username, users.email , users.firstname, users.lastname, users.city, com.user_id 
                                                 FROM users 
                                                 INNER JOIN com", ['id' => $id['profil']]);
    }


    public function showProfil()
    {
        return $this->DBManager->findAllSecure("SELECT * FROM users WHERE id = " . $_SESSION['user_id']);
    }

    public function sendInfos($data)
    {
        $new_mail = $data['change-email'];
        $new_firstname = $data['change-prenom'];
        $new_lastname = $data['change-nom'];
        $new_city = $data['change-ville'];
        return $this->DBManager->findOneSecure("UPDATE users SET email='$new_mail', firstname='$new_firstname'
                                                , lastname='$new_lastname', city='$new_city' WHERE id='"
            . $_SESSION['user_id'] . "'");
    }
}
