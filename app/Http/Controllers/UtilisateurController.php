<?php

namespace Controllers;

use Utils\Controller;
use Models\UtilisateursModel;
use Request\RequestUtilisateur;

class UtilisateurController extends Controller
{
    public function index()
    {
        $this->view('connexion');
    }

    public function login(RequestUtilisateur $request)
    {
        header('Content-Type: Application/json');

        $errors = [];
        $validate = [];

        $post = $request->getPost();
        $email = $post['mail'] ?? '';
        $password = $post['mdp'] ?? '';

        if (empty($email) || empty($password)) {
            $errors['errors'] = 'Veuillez fournir une adresse e-mail et un mot de passe.';
            return $errors;
        }

        $model = new UtilisateursModel();
        $utilisateurs = $model->all();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur->mail == $email && password_verify($password, $utilisateur->mdp)) {
                $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);

                if($model->query()->update(["token" => $token], $utilisateur->id)){
                    $_SESSION['user_name'] = $utilisateur->nom;
                    $_SESSION['user_surname'] = $utilisateur->prenom;
                    $_SESSION['user_token'] = $token;
                    $_SESSION['user_permission'] = $utilisateur->id_permissions;
                    $validate['url'] = 'http://parrotpoo.test/dashboard/parametre';
                    $validate['isConnect'] = 'connected';
                    echo json_encode($validate);
                    die;
                } else { 
                    $errors['errors'] = 'Veuillez fournir une adresse e-mail et un mot de passe.';
                    echo json_encode($errors);
                }
            }
        }
        $errors['errors'] = 'Adresse e-mail ou mot de passe incorrect.';
        echo json_encode($errors);
    }

    public function logout()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_token'])) {

            $model = new UtilisateursModel();
            $utilisateurs = $model->all();

            $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);

                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->token == $_SESSION['user_token']) {
                        $model->query()->update(['token' => $token], $utilisateur->id);
                        echo json_encode([
                            'url' => 'http://parrotpoo.test',
                            'isConnect' => 'disconnected'
                        ]);
    
                        setcookie(session_name(), '', time() - 3600, '/');
                        return;
                } 
            }
        }
        echo json_encode([
            'url' => 'http://parrotpoo.test',
            'isConnect' => 'disconnected'
        ]);
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }

    public function isConnect()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_token'])) {
            echo json_encode(true);
            return;
        }

        echo json_encode(false);
        return;
    }
}