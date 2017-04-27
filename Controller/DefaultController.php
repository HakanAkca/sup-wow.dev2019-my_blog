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


            echo  "<div class='header'>";
            echo "<li><a href='?action=edit'>Edition du profil</a></li>";
            echo "<li><a href='?action=article'>Ajouter un article</a></li>";
            echo "<li><a href='?action=logout'>Se deconnecter</a></li>";
            echo "</div>";
            echo $this->renderView('home.php.twig',
                ['name' => $user['username'], 'articles' => $articles]);
        } else {
            $manager = UserManager::getInstance();
            $articles = $manager->showArticle();
            echo "<div class='header'>";
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo "</div>";
            echo $this->renderView('home.php.twig', ['name' => $user = 'Visiteur', 'articles' => $articles]);
        }

    }

    public function articleViewAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $articles = $manager->showSpecificArticle();
            echo "<div class='header'>";
            echo "<li><a href='?action=home'>Home</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo "</div>";
            echo "<form action='?action=?action=profilview&profil={{ i['user_id'] }}crWmp%0pdsaDcleRasmce{{ i['title'] }}lslkdnvopvFSAM£' method='POST' name='register-form'>";
            echo "<input type='text' name='commentaire' class='commentaire'>";
            echo "<input type='submit' class='submit' value='Poster'>";
            echo "</form>";
            echo $this->renderView('articleView.php.twig', ['articles' => $articles]);
        } else {
            $manager = UserManager::getInstance();
            $articles = $manager->showSpecificArticle();
            echo '<div class="header">';
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo '</div>';
            echo $this->renderView('articleView.php.twig', ['articles' => $articles]);
        }
    }

    public function profilViewAction()
    {
        if (!empty($_SESSION['user_id']))
        {
            $manager = UserManager::getInstance();
            $profil = $manager->showAllProfil($_GET);

            echo '<div class="header">';
            echo "<li><a href='?action=home'>Home</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo '</div>';
            echo $this->renderView('profilView.php.twig', ['profils' => $profil]);
        } else {
            $manager = UserManager::getInstance();
            $profil = $manager->showAllProfil($_GET);

            echo '<div class="header">';
            echo "<li><a href='?action=register'>Register</a></li>";
            echo "<li><a href='?action=login'>Login</a></li>";
            echo '</div>';
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
