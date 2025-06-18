CREATE DATABASE resume_analyzer;

USE resume_analyzer;

CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uploader_name VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    stored_filename VARCHAR(255) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
