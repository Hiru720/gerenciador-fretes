-- Banco de dados do Gerenciador de Fretes
CREATE DATABASE IF NOT EXISTS fretes_db CHARACTER SET utf8mb4;
USE fretes_db;

CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  peso DECIMAL(10,2),
  valor DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS enderecos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  rua VARCHAR(150) NOT NULL,
  numero VARCHAR(10),
  bairro VARCHAR(80),
  cidade VARCHAR(80) NOT NULL,
  estado CHAR(2) NOT NULL,
  cep VARCHAR(9)
);

CREATE TABLE IF NOT EXISTS transportadores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  cnpj VARCHAR(18),
  telefone VARCHAR(15),
  placa VARCHAR(8)
);

CREATE TABLE IF NOT EXISTS fretes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transportador_id INT NOT NULL,
  origem_id INT NOT NULL,
  destino_id INT NOT NULL,
  data_frete DATE NOT NULL,
  FOREIGN KEY (transportador_id) REFERENCES transportadores(id),
  FOREIGN KEY (origem_id) REFERENCES enderecos(id),
  FOREIGN KEY (destino_id) REFERENCES enderecos(id)
);

CREATE TABLE IF NOT EXISTS frete_produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  frete_id INT NOT NULL,
  produto_id INT NOT NULL,
  quantidade INT DEFAULT 1,
  FOREIGN KEY (frete_id) REFERENCES fretes(id),
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
