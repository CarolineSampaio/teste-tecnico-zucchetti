<?php
require_once '../app/models/Database.php';
require_once '../app/models/Customer.php';
require_once '../app/interfaces/CustomerRepositoryInterface.php';

class CustomerRepository extends Database implements CustomerRepositoryInterface
{
    public function store($customer)
    {
        try {
            $sql = 'INSERT INTO customers 
            (
                name, 
                email, 
                cpf, 
                cep, 
                street, 
                number, 
                complement, 
                neighborhood, 
                city, 
                state
            ) 
            VALUES 
            (
                :name, 
                :email, 
                :cpf, :cep, 
                :street, 
                :number, 
                :complement, 
                :neighborhood, 
                :city, 
                :state
            )';

            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(':name', $customer->getName());
            $stmt->bindValue(':email', $customer->getEmail());
            $stmt->bindValue(':cpf', $customer->getCpf());
            $stmt->bindValue(':cep', $customer->getCep());
            $stmt->bindValue(':street', $customer->getStreet());
            $stmt->bindValue(':number', $customer->getNumber());
            $stmt->bindValue(':complement', $customer->getComplement());
            $stmt->bindValue(':neighborhood', $customer->getNeighborhood());
            $stmt->bindValue(':city', $customer->getCity());
            $stmt->bindValue(':state', $customer->getState());

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function index()
    {
        $sql = 'SELECT * FROM customers';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id)
    {
        $sql = 'SELECT * FROM customers WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $customer)
    {
        try {
            $customerInDataBase = $this->show($id);

            $sql = 'UPDATE customers SET 
            name = :name,
            email = :email,
            cpf = :cpf,
            cep = :cep,
            street = :street,
            number = :number,
            complement = :complement,
            neighborhood = :neighborhood,
            city = :city,
            state = :state,
            updated_at = NOW()
            WHERE id = :id';

            $stmt = ($this->getConnection())->prepare($sql);

            $stmt->bindValue(":name", $customer->name ?? $customerInDataBase['name']);
            $stmt->bindValue(":email", $customer->email ?? $customerInDataBase['email']);
            $stmt->bindValue(":cpf", $customer->cpf ?? $customerInDataBase['cpf']);
            $stmt->bindValue(":cep", $customer->cep ?? $customerInDataBase['cep']);
            $stmt->bindValue(":street", $customer->street ?? $customerInDataBase['street']);
            $stmt->bindValue(":number", $customer->number ?? $customerInDataBase['number']);
            $stmt->bindValue(":complement", $customer->complement ?? $customerInDataBase['complement']);
            $stmt->bindValue(":neighborhood", $customer->neighborhood ?? $customerInDataBase['neighborhood']);
            $stmt->bindValue(":city", $customer->city ?? $customerInDataBase['city']);
            $stmt->bindValue(":state", $customer->state ?? $customerInDataBase['state']);
            $stmt->bindValue(':id', $id);

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM customers WHERE id = :id';
        $stmt = ($this->getConnection())->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ['success' => true];
    }
}
