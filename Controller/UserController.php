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
            var_dump($articles);
            if ($manager->userArticle($_POST)) {
                $manager->userSendArticle($_POST);
                $this->redirect('article');
            } else
                $this->redirect('login');
        }
        echo "<li><a href='?action=logout'>logout</a></li>";
        echo $this->renderView('article.php.twig', ['error' => $error]);
    }
}
