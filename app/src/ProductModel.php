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

    public static function fetchAll(Application $application, int $page = 1, int $pagesize = 10): array
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
        return self::resultToCollection($result);
    }

    private static function resultToCollection(array $array): array
    {
        $coll = [];
        $objColl = [];
        foreach ($array as $row) {
            $coll[$row["id"]]["id"] = $row["id"];
            $coll[$row["id"]]["price"] = $row["price"];
            $coll[$row["id"]]["quantity"] = $row["quantity"];
            $coll[$row["id"]]["translation"][$row["language"]]["name"] = $row["name"];
            $coll[$row["id"]]["translation"][$row["language"]]["description"] = $row["description"];
        }
        foreach ($coll as $key => $obj) {
            $objColl[$key] = new self($obj);
        }
        return $objColl;
    }
}
