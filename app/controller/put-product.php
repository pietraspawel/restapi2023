<?php

/**
 * Update product.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

if (!UserModel::isWritingPermitted($application, $user, $password)) {
    RestMethods::send401();
}
$changes = json_decode(file_get_contents('php://input'), true);
if (gettype($changes) != "array") {
    RestMethods::send400();
    exit;
}
$result = ProductModel::updateByArray($application, (int)$url2, $changes);
if ($result) {
    RestMethods::send200();
    exit;
} else {
    RestMethods::send400();
    exit;
}
