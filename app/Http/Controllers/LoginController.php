<?php

namespace Controllers;

use Models\UtilisateursModel;

class LoginController extends Controller
{
    public function login(array $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $utilisateurs = new UtilisateursModel();
        $users = $utilisateurs->getDataObject();

        foreach ($users as $user) {
            if ($user->mail == $email && $user->mdp == $password) {
                echo $user->nom;
            }
        }
    }
}