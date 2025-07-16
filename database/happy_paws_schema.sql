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
    user_id INT NOT NULL,
    pet_name VARCHAR(50) NOT NULL,
    pet_type VARCHAR(20) NOT NULL,
    preferred_date DATE NOT NULL,
    consultation_type VARCHAR(50) NOT NULL,
    message TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
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

INSERT IGNORE INTO users (fname, lname, phone, email, password, role) VALUES
('Alice', 'Johnson', '09171234501', 'alice@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Bob', 'Smith', '09171234502', 'bob@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Clara', 'Santos', '09171234503', 'clara@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('David', 'Lee', '09171234504', 'david@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Ella', 'Martinez', '09171234505', 'ella@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Frank', 'Lim', '09171234506', 'frank@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Grace', 'Nguyen', '09171234507', 'grace@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Hannah', 'Go', '09171234508', 'hannah@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user'),
('Ivan', 'Reyes', '09171234509', 'ivan@example.com', '$2y$10$123456789012345678901uAbCdEfGhIjKlMnOpQrStUvWxYz', 'user');

INSERT IGNORE INTO pets (user_id, name, type) VALUES
(1, 'Buddy', 'Dog'),
(2, 'Mittens', 'Cat'),
(3, 'Charlie', 'Dog'),
(4, 'Luna', 'Cat'),
(5, 'Sunny', 'Bird'),
(6, 'Coco', 'Rabbit'),
(7, 'Max', 'Dog'),
(8, 'Bella', 'Cat'),
(9, 'Chirpy', 'Bird'),
(10, 'Hopper', 'Rabbit'),
(1, 'Buster', 'Dog'),
(2, 'Whiskers', 'Cat'),
(3, 'Flap', 'Bird'),
(4, 'Thumper', 'Rabbit'),
(5, 'Milo', 'Dog'),
(6, 'Chloe', 'Cat'),
(7, 'Skye', 'Bird'),
(8, 'Lily', 'Rabbit'),
(9, 'Rex', 'Dog'),
(10, 'Oreo', 'Cat'),
(1, 'Zoe', 'Bird'),
(2, 'Ginger', 'Rabbit'),
(3, 'Toby', 'Dog'),
(4, 'Mochi', 'Cat'),
(5, 'Jack', 'Bird'),
(6, 'Snowball', 'Rabbit'),
(7, 'Maggie', 'Dog'),
(8, 'Nala', 'Cat'),
(9, 'Wings', 'Bird'),
(10, 'Cinnamon', 'Rabbit'),
(1, 'Rusty', 'Dog'),
(2, 'Pumpkin', 'Cat'),
(3, 'Shadow', 'Bird'),
(4, 'Willow', 'Rabbit'),
(5, 'Finn', 'Dog'),
(6, 'Hazel', 'Cat'),
(7, 'Feathers', 'Bird'),
(8, 'Snuffles', 'Rabbit'),
(9, 'Bruno', 'Dog'),
(10, 'Patches', 'Cat'),
(1, 'Marley', 'Bird'),
(2, 'Clover', 'Rabbit'),
(3, 'Ace', 'Dog'),
(4, 'Penny', 'Cat'),
(5, 'Fluffy', 'Bird'),
(6, 'Bunbun', 'Rabbit'),
(7, 'Riley', 'Dog'),
(8, 'Tigger', 'Cat'),
(9, 'Beaky', 'Bird'),
(10, 'Mimi', 'Rabbit');

INSERT INTO appointments (user_id, pet_name, pet_type, preferred_date, consultation_type, message, status) VALUES
(1, 'Buddy', 'Dog', '2025-07-20', 'Vaccination', 'Rabies shot needed.', 'pending'),
(2, 'Mittens', 'Cat', '2025-07-22', 'Checkup', 'Annual wellness check.', 'pending'),
(3, 'Sunny', 'Bird', '2025-07-23', 'Grooming', 'Beak and feather cleaning.', 'pending'),
(4, 'Thumper', 'Rabbit', '2025-07-25', 'Emergency', 'Refusing to eat and lethargic.', 'pending'),
(5, 'Max', 'Dog', '2025-07-28', 'Vaccination', 'Parvo booster required.', 'pending');