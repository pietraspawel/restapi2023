<?php

use pietras\RestApi\LanguageModel;
use pietras\RestApi\ProductModel;

$productId = 42;
$data = [
    "price" => 1,
    "quantity" => 10,
];
$data = [
    "price" => 1,
    "quantity" => 10,
    "translation" => [
        "pl" => [
            "name" => "nazwa zmieniona",
            "description" => "opis zmieniony",
        ],
        "en" => [
            "name" => "name added",
            "description" => "description added",
        ],
        "zz" => [
            "name" => "błędny język",
            "description" => "błędny język",
        ],
    ]
];

$data = [
    "translation" => [
        "en" => [
            "name" => "bez description",
        ],
    ]
];

var_dump(ProductModel::updateByArray($application, $productId, $data));
