INSERT INTO customers (name, email, cpf, cep, street, number, complement, neighborhood, city, state)
VALUES
    ('João Silva', 'joao@example.com', '123.456.789-01', '12345678', 'Rua A', '123', 'Apto 101', 'Centro', 'Cidade A', 'AB'),
    ('Maria Santos', 'maria@example.com', '987.654.321-01', '87654321', 'Rua B', '456', 'Casa', 'Bairro X', 'Cidade B', 'CD'),
    ('José Oliveira', 'jose@example.com', '111.222.333-44', '11112222', 'Rua C', '789', 'Sobrado', 'Bairro Y', 'Cidade C', 'EF'),
    ('Ana Pereira', 'ana@example.com', '555.666.777-88', '55556666', 'Rua D', '1011', 'Loja 1', 'Bairro Z', 'Cidade D', 'GH'),
    ('Carlos Ferreira', 'carlos@example.com', '999.888.777-66', '99998888', 'Rua E', '1213', 'Loja 2', 'Bairro W', 'Cidade E', 'IJ');

INSERT INTO products (name, quantity, price)
VALUES
    ('Produto A', 10, 25.00),
    ('Produto B', 20, 30.00),
    ('Produto C', 15, 40.00),
    ('Produto D', 25, 20.00),
    ('Produto E', 30, 35.00);

INSERT INTO paymentMethods (name, max_installments)
VALUES
    ('Cartão de Crédito', 12),
    ('Boleto Bancário', 1),
    ('Transferência Bancária', 1),
    ('Pix', 1),
    ('Dinheiro', 1);