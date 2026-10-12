# Valmadrid Advertising and Digital Print E-Commerce System

Beginner-friendly native PHP and MySQL printing shop system for a college capstone project. It uses Bootstrap 5, procedural PHP, PDO prepared statements, sessions, file upload validation, and a simple folder structure.

## Default Accounts

- Admin: `admin` / `admin123`
- Customer: `customer@example.com` / `customer123`

On first successful login, the demo plaintext password is automatically converted to a hashed password using `password_hash()`.

## XAMPP Setup

1. Copy this folder to `C:\xampp\htdocs\valmadrid-printshop`.
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Import `database/valmadrid_printshop.sql`.
5. Open `http://localhost/valmadrid-printshop/index.php`.
6. Admin panel: `http://localhost/valmadrid-printshop/admin/login.php`.

## Folder Structure

- `/admin` admin dashboard, orders, products, inventory, and sales pages
- `/customer` login, register, forgot password, dashboard, and logout pages
- `/assets` CSS, JavaScript, and SVG image placeholders
- `/config` database connection
- `/includes` reusable PHP functions, header, and footer
- `/uploads` customer and product uploaded files
- `/database` complete MySQL SQL file

## Main Features

- Home page, product catalog, product search, category filters, and pagination
- Cart using PHP sessions with automatic quantity update
- Checkout with Cash on Pickup and GCash options
- Customer registration, login, profile editing, password changing, order history, file list, invoices, and reorder
- Printable invoice and receipt layout with logo and QR code placeholder
- Admin dashboard analytics, sales chart, low stock alerts, best sellers, and notifications
- Product CRUD, image preview, archive products, category selection, prices, and stock
- Inventory stock in/out logs and movement history
- Sales filtering and printable report
- Order status management and customer notification entries
- File uploads for PNG, JPG, PDF, PSD, and DOCX up to 15MB

## Notes for Students

- Database queries use PDO prepared statements to help prevent SQL injection.
- Passwords created by the register form are hashed.
- Uploaded files are checked by extension and size before saving.
- The UI follows Valmadrid branding colors: bright yellow, red, black, white, and green highlights.
- The project is intentionally simple so beginner developers can read and modify it.
