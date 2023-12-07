<?php

use pietras\RestApi\LanguageModel;
use pietras\RestApi\ProductModel;

$productId = 44;
$data = [];

var_dump(ProductModel::updateByArray($application, $productId, $data));
