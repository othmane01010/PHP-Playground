# 📂 `Gestion de Contacts (Contact Management System)`

`This is a professional PHP web application for managing personal contacts, developed as part of my Backend learning journey. It focuses on Object-Oriented Programming (OOP) and secure database interactions.`

---

## 🚀 `Features (Fonctionnalités)`

- **`User Authentication`**: `Secure Login and Registration system.`
- **`Full CRUD`**: `Create, Read, Update, and Delete contacts.`
- **`Data Security`**: `Uses Prepared Statements to prevent SQL Injection and password_hash for security.`
- **`Search`**: `Real-time search for contacts by name, email, or phone.`
- **`Export Data`**: `Export your contact list to a CSV file.`
- **`Validation`**: `Custom Validator trait for data integrity.`

---

## 🛠️ `Tech Stack (Technologies utilisées)`

- **`Backend`**: `PHP 8.x (OOP Architecture)`
- **`Database`**: `MySQL / MariaDB`
- **`Frontend`**: `HTML5 & CSS3`

---

## 📋 `How to use (Comment utiliser)`

### 1️⃣ `Database Setup`
`Import the file:` `databases/database.sql` `to create the necessary tables.`

### 2️⃣ `Configuration`
`Update` `classes/connect.class.php` `with your local credentials:`
- `$host = "localhost"`
- `$user = "root"`
- `$pass = ""`
- `$db   = "gestion_de_contacts"`

### 3️⃣ `Running the project`
- `Move folder to` `htdocs` `or` `/var/www/html`.
- `Start Apache & MySQL services.`
- `Open:` [http://localhost/gestion_de_contacts/login.php](http://localhost/gestion_de_contacts/login.php)

---

## 📁 `Project Structure`

- 📂 `classes/` : `Core logic (Connect, Contacts, Login, Register).`
- 📂 `databases/` : `SQL initialization scripts.`
- 📄 `validator.trait.php` : `Shared validation logic across classes.`
- 📄 `export.php` : `Secure CSV generation script.`
- 📄 `home.php` : `The main Interactive Dashboard.`

---

## 💡 `Why this architecture?`

- **`OOP`**: `To make the code organized, reusable, and easy to maintain.`
- **`Security`**: `Implementation of Prepared Statements and secure hashing.`
- **`Dry Principle`**: `Using Traits to avoid code repetition.`

---

**`Developed by:`** `Othmane - Computer Science Student`
