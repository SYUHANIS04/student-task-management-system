# Student Task Management System (STMS)

## Description
The Student Task Management System (STMS) is a PHP-based web application designed to help manage student tasks, subjects, and deadlines efficiently.  
It is built using PHP, MySQL, Bootstrap, and runs locally using XAMPP.

The system includes:
- Secure user registration & login authentication  
- Password hashing for account security  
- Task management (Add, Edit, Delete tasks)
- Subject management
- Dashboard with visual task summaries  
- Modern UI using Bootstrap (responsive)

##  Test Login
- Username: Syuhanis 
- Password: 1010  
(Password is securely hashed in the database.)


##  How to Run Locally

1. Place the `student_task_management_system` folder inside your web server root, for example:


## How to run locally
1. Place the student_task_management folder inside your web server root (e.g., XAMPP htdocs).  
2. Start Apache and MySQL using XAMPP.
3. Open phpMyAdmin and create a new database:
4. Import the SQL file:
- `stms_db.sql`
(This file contains the tables: users, subjects, tasks, and sample data.)
5. Open your browser and go to:
 http://localhost/student_task_management_system/index.php
6. Login using the test credentials above.


##  Files Included

### 🔹 Main Pages
- index.php  
- login.php  
- register.php  
- logout.php  
- dashboard.php  
- tasks.php  
- subjects.php  
- users.php

### 🔹 Includes
- includes/header.php  
- includes/footer.php  
- includes/conn.php  

### 🔹 Assets
- css/style.css  
- js/script.js  

### 🔹 Database
- stms_db.sql

##  Technologies Used
- PHP (Core Logic)
- MySQL (Database)
- Bootstrap 5 (Frontend UI)
- HTML & CSS
- JavaScript





