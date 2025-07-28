-- Create Customers Table
CREATE TABLE Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Phone VARCHAR(20) NOT NULL
);

-- Create Computers Table
CREATE TABLE Computers (
    ComputerID INT AUTO_INCREMENT PRIMARY KEY,
    Location VARCHAR(50) NOT NULL, -- e.g., "Room 1, Desk 5"
    Specifications TEXT NOT NULL -- e.g., "Intel i7, 16GB RAM, GTX 1080"
);

-- Create Sessions Table
CREATE TABLE Sessions (
    SessionID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT NOT NULL,
    ComputerID INT NOT NULL,
    StartTime DATETIME NOT NULL,
    EndTime DATETIME,
    TotalTime DECIMAL(5, 2) NOT NULL, -- in hours
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    FOREIGN KEY (ComputerID) REFERENCES Computers(ComputerID)
);

-- Create Payments Table
CREATE TABLE Payments (
    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    PaymentDate DATETIME NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

-- Create Users Table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE Users ADD COLUMN create_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP;