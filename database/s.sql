DROP DATABASE IF EXISTS streamhub;

CREATE DATABASE streamhub;

USE streamhub;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    gebruikernaam VARCHAR(255) NOT NULL,
    wachtwoord VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    subscribsie VARCHAR(255) NOT NULL,
    eind_date DATE NOT NULL
);