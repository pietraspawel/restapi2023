<?php

/**
 * Front controller.
 */

$file = null;

if ($url1 == "products" and $url2 == "") {
    if ($requestMethod == "GET") {
        $file = C . "get-products.php";
    }
    if ($requestMethod == "POST") {
        $file = C . "post-product.php";
    }
}
if ($url1 == "products" and $url2 != "") {
    if ($requestMethod == "GET") {
        $file = C . "get-single-product.php";
    }
    if ($requestMethod == "PUT") {
        $file = C . "put-product.php";
    }
    if ($requestMethod == "DELETE") {
        $file = C . "delete-product.php";
    }
}
if ($url1 == "help") {
    $file = C . "help.php";
}
if ($file !== null) {
    include "$file";
} else {
    $rest->send404();
    die();
}
