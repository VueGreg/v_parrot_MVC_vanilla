<?php

namespace Middleware;

use Models\UtilisateursModel;

class Permission
{
    private function getPermissionsRole(): Array
    {
        $permissionsRole = [
                "admin" => [
                    "/",
                    "/permission",
                    "/deconnexion",
                    "/isconnect",
                    "/dashboard/employe",
                    "/dashboard/message",
                    "/dashboard/parametre",
                    "/dashboard/temoignage"
                ],
                "moderateur" => [
                    "/",
                    "/permission",
                    "/deconnexion",
                    "/isconnect",
                    "/dashboard/message",
                    "/dashboard/temoignage"
                ],
                "vendeur" => [
                    "/",
                    "/permission",
                    "/deconnexion",
                    "/isconnect",
                    "/permission",
                    "/dashboard/message"
                ]
            ];

        return $permissionsRole;
    }

    public function validatePermissions(string $path): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_role'])) {
            foreach ($this->getPermissionsRole() as $key => $value) {
                foreach ($value as $pathPermission) {
                    if ($key == $_SESSION['user_role'] && $path == $pathPermission) {
                        return true;
                    }
                }
            }
        } else {
            return true;
        }

        return false;
    }

    public function getPermissionsUser(): Array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_role'])) {
            foreach ($this->getPermissionsRole() as $key => $value) {
                if ($key == $_SESSION['user_role']) {
                    return [$value];
                }
            }
        }

        return ["errors" => "il n'y a aucune permissions"];
    }
}