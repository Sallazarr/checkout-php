/*
Cria o banco de dados
*/
CREATE DATABASE db_pagamento;

USE db_pagamento;

/*
Tabela de produtos - atualizada com descricao e imagem_path
*/
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL UNIQUE,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL,
    imagem_path VARCHAR(255),
    descricao TEXT
);

/*
Tabela de usuários
*/
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

/*
Tabela de transações
*/
CREATE TABLE transacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    metodo_pagamento VARCHAR(50) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

/*
Itens que fazem parte de cada transação
*/
CREATE TABLE itens_transacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_transacao INT,
    id_produto INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (id_transacao) REFERENCES transacoes(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);
