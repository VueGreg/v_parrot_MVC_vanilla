<?php

namespace Middleware;

use Models\UtilisateursModel;


class Auth
{
    public function verify($path): bool
    {
        if ($path === '/dashboard/parametre' || $path === '/dashboard/temoignage' || $path === 'dashboard/employe' || $path === 'dashboard/message') {

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $session_key = $_SESSION['user_token'];
            $utilisateurs = (new UtilisateursModel())->all();

            foreach ($utilisateurs as $utilisateur) {
                if (isset($_SESSION['user_token']) && $utilisateur->token == $session_key) {
                    return true;
                }
            }

            session_destroy();
            setcookie(session_name(), '', time() - 3600, '/');
            return false;
        }

        return true;
    }
}