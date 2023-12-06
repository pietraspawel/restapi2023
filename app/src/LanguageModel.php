<?php

namespace pietras\RestApi;

/**
 * Provide language model and its methods.
 */
class LanguageModel
{
    private $id;
    private $abbr;

    public function __construct(array $param)
    {
        $this->id = $param["id"];
        $this->abbr = $param["abbr"];
    }

    public static function fetchAllAsArray(Application $application): array
    {
        $database = $application->getDatabase();
        $sql = "SELECT * FROM language";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function fetchAllAbbreviationsAsArray(Application $application): array
    {
        $database = $application->getDatabase();
        $sql = "SELECT id, abbr FROM language";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $array = [];
        foreach ($result as $languageData) {
            $array[$languageData["id"]] = $languageData["abbr"];
        }
        return $array;
    }
}
