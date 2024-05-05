<?php
require_once '../app/models/Database.php';
require_once '../app/models/Product.php';
require_once '../app/interfaces/ProductRepositoryInterface.php';

class ProductRepository extends Database implements ProductRepositoryInterface
{
    public function createOne($product)
    {
        try {
            $sql = 'INSERT INTO products
            (
                name, 
                price, 
                quantity
            ) VALUES 
            (
                :name, 
                :price, 
                :quantity
            )';
            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(':name', $product->getName());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':quantity', $product->getQuantity());

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM products ORDER BY id ASC';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id)
    {
        $sql = 'SELECT * FROM products WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $product)
    {
        try {
            $productInDataBase = $this->getOne($id);

            $sql = 'UPDATE products SET 
            name = :name, 
            price = :price, 
            quantity = :quantity,
            updated_at = NOW()
            WHERE id = :id';

            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(":name", $product->name ?? $productInDataBase['name']);
            $stmt->bindValue(":price", $product->price ?? $productInDataBase['price']);
            $stmt->bindValue(":quantity", $product->quantity ?? $productInDataBase['quantity']);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function deleteOne($id)
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['success' => true];
    }
}
