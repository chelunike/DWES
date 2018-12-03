

create database project default character set utf8 collate utf8_general_ci; 

create user

grant all on project.* to usuariobd@'%';

flush privileges;

create table usuario (
    id bigint auto_increment primary key,
    correo varchar(255) not null unique,
    alias varchar(255) not null unique,
    nombre varchar(255) not null,
    clave varchar(255) not null,
    activo boolean not null default 0,
    fechaalta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    administrador boolean not null default 0
) engine = innodb
  character set utf8
  collate utf8_general_ci;

-- Primer usuario

insert into usuario values(null, 'patata@mail.com', 'patata', 'patata', '$2y$10$OfX73HR40yu0VPXl1szhOuhQHzIidiOmjjJW3TtmQ2uJWyJN1OCt6', 1, 1, null);