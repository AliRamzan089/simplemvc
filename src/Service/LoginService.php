<?php

namespace App\Service;

use App\Model\UserManager;

class LoginService
{
    public function login()
    {
        $userManager = new UserManager();
        $errorLogin = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $user = $userManager->search($_POST['email']);
                if ($user) {
                    if ($user->password === md5($_POST['password'])) {
                        
                            $_SESSION['user'] = $user;
                            $_SESSION['id'] = $user->id;
                            $_SESSION['firstname'] = $user->firstname;
                            $_SESSION['lastname'] = $user->lastname;
                            if (!isset($_SESSION['cart'])) {
                                header('Location:/User/account');
                            } else {
                                header('Location:/');
                            }
                        
                    } else {
                        $_SESSION['flash_message'] = ["Password incorrect !"];
                        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
                } else {
                    $_SESSION['flash_message'] = ['User not found'];
                    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                }
            } else {
                $_SESSION['flash_message'] = ['All fields are mandatory !'];
                header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            }
        }
    }
}
