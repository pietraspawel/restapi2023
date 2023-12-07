<?php

/**
 * Delete product.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

if (!UserModel::isWritingPermitted($application, $user, $password)) {
    RestMethods::send401();
}
$result = ProductModel::delete($application, (int)$url2);
if ($result) {
    RestMethods::send200();
    exit;
} else {
    RestMethods::send400();
    exit;
}
