<?php
namespace App\Controller;

use App\Service\LoginService;
use App\Model\UserManager;

class SecurityController extends AbstractController
{
    public function login()
    {
        unset($_SESSION['flash_message']);
        $loginService = new LoginService();
        $loginHome = $loginService ->login();
        $errorLogin= null;
        
        return $this->twig->render('Security/login.html.twig', [
            'errorLogin' => $errorLogin
        ]);
    }
    
    public function register()
    {
        $userManager = new UserManager();
        $error = null;
        unset($_SESSION['flash_message']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['firstname']) &&
                !empty($_POST['lastname']) &&
                !empty($_POST['email']) &&
                !empty($_POST['password']) &&
                !empty($_POST['password2'])) {
                $user = $userManager->search($_POST['email']);
                if ($user) {
                    $error = true;
                    $_SESSION['flash_message'] = ['Email already exist'];
                    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                }
                if ($_POST['password'] != $_POST['password2']) {
                    $error = true;
                    $_SESSION['flash_message'] = ['Password do not match'];
                    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                }
                if ($error === null) {
                    $newsletter = isset($_POST['newsletter']) ? true : false;
                    $user = [
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'email' => $_POST['email'],
                        'password' => md5($_POST['password']),

                    ];
                    $idUser = $userManager->insert($user);

                    if ($idUser) {
                        $_SESSION['user'] = $user;
                        $_SESSION['id'] = $idUser;
                        $_SESSION['email'] = $user['email'];
                        $_SESSION ['firstname'] = $user ['firstname'];
                        $_SESSION ['lastname'] = $user ['lastname'];
                        header('Location:/');
                    }
                }
            }
        }
        return $this->twig->render('Security/register.html.twig', [
            'error' => $error
        ]);
    }
    
    public function logout()
    {
        session_destroy();
        header('Location:/');
    }
}
