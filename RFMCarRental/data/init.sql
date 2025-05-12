CREATE DATABASE IF NOT EXISTS RFMCarRental;
USE RFMCarRental;


DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS users;


CREATE TABLE users (
                       userID INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       phoneNumber VARCHAR(20),
                       isAdmin TINYINT(1) NOT NULL DEFAULT 0,
                       reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE cars (
                      carID INT AUTO_INCREMENT PRIMARY KEY,
                      make VARCHAR(50) NOT NULL,
                      model VARCHAR(50) NOT NULL,
                      year INT NOT NULL,
                      rentalPrice DECIMAL(10,2) NOT NULL,
                      availabilityStatus TINYINT(1) DEFAULT 1,
                      regNumber VARCHAR(50),
                      image VARCHAR(255),
                      description VARCHAR(1000),
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE bookings (
                          bookingID INT AUTO_INCREMENT PRIMARY KEY,
                          userID INT NOT NULL,
                          carID INT NOT NULL,
                          startDate DATE NOT NULL,
                          endDate DATE NOT NULL,
                          location VARCHAR(100) NOT NULL,
                          totalCost DECIMAL(10,2) NOT NULL,
                          status VARCHAR(20) DEFAULT 'Confirmed',
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
                          FOREIGN KEY (carID) REFERENCES cars(carID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE contacts (
                          messageID INT AUTO_INCREMENT PRIMARY KEY,
                          userID INT,
                          name VARCHAR(100) NOT NULL,
                          email VARCHAR(100) NOT NULL,
                          message TEXT NOT NULL,
                          adminReply TEXT DEFAULT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE payments (
                          paymentID INT AUTO_INCREMENT PRIMARY KEY,
                          bookingID INT NOT NULL,
                          userID INT NOT NULL,
                          amount DECIMAL(10,2) NOT NULL,
                          paymentStatus ENUM('Pending','Completed','Refunded') DEFAULT 'Pending',
                          paymentDate DATETIME DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (bookingID) REFERENCES bookings(bookingID) ON DELETE CASCADE,
                          FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE messages (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          userID INT NOT NULL,
                          name VARCHAR(100) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          message TEXT NOT NULL,
                          reply TEXT DEFAULT NULL,
                          reply_at TIMESTAMP NULL DEFAULT NULL,
                          replied_by INT DEFAULT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
                          FOREIGN KEY (replied_by) REFERENCES users(userID) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`userID`, `name`, `email`, `password`, `phoneNumber`, `isAdmin`, `reg_date`) VALUES
                                                                                                      (4, 'RFMAdmin', 'RFMAdmin@tudublin.ie', '$2y$10$9Y/V6hLrz9R6H3ShiElNNunsRf.Krl/NK2lSB3sDpekKYkoiP9Ce.', '1234567890', 1, '2025-04-22 10:16:22'),
                                                                                                      (15, 'test123', 'test123@gmail.com', '$2y$10$HGa/eZCfdTeXNIzBT9PAjuu66WsoPLxBpZSQg3Lk5q2ppOomW5b32', '0833333333', 0, '2025-04-22 10:21:38'),
                                                                                                      (16, 'test1234', 'test1234@gmail.com', '$2y$10$3KvH.aIZT8rFMYFI1GekF.t5nGifHJN4kDNuWQGHQs2c5oHusNxZa', '0833333333', 0, '2025-04-23 21:59:20'),
                                                                                                      (19, 'test2', 'test12345@gmail.com', '$2y$10$vvcYEMrM.ctsdCrtvxbtH.5SiHc5p04zLjV6odVG7ZG35l661otP.', '0839999999', 0, '2025-04-26 13:11:16'),
                                                                                                      (21, 'Cowwww', 'cowsep123@gmail.com', '$2y$10$ZbC8UcYnkNQtiTTXcgCDruAdGT5kHMGTQg5CpA1j.OGjH54OG8JKO', '0833333333', 0, '2025-04-26 13:16:04'),
                                                                                                      (22, 'tets3', 'testing123@gmail.com', '$2y$10$eGu1pYEhB2.Ndn.XVo57mO5j.28aYDRYlhfABu/PcsDgjTmBP0h6m', '0877777777', 0, '2025-04-26 19:54:40'),
                                                                                                      (24, 'testing12345', 'testing12345@gmail.com', '$2y$10$xFZjNUJySfND0XK6P3JRg.flAXnP99LYqIGXq0LKc8/4HDNt2j9NS', '0844444444', 0, '2025-04-26 20:00:23'),
                                                                                                      (25, 'gabriela', 'gabitest123@gmail.com', '$2y$10$iAycmg2g8RHedErvyfOjQeZ5WCcceKsbVV50KEnJ8C2FYCWa/wTWS', '0899999999', 0, '2025-04-26 20:13:14');


INSERT INTO cars (make, model, year, rentalPrice, description, availabilityStatus, image) VALUES
                                                                                              ('Ford', 'Raptor', 2021, 79.99, 'Powerful pickup built for performance and rugged roads.', 0, 'FordRaptor.jpeg'),
                                                                                              ('Mercedes-Benz', 'C63', 2022, 145.00, 'High-performance German luxury with aggressive design.', 0, 'MercedesC63.jpg'),
                                                                                              ('Peugeot', '308', 2023, 59.99, 'Efficient and stylish French hatchback for daily use.', 0, 'Peugeot308.jpg'),
                                                                                              ('Honda', 'Civic', 2020, 83.00, 'Reliable and sporty sedan popular worldwide.', 0, 'HondaCivic.png'),
                                                                                              ('Porsche', 'Cayenne', 2021, 112.00, 'Luxury SUV blending performance and practicality.', 1, 'PorscheCayenne.jpg'),
                                                                                              ('Tesla', 'Model S', 2022, 160.00, 'Premium all-electric sedan with impressive range.', 0, 'TeslaS.jpg'),
                                                                                              ('BMW', 'X5', 2022, 129.00, 'Spacious luxury SUV with strong road presence.', 1, 'BMWX5.png'),
                                                                                              ('Audi', 'A7', 2021, 138.50, 'Elegant sportback combining power and design.', 0, 'AudiA7.jpeg'),
                                                                                              ('BMW', '3 Series', 2020, 105.00, 'Balanced compact sedan with dynamic handling.', 0, 'BMW3Series.jpg'),
                                                                                              ('Toyota', 'Corolla', 2019, 62.00, 'Economical and dependable everyday vehicle.', 1, 'ToyotaCorolla.png'),
                                                                                              ('Tesla', 'Model 3', 2023, 139.99, 'Affordable electric vehicle with cutting-edge tech.', 0, 'TeslaModel3.png'),
                                                                                              ('Renault', 'Clio', 2020, 49.00, 'Compact city car with modern flair and features.', 0, 'RenaultClio.jpg');
