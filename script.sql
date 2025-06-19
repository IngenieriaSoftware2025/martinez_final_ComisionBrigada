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

INSERT INTO amb_usuarios (us_id,us_nombres,us_apellidos,us_telefono,us_direccion,us_dpi,us_correo,us_contrasenia,us_confirmar_contra,us_token,us_fecha_creacion,us_fecha_contrasenia,us_foto,us_situacion) VALUES(1,'Adrian','Martinez Barrientos',33001331,'1 Calle 1-43','3151291821501','adrian@mail.com','$2y$10$Nbz5pPJia03Fz/kuH9CBB.tCM.t2tioCdm22YYncrhWI/A13nk2mm','','58905322b8a1fee9617fb759c15bea790a72f98be58a9951d49cc7b6f02e6129','2025-06-18 18:05:00.0','2025-06-18 18:05:00.0','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'
,'1')
GO
INSERT INTO amb_usuarios (us_id,us_nombres,us_apellidos,us_telefono,us_direccion,us_dpi,us_correo,us_contrasenia,us_confirmar_contra,us_token,us_fecha_creacion,us_fecha_contrasenia,us_foto,us_situacion) VALUES(2,'Andrea','Mejia Mejia',51173468,'guatemala','3151291820101','andrea@mail.com','$2y$10$y8end9myDojAj2zFrkDN7uwQQNevO.WZqfk8/utHM7V/W8max1Kva','','371c485bf52141fd8d81fdead0ebd5fdbc204fbabc874b2cae65becbc3d6def3','2025-06-18 19:08:00.0','2025-06-18 19:08:00.0','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'
,'1')
GO
INSERT INTO amb_usuarios (us_id,us_nombres,us_apellidos,us_telefono,us_direccion,us_dpi,us_correo,us_contrasenia,us_confirmar_contra,us_token,us_fecha_creacion,us_fecha_contrasenia,us_foto,us_situacion) VALUES(3,'Angela','Mazariegos',47876578,'salama','3050678450101','angela@mail.com','$2y$10$IVqpQfXSDqMGqm9BtEwImuZuk/x6YAsmqBMzy3Qosr9djS.VjpJtC','','78bf2afc75d6288065fd86c3a861452d06a142256d5c20999e82d9aa5ce05fc6','2025-06-18 19:10:00.0','2025-06-18 19:10:00.0','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'
,'1')



create table amb_aplicacion(
    ap_id serial primary key,
    ap_nombre_lg varchar(150),
    ap_nombre_md varchar(100),
    ap_nombre_ct varchar(50),
    ap_fecha_creacion datetime year to minute default current year to minute,
    ap_situacion char(1)
);

INSERT INTO amb_aplicacion (ap_id,ap_nombre_lg,ap_nombre_md,ap_nombre_ct,ap_fecha_creacion,ap_situacion) VALUES(1,'Comisiones Brigada De Comunicaciones','Comisones Brigada','Comisiones','2025-06-18 19:10:00.0','1')



create table amb_permisos(
    per_id serial primary key,
    per_aplicacion integer,
    per_nombre_permiso varchar(250),
    per_clave_permiso varchar(250),
    per_descripcion varchar(250),
    per_fecha datetime year to minute default current year to minute,
    per_situacion char(1),
    foreign key(per_aplicacion) references amb_aplicacion(ap_id) constraint fk_pedr_ap
);

INSERT INTO amb_permisos (per_id,per_aplicacion,per_nombre_permiso,per_clave_permiso,per_descripcion,per_fecha,per_situacion) VALUES(1,1,'Administrador','ADMIN','Puede hacer de todo','2025-06-18 19:10:00.0','1')
GO
INSERT INTO amb_permisos (per_id,per_aplicacion,per_nombre_permiso,per_clave_permiso,per_descripcion,per_fecha,per_situacion) VALUES(2,1,'Especialista Personal','PER','Inserta solo personal','2025-06-18 19:11:00.0','1')
GO
INSERT INTO amb_permisos (per_id,per_aplicacion,per_nombre_permiso,per_clave_permiso,per_descripcion,per_fecha,per_situacion) VALUES(3,1,'Especialista Batallon','BAT','Registra las comisiones','2025-06-18 19:12:00.0','1')



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
    foreign key(asig_usuario) references amb_usuarios(us_id) constraint fk_asidg_us,
    foreign key(asig_aplicacion) references amb_aplicacion(ap_id) constraint fk_asidg_ap,
    foreign key(asig_permisos) references amb_permisos(per_id) constraint fk_asdig_per
);

