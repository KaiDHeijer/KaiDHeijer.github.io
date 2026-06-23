CREATE DATABASE IF NOT EXISTS collectables
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE collectables;

-- ──────────────────────────────────────
-- USERS
-- ──────────────────────────────────────
CREATE TABLE users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(100)  NOT NULL,
  email       VARCHAR(255)  NOT NULL UNIQUE,
  password    VARCHAR(255)  NOT NULL,
  bio         TEXT          DEFAULT NULL,
  avatar_url  VARCHAR(500)  DEFAULT NULL,
  created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- COLLECTIONS
-- ──────────────────────────────────────
CREATE TABLE collections (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  user_id     INT           NOT NULL,
  name        VARCHAR(150)  NOT NULL,
  description VARCHAR(300)  DEFAULT NULL,
  cover_url   VARCHAR(500)  DEFAULT NULL,
  created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- ITEMS
-- ──────────────────────────────────────
CREATE TABLE items (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  collection_id INT           NOT NULL,
  name          VARCHAR(150)  NOT NULL,
  description   VARCHAR(500)  DEFAULT NULL,
  category      VARCHAR(100)  DEFAULT NULL,
  image_url     VARCHAR(500)  DEFAULT NULL,
  created_at    DATETIME      DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (collection_id) REFERENCES collections(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seed data wordt ingevoegd via seed.php (vanwege password_hash in PHP)
