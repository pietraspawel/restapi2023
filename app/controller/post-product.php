<?php

/**
 * Insert product.
 */

use pietras\RestApi\ProductModel;
use pietras\RestApi\RestMethods;
use pietras\RestApi\UserModel;

if (!UserModel::isWritingPermitted($application, $user, $password)) {
    RestMethods::send401();
}
$data = json_decode(file_get_contents('php://input'), true);
if (gettype($data) != "array") {
    RestMethods::send400();
    exit;
}
$result = ProductModel::insertByArray($application, $data);
if ($result) {
    RestMethods::send201();
    exit;
} else {
    RestMethods::send400();
    exit;
}
