/* Database  */

create database nombrebd
  default character set utf8
  collate utf8_general_ci; 

create user usuariobd@localhost
  identified by 'clavebd';

grant all
  on nombrebd.*
  to usuariobd@localhost;

flush privileges;

/* Table Usuario */

create table usuario (
    id bigint auto_increment primary key,
    correo varchar(255) not null unique,
    alias varchar(255) not null unique,
    nombre varchar(255) not null,
    clave varchar(255) not null,
    activo boolean not null,
    fechaalta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) engine = innodb
  character set utf8
  collate utf8_general_ci;

insert into usuario values (null, :correo, :alias, :nombre, :clave, :activo, null);

update producto set correo = :correo, alias = :alias, nombre = :nombre, clave = :clave, activo = :activo where id = :id;

delete from usuario where id = :id;

select * from producto where id = :id;

select * from producto;