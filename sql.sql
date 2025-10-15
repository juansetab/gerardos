create table c_instructores(
    id int(11) not null primary key auto_increment,
    nombre varchar(80) not null,
    status int(1) not null default 1,
    creacion timestamp default current_timestamp
);

create table constancias(
    id int(11) not null primary key auto_increment,
    id_instructor int(11) not null,
    folio varchar(25) not null,
    nombre_alumno varchar(80) not null,
    fecha_inicio date not null,
    fecha_final date not null,
    fecha date not null,
    qr varchar(25) not null,
    status int(1) not null default 1,
    creacion timestamp default current_timestamp,
    foreign key (id_instructor) references c_instructores(id)
);

create or replace view v_constancias as
select
c.id,
i.nombre id_instructor,
c.folio,
c.nombre_alumno,
c.fecha_inicio,
c.fecha_final,
c.fecha,
c.qr,
c.status,
c.creacion
from constancias c
left join c_instructores i on i.id = c.id_instructor;
