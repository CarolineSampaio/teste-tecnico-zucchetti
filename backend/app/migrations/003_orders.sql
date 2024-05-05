INSERT INTO orders (customer_id, payment_id, installments, total)
VALUES
    (1, 1, 2, 75.00),
    (2, 2, 1, 180.00),
    (3, 1, 3, 205.00),
    (4, 4, 1, 220.00),
    (5, 1, 5, 290.00);

INSERT INTO orderDetails (order_id, product_id, quantity, unit_price)
VALUES
    (1, 1, 2, 25.00),
    (1, 2, 1, 25.00),
    (2, 3, 3, 30.00),
    (2, 4, 1, 20.00),
    (2, 5, 2, 35.00),
    (3, 1, 5, 25.00),
    (3, 3, 2, 40.00),
    (4, 2, 4, 30.00),
    (4, 4, 5, 20.00),
    (5, 1, 3, 50.00),
    (5, 2, 2, 30.00),
    (5, 4, 4, 20.00);