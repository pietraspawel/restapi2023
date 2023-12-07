<?php

namespace pietras\RestApi;

/**
 * Provide product model and its methods.
 */
class ProductModel
{
    private $id;
    private $price;
    private $quantity;
    private $translation;

    private static $database;
    private static $validLanguages;

    public function __construct(array $param)
    {
        $this->id = $param["id"];
        $this->price = $param["price"];
        $this->quantity = $param["quantity"];
        $this->translation = $param["translation"];
    }

    /**
     * @param  Application $application Application object.
     * @param  int $page                Page number.
     * @param  int $pagesize            Page size.
     * @return array
     *   [
     *       id => [
     *           "id" => int,
     *           "price" => int,
     *           "quantity" => int,
     *           "translation" => [
     *               name => [
     *                   "name" => string,
     *                   "description" => string
     *               ],
     *               name => [
     *                   ...
     *               ]
     *           ],
     *       id => [
     *           ..next product..
     *       ]
     *   ]
     */
    public static function fetchAllAsArray(Application $application, int $page = 1, int $pagesize = 10): array
    {
        $database = $application->getDatabase();
        $offset = ($page - 1) * $pagesize;
        $sql = "
            SELECT 
                p.*, 
                product_name.name AS name,
                product_name.description AS description,
                language.abbr AS language
            FROM ( SELECT * FROM product LIMIT $offset, $pagesize) AS p
            INNER JOIN product_name ON p.id = product_name.product_id
            INNER JOIN language ON product_name.language_id = language.id
        ";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return self::resultToArrayCollection($result);
    }

