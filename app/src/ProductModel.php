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
     *       [
     *           "id" => int,
     *           "price" => int,
     *           "quantity" => int,
     *           "translation" =>
     *               [
     *                   "name" => string,
     *                   "description" => string
     *               ],
     *           next_translation =>
     *               [
     *                   ...
     *               ]
     *       ],
     *       [
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
     *       [
     *           "id" => int,
     *           "price" => int,
     *           "quantity" => int,
     *           "translation" =>
     *               [
     *                   "name" => string,
     *                   "description" => string
     *               ],
     *           next_translation =>
     *               [
     *                   ...
     *               ]
     *       ]
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
}
