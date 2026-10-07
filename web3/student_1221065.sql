



DROP TABLE IF EXISTS tickets;

DROP TABLE IF EXISTS staff;

DROP TABLE IF EXISTS users;





CREATE TABLE users (

    user_id INT AUTO_INCREMENT PRIMARY KEY,

    user_name VARCHAR(100) NOT NULL,

    user_email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    user_type ENUM('manager', 'customer', 'staff') NOT NULL

);




CREATE TABLE tickets (

    ticket_id INT AUTO_INCREMENT PRIMARY KEY,

    customer_name VARCHAR(100) NOT NULL,

    customer_email VARCHAR(100) NOT NULL,

    customer_location VARCHAR(150) NOT NULL,

    issue_description TEXT NOT NULL,

    urgency_level ENUM('Low', 'Medium', 'High') NOT NULL,

    status ENUM('pending', 'assigned', 'completed') DEFAULT 'pending',

    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP,

    assigned_date DATETIME NULL,

    assigned_staff VARCHAR(100) NULL,

    ticket_image VARCHAR(255) DEFAULT NULL

);


CREATE TABLE staff (

    staff_id INT AUTO_INCREMENT PRIMARY KEY,

    staff_name VARCHAR(100) NOT NULL

);



-- Users

INSERT INTO users (user_name, user_email, password, user_type) VALUES

('System Manager', 'manger@gmail.com', 'comp@334', 'manager'),

('Mazen AlJamel', 'cust@gmail.com', 'comp#334', 'customer'),

('Hutheyfa Ammar', 'hutheyfa@gmail.com', '123456', 'customer'),

('Ahmad Manager', 'ahmad@gmail.com', 'comp@334', 'manager'),

('mahmoud AlJamel', 'moh@gmail.com', 'comp#334', 'customer'),

('ali Ammar', 'ali@gmail.com', '123456', 'customer')

,('ppp Manager', 'ppp@gmail.com', 'comp@334', 'manager'),

('oo AlJamel', 'oo@gmail.com', 'comp#334', 'customer'),

('wr Ammar', 'wr@gmail.com', '123456', 'customer'),
('wrd Ammar', 'wrd@gmail.com', '123456', 'customer');







INSERT INTO staff (staff_name) VALUES

('Maher Ahmed'),

('Ala Al-Masri'),

('Sami Mansour');





INSERT INTO tickets

(ticket_id, customer_name, customer_email, customer_location, issue_description, urgency_level, status, date_submitted, assigned_date, assigned_staff, ticket_image)

VALUES

(1, 'Mazen AlJamel', 'cust@gmail.com', 'Room 305', 'Leaky Faucet in Room 101', 'High', 'pending', '2026-08-18 10:00:00', NULL, NULL, '1.jpeg'),

(2, 'Fresh Drinking Store', 'zaher@fresh.com', 'Main office', 'Air Conditioning Malfunction in Office', 'High', 'pending', '2026-08-19 11:15:00', NULL, NULL, '2.jpeg'),
(3, 'ali AlJamel', 'cust@gmail.com', 'Room 305', 'Leaky Faucet in Room 101', 'High', 'pending', '2026-08-18 10:00:00', NULL, NULL, '1.jpeg'),

(4, 'ahma Drinking Store', 'ali@gmail.com', 'Main office', 'Air Conditioning Malfunction in Office', 'High', 'pending', '2026-08-19 11:15:00', NULL, NULL, '2.jpeg'); 
