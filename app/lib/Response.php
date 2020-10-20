<?php

namespace Lib;

class Response
{
    static public function json($data, $code)
    {
        http_response_code($code);
        header('Content-Type: application/json');

        echo json_encode($data);
        die();
    }
}
