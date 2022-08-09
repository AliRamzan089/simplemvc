<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * List articles
     */
    public function index(): string
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAll();

        return $this->twig->render('Article/index.html.twig',
         ['articles' => $articles]);
    }


    /**
     * Show informations for a specific article
     */
    public function show(int $id): string
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        return $this->twig->render('Article/show.html.twig', 
        ['article' => $article]);
    }


    /**
     * Edit a specific article
     */
    public function edit(int $id): string
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $article = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $articleManager->update($article);
            header('Location: /articles/show?id=' . $id);
        }

        return $this->twig->render('Article/edit.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * Add a new article
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $article = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $articleManager = new ArticleManager();
            $id = $articleManager->insert($article);
            header('Location:/articles/show?id=' . $id);
        }

        return $this->twig->render('Article/add.html.twig');
    }


    /**
     * Delete a specific article
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $articleManager = new ArticleManager();
            $articleManager->delete((int)$id);
            header('Location:/articles');
        }
    }
}
