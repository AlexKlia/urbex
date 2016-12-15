<?php

namespace Controller;

use Model\RecoverytokensModel;
use \W\Controller\Controller;
use W\Model\UsersModel;
use W\Security\AuthentificationModel;
use W\Security\AuthorizationModel;

class UsersController extends Controller
{

    public function signIn()
    {
        if (isset($_POST['submit'])) {

            $authModel = new AuthentificationModel();
            $userModel = new UsersModel();
            $errors = [];
            $confirm = [];

            // L'id d'un utilisateur
            if (isset($_POST['email'])) {
                if (empty($_POST['email'])) {
                    $errors['email'] = 'Vous devez entrez une adresse email';
                } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Vous devez entrez une adresse email valide';
                } else if (strlen($_POST['email']) < 8) {
                    $errors['email'] = 'Vous devez entrez une adresse email d\'au moins 8 caracteres';
                } else if ($userModel->emailExists($_POST['email'])) {
                    $errors['email'] = 'Email existante';
                } else {
                    $confirm['email'] = $_POST['email'];
                }
            }

            if (isset($_POST['password'])) {
                if (empty($_POST['password'])) {
                    $errors['password'] = 'Vous devez entrez un mot de passe';
                } else if (strlen($_POST['password']) < 8) {
                    $errors['password'] = 'Vous devez entrez un mot de passe d\'au moins 8 caracteres';
                }
            }

            if (isset($_POST['confirmPassword'])) {
                if (empty($_POST['confirmPassword'])) {
                    $errors['confirmPassword'] = 'Vous devez confirmer votre mot de passe';
                } else if ($_POST['confirmPassword'] != $_POST['password']) {
                    $errors['confirmPassword'] = 'Les mot de passe doivent être identiques';
                }
            }

            if (isset($_POST['username'])) {
                if (empty($_POST['username'])) {
                    $errors['username'] = 'Vous devez entrez un nom d\'utilisateur';
                } else if (strlen($_POST['username']) < 4) {
                    $errors['username'] = 'Vous devez entrez un nom d\'utilisateur d\'au moins 4 caracteres';
                } else if ($userModel->usernameExists($_POST['username'])) {
                    $errors['username'] = 'Nom d\'utilisateur existant';
                } else {
                    $confirm['username'] = $_POST['username'];
                }
            }

            if (!empty($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];

                $secretKey = "6LeC1A4UAAAAACfUQhkJt6I5oo2WUOo_QMx9AUD8";
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
                $responseKeys = json_decode($response, true);
                if (intval($responseKeys["success"]) !== 1) {
                    $errors['captcha'] = 'You are spammer ! Get the @$%K out';
                }
            } else {
                $errors['captcha'] = 'Vous devez valider le captcha';
            }

            if (empty($errors)) {

                $newUser = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $authModel->hashPassword($_POST['password']),
                ];

                $userModel->insert($newUser);
                $this->confirmAccount($_POST['email']);
                $_SESSION['flash']['success'] = 'Un mail de confiramation vous a etez envoyer !';
                $this->redirectToRoute('users_login');
            } else {
                $this->show('user/sign-in', ['errors' => $errors, 'confirm' => $confirm]);
            }
        } else {
            $this->show('user/sign-in');
        }
    }

    public function login()
    {
        if (isset($_POST['submit'])) {

            $authModel = new AuthentificationModel();
            $userModel = new UsersModel();
            $errors = [];
            $confirm = [];

            // L'id d'un utilisateur
            if (isset($_POST['email'])) {
                if (empty($_POST['email'])) {
                    $errors['email'] = 'Vous devez entrez une adresse email';
                } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Vous devez entrez une adresse email valide';
                } else {
                    $confirm['email'] = $_POST['email'];
                }
            }

            if (isset($_POST['password'])) {
                if (empty($_POST['password'])) {
                    $errors['password'] = 'Vous devez entrez un mot de passe';
                }
            }

            if (empty($errors)) {
                $userId = $authModel->isValidLoginInfo($_POST['email'], $_POST['password']);
            } else {
                $this->show('user/login', ['errors' => $errors, 'confirm' => $confirm]);
            }


            if ($userId > 0) {
                // Connexion
                $user = $userModel->find($userId);

                if ($user['confirmate_at'] === NULL)
                {
                    // Compte non vérifier
                    $errors['error'] = 'Votre compte n\'a pas etait activée';
                    $this->show('user/login', ['errors' => $errors, 'confirm' => $confirm]);
                }
                else
                {
                    // Placer user en session : $_SESSION['user'] = $user
                    $authModel->logUserIn($user);
                    $this->redirectToRoute('default_home');
                }

            } else {

                // Echec de la connexion
                $errors['error'] = 'Votre identifant ou votre mot de passe est incorrecte';
                $this->show('user/login', ['errors' => $errors, 'confirm' => $confirm]);
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

    private function sendMail($destAddress, $destName, $subject, $messageHtml, $messagePlain)
    {
        $mail = new \PHPMailer();

        $mail->isSMTP();                                        // On va se servir de SMTP
        $mail->Host = 'smtp.gmail.com';                        // Serveur SMTP
        $mail->SMTPAuth = true;                                // Active l'autentification SMTP
        $mail->Username = 'wf3.mailer@gmail.com';                // SMTP username
        $mail->Password = '$NJ27^^4q7';                        // SMTP password
        $mail->SMTPSecure = 'tls';                                // TLS Mode
        $mail->Port = 587;                                        // Port TCP à utiliser
        $mail->CharSet = 'UTF-8';

        // $mail->SMTPDebug = 2;

        $mail->setFrom('wf3.mail@gmail.com', 'Urbex', false);
        $mail->addAddress($destAddress, $destName);            // Ajouter un destinataire

        $mail->isHTML(true);                                     // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $messageHtml;
        $mail->AltBody = $messagePlain;

        $mail->send();
    }

    // Affichage du formulaire de demande de nouveau mot de passe
    private function confirmAccount($email)
    {
        $tokenModel = new RecoverytokensModel();
        $userModel = new UsersModel();
        if (isset($_POST['submit'])) {
            $user = $userModel->getUserByUsernameOrEmail($email);
            if (!empty($user)) {
                // Ajouter un token
                $token = \W\Security\StringUtils::randomString(32);
                $tokenModel->insert([
                    'id_user' => $user['id'],
                    'confirmation_token' => $token,
                ]);

                // Envoyer un mail
                $confirmAccount = 'http://localhost'.$this->generateUrl('user_confirm_account', ['token' => $token]);

                $messageHtml = <<< EOT
<h1>Confirmation de votre compte</h1>
Bonjour $user[username]<br>
<a href="$confirmAccount">Cliquez ici</a> pour finaliser votre inscription<br>
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

                $messagePlain = <<< EOT
Confirmation de votre compte
Bonjour $user[username],
Accédez à $confirmAccount pour finaliser votre inscription
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

                $this->sendMail($user['email'], $user['username'], 'Confirmation de compte', $messageHtml, $messagePlain);
            }
        } else {
            $_SESSION['flash']['danger'] = 'Le mail de confirmation n\' a pas pu être envoyée';
            $this->redirectToRoute('users_login');
        }
    }

    public function confirm($token)
    {
        $tokenModel = new RecoverytokensModel();
        $tokens = $tokenModel->search(['confirmation_token' => $token]);
        if (count($tokens) > 0) {
            $myToken = $tokens[0];
        }
        if (!empty($myToken)) {
            // Le token existe bien en base

            // Si j'ai reçu une soumission
            if (isset($_POST['confirm-account'])) {
                // Modification du mot de passe, si confirmation exacte
                $userModel = new UsersModel();
                $userModel->update(['confirmate_at' => date('Y-m-d')], $myToken['id_user']);

                $tokenModel->delete($myToken['id']);

                $_SESSION['flash']['success'] = 'Votre compte a etait activée !';
                $this->redirectToRoute('users_login');
            } else {
                $this->show('user/confirm-account');
            }
        } else {
            $_SESSION['flash']['danger'] = 'La confirmation de votre compte a echouée';
            $this->redirectToRoute('users_login');
        }
    }

    public function passwordRecovery()
    {
        $tokenModel = new RecoverytokensModel();
        $userModel = new UsersModel();
        if(isset($_POST['send-email'])) {
            $user = $userModel->getUserByUsernameOrEmail($_POST['email']);
            if(!empty($user)) {
                // Ajouter un token de reset de mot de passe
                $token = \W\Security\StringUtils::randomString(32);
                $tokenModel->insert([
                    'id_user' 	=> $user['id'],
                    'reset_token' 	=> $token,
                ]);

                // Envoyer un mail
                $resetUrl = 'http://localhost'.$this->generateUrl('user_reset_password', ['token' => $token]);

                $messageHtml =<<< EOT
<h1>Réinitialisation de votre mot de passe</h1>
Quelqu'un a demandé la réinitialisation de votre mot de passe.<br>
<a href="$resetUrl">Cliquez ici</a> pour finaliser l'opération<br>
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

                $messagePlain =<<< EOT
Réinitialisation de votre mot de passe
Quelqu'un a demandé la réinitialisation de votre mot de passe.
Accédez à $resetUrl pour finaliser l'opération
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

                $this->sendMail($user['email'], $user['username'], 'Réinitialisation du mot de passe', $messageHtml, $messagePlain);

                $_SESSION['flash']['success'] = 'Le mail de confirmation a etait envoyée';
                $this->redirectToRoute('users_login');
            }
            else
            {
                $this->show('/user/password-recovery' , ['error' => 'L\'adresse mail ou le pseudo n\'existe pas.']);
            }
        } else {
            $this->show('/user/password-recovery');
        }
    }

    public function resetPassword($token)
    {
        $tokenModel = new RecoverytokensModel();
        $authModel = new AuthentificationModel();
        $tokens = $tokenModel->search(['reset_token' => $token]);
        if(count($tokens) > 0) {
            $myToken = $tokens[0];
        }
        if(!empty($myToken)) {
            // Le token existe bien en base

            // Si j'ai reçu une soumission
            if(isset($_POST['update-password'])) {
                // Modification du mot de passe, si confirmation exacte
                if (isset($_POST['password'])) {
                    if (empty($_POST['password'])) {
                        $errors['password'] = 'Vous devez entrez un mot de passe';
                    } else if (strlen($_POST['password']) < 8) {
                        $errors['password'] = 'Vous devez entrez un mot de passe d\'au moins 8 caracteres';
                    }
                }

                if (isset($_POST['confirmPassword'])) {
                    if (empty($_POST['confirmPassword'])) {
                        $errors['confirmPassword'] = 'Vous devez confirmer votre mot de passe';
                    } else if ($_POST['confirmPassword'] != $_POST['password']) {
                        $errors['confirmPassword'] = 'Les mot de passe doivent être identiques';
                    }
                }

                if (empty($errors)) {
                    $userModel = new UsersModel();
                    $userModel->update(['password' => $authModel->hashPassword($_POST['password']) ,'reset_at' => date('Y-m-d')] , $myToken['id_user']);

                    $tokenModel->delete($myToken['id']);

                    $this->redirectToRoute('users_login');
                } else {
                    $this->show('/user/reset-password', ['errors' => $errors]);
                }
            }

            // Sinon
            $this->show('/user/reset-password');
        } else {
            $this->redirectToRoute('users_login');
        }
    }
}