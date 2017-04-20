<?php

namespace Controller;

use Model\UserManager;

class DefaultController extends BaseController
{
    public function homeAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $user = $manager->getUserById($_SESSION['user_id']);
            $articles = $manager->showArticle();


            echo "<li><a href='?action=profil'>Profil</a></li>";
            echo "<li><a href='?action=article'>Ajouter un article</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo $this->renderView('home.php.twig',
                ['name' => $user['username'], 'articles' => $articles]);
        } else {
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo $this->renderView('home.php.twig', ['name' => $user = 'Visiteur']);
        }

    }


    /*public function aboutAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('about.html.twig');
        else
            $this->redirect('login');
    }*/
}
