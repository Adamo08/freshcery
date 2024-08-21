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
    ('Fishes', 'Different types of fishes', 'images/fishes.jpg', 'icons/fishes-icon.png');




