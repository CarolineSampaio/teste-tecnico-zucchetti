CREATE TABLE customers (
	id serial PRIMARY KEY,
	name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	cpf varchar(14) NOT NULL,
	cep varchar(8) NOT NULL,
	street varchar(50) NOT NULL,
	number varchar(10) NOT NULL,
	complement varchar(30) NOT NULL,
	neighborhood varchar(50) NOT NULL,
	city varchar(50) NOT NULL,
	state varchar(2) NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW(),
    updated_at timestamp WITH time zone DEFAULT NOW()
);

CREATE TABLE products (
	id serial PRIMARY KEY,
	name varchar(255) NOT NULL,
	quantity integer NOT NULL,
	price float NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW(),
    updated_at timestamp WITH time zone DEFAULT NOW()
);

CREATE TABLE paymentMethods (
	id serial PRIMARY KEY,
	name varchar(255) NOT NULL,
	max_installments integer NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW(),
    updated_at timestamp WITH time zone DEFAULT NOW()
);

CREATE TABLE orders (
	id serial PRIMARY KEY,
	customer_id integer NOT NULL,
	payment_id integer NOT NULL,
	installments integer NOT NULL,
	total float NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW(),
    updated_at timestamp WITH time zone DEFAULT NOW(),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (payment_id) REFERENCES paymentMethods(id)
);

CREATE TABLE orderDetails (
	id serial PRIMARY KEY,
	order_id integer NOT NULL,
	product_id integer NOT NULL,
	quantity integer NOT NULL,
	unit_price float NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW(),
    updated_at timestamp WITH time zone DEFAULT NOW(),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);
