<?php

use pietras\RestApi\ProductModel;
use pietras\RestApi\UserMethods;
use pietras\RestApi\UserModel;

echo "<pre>";

//////

$result = $application->getPageParameterValue();
var_dump($result);

$result = ProductModel::fetchAll($application, 3, 10);
var_dump($result);
