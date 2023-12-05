<?php

namespace pietras\RestApi;

/**
 * Provide authorization methods.
 */
class UserMethods
{
    private $application;
    private $database;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->database = $application->getDatabase();
    }

    public function isReadingPermitted(?string $username, ?string $password): bool
    {
        $user = $this->fetchUser($username);
        if (!$user) {
            return false;
        }
        if (!($user["hash"] == crypt($password, $user["hash"]))) {
            return false;
        }
        if (!$user["read"]) {
            return false;
        }
        return true;
    }

    public function isWritingPermitted(?string $username, ?string $password): bool
    {
        $user = $this->fetchUser($username);
        if (!$user) {
            return false;
        }
        if (!($user["hash"] == crypt($password, $user["hash"]))) {
            return false;
        }
        if (!$user["write"]) {
            return false;
        }
        return true;
    }

    public function fetchUser(?string $username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();

        $arr = array();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $arr[] = $row;
        }

        if (!empty($arr)) {
            return current($arr);
        } else {
            return false;
        }
    }
}
