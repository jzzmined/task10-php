-- Create Database
CREATE DATABASE IF NOT EXISTS journal_db;
USE journal_db;

-- Create Journal Table
CREATE TABLE IF NOT EXISTS journal_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data (optional)
INSERT INTO journal (title, content) VALUES
('My First Entry', 'Today was a great day! I started learning PHP and MySQL.'),
('Learning CRUD', 'I am building a journal application with full CRUD functionality.');