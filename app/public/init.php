<?php

/**
 * Initialize variables.
 */

use pietras\RestApi\Application;

$application = new Application();
$database = $application->getDatabase();
$url1 = $application->getPathElement(1);
$url2 = $application->getPathElement(2);
$requestMethod = $_SERVER['REQUEST_METHOD'];
