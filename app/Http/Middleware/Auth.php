<?php

namespace Middleware;

use Models\UtilisateursModel;


class Auth
{
    private $pageVitrine;

    public function verify($path): bool
    {
        if ($path === '/dashboard/parametre' || $path === '/dashboard/temoignage' || $path === 'dashboard/employe' || $path === 'dashboard/message' || $path === 'getcsrf') {

            if (session_status()  === PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['user_token'])) {
                $session_key = $_SESSION['user_token'];
                $utilisateurs = (new UtilisateursModel())->all();

                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->token == $session_key) {
                        $this->pageVitrine = false;
                        return true;
                    }
                }

                session_destroy();
                setcookie(session_name(), '', time() - 3600, '/');
                return false;
            } else {
                return false;
            }
        }

        $this->pageVitrine = true;
        return true;
    }

    public function setPageVitrine(): void
    {
        $currentUrl = $_SERVER['REQUEST_URI'];

        if (strpos($currentUrl, 'dashboard') !== false) {
            $this->pageVitrine = false;
        } else {
            $this->pageVitrine = true;
        }
    }

    public function getPageVitrine(): bool
    {
        return $this->pageVitrine;
    }
}