<?php

use pietras\RestApi\ProductModel;

var_dump($url2);
var_dump(ProductModel::fetchByIdAsArray($application, $url2));
