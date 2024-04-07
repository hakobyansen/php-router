<?php

namespace PhpRouter\Router;

class Request
{
    public static function get(string $param): ?string
    {
        if(isset($_REQUEST[$param])) {
            return htmlspecialchars($_REQUEST[$param]);
        }

        $phpInput = file_get_contents("php://input");

        if($phpInput) {
            $params = json_decode($phpInput);

            return isset($params->$param) ? htmlspecialchars($params->$param) : null;
        }

        return null;
    }
}