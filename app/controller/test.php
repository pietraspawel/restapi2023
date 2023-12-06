<?php

use pietras\RestApi\UserMethods;

echo "<pre>";
$userMethods = new UserMethods($application);

var_dump($userMethods->fetchUser("testuser"));
var_dump($userMethods->fetchUser("wribf"));

//////
$username = "testuser";

$sql = "SELECT * FROM user";
$stmt = $database->prepare($sql);
// $stmt->bindParam(':username', $username);
$stmt->execute();

$result = $stmt->fetch();
var_dump($result, $database);
