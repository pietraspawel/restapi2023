<?php

namespace pietras\RestApi;

/**
 * Provide respond methods.
 */
class RestMethods
{
    public function send200AndJson($json)
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
        header("Cache-Control: public, max-age=86400");
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function send200()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public function send201()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 201 OK.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public function send400()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Data error.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }

    public function send404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Source not found.");
        header("Cache-Control: no-cache, no-store, must-revalidate");
    }
}
