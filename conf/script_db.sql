/*
Script para criar o banco de dados e as tabelas necessárias para o sistema.
Só copiar e colar no phpmyadmin.
 */
CREATE DATABASE db_pagamento;

USE db_pagamento;

CREATE TABLE
    produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        produto VARCHAR(100) NOT NULL UNIQUE,
        quantidade INT NOT NULL,
        preco DECIMAL(10, 2) NOT NULL
    );

CREATE TABLE
    usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(100) NOT NULL,
        data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    transacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        data DATETIME DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10, 2) NOT NULL,
        metodo_pagamento VARCHAR(50) NOT NULL,
        id_usuario INT,
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
    );

CREATE TABLE
    itens_transacao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_transacao INT,
        id_produto INT,
        preco_unitario DECIMAL(10, 2),
        FOREIGN KEY (id_transacao) REFERENCES transacoes (id)
    );

INSERT INTO
    produtos (produto, quantidade, preco)
VALUES
    ('Paracetamol 500mg', 100, 5.99),
    ('Dipirona Gotas 20ml', 80, 7.50),
    ('Vitamina C 1g', 60, 12.00),
    ('Álcool 70% 500ml', 40, 9.90),
    ('Esparadrapo 10cm x 4,5m', 20, 4.50),
    ('Amoxilina 500mg', 90, 15.00),
    ('Maconal 15mg', 85, 8.50),
    ('Loratadina 10mg', 75, 6.30),
    ('Ranitidina 150mg', 70, 10.40),
    ('Bepantol Derma', 65, 28.00),
    ('Omeprazol 20mg', 95, 13.50),
    ('Cataflam 50mg', 50, 11.00),
    ('Gelol 30g', 60, 6.90),
    ('Glicose 500ml', 55, 4.90),
    ('Neosoro 10ml', 60, 8.00),
    ('Benegripe 12 comprimidos', 40, 11.90),
    ('Rimax 5mg', 35, 6.00),
    ('Soro Fisiológico 500ml', 50, 3.00),
    ('Dolex 400mg', 45, 9.20),
    ('Cloridrato de Dipirona 1g', 70, 7.80),
    ('Dextrometorfano 20mg', 30, 12.50),
    ('Cicloconazol 150mg', 25, 22.00),
    ('Mastodynon 30ml', 55, 30.00),
    ('Naldecon 30mg', 60, 14.50),
    ('Lactopurga 30mg', 40, 6.40),
    ('Lasix 40mg', 85, 7.60),
    ('Paroxetina 20mg', 50, 18.90),
    ('Ciproflaxacino 500mg', 60, 10.00),
    ('Xarope Pediátrico 120ml', 40, 15.80),
    ('Tão Laranja 10mg', 45, 5.90),
    ('Pasta de Dente Sensodyne', 70, 8.50),
    ('Thermacare', 80, 25.00),
    ('Polaramine 4mg', 50, 7.20),
    ('Leite de Magnésia 200ml', 60, 9.50),
    ('Bromazepam 6mg', 65, 16.00),
    ('Lorazepam 2mg', 70, 19.00),
    ('Fluconazol 150mg', 55, 21.00),
    ('Diprogenta 15g', 45, 28.00),
    ('Biotônico Fontoura 250ml', 75, 12.00),
    ('Erythromycin 500mg', 60, 17.50),
    ('Vicks Vaporub 50g', 50, 18.30),
    ('Benzetacil 1.200.000U', 35, 36.00),
    ('Advil 400mg', 40, 10.90),
    ('Betadine Solução 120ml', 60, 18.00),
    ('Decongex 30 cápsulas', 50, 13.80),
    ('Loratadina Xarope 120ml', 45, 10.00),
    ('Salmeterol 50mcg', 60, 30.00),
    ('Dorflex 30 comprimidos', 80, 15.00),
    ('Cleocina 300mg', 70, 22.00),
    ('Antigripal Granulado', 90, 10.00),
    ('Aspirina 500mg', 60, 5.50),
    ('Fluimucil 600mg', 45, 23.00),
    ('Tilosina 250mg', 35, 12.00),
    ('Melox 7,5mg', 40, 14.50),
    ('Rivotril 2mg', 50, 25.00),
    ('Melatonina 3mg', 60, 19.90);