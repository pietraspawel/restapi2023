<?php

use pietras\RestApi\LanguageModel;
use pietras\RestApi\ProductModel;

var_dump(LanguageModel::fetchAllAsArray($application));
var_dump(LanguageModel::fetchAllAbbreviationsAsArray($application));

if (in_array("en", LanguageModel::fetchAllAsArray($application))) {
    var_dump(true);
}

if (in_array("en", [ "en" ])) {
    var_dump(true);
}

exit;


$data = [

];
ProductModel::insertByArray($application, $data);
