<?php

/**
 * Initialize variables.
 */

use pietras\RestApi\Application;

$application = new Application();
$database = $application->getDatabase();
$url1 = $application->getUrlParam(1);
$url2 = $application->getUrlParam(2);
$requestMethod = $_SERVER['REQUEST_METHOD'];
