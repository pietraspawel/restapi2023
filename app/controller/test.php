<?php

use pietras\RestApi\UserMethods;

echo "<pre>";
$userMethods = new UserMethods($application);

var_dump($userMethods->fetchUser("testuser"));
