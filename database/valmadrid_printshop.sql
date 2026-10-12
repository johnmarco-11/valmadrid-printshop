CREATE DATABASE IF NOT EXISTS valmadrid_printshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE valmadrid_printshop;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS notifications, uploaded_files, inventory, sales, payments, order_items, orders, cart, products, categories, admins, users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(40),
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(120) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  low_stock_level INT NOT NULL DEFAULT 5,
  image VARCHAR(255),
  sold_count INT NOT NULL DEFAULT 0,
  is_archived TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  custom_notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  invoice_no VARCHAR(40) NOT NULL UNIQUE,
  customer_name VARCHAR(120) NOT NULL,
  customer_contact VARCHAR(40),
  customer_address TEXT,
  subtotal DECIMAL(10,2) NOT NULL,
  service_fee DECIMAL(10,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(10,2) NOT NULL,
  payment_method VARCHAR(40) NOT NULL,
  payment_status VARCHAR(40) NOT NULL DEFAULT 'Unpaid',
  status ENUM('Pending','Confirmed','Designing','Printing','Ready for Pickup','Completed','Cancelled') DEFAULT 'Pending',
  order_notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(150) NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  line_total DECIMAL(10,2) NOT NULL,
  custom_notes TEXT,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  method VARCHAR(40) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status VARCHAR(40) NOT NULL,
  paid_at DATETIME NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE inventory (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  movement_type VARCHAR(40) NOT NULL,
  quantity INT NOT NULL,
  remarks VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE sales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  sale_date DATE NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE uploaded_files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NULL,
  original_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  status VARCHAR(40) DEFAULT 'For Review',
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  message VARCHAR(255) NOT NULL,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO admins (username,password,name) VALUES ('admin','admin123','System Administrator');
INSERT INTO users (name,email,password,phone,address) VALUES ('Juan Dela Cruz','customer@example.com','customer123','0917-000-0000','San Ildefonso, Bulacan');

INSERT INTO categories (name,description) VALUES
('Printing Services','Custom printing, advertising, and office document services'),
('Souvenir Printing','Personalized gift and sublimation products'),
('Signage and Display','Tarpaulins, boards, signage, and display materials'),
('Document Services','Xerox and paper printing services');

INSERT INTO products (category_id,name,description,price,stock,low_stock_level,image,sold_count) VALUES
(1,'T-Shirt Printing','Custom shirt printing for events, teams, uniforms, and giveaways.',250,60,10,'assets/images/product-placeholder.svg',34),
(1,'ID Lace','Printed ID lace with logo and custom layout.',80,150,20,'assets/images/product-placeholder.svg',46),
(1,'PVC ID','Durable PVC identification card with clear print quality.',120,100,15,'assets/images/product-placeholder.svg',50),
(2,'Mug Printing','Personalized mug printing for gifts and souvenirs.',180,70,10,'assets/images/product-placeholder.svg',27),
(2,'Sublimation Printing','Full-color sublimation prints for compatible items and fabrics.',200,40,8,'assets/images/product-placeholder.svg',23),
(1,'Vinyl Stickers','Weather-resistant vinyl stickers for branding and labels.',35,200,30,'assets/images/product-placeholder.svg',64),
(1,'Sticker Labels','Sticker labels for packaging, bottles, and business products.',25,300,50,'assets/images/product-placeholder.svg',72),
(3,'Acrylic Plate Plaque','Elegant acrylic plaque for awards and recognition.',750,20,5,'assets/images/product-placeholder.svg',9),
(3,'Sintra Board','Rigid sintra board print for signs and displays.',450,30,6,'assets/images/product-placeholder.svg',18),
(3,'Tarpaulin Printing','Large-format tarpaulin printing for birthdays, events, and business ads.',120,80,12,'assets/images/product-placeholder.svg',88),
(3,'Signage','Custom signage for stores, offices, and events.',1500,15,3,'assets/images/product-placeholder.svg',12),
(3,'Panaflex','Bright panaflex signage print for lighted sign boxes.',1800,12,3,'assets/images/product-placeholder.svg',8),
(4,'Xerox Black & White','Black and white document photocopy service.',2,1000,100,'assets/images/product-placeholder.svg',210),
(4,'Xerox Colored','Colored document photocopy service.',10,600,80,'assets/images/product-placeholder.svg',98),
(4,'A4 Printing','A4 document printing for school and office requirements.',8,700,100,'assets/images/product-placeholder.svg',135),
(4,'A3 Printing','A3 size document and poster printing.',25,250,40,'assets/images/product-placeholder.svg',62);

INSERT INTO orders (user_id,invoice_no,customer_name,customer_contact,customer_address,subtotal,service_fee,total_amount,payment_method,payment_status,status,order_notes,created_at) VALUES
(1,'VM-20250110-1001','Juan Dela Cruz','0917-000-0000','San Ildefonso, Bulacan',480,30,510,'Cash on Pickup','Paid','Completed','Birthday tarpaulin','2025-01-10 09:30:00'),
(1,'VM-20250215-1002','Juan Dela Cruz','0917-000-0000','San Ildefonso, Bulacan',600,30,630,'GCash','Paid','Completed','Sticker labels','2025-02-15 14:20:00'),
(1,'VM-20250320-1003','Juan Dela Cruz','0917-000-0000','San Ildefonso, Bulacan',250,30,280,'Cash on Pickup','Unpaid','Pending','Shirt print','2025-03-20 11:00:00');
INSERT INTO order_items (order_id,product_id,product_name,quantity,unit_price,line_total,custom_notes) VALUES (1,10,'Tarpaulin Printing',4,120,480,'6x3 ft'),(2,7,'Sticker Labels',24,25,600,'Round labels'),(3,1,'T-Shirt Printing',1,250,250,'Front print');
INSERT INTO payments (order_id,method,amount,status,paid_at) VALUES (1,'Cash on Pickup',510,'Paid','2025-01-10 16:00:00'),(2,'GCash',630,'Paid','2025-02-15 15:00:00'),(3,'Cash on Pickup',280,'Unpaid',NULL);
INSERT INTO sales (order_id,total_amount,sale_date) VALUES (1,510,'2025-01-10'),(2,630,'2025-02-15'),(3,280,'2025-03-20');
INSERT INTO inventory (product_id,movement_type,quantity,remarks) VALUES (10,'Stock Out',4,'Sample completed order'),(7,'Stock Out',24,'Sample completed order'),(1,'Stock Out',1,'Sample pending order');
INSERT INTO notifications (user_id,message) VALUES (1,'Welcome to Valmadrid Advertising and Digital Print.'),(1,'Your sample order is pending review.');