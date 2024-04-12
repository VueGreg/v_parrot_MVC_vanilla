<?php

namespace Middleware;

class CrossSiteRequestForgery
{
    public function generateCSRFToken()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public function getCSRFToken()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        return $_SESSION['csrf_token'];
    }

    public function validateCSRFToken($bearerToken)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (preg_match('/Bearer\s+(.*)$/i', $bearerToken, $matches)) {
            $token = $matches[1];
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}