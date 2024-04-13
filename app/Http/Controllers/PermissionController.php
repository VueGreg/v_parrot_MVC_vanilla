<?php

namespace Controllers;

use Middleware\Permission;
use Utils\Controller;

class PermissionController extends Controller
{
    public function checkPermission()
    {
        $permissions = new Permission();
        $path = $permissions->getPermissionsUser();
        var_dump($path);
    }
}