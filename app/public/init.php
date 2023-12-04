<?php

/**
 * Initialize variables.
 */

use pietras\RestApi\Application;

$application = new Application();
$database = $application->getDatabase();

var_dump($database);
