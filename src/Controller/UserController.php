<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * List users
     */
    public function index(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll('title');

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }


    /**
     * Show informations for a specific user
     */
    public function show(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }


    /**
     * Edit a specific user
     */
    public function edit(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $userManager->update($user);
            header('Location: /users/show?id=' . $id);
        }

        return $this->twig->render('User/edit.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * Add a new user
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $userManager = new UserManager();
            $id = $userManager->insert($user);
            header('Location:/users/show?id=' . $id);
        }

        return $this->twig->render('User/add.html.twig');
    }


    /**
     * Delete a specific user
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $userManager = new UserManager();
            $userManager->delete((int)$id);
            header('Location:/users');
        }
    }

    public function account()
    {
        if (!isset($_SESSION['user'])) {
            header('Location:/security/login');
        } else {

            if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                $userManager = new UserManager();
                $user = $userManager->selectOneById($_SESSION['id']);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ((!empty($_POST['firstname']) &&
                    !empty($_POST['lastname']) &&
                    !empty($_POST['address']) &&
                    !empty($_POST['email']))) {
                        $user = [
                            'id' => $_POST['id'],
                            'firstname' => $_POST['firstname'],
                            'lastname' => $_POST['lastname'],
                            'email' => $_POST['email'],
                            'address' => $_POST['address'],
                        ];
                        $userManager->update($user);
                        header('Location:/User/account');
                    }
                }



                return $this->twig->render('User/account.html.twig', [

                    'user' => $user,
                    
                ]);
            }
        }
    }
}
