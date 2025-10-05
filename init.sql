CREATE DATABASE IF NOT EXISTS excel1;
USE excel1;

CREATE TABLE IF NOT EXISTS personnels (
    id VARCHAR(255) PRIMARY KEY,
    type VARCHAR(50),
    nom VARCHAR(255),
    profession VARCHAR(255),
    heurs DECIMAL(10,2),
    taux DECIMAL(10,2),
    total DECIMAL(10,2),
    projet VARCHAR(255),
    category VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS facture (
    id INT PRIMARY KEY,
    numero VARCHAR(50),
    dj DATE,
    fj DATE,
    m DATE,
    adresse TEXT,
    societe VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS projet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);
