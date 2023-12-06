<?php

namespace pietras\RestApi;

/**
 * Provide respond methods.
 */
class RestMethods
{
    public static function send200AndJson($json)
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
        header("Cache-Control: public, max-age=86400");
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public static function send200()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public static function send201()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 201 OK.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public static function send400()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Data error.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public static function send401()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 401 Authorization Required.");
        exit;
    }

    public static function send404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Source not found.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }
}
