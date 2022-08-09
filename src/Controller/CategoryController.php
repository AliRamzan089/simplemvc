<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    /**
     * List categorys
     */
    public function index(): string
    {
        $categoryManager = new CategoryManager();
        $categorys = $categoryManager->selectAll();

        return $this->twig->render('Category/index.html.twig', 
        ['categorys' => $categorys]);
    }


    /**
     * Show informations for a specific category
     */
    public function show(int $id): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);

        return $this->twig->render('Category/show.html.twig', 
        ['category' => $category]);
    }


    /**
     * Edit a specific category
     */
    public function edit(int $id): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $category = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $categoryManager->update($category);
            header('Location: /categorys/show?id=' . $id);
        }

        return $this->twig->render('Category/edit.html.twig', [
            'category' => $category,
        ]);
    }


    /**
     * Add a new category
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $category = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $categoryManager = new CategoryManager();
            $id = $categoryManager->insert($category);
            header('Location:/categorys/show?id=' . $id);
        }

        return $this->twig->render('Category/add.html.twig');
    }


    /**
     * Delete a specific category
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $categoryManager = new CategoryManager();
            $categoryManager->delete((int)$id);
            header('Location:/categorys');
        }
    }
}
