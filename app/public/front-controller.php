<?php

/**
 * Front controller.
 */

use pietras\RestApi\RestMethods;

$file = null;

if ($url1 == "products" and $url2 == "") {
    if ($requestMethod == "GET") {
        $file = "../controller/get-products.php";
    }
    if ($requestMethod == "POST") {
        $file = "../controller/post-product.php";
    }
}
if ($url1 == "products" and $url2 != "") {
    if ($requestMethod == "GET") {
        $file = "../controller/get-single-product.php";
    }
    if ($requestMethod == "PUT") {
        $file = "../controller/put-product.php";
    }
    if ($requestMethod == "DELETE") {
        $file = "../controller/delete-product.php";
    }
}
if ($url1 == "help") {
    $file = "../controller/help.php";
}
if ($url1 == "test") {
    $file = "../controller/test.php";
}
if ($file !== null) {
    include $file;
} else {
    RestMethods::send404();
    die();
}
