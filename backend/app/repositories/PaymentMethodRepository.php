<?php
require_once '../app/models/Database.php';
require_once '../app/models/PaymentMethod.php';
require_once '../app/interfaces/PaymentMethodRepositoryInterface.php';

class PaymentMethodRepository extends Database implements PaymentMethodRepositoryInterface
{
    public function store($paymentMethod)
    {
        try {
            $sql = 'INSERT INTO paymentmethods 
            (
                name, 
                max_installments
            ) 
            VALUES 
            (
                :name, 
                :max_installments
            )';

            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(':name', $paymentMethod->getName());
            $stmt->bindValue(':max_installments', $paymentMethod->getMaxInstallments());

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function index()
    {
        $sql = 'SELECT * FROM paymentmethods';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id)
    {
        $sql = 'SELECT * FROM paymentmethods WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $paymentMethod)
    {
        try {
            $paymentMethodInDataBase = $this->show($id);

            $sql = 'UPDATE paymentmethods SET 
            name = :name, 
            max_installments = :max_installments,
            updated_at = NOW()
            WHERE id = :id';

            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(":name", $paymentMethod->name ?? $paymentMethodInDataBase['name']);
            $stmt->bindValue(":max_installments", $paymentMethod->max_installments ?? $paymentMethodInDataBase['max_installments']);
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
        $sql = 'DELETE FROM paymentmethods WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['success' => true];
    }
}
