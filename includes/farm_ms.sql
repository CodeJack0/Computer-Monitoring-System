-- Drop the existing database if it exists
DROP DATABASE IF EXISTS farm_management;

-- Create the farm_management database
CREATE DATABASE farm_management;
USE farm_management;

-- Table structure for the Users
CREATE TABLE IF NOT EXISTS Users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  create_datetime DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for the Farms
CREATE TABLE IF NOT EXISTS Farms (
  farm_id INT AUTO_INCREMENT PRIMARY KEY,
  farm_name VARCHAR(100),
  location VARCHAR(255),
  size_acres DECIMAL(10, 2),
  owner_id INT,
  CONSTRAINT fk_owner_id FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for the Livestock
CREATE TABLE IF NOT EXISTS Livestock (
  livestock_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  type VARCHAR(100),
  quantity INT,
  farm_id INT,
  CONSTRAINT fk_livestock_farm_id FOREIGN KEY (farm_id) REFERENCES Farms(farm_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for the Crops
CREATE TABLE IF NOT EXISTS Crops (
  crop_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  type VARCHAR(100),
  quantity INT,
  farm_id INT,
  CONSTRAINT fk_crop_farm_id FOREIGN KEY (farm_id) REFERENCES Farms(farm_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for the Equipment
CREATE TABLE IF NOT EXISTS Equipment (
  equipment_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  type VARCHAR(100),
  quantity INT,
  farm_id INT,
  CONSTRAINT fk_equipment_farm_id FOREIGN KEY (farm_id) REFERENCES Farms(farm_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
