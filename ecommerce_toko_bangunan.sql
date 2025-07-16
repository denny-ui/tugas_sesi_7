
-- -----------------------------------------------------
-- Database structure for e-commerce toko bangunan
-- -----------------------------------------------------

-- Drop tables if they already exist
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS products;

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    stock INT NOT NULL
);

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Sample data for products
INSERT INTO products (name, price, description, stock) VALUES
('Semen Tiga Roda', 60000.00, 'Semen berkualitas tinggi untuk konstruksi', 50),
('Cat Dulux Warna Merah', 85000.00, 'Cat tembok interior dan eksterior', 30),
('Paku 5cm', 15000.00, 'Paku baja untuk kebutuhan konstruksi', 100),
('Cat Avian Putih', 75000.00, 'Cat dinding tahan lama', 40),
('Semen Gresik', 58000.00, 'Semen serbaguna dan kuat', 60);

-- Sample data for users
INSERT INTO users (name, email, password) VALUES
('Andi', 'andi@example.com', 'hashed_password_123'),
('Budi', 'budi@example.com', 'hashed_password_456');

-- Sample data for orders
INSERT INTO orders (user_id, product_id, quantity, total) VALUES
(1, 1, 5, 300000.00),
(2, 3, 10, 150000.00);
