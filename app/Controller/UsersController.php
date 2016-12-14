<?php

namespace Controller;

use \W\Controller\Controller;
use W\Model\UsersModel;
use W\Security\AuthentificationModel;
use W\Security\AuthorizationModel;

class UsersController extends Controller
{

    public function signIn()
    {
        if(isset($_POST['submit'])) {

            $authModel = new AuthentificationModel();
            $userModel = new UsersModel();
            $errors = [];
            $confirm = [];

            // L'id d'un utilisateur
            if (isset($_POST['email']))
            {
                if (empty($_POST['email']))
                {
                    $errors['email'] = 'Vous devez entrez une adresse email';
                }
                else if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL))
                {
                    $errors['email'] = 'Vous devez entrez une adresse email valide';
                }
                else if (strlen($_POST['email']) < 8)
                {
                    $errors['email'] = 'Vous devez entrez une adresse email d\'au moins 8 caracteres';
                }
                else if ($userModel->emailExists($_POST['email']))
                {
                    $errors['email'] = 'Email existante';
                }
                else
                {
                    $confirm['email'] = $_POST['email'];
                }
            }

            if (isset($_POST['password']))
            {
                if (empty($_POST['password']))
                {
                    $errors['password'] = 'Vous devez entrez un mot de passe';
                }

                else if (strlen($_POST['password']) < 8)
                {
                    $errors['password'] = 'Vous devez entrez un mot de passe d\'au moins 8 caracteres';
                }
            }

            if (isset($_POST['confirmPassword']))
            {
                if (empty($_POST['confirmPassword']))
                {
                    $errors['confirmPassword'] = 'Vous devez confirmer votre mot de passe';
                }

                else if ($_POST['confirmPassword'] != $_POST['password'])
                {
                    $errors['confirmPassword'] = 'Les mot de passe doivent être identiques';
                }
            }

            if (isset($_POST['username']))
            {
                if (empty($_POST['username']))
                {
                    $errors['username'] = 'Vous devez entrez un nom d\'utilisateur';
                }

                else if (strlen($_POST['username']) < 4)
                {
                    $errors['username'] = 'Vous devez entrez un nom d\'utilisateur d\'au moins 4 caracteres';
                }
                else if ($userModel->usernameExists($_POST['username']))
                {
                    $errors['username'] = 'Nom d\'utilisateur existant';
                }

                else
                {
                    $confirm['username'] = $_POST['username'];
                }
            }

            if(!empty($_POST['g-recaptcha-response']))
            {
                $captcha=$_POST['g-recaptcha-response'];

                $secretKey = "6LeC1A4UAAAAACfUQhkJt6I5oo2WUOo_QMx9AUD8";
                $ip = $_SERVER['REMOTE_ADDR'];
                $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
                $responseKeys = json_decode($response,true);
                if(intval($responseKeys["success"]) !== 1) {
                    $errors['captcha'] = 'You are spammer ! Get the @$%K out';
                }
            }
            else
            {
                $errors['captcha'] = 'Vous devez valider le captcha';
            }

            if (empty($errors))
            {

                $newUser = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $authModel->hashPassword($_POST['password']),
                ];

                $userModel->insert($newUser);
                $this->redirectToRoute('users_login');
            }
            else
            {
                $this->show('user/sign-in', ['errors' => $errors , 'confirm' => $confirm]);
            }
        }
        else
        {
            $this->show('user/sign-in');
        }
    }

    public function login()
    {
        if(isset($_POST['submit'])) {

            $authModel = new AuthentificationModel();
            $userModel = new UsersModel();
            $errors = [];
            $confirm = [];

            // L'id d'un utilisateur
            if (isset($_POST['email']))
            {
                if (empty($_POST['email']))
                {
                    $errors['email'] = 'Vous devez entrez une adresse email';
                }
                else if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL))
                {
                    $errors['email'] = 'Vous devez entrez une adresse email valide';
                }
                else
                {
                    $confirm['email'] = $_POST['email'];
                }
            }

            if (isset($_POST['password']))
            {
                if (empty($_POST['password']))
                {
                    $errors['password'] = 'Vous devez entrez un mot de passe';
                }
            }

            if (empty($errors))
            {
                $userId = $authModel->isValidLoginInfo($_POST['email'], $_POST['password']);
            }
            else
            {
                $this->show('user/login', ['errors' => $errors , 'confirm' => $confirm]);
            }


            if($userId > 0) {
                // Connexion
                $user = $userModel->find($userId);

                // Placer user en session : $_SESSION['user'] = $user
                $authModel->logUserIn($user);
                $this->redirectToRoute('default_home');
            } else {

                // Echec de la connexion
                $errors['error'] = 'Votre identifant ou votre mot de passe est incorrecte';
                $this->show('user/login', ['errors' => $errors , 'confirm' => $confirm]);
            }
        } else {
            $this->show('user/login');
        }

    }

    public function logout()
    {
        $authModel = new AuthentificationModel();
        $authModel->logUserOut();

        $authorizationModel = new AuthorizationModel();
        $authorizationModel->redirectToLogin();
    }
}