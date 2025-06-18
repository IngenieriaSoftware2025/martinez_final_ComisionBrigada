create table amb_usuarios(
    us_id serial primary key,
    us_nombres varchar(100),
    us_apellidos varchar(100),
    us_telefono integer,
    us_direccion varchar(250),
    us_dpi varchar(13),
    us_correo varchar(100),
    us_contrasenia lvarchar(1056),
    us_confirmar_contra lvarchar(1056),
    us_token lvarchar,
    us_fecha_creacion datetime year to minute default current year to minute,
    us_fecha_contrasenia datetime year to minute default current year to minute,
    us_foto lvarchar(2056),
    us_situacion char(1)
);

create table amb_aplicacion(
    ap_id serial primary key,
    ap_nombre_lg varchar(150),
    ap_nombre_md varchar(100),
    ap_nombre_ct varchar(50),
    ap_fecha_creacion datetime year to minute default current year to minute,
    ap_situacion char(1)
);



create table amb_permisos(
    per_id serial primary key,
    per_aplicacion integer,
    per_nombre_permiso varchar(250),
    per_clave_permiso varchar(250),
    per_descripcion varchar(250),
    per_fecha datetime year to minute default current year to minute,
    per_situacion char(1),
    foreign key(per_aplicacion) references amb_aplicacion(ap_id) constraint fk_per_ap
);


create table amb_asig_permisos(
    asig_id serial primary key,
    asig_usuario integer not null,
    asig_aplicacion integer not null,
    asig_permisos integer not null,
    asig_fecha datetime year to minute default current year to minute,
    asig_quitar_fechaPermiso datetime year to minute default current year to minute,
    asig_usuario_asignador integer not null,
    asig_motivo varchar(250),
    asig_situacion char(1),
    foreign key(asig_usuario) references amb_usuarios(us_id) constraint fk_asig_us,
    foreign key(asig_aplicacion) references amb_aplicacion(ap_id) constraint fk_asig_ap,
    foreign key(asig_permisos) references amb_permisos(per_id) constraint fk_asig_per
);
