<?php

/**
 * Get all products.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

if (!UserModel::isReadingPermitted($user, $password)) {
    RestMethods::send401();
}
$products = ProductModel::fetchAll($application, $page, $pagesize);
$rest->send200AndJson($products);
exit();
