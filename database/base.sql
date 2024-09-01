-- Create the database
CREATE DATABASE Freshcery;

-- Use the database
USE Freshcery;

-- Creating the `users` table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Unique identifier for each user
    full_name VARCHAR(255) NOT NULL,    -- Full name of the user
    email VARCHAR(255) NOT NULL UNIQUE, -- Email address (must be unique)
    username VARCHAR(50) NOT NULL UNIQUE, -- Username (must be unique)
    image VARCHAR(255), -- image
    password VARCHAR(255) NOT NULL,     -- Password (hashed)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of when the record was created
);

-- Insert random users
INSERT INTO users (full_name, email, username, password,image)
VALUES
    ('Alice Johnson', 'alice.johnson@example.com', 'alicej', SHA2('password123', 256),"alice.png"),

    ('Bob Smith', 'bob.smith@example.com', 'bobsmith', SHA2('password123', 256),"bob.png"),

    ('Charlie Brown', 'charlie.brown@example.com', 'charlieb', SHA2('password123', 256),"charlie.jpg"),

    ('Dana White', 'dana.white@example.com', 'danaW', SHA2('password123', 256),"dana.png");


-- Creating a categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    icon VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Inserting categories
INSERT INTO categories (name, description, image, icon) 
VALUES
    ('Vegetables', 'All kinds of vegetables', 'images/vegetables.jpg', 'icons/vegetables-icon.png'),
    ('Fruits', 'All kinds of fruits', 'images/fruits.jpg', 'icons/fruits-icon.png'),
    ('Meats', 'Various types of meats', 'images/meats.jpg', 'icons/meats-icon.png'),
    ('Fishes', 'Different types of fishes', 'images/fishes.jpg', 'icons/fishes-icon.png'),
    ('Dairy Products', 'Various dairy products like milk, cheese, and butter', 'images/dairy.jpg', 'icons/dairy-icon.png'),
    ('Beverages', 'A wide range of drinks including juices, sodas, and teas', 'images/beverages.jpg', 'icons/beverages-icon.png'),
    ('Bakery Products', 'Freshly baked bread, cakes, and pastries', 'images/bakery.jpg', 'icons/bakery-icon.png'),
    ('Snacks', 'A variety of snacks including chips, nuts, and cookies', 'images/snacks.jpg', 'icons/snacks-icon.png');



-- Creating the `products` table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,                -- Unique identifier for each product
    name VARCHAR(255) NOT NULL,                       -- Name of the product
    description TEXT,                                 -- Detailed description of the product
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0), -- Price of the product; must be non-negative
    quantity INT NOT NULL CHECK (quantity >= 0),      -- Quantity available in stock; must be non-negative
    discount DECIMAL(5, 2) DEFAULT 0.00 CHECK (discount >= 0 AND discount <= 100), -- Discount percentage; must be between 0 and 100
    category_id INT,                                  -- Foreign key to link to a categories table
    image VARCHAR(255),                               -- Path to the product image
    expiration_date DATE,                             -- Expiration date of the product
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   -- Timestamp when the product was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Timestamp for last update
    is_active BOOLEAN DEFAULT TRUE,                   -- Whether the product is active or not
    sku VARCHAR(100) UNIQUE,                         -- Stock Keeping Unit for inventory management; must be unique
    FOREIGN KEY (category_id) REFERENCES categories(id) -- Foreign key constraint
);

-- Inserting some values to the `products` table
INSERT INTO products (name, description, price, quantity, discount, category_id, image, sku, expiration_date)
VALUES 
    ('Organic Apples', 'Freshly picked organic apples', 3.99, 100, 10.00, 2, 'products/apples.jpg', 'SKU001', '2024-12-31'),  -- Fruits
    ('Whole Chicken', 'Free-range whole chicken', 12.99, 50, 5.00, 3, 'products/chicken.jpg', 'SKU002', '2024-11-15'),  -- Meats
    ('Almond Milk', 'Unsweetened almond milk, 1L', 2.49, 200, 0.00, 5, 'products/almond_milk.jpg', 'SKU003', '2024-10-05'),  -- Dairy Products
    ('Whole Wheat Bread', 'Freshly baked whole wheat bread', 2.99, 75, 0.00, 7, 'products/whole_wheat_bread.jpg', 'SKU004', '2024-09-30'),  -- Bakery Products
    ('Cheddar Cheese', 'Aged cheddar cheese, 200g', 4.99, 30, 15.00, 5, 'products/cheddar_cheese.jpg', 'SKU005', '2025-02-28'),  -- Dairy Products
    ('Brown Rice', 'Organic brown rice, 500g', 3.29, 60, 5.00, 6, 'products/brown_rice.jpg', 'SKU006', '2025-01-10'),  -- Beverages
    ('Olive Oil', 'Extra virgin olive oil, 500ml', 6.49, 40, 0.00, 6, 'products/olive_oil.jpg', 'SKU007', '2026-06-20'),  -- Beverages
    ('Greek Yogurt', 'Plain Greek yogurt, 500g', 5.79, 100, 10.00, 5, 'products/greek_yogurt.jpg', 'SKU008', '2024-08-15'),  -- Dairy Products
    ('Granola Bars', 'Pack of 6 granola bars', 3.99, 150, 0.00, 8, 'products/granola_bars.jpg', 'SKU009', '2024-12-01'),  -- Snacks
    ('Chicken Breasts', 'Boneless chicken breasts, 500g', 9.49, 70, 0.00, 3, 'products/chicken_breasts.jpg', 'SKU010', '2024-11-25');  -- Meats

-- Adding a views colums to the `products` table
ALTER TABLE products
ADD views INT DEFAULT 0;


-- Creating the `card` table
CREATE TABLE card (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL, -- Name of the product
    description TEXT,
    product_id INT,
    user_id INT,
    category_id INT NOT NULL,
    image VARCHAR(255) NOT NULL, -- The card (product) image
    price DECIMAL(10, 2) NOT NULL,
    discount INT DEFAULT 0,
    discounted_price DECIMAL(10, 2) AS (price * (1 - discount / 100)) STORED,
    stock INT NOT NULL, -- Available quantity in stock
    product_quantity INT NOT NULL CHECK (product_quantity <= stock), -- Ensure product_quantity does not exceed stock
    status BOOLEAN DEFAULT TRUE,
    expiration_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE card
ADD CONSTRAINT unique_user_product
UNIQUE (user_id, product_id);


-- The orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    company_name VARCHAR(100),
    address TEXT NOT NULL,
    town_city VARCHAR(50) NOT NULL,
    state_country VARCHAR(50) NOT NULL,
    postcode_zip VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    order_notes TEXT,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending', -- A column to track the order status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



