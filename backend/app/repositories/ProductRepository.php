<?php
require_once '../models/Database.php';
require_once '../models/Product.php';
require_once '../interfaces/ProductRepositoryInterface.php';

class ProductRepository extends Database implements ProductRepositoryInterface
{
    public function store($product)
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

            $stmt->bindParam(':name', $product->getName());
            $stmt->bindParam(':price', $product->getPrice());
            $stmt->bindParam(':quantity', $product->getQuantity());

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function index()
    {
        $sql = 'SELECT * FROM products';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id)
    {
        $sql = 'SELECT * FROM products WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $product)
    {
        try {
            $productInDataBase = $this->show($id);

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

    public function delete($id)
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['success' => true];
    }
}
