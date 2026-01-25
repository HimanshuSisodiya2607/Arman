-- VocalFluxStudio Links & Enquiries
-- Run in phpMyAdmin (select DB first) or: mysql -u root -p < schema.sql

CREATE DATABASE IF NOT EXISTS arman CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE arman;

-- Admins table (email + password)
CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Links table (title, url, type, status)
-- type: youtube | instagram | external
-- status: active | inactive
CREATE TABLE IF NOT EXISTS links (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(1024) NOT NULL,
    type ENUM('youtube', 'instagram', 'external') NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Enquiries from client form (name, email, phone, message)
CREATE TABLE IF NOT EXISTS enquiries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(32) DEFAULT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- If you already have enquiries without phone, run:
-- ALTER TABLE enquiries ADD COLUMN phone VARCHAR(32) DEFAULT NULL AFTER email;

-- Default admin: admin@vocalflux.studio / Admin@123 (plain text)
INSERT INTO admins (email, password) VALUES
('admin@vocalflux.studio', 'Admin@123')
ON DUPLICATE KEY UPDATE password = VALUES(password);
