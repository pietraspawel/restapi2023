<?php

namespace pietras\RestApi;

/**
 * Provide authorization methods.
 */
class UserModel
{
    private $id;
    private $username;
    private $hash;
    private $read;
    private $write;

    public static function fetchUserByName(Application $application, ?string $username): ?self
    {
        $database = $application->getDatabase();
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (isset($result[0])) {
            return $result[0];
        }
        return null;
    }

    public static function isReadingPermitted(Application $application, string $username, string $password): bool
    {
        $user = self::fetchUserByName($application, $username);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user->hash)) {
            return false;
        }
        if (!$user->read) {
            return false;
        }
        return true;
    }

    public static function isWritingPermitted(Application $application, string $username, string $password): bool
    {
        $user = self::fetchUserByName($application, $username);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user->hash)) {
            return false;
        }
        if (!$user->write) {
            return false;
        }
        return true;
    }
}
