create database locadora;
use locadora;

create table filmes(

id int primary key auto_increment,
titulo varchar(100) not null unique,
ano year not null,
duracao float not null,
preco_locacao float 
);


create table clientes(
id int primary key auto_increment,
nome varchar(50) not null,
cpf char(14)
);

create table locacoes(
id int primary key auto_increment,
id_cliente int references clientes(id),
id_filme int   references filmes(id),
data_locacao date,
data_devolucao date
);