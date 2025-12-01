-- Create database
CREATE DATABASE IF NOT EXISTS pc_store;
USE pc_store;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    specifications TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(50),
    stock INT DEFAULT 0,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample products (only if table is empty)
-- This uses a stored procedure to check if products already exist
DELIMITER $$
CREATE PROCEDURE IF NOT EXISTS seed_products()
BEGIN
    DECLARE product_count INT;
    SELECT COUNT(*) INTO product_count FROM products;

    IF product_count = 0 THEN
        INSERT INTO products (
            name, description, specifications, price, image, category, stock, featured
        ) VALUES
(
    'Gaming PC Pro',
    'High-performance gaming desktop with RGB lighting',
    'Intel i9-13900K, RTX 4090, 32GB DDR5, 2TB NVMe SSD',
    2999.99,
    'gaming-pc-pro.jpg',
    'Gaming',
    15,
    TRUE
),
(
    'Office Workstation',
    'Reliable workstation for productivity tasks',
    'Intel i7-13700, 16GB DDR4, 1TB SSD, Integrated Graphics',
    1299.99,
    'office-pc.jpg',
    'Office',
    25,
    FALSE
),
(
    'Creator Studio',
    'Powerful PC for content creation and video editing',
    'AMD Ryzen 9 7950X, RTX 4080, 64GB DDR5, 4TB NVMe SSD',
    3499.99,
    'creator-pc.jpg',
    'Professional',
    10,
    TRUE
),
(
    'Budget Gaming',
    'Entry-level gaming PC for casual gamers',
    'Intel i5-13400F, RTX 4060, 16GB DDR4, 500GB SSD',
    899.99,
    'budget-gaming.jpg',
    'Gaming',
    30,
    FALSE
),
(
    'Mini PC Compact',
    'Small form factor PC perfect for home office',
    'Intel i5-13500, 16GB DDR4, 512GB SSD, Intel UHD',
    799.99,
    'mini-pc.jpg',
    'Office',
    20,
    FALSE
),
(
    'Extreme Workstation',
    'Professional workstation for demanding applications',
    'AMD Threadripper PRO, RTX 6000 Ada, 128GB DDR5, 8TB NVMe',
    7999.99,
    'extreme-workstation.jpg',
    'Professional',
    5,
    TRUE
),
(
    'Student Special',
    'Affordable PC for students and everyday use',
    'Intel i3-13100, 8GB DDR4, 256GB SSD, Integrated Graphics',
    499.99,
    'student-pc.jpg',
    'Office',
    40,
    FALSE
),
(
    'Streaming Beast',
    'Optimized for streaming and multitasking',
    'AMD Ryzen 7 7800X3D, RTX 4070 Ti, 32GB DDR5, 2TB SSD',
    2299.99,
    'streaming-pc.jpg',
    'Gaming',
    12,
    TRUE
);
    END IF;
END$$
DELIMITER ;

-- Call the procedure to seed products
CALL seed_products();

-- Drop the procedure after use (cleanup)
DROP PROCEDURE IF EXISTS seed_products;
