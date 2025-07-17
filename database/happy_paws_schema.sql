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
    detailed_report LONGTEXT,
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

/* RECORDS */
INSERT INTO records (pet_id, service, vet_in_charge, visit_date, detailed_report)
VALUES (
    1,
    'Ultrasound',
    'Dr. Sunshine Magbuhos Arevalo',
    '2024-03-03',
    '
    <strong>Abdominal Ultrasound Report</strong><br><br>
    <strong>Patient Name:</strong> Whiskers<br>
    <strong>Species/Breed:</strong> Domestic Shorthair Cat<br>
    <strong>Age/Sex:</strong> 7-year-old Spayed Female<br>
    <strong>Referring Veterinarian:</strong> Dr. Sunshine Magbuhos Arevalo<br>
    <strong>Date of Ultrasound:</strong> March 3, 2024<br><br>

    <strong>Clinical History:</strong><br>
    Whiskers was referred for abdominal ultrasound due to a 3-day history of vomiting, decreased appetite, and lethargy. Bloodwork showed elevated liver enzymes and an increased white blood cell count.<br><br>

    <strong>Ultrasound Findings:</strong><br>
    <strong>Liver:</strong> Mildly enlarged with a uniform decrease in echogenicity (appears darker than normal). No masses or bile duct abnormalities noted.<br>
    <strong>Gallbladder:</strong> Contains mild, non-obstructive sludge. No gallstones or wall thickening observed.<br>
    <strong>Pancreas:</strong> Appears slightly enlarged and inflamed, with surrounding fat changes—findings consistent with mild to moderate pancreatitis.<br>
    <strong>Kidneys:</strong> Normal in size and shape. The left kidney shows minor changes in tissue structure, but no signs of kidney stones or fluid buildup.<br>
    <strong>Intestines:</strong> Mild thickening of the muscular layer in the small intestine, likely due to inflammation. No obstruction or abnormal masses detected.<br>
    <strong>Bladder:</strong> Normal in appearance with clear urine.<br>
    <strong>Abdomen:</strong> A small amount of free fluid is present, likely secondary to inflammation in the pancreas.<br><br>

    <strong>Impression:</strong>
    <ul>
      <li>Changes consistent with hepatic lipidosis (fatty liver disease)</li>
      <li>Pancreatitis, mild to moderate</li>
      <li>Mild, nonspecific intestinal inflammation</li>
      <li>Small volume abdominal effusion, likely reactive</li>
    </ul>

    <strong>Recommendations:</strong>
    <ul>
      <li>Supportive care including IV fluids, pain management, anti-nausea medication, and nutritional support</li>
      <li>Monitor liver and pancreatic enzyme levels</li>
      <li>Consider follow-up ultrasound in 5–7 days if clinical signs persist</li>
      <li>Fine needle aspiration of the liver may be recommended if no improvement is seen</li>
    </ul>

    <img src="uploads/ultrasound1.jpg" alt="Ultrasound Image" style="max-width:100%; height:auto;" />
    '
);

