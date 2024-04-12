<?php

namespace Controllers;

use Middleware\CrossSiteRequestForgery;
use Utils\Controller;

class _csrfController extends Controller
{
    public function index()
    {
        $csrf = (new CrossSiteRequestForgery())->getCSRFToken();
        $this->renderApi(['csrf_token' => $csrf]);
    }
}