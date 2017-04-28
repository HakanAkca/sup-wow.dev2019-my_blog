<?php

namespace Controller;

use Model\UserManager;

class UserController extends BaseController
{
    public function articleAction()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager = UserManager::getInstance();

            if ($manager->userArticle($_POST)) {
                $manager->userSendArticle($_POST);
                $this->redirect('article');
            } else
                $this->redirect('login');
        }
        echo "<div class='header'>";
        echo "<ul>";
        echo "<li><a href='?action=home'>Home</a></li>";
        echo "<li><a href='?action=edit'>Profil</a></li>";
        echo "<li><a href='?action=logout'>Se déconnecter</a></li>";
        echo "</ul>";
        echo "</div>";
        echo $this->renderView('article.php.twig', ['error' => $error]);
    }

    public function profilAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $connectedProfil = $manager->showProfil();

            echo '<div class="header">';
            echo "<ul>";
            echo "<li><a href='?action=home'>Home</a></li>";
            echo "<li><a href='?action=profil'>profil</a></li>";
            echo "<li><a href='?action=logout'>logout</a></li>";
            echo "</ul>";
            echo '</div>';
            echo $this->renderView('profil.php.twig', ['connectedProfil' => $connectedProfil]);
        } else {
            $this->redirect('login');
        }
    }

    /*public function editAction()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager = UserManager::getInstance();
            if ($manager->($_POST)) {
                $manager->($_POST);
                $this->redirect('edit');
            } else
                $this->redirect('login');
        }
        echo "<div class='header'>";
        echo "<li><a href='?action=home'>Home</a></li>";
        echo "<li><a href='?action=e'>Profil</a></li>";
        echo "<li><a href='?action=logout'>Se déconnecter</a></li>";
        echo "</div>";
        echo $this->renderView('edit.php.twig', ['error' => $error]);
    }*/

}
