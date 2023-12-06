<?php

namespace pietras\RestApi;

use Symfony\Component\Yaml\Yaml;

/**
 * Store application properties and provide methods to control it.
 */
class Application
{
    private $config;
    private $controller;
    private $database;
    private $mode;

    public const DEAFULT_PAGE = 1;

    public function __construct(string $configFilepath = "../config/application.yaml")
    {
        $this->config = Yaml::parseFile($configFilepath);
        $this->__initVariables();
        $this->__setErrorReporting($this->mode);
        $this->__initDatabase();
    }

    protected function __initVariables()
    {
        $this
            ->mode = $this->config["mode"];
    }

    protected function __setErrorReporting($mode)
    {
        if ($mode == "dev") {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }

    protected function __initDatabase()
    {
        $host = $_ENV["MYSQL_HOST"];
        $user = $_ENV["MYSQL_USER"];
        $pass = $_ENV["MYSQL_PASSWORD"];
        $databaseName = $_ENV["MYSQL_DATABASE"];
        $port = $_ENV["MYSQL_PORT"];
        $this->database = new Database($host, $user, $pass, $databaseName, $port);
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * Ex: url = "https://something.com/aaa/bbb".
     * getPathElement(1) == "aaa"
     * getPathElement(2) == "bbb"
     * getPathElement(3) === null
     */
    public function getPathElement(int $index): ?string
    {
        $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($url);
        $pathSegments = explode("/", $parsedUrl['path']);
        $parameter = isset($pathSegments[$index]) ? $pathSegments[$index] : null;
        return $parameter;
    }

    /**
     * Ex: url = "https://something.com/aaa/bbb?ccc=1&ddd=eee".
     * getQueryParameterValue("ccc") == 1
     * getQueryParameterValue("ddd") == "eee"
     * getQueryParameterValue("eee") === null
     */
    public function getQueryParameterValue(string $parameterName): mixed
    {
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        if ($queryString === null) {
            return null;
        }
        parse_str($queryString, $queryParameters);
        return $queryParameters[$parameterName] ?? null;
    }

    public function getPageParameterValue(): int
    {
        $value = (int)$this->getQueryParameterValue("page");
        if (empty($value)) {
            return self::DEAFULT_PAGE;
        }
        return $value;
    }
}