INSERT INTO records (pet_id, service, vet_in_charge, visit_date, detailed_report) VALUES
(2, 'Ultrasound', 'Dr. Sunshine Magbuhos Arevalo', '2024-03-03', '<strong>Abdominal Ultrasound Report</strong><br><br><strong>Patient Name:</strong> Ginger<br><strong>Species/Breed:</strong> Domestic Shorthaired Cat<br><strong>Age/Sex:</strong> 3-year-old Female<br><strong>Referring Veterinarian:</strong> Dr. Sunshine Magbuhos Arevalo<br><strong>Date of Ultrasound:</strong> March 3, 2024<br><br><strong>Ultrasound Findings:</strong><br><strong>Liver:</strong> Normal size and echogenicity.<br><strong>Gallbladder:</strong> No abnormalities.<br><strong>Pancreas:</strong> Mild inflammation, suggestive of early pancreatitis.<br><strong>Kidneys:</strong> Symmetrical, normal shape.<br><strong>Intestines:</strong> Mild thickening in jejunum, likely reactive.<br><strong>Bladder:</strong> Normal.<br><strong>Abdomen:</strong> No free fluid noted.<br><br><strong>Impression:</strong><br>• Early pancreatitis<br>• Mild reactive intestinal changes<br><br><strong>Recommendations:</strong><br>• Anti-nausea meds<br>• Low-fat diet<br>• Re-evaluate in 5 days.'),
(3, 'Vaccination', 'Dr. Elaine Fajardo', '2024-04-15', '<strong>Vaccination Visit Report</strong><br><br><strong>Patient Name:</strong> Max<br><strong>Species/Breed:</strong> Labrador Retriever<br><strong>Age/Sex:</strong> 1-year-old Male<br><br><strong>Service:</strong> Core vaccine boosters administered.<br><br><strong>Vaccines Given:</strong><br>• DHPP<br>• Rabies<br>• Leptospirosis<br><br><strong>Observations:</strong> No adverse reactions noted post-vaccination.<br><br><strong>Recommendations:</strong><br>• Monitor for signs of reaction (swelling, vomiting, etc.)<br>• Next booster due in 1 year.'),
(4, 'Checkup', 'Dr. Alena Garcia', '2024-05-10', '<strong>Routine Checkup Report</strong><br><br><strong>Patient Name:</strong> Bella<br><strong>Species/Breed:</strong> Pomeranian<br><strong>Age/Sex:</strong> 5-year-old Female<br><br><strong>Findings:</strong><br>• Heart rate: Normal<br>• Lungs: Clear<br>• Weight: Slightly overweight<br><br><strong>Notes:</strong><br>Recommended reduced feeding portions and increased activity.<br><br><strong>Follow-up:</strong> Weight recheck in 4 weeks.'),
(5, 'Grooming', 'Ms. Jane Cortez', '2024-06-01', '<strong>Grooming Session Report</strong><br><br><strong>Patient Name:</strong> Charlie<br><strong>Species/Breed:</strong> Shih Tzu<br><strong>Age/Sex:</strong> 2-year-old Male<br><br><strong>Service Provided:</strong><br>• Full bath and blow dry<br>• Nail trimming<br>• Ear cleaning<br><br><strong>Notes:</strong><br>Skin in good condition, no fleas or ticks noted.<br><br><strong>Recommendations:</strong><br>• Return in 6 weeks for next grooming.'),
(6, 'Emergency', 'Dr. Ronel Tan', '2024-06-18', '<strong>Emergency Visit Report</strong><br><br><strong>Patient Name:</strong> Oreo<br><strong>Species/Breed:</strong> Domestic Longhair Cat<br><strong>Age/Sex:</strong> 4-year-old Neutered Male<br><br><strong>Chief Complaint:</strong> Vomiting and lethargy.<br><strong>Findings:</strong> Dehydration, elevated temperature.<br><br><strong>Diagnostics:</strong> CBC, blood chemistry (awaiting results).<br><br><strong>Initial Treatment:</strong><br>• Subcutaneous fluids<br>• Antiemetics<br>• Monitoring overnight<br><br><strong>Next Steps:</strong><br>• Evaluate lab results<br>• Determine need for ultrasound.'),
(7, 'Checkup', 'Dr. Aria Lim', '2024-03-22', '<strong>Annual Checkup Report</strong><br><br><strong>Patient Name:</strong> Luna<br><strong>Species/Breed:</strong> Beagle<br><strong>Age/Sex:</strong> 6-year-old Female<br><br><strong>Findings:</strong><br>• Slight dental tartar<br>• Joints normal<br><br><strong>Recommendations:</strong><br>• Schedule dental cleaning<br>• Continue current diet.'),
(8, 'Vaccination', 'Dr. Greg Ramirez', '2024-02-17', '<strong>Vaccination Record</strong><br><br><strong>Patient Name:</strong> Simba<br><strong>Species/Breed:</strong> Golden Retriever<br><strong>Age/Sex:</strong> 8-week-old Male Puppy<br><br><strong>Vaccines Administered:</strong><br>• DHPP<br>• Bordetella (nasal)<br><br><strong>Notes:</strong><br>Puppy in good health. Slight stress post-vaccine, resolved within minutes.'),
(9, 'Grooming', 'Ms. Jane Cortez', '2024-07-01', '<strong>Grooming Session Summary</strong><br><br><strong>Patient Name:</strong> Coco<br><strong>Species/Breed:</strong> Poodle<br><strong>Age/Sex:</strong> 3-year-old Female<br><br><strong>Grooming:</strong><br>• Summer cut<br>• Ear plucking<br><br><strong>Notes:</strong> Matting on hind limbs trimmed carefully.'),
(10, 'Ultrasound', 'Dr. Sunshine Magbuhos Arevalo', '2024-07-10', '<strong>Ultrasound Follow-Up Report</strong><br><br><strong>Patient Name:</strong> Tiger<br><strong>Species/Breed:</strong> Siamese Cat<br><strong>Age/Sex:</strong> 9-year-old Neutered Male<br><br><strong>Findings:</strong><br>• Stable hepatic structure<br>• No abnormal fluid<br><strong>Assessment:</strong> Stable compared to previous scan.');