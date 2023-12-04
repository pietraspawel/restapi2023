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
    /**
     * @var \Twig\Environment $twig Twig object.
     */
    private $twig;
    private $user;

    public function __construct(string $configFilepath = "../config/application.yaml")
    {
        $this->config = Yaml::parseFile($configFilepath);
        $this->__initVariables();
        $this->__setErrorReporting($this->mode);
        $this->__initTwig();
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

    protected function __initTwig()
    {
        $debug = $this->mode == "dev" ? true : false;
        $loader = new \Twig\Loader\FilesystemLoader($this->config["templates_path"]);
        $this->twig = new \Twig\Environment($loader, [
            "cache" => $this->config["cache_path"],
            "debug" => $debug,
            "strict_variables" => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
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
}
