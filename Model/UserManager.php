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
        header('content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
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
        header('content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
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

    public function userArticle($data)
    {
        $isFormGood = true;
        $errors = array();
        $result = array();

        if (!isset($data['title']) || strlen($data['title']) < 1) {
            $errors['titre'] = 'Titre trop court ! Merci de saissir 20 caractères minimum';
            $isFormGood = false;
        }

        if (!isset($data['commentary']) || strlen($data['commentary']) < 1) {
            $errors['text'] = 'Article trop court minimum 500 caractères';
            $isFormGood = false;
        }

        /*if (isset($_FILES['uploads_file']['name']) && !empty($_FILES)){
            $data['image'] = $_FILES['uploads_file']['name'];
            $data['image_tmp_name'] = $_FILES['uploads_file']['tmp_name'];
            $result['data'] = $data;
        }
        else{
            $errors['image'] = 'Veillez choisir une image';
            $isFormGood = false;
        }*/

        if ($isFormGood) {
            echo(json_encode(array('success' => true, 'user' => $_POST)));
        } else {
            echo(json_encode(array('success' => false, 'error' => $errors)));
            exit(0);
        }
        $result['isFormGood'] = $isFormGood;
        return $result;
    }

    public function userSendArticle($data)
    {
        $user['title'] = $data['title'];
        $user['text'] = $data['commentary'];
        $user['image'] = 'uploads/' . $_SESSION['username'] . '/' . $_FILES['uploads_file']['name'];
        $user['id_user'] = $_SESSION['user_id'];
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

    public function showAllProfil()
    {
        $show = $this->DBManager->findAllSecure("SELECT users.id, users.username, users.firstname, users.lastname, users.city 
                                                 FROM users 
                                                 INNER JOIN com ON users.id = com.user_id");
        var_dump($show);
        return $show;
    }

    public function checkPassword($data)
    {
        header('content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $isFormGood = true;
        $errors = array();

        if (!isset($data['currentPassword'])) {
            $errors['titre'] = 'c';
            $isFormGood = false;
        }

        if (!isset($data['newPassword'])) {
            $errors['titre'] = 'a';
            $isFormGood = false;
        }

        if (!isset($data['confirmPassword'])) {
            $errors['titre'] = 'b';
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

    public function changePassword($data)
    {

    }
}
