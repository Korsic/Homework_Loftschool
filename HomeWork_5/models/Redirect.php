<?php

class Redirect
{
    public static function redirectToPage($way)
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = $way;
        header("Location: http://$host$uri/$extra");
        exit;
    }
}
