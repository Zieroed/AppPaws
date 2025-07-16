-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS happy_paws;
USE happy_paws;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pets table
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(20) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    preferred_date DATE NOT NULL,
    consultation_type VARCHAR(50) NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

-- Records table
CREATE TABLE IF NOT EXISTS records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    service VARCHAR(100) NOT NULL,
    vet_in_charge VARCHAR(100) NOT NULL,
    visit_date DATE NOT NULL,
    detailed_report TEXT,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

-- Insert default admin account if not already present
INSERT IGNORE INTO users (fname, lname, phone, email, password, role)
VALUES (
    'Admin', 
    'User', 
    '09123456789', 
    'admin@happypaws.com', 
    '$2y$10$boaH23Fl29yT867Q90XRheo/PrNYD8IYgvlIJ9cuJLAG7h1ip7vsm', 
    'admin'
);