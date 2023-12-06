<?php

/**
 * Initialize variables.
 */

use pietras\RestApi\Application;

$application = new Application();
$database = $application->getDatabase();
$url1 = $application->getPathElement(1);
$url2 = $application->getPathElement(2);
$page = $application->getPageParameterValue();
$pagesize = $application->getPagesizeParameterValue();
$requestMethod = $_SERVER['REQUEST_METHOD'];
$user = $_SERVER['PHP_AUTH_USER'] ?? null;
$password = $_SERVER['PHP_AUTH_PW'] ?? null;
