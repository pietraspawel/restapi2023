<?php

use pietras\RestApi\UserMethods;
use pietras\RestApi\UserModel;

echo "<pre>";

//////
$username = "testuser";

$user = UserModel::fetchUserByName($application, $username);
var_dump($user);
$user = UserModel::fetchUserByName($application, "");
var_dump($user);
$user = UserModel::fetchUserByName($application, "wrong");
var_dump($user);

$user = UserModel::isReadingPermitted($application, $username, "kupa");
var_dump($user);

$user = UserModel::isReadingPermitted($application, $username, "123");
var_dump($user);

$user = UserModel::isReadingPermitted($application, "wrong", "123");
var_dump($user);

$user = UserModel::isReadingPermitted($application, "reader", "123");
var_dump($user);

$user = UserModel::isWritingPermitted($application, $username, "kupa");
var_dump($user);

$user = UserModel::isWritingPermitted($application, $username, "123");
var_dump($user);

$user = UserModel::isWritingPermitted($application, "wrong", "123");
var_dump($user);

$user = UserModel::isWritingPermitted($application, "reader", "123");
var_dump($user);
