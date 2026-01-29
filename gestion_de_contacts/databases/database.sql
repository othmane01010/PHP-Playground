-- Create the main database
CREATE DATABASE gestion_de_contacts;
USE gestion_de_contacts;

-- Table to store user accounts
CREATE TABLE users(
   id INT AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(100) NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   password VARCHAR(120) NOT NULL
) ENGINE=InnoDB;

-- Table to store contacts linked to each user
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    adresse TEXT,
    
    -- Indexes to speed up search operations
    INDEX idx_search_name (name),      
    INDEX idx_search_tel (telephone),
    INDEX idx_search_email (email),  
   
    -- Link contact to user and delete contacts if user is deleted
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;