    /**
     * @param  Application $application Application object.
     * @param  int $recordId            Product id.
     * @return array
     *   [
     *       id => [
     *           "id" => int,
     *           "price" => int,
     *           "quantity" => int,
     *           "translation" => [
     *               name => [
     *                   "name" => string,
     *                   "description" => string
     *               ],
     *               name => [
     *                   ...
     *               ]
     *           ]
     *   ]
     */
    public static function fetchByIdAsArray(Application $application, int $recordId): array
    {
        $database = $application->getDatabase();
        $sql = "
            SELECT 
                product.*, 
                product_name.name AS name,
                product_name.description AS description,
                language.abbr AS language
            FROM product 
            INNER JOIN product_name ON product.id = product_name.product_id
            INNER JOIN language ON product_name.language_id = language.id
            WHERE product.id = :recordId
        ";
        $stmt = $database->prepare($sql);
        $stmt->bindParam("recordId", $recordId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return self::resultToArrayCollection($result);
    }

    private static function resultToArrayCollection(array $array): array
    {
        $coll = [];
        foreach ($array as $row) {
            $coll[$row["id"]]["id"] = $row["id"];
            $coll[$row["id"]]["price"] = $row["price"];
            $coll[$row["id"]]["quantity"] = $row["quantity"];
            $coll[$row["id"]]["translation"][$row["language"]]["name"] = $row["name"];
            $coll[$row["id"]]["translation"][$row["language"]]["description"] = $row["description"];
        }
        return $coll;
    }

    /**
     * @param  Application $application Application object.
     * @param  array $data
     *   [
     *       "price" => int,                     // if omitted, default is 0
     *       "quantity" => int,                  // if omitted, default is 0
     *       "translation" => [                  // works only if language is valid, minimum one is required
     *           name => [
     *               "name" => string,           // required
     *               "description" => string     // if omitted, default is null
     *           ],
     *           name => [
     *               ...
     *           ]
     *       ]
     *   ]
     * @return bool Return true if everything is ok, else return false.
     */
    public static function insertByArray(Application $application, array $data): bool
    {
        self::$database = $application->getDatabase();
        if (!isset($data["translation"])) {
            return false;
        }

        self::$validLanguages = LanguageModel::fetchAllAbbreviationsAsArray($application);
        $translationAdded = false;
        $price = $data["price"] ?? 0;
        $quantity = $data["quantity"] ?? 0;

        self::$database->beginTransaction();
        $sql = "INSERT INTO product (price, quantity) VALUES (:price, :quantity)";
        $stmt = self::$database->prepare($sql);
        $stmt->bindParam("price", $price, \PDO::PARAM_INT);
        $stmt->bindParam("quantity", $quantity, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            self::$database->rollBack();
            return false;
        }
        $lastId = self::$database->lastInsertId();

        foreach ($data["translation"] as $languageName => $translationData) {
            if (in_array($languageName, self::$validLanguages)) {
                $result = self::insertTranslation($lastId, $languageName, $translationData);
                if ($result === true) {
                    $translationAdded = true;
                } else {
                    self::$database->rollBack();
                    return false;
                }
            }
        }

        if ($translationAdded) {
            self::$database->commit();
            return true;
        } else {
            self::$database->rollBack();
            return false;
        }
    }

    private static function insertTranslation(int $productId, string $languageName, array $translationData): bool
    {
        if (!isset($translationData["name"])) {
            self::$database->rollback();
            return false;
        }
        $name = $translationData["name"];
        $description = $translationData["description"] ?? "";

        $languageId = array_search($languageName, self::$validLanguages);
        $sql = "
            INSERT INTO product_name 
            (product_id, language_id, name, description) 
            VALUES (:productId, :languageId, :name, :description)
        ";
        $stmt = self::$database->prepare($sql);
        $stmt->bindParam("productId", $productId, \PDO::PARAM_INT);
        $stmt->bindParam("languageId", $languageId, \PDO::PARAM_INT);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("description", $description);
        if (!$stmt->execute()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Update product.
     *
     * Every field is optional.
     *
     * @param  Application $application Application object.
     * @param  int         $productId   Product id.
     * @param  array       $data        Array of changes.
     *   [
     *       "price" => int,
     *       "quantity" => int,
     *       "translation" => [
     *           name => [
     *               "name" => string,
     *               "description" => string
     *           ],
     *           name => [
     *               ...
     *           ]
     *       ]
     *   ]
     * @return bool Return true if everything is ok, else return false.
     */
    public static function updateByArray(Application $application, int $productId, array $data): bool
    {
        self::$database = $application->getDatabase();
        self::$validLanguages = LanguageModel::fetchAllAbbreviationsAsArray($application);

        $product = self::getUpdatedModel($application, $productId, $data);
        if (empty($product)) {
            return false;
        }

        self::$database->beginTransaction();
        $result = self::prepareUpdateProductTable($product);
        if (!$result) {
            return false;
        }

        $result = self::prepareUpdateProductNameTable($application, $product);
        if (!$result) {
            return false;
        }

        self::$database->commit();
        return true;
    }

    private static function getUpdatedModel(Application $application, int $productId, array $data): array
    {
        self::$database = $application->getDatabase();
        self::$validLanguages = LanguageModel::fetchAllAbbreviationsAsArray($application);

        $product = self::fetchByIdAsArray($application, $productId);
        if (empty($product)) {
            return [];
        }
        $product[$productId]["price"] = $data["price"] ?? $product[$productId]["price"];
        $product[$productId]["quantity"] = $data["quantity"] ?? $product[$productId]["quantity"];
        if (isset($data["translation"])) {
            foreach ($data["translation"] as $languageAbbr => $translation) {
                if (in_array($languageAbbr, self::$validLanguages)) {
                    if (isset($translation["name"])) {
                        $product[$productId]["translation"][$languageAbbr]["name"] =
                            $translation["name"];
                    }
                    if (
                        isset($translation["description"])
                        && isset($product[$productId]["translation"][$languageAbbr]["name"])
                    ) {
                        $product[$productId]["translation"][$languageAbbr]["description"] =
                            $translation["description"];
                    }
                }
            }
        }
        return $product;
    }

    private static function prepareUpdateProductTable(array $product): bool
    {
        $product = current($product);
        $sql = "UPDATE product SET price = :price, quantity = :quantity WHERE id = :productId";
        $stmt = self::$database->prepare($sql);
        $stmt->bindParam("productId", $product["id"], \PDO::PARAM_INT);
        $stmt->bindParam("price", $product["price"], \PDO::PARAM_INT);
        $stmt->bindParam("quantity", $product["quantity"], \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            self::$database->rollBack();
            return false;
        }
        return true;
    }

    private static function prepareUpdateProductNameTable(Application $application, array $product): bool
    {
        $product = current($product);
        $origin = self::fetchByIdAsArray($application, $product["id"]);
        $origin = current($origin);
        if (isset($product["translation"])) {
            foreach ($product["translation"] as $languageAbbr => $translation) {
                if (in_array($languageAbbr, self::$validLanguages)) {
                    if (isset($origin["translation"][$languageAbbr])) {
                        $languageId = array_search($languageAbbr, self::$validLanguages);
                        $sql = "
                            UPDATE product_name 
                            SET 
                                name = :name,
                                description = :description
                            WHERE 
                                product_id = :productId
                                AND language_id = :languageId
                        ";
                        $stmt = self::$database->prepare($sql);
                        $stmt->bindParam("name", $translation["name"], \PDO::PARAM_STR);
                        $stmt->bindParam("description", $translation["description"], \PDO::PARAM_STR);
                        $stmt->bindParam("productId", $product["id"], \PDO::PARAM_INT);
                        $stmt->bindParam("languageId", $languageId, \PDO::PARAM_INT);
                        if (!$stmt->execute()) {
                            self::$database->rollBack();
                            return false;
                        }
                    } else {
                        $result = self::insertTranslation($product["id"], $languageAbbr, $translation);
                        if (!$result) {
                            self::$database->rollBack();
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }
}
