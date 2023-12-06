<?php

/**
 * Get all products.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

if (!UserModel::isReadingPermitted($application, $user, $password)) {
    RestMethods::send401();
}
$products = ProductModel::fetchAllAsArray($application, $page, $pagesize);
RestMethods::send200AndJson($products);
exit();
