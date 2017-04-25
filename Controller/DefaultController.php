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


            echo "<li><a href='?action=edit'>Edition du profil</a></li>";
            echo "<li><a href='?action=article'>Ajouter un article</a></li>";
            echo "<li><a href='?action=profil'>Voir les profils</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo $this->renderView('home.php.twig',
                ['name' => $user['username'], 'articles' => $articles]);
        } else {
            $manager = UserManager::getInstance();
            $articles = $manager->showArticle();
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo "<li><a href='?action=profil'>Voir les profils</a></li>";
            echo $this->renderView('home.php.twig', ['name' => $user = 'Visiteur', 'articles' => $articles]);
        }

    }

    public function articleViewAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $articles = $manager->showSpecificArticle();

            echo "<li><a href='?action=home'>Home</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo $this->renderView('articleView.php.twig', ['articles' => $articles]);
        } else {
            $manager = UserManager::getInstance();
            $articles = $manager->showSpecificArticle();
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo $this->renderView('articleView.php.twig', ['articles' => $articles]);
        }
    }

    public function profilViewAction()
    {
        if (!empty($_SESSION['user_id']))
        {
            $manager = UserManager::getInstance();
            $profil = $manager->showAllProfil();

            echo "<li><a href='?action=home'>Home</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo $this->renderView('profilView.php.twig', ['profils' => $profil]);
        } else {
            $manager = UserManager::getInstance();
            $profil = $manager->showAllProfil();

            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo $this->renderView('profilView.php.twig', ['profils' => $profil]);
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
