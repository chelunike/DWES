create database simple
  default character set utf8
  collate utf8_general_ci;
  
create user 'phepy'@'%'
  identified by 'pepa';

create database project;

grant all
  on porject.*
  to phepy@'%';

flush privileges;

use project;

create table usuario (
    id bigint not null auto_increment primary key,
    correo varchar(60) not null unique,
    clave varchar(255) not null
) engine = innodb
  character set utf8
  collate utf8_general_ci;