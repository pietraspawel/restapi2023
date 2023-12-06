<?php

/**
 * Get single product.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

$productId = (int)$url2;

if (!UserModel::isReadingPermitted($application, $user, $password)) {
    RestMethods::send401();
}
$products = ProductModel::fetchByIdAsArray($application, $productId);
RestMethods::send200AndJson($products);
exit();
