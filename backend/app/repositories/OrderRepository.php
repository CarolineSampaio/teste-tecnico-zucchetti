<?php
require_once '../app/models/Database.php';
require_once '../app/models/Order.php';
require_once '../app/interfaces/OrderRepositoryInterface.php';

class OrderRepository extends Database implements OrderRepositoryInterface
{
    public function getProductsTotal($products)
    {
        $productIds = array_map(function ($product) {
            return $product->product_id;
        }, $products);

        $productIds = implode(',', $productIds);

        $sql = "SELECT id, price FROM products WHERE id IN ($productIds)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        $prices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;
        foreach ($products as $product) {
            $price = array_filter($prices, function ($item) use ($product) {
                return $item['id'] == $product->product_id;
            });

            $total += $price[0]['price'] * $product->quantity;
        }
        return $total;
    }

    public function storeOrder($order)
    {
        try {
            $connection = $this->getConnection();

            $sql = 'INSERT INTO orders 
            (
                customer_id, 
                payment_id, 
                installments,
                total
            ) 
            VALUES 
            (
                :customer_id, 
                :payment_id, 
                :installments,
                :total
            )';

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(':customer_id', $order->getCustomerId());
            $stmt->bindValue(':payment_id', $order->getPaymentId());
            $stmt->bindValue(':installments', $order->getInstallments());
            $total = $this->getProductsTotal($order->getProducts());
            $stmt->bindValue(':total', $total);
            $stmt->execute();

            return $connection->lastInsertId();
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function getProductPrice($productId)
    {
        $sql = 'SELECT price FROM products WHERE id = :id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $productId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeOrderDetail($order)
    {
        # TODO: Refactor this method to use a bulk insert and select
        foreach ($order->getProducts() as $product) {

            $productPrice = $this->getProductPrice($product->product_id);
            $productPrice = $productPrice['price'];
            $sql = 'INSERT INTO orderdetails 
            (
                order_id, 
                product_id, 
                quantity, 
                unit_price
            )
            VALUES 
            (
                :order_id, 
                :product_id, 
                :quantity, 
                :unit_price
            )';

            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':order_id', $order->getOrderId());
            $stmt->bindValue(':product_id', $product->product_id);
            $stmt->bindValue(':quantity', $product->quantity);
            $stmt->bindValue(':unit_price', $productPrice);

            $stmt->execute();
        }
        return ['success' => true];
    }

    public function decreaseInventory($product)
    {
        # FOR UPDATE  to lock the row
        $sql = 'SELECT * FROM products WHERE id = :id FOR UPDATE';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $product->product_id);
        $stmt->execute();

        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData['quantity'] < $product->quantity) {
            return false;
        }

        $sql = 'UPDATE products SET quantity = quantity - :quantity WHERE id = :id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $product->product_id);
        $stmt->bindValue(':quantity', $product->quantity);
        $stmt->execute();

        return true;
    }

    public function verifyInstallments($installments, $payment_id)
    {
        $sql = 'SELECT max_installments FROM paymentmethods WHERE id = :id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $payment_id);
        $stmt->execute();

        $max_installments = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($installments > $max_installments['max_installments']) {
            return false;
        }

        return true;
    }

    public function registerOrder($order)
    {
        try {
            $this->getConnection()->beginTransaction();

            $verifyInstallments = $this->verifyInstallments($order->getInstallments(), $order->getPaymentId());
            if (!$verifyInstallments) {
                $this->getConnection()->rollBack();
                return ['success' => false, 'message' => 'Installments is greater than the maximum allowed'];
            }

            foreach ($order->getProducts() as $product) {
                $hasStock = $this->decreaseInventory($product);
                if (!$hasStock) {
                    $this->getConnection()->rollBack();
                    return ['success' => false, 'message' => 'Insufficient stock for product_id ' . $product->product_id];
                }
            }

            $orderId = $this->storeOrder($order);
            if (!$orderId) {
                $this->getConnection()->rollBack();
                return ['success' => false, 'message' => 'Error to store order'];
            }

            $order->setOrderId($orderId);
            $success = $this->storeOrderDetail($order);

            if (!$success) {
                $this->getConnection()->rollBack();
                return ['success' => false, 'message' => 'Error to store order details'];
            }

            $this->getConnection()->commit();

            return ['success' => true];
        } catch (PDOException $error) {
            $this->getConnection()->rollBack();
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function getOrdersAndDetails($order_id = null, $customer_id = null)
    {
        $sql = 'SELECT
        orders.id as order_id,
        orders.customer_id,
        customers.name as customer_name,
        orders.payment_id,
        paymentmethods.name as payment_method,
        orders.installments,
        orders.total,
        orderdetails.product_id,
        products.name as product_name,
        orderdetails.quantity,
        orderdetails.unit_price
        FROM orders
        JOIN customers ON orders.customer_id = customers.id
        JOIN paymentmethods ON orders.payment_id = paymentmethods.id
        JOIN orderdetails ON orders.id = orderdetails.order_id
        JOIN products ON orderdetails.product_id = products.id';

        if ($order_id) {
            $sql .= ' WHERE orders.id = :order_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindValue(':order_id', $order_id);
        } elseif ($customer_id) {
            $sql .= ' WHERE orders.customer_id = :customer_id';
            $sql .= ' ORDER BY orders.id ASC';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindValue(':customer_id', $customer_id);
        } else {
            $stmt = $this->getConnection()->prepare($sql);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function serializeOrders($orders)
    {
        $groupedOrders = [];
        foreach ($orders as $order) {
            $orderId = $order['order_id'];

            if (!array_key_exists($orderId, $groupedOrders)) {
                $groupedOrders[$orderId] = [
                    'order_id' => $orderId,
                    'customer_id' => $order['customer_id'],
                    'customer_name' => $order['customer_name'],
                    'payment_id' => $order['payment_id'],
                    'payment_method' => $order['payment_method'],
                    'installments' => $order['installments'],
                    'total' => $order['total'],
                    'products' => []
                ];
            }

            $product = [
                'product_id' => $order['product_id'],
                'product_name' => $order['product_name'],
                'quantity' => $order['quantity'],
                'unit_price' => $order['unit_price']
            ];

            $groupedOrders[$orderId]['products'][] = $product;
        }

        return array_values($groupedOrders);
    }

    public function getAll()
    {
        $orders = $this->getOrdersAndDetails();
        return $this->serializeOrders($orders);
    }

    public function getOne($id)
    {
        $orders = $this->getOrdersAndDetails(order_id: $id);
        return $this->serializeOrders($orders);
    }

    public function getOneByCustomerId($customerId)
    {
        $orders = $this->getOrdersAndDetails(customer_id: $customerId);
        return $this->serializeOrders($orders);
    }

    public function updateOne($id, $order)
    {
    }
    public function deleteOne($id)
    {
    }
}