INSERT INTO amb_asig_permisos (asig_id,asig_usuario,asig_aplicacion,asig_permisos,asig_fecha,asig_quitar_fechapermiso,asig_usuario_asignador,asig_motivo,asig_situacion) VALUES(1,1,1,1,'2025-06-18 19:13:00.0',null,1,'Tiene permisos para administrar toda la app','1')
GO
INSERT INTO amb_asig_permisos (asig_id,asig_usuario,asig_aplicacion,asig_permisos,asig_fecha,asig_quitar_fechapermiso,asig_usuario_asignador,asig_motivo,asig_situacion) VALUES(2,2,1,2,'2025-06-18 19:14:00.0',null,1,'Tiene permisos para insertar datos de personal','1')
GO
INSERT INTO amb_asig_permisos (asig_id,asig_usuario,asig_aplicacion,asig_permisos,asig_fecha,asig_quitar_fechapermiso,asig_usuario_asignador,asig_motivo,asig_situacion) VALUES(3,3,1,3,'2025-06-18 19:15:00.0',null,1,'Registrara datos de comisiones','1')




create table amb_personal(
    perso_id serial primary key,
    perso_grado varchar(50) not null,
    perso_nombre varchar(50) not null,
    perso_apellidos varchar(50) not null,
    perso_unidad varchar(100),
    perso_situacion char(1)
);

INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(1,'Subteniente','Leonel','Torres Lopez','Informatica','1')
GO
INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(2,'Subteniente','Mauricio','Lainez Chavez','Informatica','1')
GO
INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(3,'Teniente','Abraham','Leopoldo Soc','Transmisiones','1')
GO
INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(4,'Teniente','Oracio','Mendizabal Tut','Transmisiones','1')
GO
INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(5,'Capitan Segundo','Francisco','Marroquin Gomez','Informatica','1')
GO
INSERT INTO amb_personal (perso_id,perso_grado,perso_nombre,perso_apellidos,perso_unidad,perso_situacion) VALUES(6,'Capitan Primero','Lisandro','Turcios Samayoa','Transmisiones','1')




create table amb_comisiones(
    com_id serial primary key,
    com_usuario integer,
    com_destino varchar(250),
    com_descripcion varchar(250),
    com_fech_inicio datetime year to minute,
    com_fech_fin datetime year to minute,
    com_situacion char(1),
    foreign key (com_usuario) references amb_personal(perso_id) constraint fk_comd_per
);


INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(1,1,'Ministerio De La Defensa Nacional','Reunion con el ministro de la defensa nacional','2025-06-18 19:41:00.0','2025-06-19 00:39:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(2,2,'Adolfo Hall','Mantenimiento de radios','2025-06-19 19:39:00.0','2025-06-20 19:39:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(3,3,'Priemra Brigada Peten','Mantenimiento de equipos','2025-06-18 19:41:00.0','2025-06-21 19:40:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(4,4,'Zacapa','Reunion con comandante','2025-06-19 19:40:00.0','2025-06-19 23:40:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(5,5,'Estado Mayor','Reunion de coordinacion','2025-06-21 19:41:00.0','2025-06-22 19:41:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(6,6,'Ministerio De La Defensa Nacional','Reunion puerta 5','2025-06-21 19:41:00.0','2025-06-24 19:41:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(7,2,'Ministerio De La Defensa Nacional','Reunion viceministerio','2025-06-21 08:42:00.0','2025-06-25 19:42:00.0','1')
GO
INSERT INTO amb_comisiones (com_id,com_usuario,com_destino,com_descripcion,com_fech_inicio,com_fech_fin,com_situacion) VALUES(8,4,'Primera Brigada  Peten','Visita antenas','2025-06-20 19:44:00.0','2025-06-24 19:44:00.0','1')

