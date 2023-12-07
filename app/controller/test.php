<?php

use pietras\RestApi\LanguageModel;
use pietras\RestApi\ProductModel;

echo "Hi";
exit;

// $validLanguages = LanguageModel::fetchAllAbbreviationsAsArray($application);
// var_dump($validLanguages);

// exit;

$data = [
    "price" => 1234,
    "quantity" => 12,
    "translation" => [
        "en" => [
            "name" => "Lion"
        ],
        "pl" => [
            "name" => "Lew"
        ],
        "xx" => [
            "name" => "abc"
        ]
    ]
];
$result = ProductModel::insertByArray($application, $data);
var_dump($result);
