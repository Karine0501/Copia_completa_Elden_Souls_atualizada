CREATE DATABASE EldenSouls CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE EldenSouls;

CREATE TABLE Admin (
cod_adm int PRIMARY KEY AUTO_INCREMENT,
nome varchar(40) NOT NULL,
login varchar(40) NOT NULL UNIQUE,
senha varchar(70) NOT NULL
);

CREATE TABLE Cliente (
cod_cli int PRIMARY KEY AUTO_INCREMENT,
nome varchar(60) NOT NULL,
cpf char(14) NOT NULL UNIQUE,
endereco varchar(70) NOT NULL,
telefone varchar(20) NOT NULL,
login varchar(40) NOT NULL UNIQUE,
senha varchar(70) NOT NULL

);

CREATE TABLE Jogo (
cod_jogo int PRIMARY KEY AUTO_INCREMENT,
nome varchar(70) NOT NULL,
console varchar(20) NOT NULL,
genero varchar(20) NOT NULL,
desenvolvedora varchar(50) NOT NULL,
estado varchar(20) NOT NULL,
quantidade int NOT NULL DEFAULT 0,
v_compra decimal(6,2) NOT NULL,
v_venda decimal(6,2) NOT NULL,
descricao text NOT NULL,
foto blob NOT NULL
);

CREATE TABLE Livro (
cod_liv int PRIMARY KEY AUTO_INCREMENT,
titulo varchar(70) NOT NULL,
autor varchar(30) NOT NULL,
genero varchar(20) NOT NULL,
editora varchar(30) NOT NULL,
data_publi date NOT NULL,
estado varchar(20) NOT NULL,
quantidade int NOT NULL DEFAULT 0,
v_compra decimal(6,2) NOT NULL,
v_venda decimal(6,2) NOT NULL,
descricao text NOT NULL,
foto blob NOT NULL
);

CREATE TABLE Musica (
cod_mu int PRIMARY KEY AUTO_INCREMENT,
titulo varchar(70) NOT NULL,
artista varchar(50) NOT NULL,
genero varchar(70) NOT NULL,
formato varchar(20) NOT NULL,
estado varchar(20) NOT NULL,
quantidade int NOT NULL DEFAULT 0,
v_compra decimal(6,2) NOT NULL,
v_venda decimal(6,2) NOT NULL,
foto blob NOT NULL
);

CREATE TABLE Pedido (
cod_ped int PRIMARY KEY AUTO_INCREMENT,
cod_cli int NOT NULL,
data_ped date NOT NULL,
total decimal(10,2) NOT NULL,
status ENUM('ABERTO','FECHADO','CANCELADO') NOT NULL DEFAULT 'ABERTO'
);

CREATE TABLE Itens (
cod_item int PRIMARY KEY AUTO_INCREMENT,
cod_ped int NOT NULL,
cod_produto int NOT NULL,
quantidade int NOT NULL,
tipo varchar(15) NOT NULL,
valor decimal(10,2) NOT NULL
);


ALTER TABLE Itens ADD FOREIGN KEY(cod_ped) REFERENCES Pedido (cod_ped);
ALTER TABLE Pedido ADD FOREIGN KEY(cod_cli) REFERENCES Cliente (cod_cli);


INSERT INTO admin (nome, login, senha) VALUES('Alucard Vlad Tepes','admin','$2y$10$v8x.wuqz.mnu0mBlRPdmb.C3VtATz1aTmPzXIzBxK9rHxu8v1SNti');

