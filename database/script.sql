
create database gestordocumentos;

use gestordocumentos;

create table sexo(
    id int not null auto_increment primary key,
    nombre varchar(20) not null
);

insert into sexo(nombre) values('Masculino');
insert into sexo(nombre) values('Femenino');

create table estadocivil(
    id int not null auto_increment primary key,
    nombre varchar(20) not null
);

insert into estadocivil(nombre) values('Soltero');
insert into estadocivil(nombre) values('Casado');
insert into estadocivil(nombre) values('Divorciado');
insert into estadocivil(nombre) values('Viudo');

create table pension(
    id int not null auto_increment primary key,
    nombre varchar(20) not null
);

insert into pension (nombre) values('Si');
insert into pension (nombre) values('No');

create table discapacidad(
    id int not null auto_increment primary key,
    nombre varchar(20) not null
);

insert into discapacidad(nombre) values('Si');
insert into discapacidad(nombre) values('No');


create table regiones (
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null, 
    nombre varchar(200) not null
);

create table provincias(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(200) not null,
    region int not null references regiones(id)
);

create table comunas(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    region int not null references regiones(id),
    provincia int not null references provincias(id)
);


create table ciudades (
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    region int not null references regiones(id)
);

create table nacionalidad (
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table afp(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    tasa decimal(10,2) not null
);

create table tiposueldo(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table tipoisapre(
    id int not null auto_increment primary key,
    nombre varchar(50) not null
);

insert into tipoisapre(nombre) values('Fonasa');
insert into tipoisapre(nombre) values('Isapre');

create table isapre(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    tipo int not null references tipoisapre(id)
);


create table cajascompensacion(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table mutuales(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table tipocontrato(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table jornadas(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    termino int not null,
    entidad int not null
);

create table tramosasignacionfamiliar(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table causalterminocontrato(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);


create table empresa(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    razonsocial varchar(200) not null,
    calle varchar(200) not null,
    villa varchar(200) null,
    numero varchar(20) not null,
    dept varchar(200) null,
    region int not null references regiones(id),
    comuna int not null references comunas(id),
    ciudad int not null references ciudades(id),
    telefono varchar(20) not null,
    email varchar(200) not null,
    giro varchar(200) not null,
    cajascompensacion int not null references cajascompensacion(id),
    mutuales int not null references mutuales(id),
    cotizacionbasica decimal(10,2) not null,
    cotizacionleysanna decimal(10,2) not null,
    cotizacionadicional decimal(10,2) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp
);

create table tipodocumento(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null
);

create table escritoempresa(
    id int not null auto_increment primary key,
    tipodocumento int not null references tipodocumento(id),
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);


create table plantillas(
    id int not null auto_increment primary key,
    tipodocumento int not null references tipodocumento(id),
    contenido text not null,
    register_at timestamp not null default current_timestamp
);


create table plan(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into plan(nombre) values('Plan Normal');
insert into plan(nombre) values('Plan Pro');

create table planempresa(
    id int not null auto_increment primary key,
    plan int not null references plan(id),
    empresa int not null references empresa(id),
    created_at timestamp not null default current_timestamp
);

create table cargos(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    empresa int not null references empresa(id)
);

create table codigoactividad(
    id int not null auto_increment primary key,
    codigosii int not null,
    nombre varchar(200) not null
);

create table status(
    id int not null auto_increment primary key,
    nombre varchar(50) not null
);

insert into status(nombre) values('Activo');
insert into status(nombre) values('Inactivo');

create table tipousuario(
    id int not null auto_increment primary key,
    nombre varchar(50) not null
);

insert into tipousuario(nombre) values('Administrador');
insert into tipousuario(nombre) values('Contratista');
insert into tipousuario(nombre) values('Mandante');

-- Modificar tabla users para agregar nuevos campos
ALTER TABLE users 
ADD COLUMN nacionalidad int not null default 0,
ADD COLUMN estado_civil int not null default 0,
ADD COLUMN profesion varchar(200) null,
ADD FOREIGN KEY (nacionalidad) REFERENCES nacionalidad(id),
ADD FOREIGN KEY (estado_civil) REFERENCES estadocivil(id);

-- Script para verificar la estructura actualizada
DESCRIBE users;


create table users (
    id_usu int not null auto_increment primary key,
    rut varchar(20) not null,
    nombre varchar(200) not null,
    apellidos varchar(200) not null,
    email varchar(200) not null,
    direccion varchar(200) not null,
    region int not null references regiones(id),
    comuna int not null references comunas(id),
    telefono varchar(20) not null,
    password varchar(64) not null,
    estado int not null references status(id),
    token varchar(200) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp
);


create table sesionusuario (
    id int not null auto_increment primary key,
    id_usu int not null references users(id_usu),
    token varchar(200) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp
);

create table permisos(
    id int not null auto_increment primary key,
    nombre varchar(50) not null,
    descripcion varchar(200) not null
);

insert into permisos(nombre,descripcion) values('Gestión','Permite Gestion las definiciones de sistema');
insert into permisos(nombre,descripcion) values('Lectura','Permite leer los datos');
insert into permisos(nombre,descripcion) values('Escritura','Permite escribir los datos');
insert into permisos(nombre,descripcion) values('Actualizacion','Permite actualizar los datos');
insert into permisos(nombre,descripcion) values('Eliminacion','Permite eliminar los datos');

create table permisosusers(
    id int not null auto_increment primary key,
    idusuario int not null references users(id_usu),
    idpermiso int not null references permisos(id)
);



create table representantelegal(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    nombre varchar(200) not null,
    primerapellido varchar(200) not null,
    segundoapellido varchar(200) not null,
    empresa int not null references empresa(id)
);

create table nubcodigoactividad(
    id int not null auto_increment primary key,
    codigo int not null references codigoactividad(id),
    empresa int not null references empresa(id)
);

create table centrocosto(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(50) not null,
    empresa int not null references empresa(id)
);

create table subcentrocosto(
    id int not null auto_increment primary key,
    nombre varchar(200) not null,
    centrocosto int not null references centrocosto(id)
);


create table AuditoriaEventos(
    id int not null auto_increment primary key,
    idusuario int not null references users(id_usu),
    evento varchar(200) not null,
    fecha timestamp not null default current_timestamp
);


create table tasaafp(
    id int not null auto_increment primary key,
    afp int not null references afp(id),
    fecha date not null,
    tasa decimal(10,2) not null
);
-- ALTER TABLE tasaafp CHANGE COLUMN tasasis capitalizacion_individual DECIMAL(20,2) NOT NULL DEFAULT 0;

alter table tasaafp add capitalizacion_individual decimal(20,2) not null default 0 after fecha;


create table segurosocial_expectativadevida(
    id int not null auto_increment primary key,
    codigo varchar(20),
    codigoprevired varchar(20),
    fecha date not null,
    tasa decimal(20,2)
);

create table segurosocial_rentabilidadprotegida(
    id int not null auto_increment primary key,
    codigo varchar(20),
    codigoprevired varchar(20),
    fecha date not null,
    tasa decimal(20,2)
);

create table segurosocial_sis(
    id int not null auto_increment primary key,
    codigo varchar(20),
    codigoprevired varchar(20),
    fecha date not null,
    tasa decimal(20,2) not null
);

-- Agregar campos codigo y codigoprevired a tablas existentes (si ya fueron creadas)
-- Ejecutar solo si las tablas ya existen sin estos campos
-- ALTER TABLE segurosocial_expectativadevida ADD COLUMN codigo varchar(20) AFTER id;
-- ALTER TABLE segurosocial_expectativadevida ADD COLUMN codigoprevired varchar(20) AFTER codigo;

-- ALTER TABLE segurosocial_rentabilidadprotegida ADD COLUMN codigo varchar(20) AFTER id;
-- ALTER TABLE segurosocial_rentabilidadprotegida ADD COLUMN codigoprevired varchar(20) AFTER codigo;

-- ALTER TABLE segurosocial_sis ADD COLUMN codigo varchar(20) AFTER id;
-- ALTER TABLE segurosocial_sis ADD COLUMN codigoprevired varchar(20) AFTER codigo;



create table tasamutual(
    id int not null auto_increment primary key,
    fecha date not null,
    tasabasica decimal(10,2) not null,
    tasaleysanna decimal(10,2) not null
);

create table tasacaja(
    id int not null auto_increment primary key,
    fecha date not null,
    tasa decimal(10,2) not null
);

create table usuarioempresa(
    id int not null auto_increment primary key,
    usuario int not null references users(id_usu),
    empresa int not null references empresa(id),
    estado int not null 
);

create table jubilado(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into jubilado values(1, 'Si');
insert into jubilado values(2, 'No');

create table cesantia(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into cesantia values(1, 'Si');
insert into cesantia values(2, 'No');

create table accidente(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into accidente values(1, 'Si');
insert into accidente values(2, 'No');

create table tipomoneda(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);


insert into tipomoneda values(1, 'Pesos');
insert into tipomoneda values(2, 'UF');
insert into tipomoneda values(3, 'Porcentaje');


create table tipocausante(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipocausante values(1, 'La o El Conyuge');
insert into tipocausante values(2, 'HIJO E HIJASTRO CON EDAD MENOS O IGUAL A 18 AÑOS');
insert into tipocausante values(3, 'HIJO E HIJASTRO CON EDAD ENTRE 18 Y 24 AÑOS Y QUE ESTUDIA');
insert into tipocausante values(4, 'CARGA MATERNAL');

create table trabajadores(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    dni varchar(20) ,
    nombre varchar(200) not null,
    primerapellido varchar(200) not null,
    segundoapellido varchar(200),
    fechanacimiento date not null,
    sexo int not null references sexo(id),
    estadocivil int not null references estadocivil(id),
    nacionalidad int not null references nacionalidad(id),
    discapacidad int not null references discapacidad(id),
    pension int not null references pension(id),
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);

create table trabajadordomicilio(
    id int not null auto_increment primary key,
    calle varchar(200) not null,
    villa varchar(200) null,
    numero varchar(20) not null,
    depto varchar(20) ,
    region int not null references regiones(id),
    comuna int not null references comunas(id),
    ciudad int not null references ciudades(id),
    trabajador int not null references trabajadores(id),
    register_at timestamp not null default current_timestamp
);

create table trabajadorcontacto(
    id int not null auto_increment primary key,
    telefono varchar(20) not null,
    email varchar(200) not null,
    trabajador int not null references trabajadores(id),
    register_at timestamp not null default current_timestamp
);

create table previsiontrabajador(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    periodo date not null,
    afp int not null references afp(id),
    jubilado int not null references jubilado(id),
    cesantia int not null references cesantia(id),
    accidente int not null references accidente(id),
    fechacesantiainicio date not null,
    isapre int not null references isapre(id),
    planpactado int not null references tipomoneda(id),
    valorplanpactado decimal(10,2) not null,
    ges int not null references tipomoneda(id),
    valorges decimal(10,2) not null,
    comentario varchar(200),
    documentoafp varchar(200),
    documentosalud varchar(200),
    documentojubilacion varchar(200)
);

create table cargastrabajador(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    nombres varchar(200) not null,
    primerapellido varchar(200) not null,
    segundoapellido varchar(200) not null,
    fechanacimiento date not null,
    civil int not null references estadocivil(id),
    fechareconocimiento date not null,
    fechapago date not null,
    vigencia date,
    tipocausante int not null references tipocausante(id),
    sexo int not null references sexo(id),
    tipocarga int not null references tipocarga(id),
    documento varchar(40),
    register_at timestamp not null default current_timestamp,
    trabajador int not null references trabajadores(id),
    comentario varchar(200)
);

create table pagadoressubsidio(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    codigoprevired varchar(20) not null,
    nombre varchar(200) not null
);

create table tipolicencia(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipolicencia values(1, 'Orden de reposo');
insert into tipolicencia values(2, 'Maternal (Pre y Post)');
insert into tipolicencia values(3, 'Licencias Medicas');

create table licenciamedica(
    id int not null auto_increment primary key,
    folio varchar(50) not null,
    tipolicencia int not null references tipolicencia(id),
    fechainicio date not null,
    fechatermino date not null,
    pagadora int not null references pagadoressubsidio(id),
    comentario varchar(200),
    documentolicencia varchar(200),
    comprobantetramite varchar(200),
    trabajador int not null references trabajadores(id),
    register_at timestamp not null default current_timestamp
);

create table estado(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);


create table trabajadorcargo(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    centrocosto int not null references centrocosto(id),
    cargo int not null references cargos(id),
    descripcion varchar(200),
    tipocontrato int not null references tipocontrato(id),
    desde date not null,
    hasta date,
    jornada int not null references jornadas(id),
    horaspactadas int not null,
    register_at timestamp not null default current_timestamp
);

create table tiposueldobase(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tiposueldobase values(1, 'Por Hora');
insert into tiposueldobase values(2, 'Mensual');
insert into tiposueldobase values(3, 'Semanal');
insert into tiposueldobase values(4, 'Diario');

create table trabajadorremuneracion(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    tiposueldobase int not null references tiposueldobase(id),
    sueldobase decimal(10,2) not null,
    zonaextrema decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);

create table lote(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    token varchar(200) not null,
    usuario int not null references users(id)
);

create table resumenregion(
    id int not null auto_increment primary key,
    region int not null references regiones(id),
    usuario int not null references users(id)
);

create table resumenprovincia(
    id int not null auto_increment primary key,
    provincia int not null references provincias(id),
    usuario int not null references users(id)
);

create table resumencomuna(
    id int not null auto_increment primary key,
    comuna int not null references comunas(id),
    usuario int not null references users(id)
);



create table vacaciones(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    periodo_inicio date not null,
    periodo_termino date not null,
    diasacumulados int not null,
    anosacumulados int not null,
    diasprograsivas int not null,
    tipodocumento int not null references tipodocumento(id),
    fechainicio date not null,
    fechatermino date not null,
    diashabiles int not null,
    diasinhabiles int not null,
    diasferiados int not null,
    totales int not null,
    diasrestantes int not null,
    observacion varchar(200),
    comprobantetramitefirmado varchar(200),
    register_at timestamp not null default current_timestamp
);

create table diasferiado(
    id int not null auto_increment primary key,
    periodo int not null,
    fecha date not null,
    descripcion varchar(200) not null
);

create table estadocontrato(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into estadocontrato values(1, 'Activo');
insert into estadocontrato values(2, 'Finiquitado');

create table formato_contrato(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into formato_contrato values(1, 'Contrato Individual Normal');
insert into formato_contrato values(2, 'Contrato Individual Express');

create table contratos(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    tipocontrato varchar(200) not null,
    cargo varchar(200) not null,
    sueldo decimal(10,2) not null,
    fechainicio date not null,
    fechatermino varchar(200) ,
    documento varchar(200) not null,
    estado int not null references estadocontrato(id),
    register_at timestamp not null default current_timestamp
);

--Agregar id centro de costo a tabla contratos despues de id empresa con valor por defecto 0 a referencia centrocosto(id)
alter table contratos add column centrocosto int not null references centrocosto(id) default 0 after empresa;

-- ==================================================================================
-- MODIFICACIONES A TABLA CONTRATOS - NUEVOS CAMPOS
-- ==================================================================================


-- Campos básicos del contrato
alter table contratos add column formato_contrato int null references formato_contrato(id) after estado;
alter table contratos add column categoria_contrato varchar(200) null after formato_contrato;
alter table contratos add column fecha_suscripcion date null after categoria_contrato;
alter table contratos add column region_celebracion int null after fecha_suscripcion;
alter table contratos add column comuna_celebracion int null after region_celebracion;
alter table contratos add column fecha_celebracion date null after comuna_celebracion;

-- Información del cargo
alter table contratos add column centro_costo int null after fecha_celebracion;
alter table contratos add column cargo_descripcion varchar(500) null after centro_costo;
-- Lugar específico de prestación de servicios
alter table contratos add column region_especifica int null after cargo_descripcion;
alter table contratos add column comuna_especifica int null after region_especifica;
alter table contratos add column calle_especifica varchar(200) null after comuna_especifica;
alter table contratos add column numero_especifico varchar(20) null after calle_especifica;
alter table contratos add column dept_oficina_especifico varchar(20) null after numero_especifico;
-- Zona geográfica de desplazamiento (se guarda si tiene zonas o no)
alter table contratos add column territorio_zona tinyint(1) default 0 after dept_oficina_especifico;

-- Subcontratación y servicios transitorios
alter table contratos add column subcontratacion tinyint(1) default 0 after territorio_zona;
alter table contratos add column subcontratacion_rut varchar(20) null after subcontratacion;
alter table contratos add column subcontratacion_razon_social varchar(200) null after subcontratacion_rut;
alter table contratos add column servicios_transitorios tinyint(1) default 0 after subcontratacion_razon_social;
alter table contratos add column transitorios_rut varchar(20) null after servicios_transitorios;
alter table contratos add column transitorios_razon_social varchar(200) null after transitorios_rut;

-- Remuneración
alter table contratos add column tipo_sueldo int null after transitorios_razon_social;
alter table contratos add column sueldo_base decimal(10,2) null after tipo_sueldo;
alter table contratos add column asignacion_zona decimal(10,2) null after sueldo_base;

-- Haberes imponibles
alter table contratos add column haber_imponible_tipo int null after asignacion_zona;
alter table contratos add column haber_imponible_monto decimal(10,2) null after haber_imponible_tipo;
alter table contratos add column haber_imponible_periodo varchar(50) null after haber_imponible_monto;
alter table contratos add column haber_imponible_detalle varchar(500) null after haber_imponible_periodo;

-- Haberes no imponibles
alter table contratos add column haber_no_imponible_tipo int null after haber_imponible_detalle;
alter table contratos add column haber_no_imponible_monto decimal(10,2) null after haber_no_imponible_tipo;
alter table contratos add column haber_no_imponible_periodo varchar(50) null after haber_no_imponible_monto;
alter table contratos add column haber_no_imponible_detalle varchar(500) null after haber_no_imponible_periodo;

-- Haberes imponibles no tributables
alter table contratos add column haber_imponible_notributable_tipo int null after haber_no_imponible_detalle;
alter table contratos add column haber_imponible_notributable_monto decimal(10,2) null after haber_imponible_notributable_tipo;
alter table contratos add column haber_imponible_notributable_periodo varchar(50) null after haber_imponible_notributable_monto;
alter table contratos add column haber_imponible_notributable_detalle varchar(500) null after haber_imponible_notributable_periodo;

-- Haberes no imponibles no tributables
alter table contratos add column haber_no_imponible_notributable_tipo int null after haber_imponible_notributable_detalle;
alter table contratos add column haber_no_imponible_notributable_monto decimal(10,2) null after haber_no_imponible_notributable_tipo;
alter table contratos add column haber_no_imponible_notributable_periodo varchar(50) null after haber_no_imponible_notributable_monto;
alter table contratos add column haber_no_imponible_notributable_detalle varchar(500) null after haber_no_imponible_notributable_periodo;

-- Forma de pago
alter table contratos add column forma_pago int null after haber_no_imponible_notributable_detalle;
alter table contratos add column periodo_pago_gratificacion varchar(50) null after forma_pago;
alter table contratos add column detalle_gratificacion varchar(500) null after periodo_pago_gratificacion;
alter table contratos add column periodo_pago_trabajador varchar(50) null after detalle_gratificacion;
alter table contratos add column fecha_pago_trabajador varchar(50) null after periodo_pago_trabajador;
alter table contratos add column forma_pago_trabajador int null after fecha_pago_trabajador;
alter table contratos add column banco_id int null after forma_pago_trabajador;
alter table contratos add column tipo_cuenta_id int null after banco_id;
alter table contratos add column numero_cuenta varchar(50) null after tipo_cuenta_id;
alter table contratos add column anticipo varchar(50) null after numero_cuenta;

-- Previsión
alter table contratos add column afp_id int null after anticipo;
alter table contratos add column salud_id int null after afp_id;

-- Pactos adicionales
alter table contratos add column pacto_badi tinyint(1) default 0 after salud_id;
alter table contratos add column otros_terminos text null after pacto_badi;

-- Jornada laboral
alter table contratos add column jornada_excepcional tinyint(1) default 0 after otros_terminos;
alter table contratos add column jornada_excluida tinyint(1) default 0 after jornada_excepcional;
alter table contratos add column no_resolucion varchar(100) null after jornada_excluida;
alter table contratos add column fecha_excepcion date null after no_resolucion;
alter table contratos add column tipo_jornada int null after fecha_excepcion;
alter table contratos add column incluye_domingos tinyint(1) default 0 after tipo_jornada;
alter table contratos add column dias_trabajo varchar(100) null after incluye_domingos;
alter table contratos add column duracion_jornada varchar(50) null after dias_trabajo;
alter table contratos add column dias_trabajo_semanal varchar(100) null after duracion_jornada;
alter table contratos add column horario_turno int null after dias_trabajo_semanal;
alter table contratos add column colacion varchar(100) null after horario_turno;
alter table contratos add column rotativo varchar(50) null after colacion;
alter table contratos add column colacion_imputable varchar(100) null after rotativo;
alter table contratos add column colacion_imputable_tiempo varchar(100) null after colacion_imputable;

-- Modificar columna documento para que acepte valores nulos
alter table contratos modify column documento varchar(500) null;

create table estadoafectoavacaciones(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into estadoafectoavacaciones values(1, 'Si');
insert into estadoafectoavacaciones values(2, 'No');

create table afectoavacaciones(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    fechainicio date not null,
    estadoafectoavacaciones int not null references estadoafectoavacaciones(id),
    register_at timestamp not null default current_timestamp
);

create table banco(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into banco values(1, 'Banco de Chile');
insert into banco values(2, 'Banco Santander');
insert into banco values(3, 'Banco Estado');
insert into banco values(4, 'Banco Security');
insert into banco values(5, 'Banco Itaú');
insert into banco values(6, 'Banco BCI');
insert into banco values(7, 'Banco Falabella');
insert into banco values(8, 'Banco Ripley');
insert into banco values(9, 'Banco Consorcio');
insert into banco values(10, 'Banco Internacional');
insert into banco values(11, 'Banco Edwards Citi');
insert into banco values(12, 'Banco de Crédito e Inversiones (BCI)');
insert into banco values(13, 'Banco Penta');
insert into banco values(14, 'Banco Paris');


create table tipocuenta(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipocuenta values(1, 'Cuenta Corriente');
insert into tipocuenta values(2, 'Cuenta Vista');
insert into tipocuenta values(3, 'Cuenta RUT');
insert into tipocuenta values(4, 'Cuenta Ahorro');
insert into tipocuenta values(5, 'Cuenta de Inversiones');

create table cuentabancaria(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    banco int not null references banco(id),
    tipocuenta int not null references tipocuenta(id),
    numero varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

create table tipodeindezacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipodeindezacion values(1, 'Descuento');
insert into tipodeindezacion values(2, 'Suma');

create table indemnizacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null,
    tipodeindezacion int not null references tipodeindezacion(id)
);

insert into indemnizacion values(1, 'Descuentos', 1);
insert into indemnizacion values(2, 'Impuesto retenido por indemnizaciones', 2);
insert into indemnizacion values(3, 'Indemnización años de servicio', 2);
insert into indemnizacion values(4, 'Indemnización fuero maternal (Art. 163 bis)', 2);
insert into indemnizacion values(5, 'Indemnización por feriado legal', 2);
insert into indemnizacion values(6, 'Indemnización sustitutiva del aviso previo', 2);
insert into indemnizacion values(7, 'Indemnización contractuales tributables', 2);
insert into indemnizacion values(8, 'Indemnización voluntarias tributables', 2);
insert into indemnizacion values(9, 'Otros haberes', 2);

create table resumenfiniquito(
    id int not null auto_increment primary key,
    indemnizacion int not null references indemnizacion(id),
    tipoindemnizacion int not null references tipodeindezacion(id),
    descripcion varchar(500) not null,
    monto decimal(10,2) not null,
    usuario int not null references users(id)
);

create table finiquito(
    id int not null auto_increment primary key,
    contrato int not null references contratos(id),
    tipodocumento int not null references tipodocumento(id),
    fechafiniqito date not null,
    fechainicio date not null,
    fechatermino date not null,
    causalterminocontrato int not null references causalterminocontrato(id),
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);

create table detallefiniquito(
    id int not null auto_increment primary key,
    indemnizacion int not null references indemnizacion(id),
    tipoindemnizacion int not null references tipodeindezacion(id),
    descripcion varchar(500) not null,
    monto decimal(10,2) not null,
    finiquito int not null references finiquito(id)
);

create table comunicacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into comunicacion values(1, 'Personal');
insert into comunicacion values(2, 'Carta Certificada');

create table acreditacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into acreditacion values(1, 'Planilla Cotizaciones');
insert into acreditacion values(2, 'Certificado Cotizaciones');
insert into acreditacion values(3, 'No Corresponde Informar');

create table notificaciones(
    id int not null auto_increment primary key,
    fechanotificacion date not null,
    finiquito int not null references finiquito(id),
    tipodocumento int not null references tipodocumento(id),
    causal int not null references causalterminocontrato(id),
    causalhechos text not null,
    cotizacionprevisional text not null,
    comunicacion int not null references comunicacion(id),
    acreditacion int not null references acreditacion(id),
    comuna varchar(200),
    texto text not null,
    register_at timestamp not null default current_timestamp
);

create table lotes(
    id int not null auto_increment primary key,
    nombre varchar(200) not null,
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);

create table detallelotes(
    id int not null auto_increment primary key,
    contrato int not null references contratos(id),
    lotes int not null references lotes(id),
    register_at timestamp not null default current_timestamp
);

create table lote2(
    id int not null auto_increment primary key,
    contrato int not null references contratos(id),
    usuario int not null references users(id_usu),
    register_at timestamp not null default current_timestamp
);

create table lote4(
    id int not null auto_increment primary key,
    contrato int not null references contratos(id),
    usuario int not null references users(id_usu),
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);

create table lote3(
    id int not null auto_increment primary key,
    finiquito int not null references finiquito(id),
    usuario int not null references users(id),
    register_at timestamp not null default current_timestamp
);

create table documentos(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    tipodocumento int not null references tipodocumento(id),
    fechageneracion date not null,
    documento varchar(200) not null,
    register_at timestamp not null default current_timestamp
);


create table tipoanotacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipoanotacion values(null, 'Observación');
insert into tipoanotacion values(null, 'Anotación Positiva');
insert into tipoanotacion values(null, 'Anotación Negativa');

create table anotacion(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    tipoanotacion int not null references tipoanotacion(id),
    anotacion text not null,
    register_at timestamp not null default current_timestamp  
);

create table tipodocumentosubido(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipodocumentosubido values(null, 'Contrato');
insert into tipodocumentosubido values(null, 'Certificado de trabajo');
insert into tipodocumentosubido values(null, 'Anexo de contrato');
insert into tipodocumentosubido values(null, 'Finiquito');
insert into tipodocumentosubido values(null, 'Carta de Renuncia');
insert into tipodocumentosubido values(null, 'Carta de despido');
insert into tipodocumentosubido values(null, 'Carta de Aviso');
insert into tipodocumentosubido values(null, 'Entrega de EPP');

create table documentosubido(
    id int not null auto_increment primary key,
    titulo varchar(200) not null,
    tipodocumento int not null references tipodocumentosubido(id),
    observacion text,
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    documento varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

create table anexoscontrato(
    id int not null auto_increment primary key,
    contrato int not null references contratos(id),
    fechageneracion date not null,
    base int not null,
    sueldo_base decimal(10,2) not null,
    estado int not null references estadocontrato(id),
    register_at timestamp not null default current_timestamp    
);

create table clausulasanexos(
    id int not null auto_increment primary key,
    anexo int not null references anexoscontrato(id),
    clausula text not null,
    tipodocumento int not null references tipodocumento(id),
    register_at timestamp not null default current_timestamp
);

--Documentos Firmados
create table contratosfirmados(
    id int not null auto_increment primary key,
    empresa int not null references empresa(id),
    centrocosto int not null references centrocosto(id),
    contrato int not null references contratos(id),
    documento varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

create table finiquitosfirmados(
    id int not null auto_increment primary key,
    empresa int not null references empresa(id),
    centrocosto int not null references centrocosto(id),
    finiquito int not null references finiquito(id),
    documento varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

create table notificacionesfirmadas(
    id int not null auto_increment primary key,
    empresa int not null references empresa(id),
    centrocosto int not null references centrocosto(id),
    notificacion int not null references notificaciones(id),
    documento varchar(200) not null,
    carta varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

create table otrosdocumentosfirmados(
    id int not null auto_increment primary key,
    empresa int not null references empresa(id),
    centrocosto int not null references centrocosto(id),
    id_doc int not null references documentos(id),
    documento varchar(200) not null,
    register_at timestamp not null default current_timestamp
);

--Documentos EMPRESA
create table periododocumento(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into periododocumento values(1, 'Mensual');
insert into periododocumento values(2, 'Unico');

create table tipo_documento_empresa(
    id int not null auto_increment primary key,
    nombre varchar(500) not null,
    periodo int not null references periododocumento(id)
);

insert into tipo_documento_empresa values(1, 'Certificado de Inicio actividad SII', 2);
insert into tipo_documento_empresa values(2, 'Certificado de adhesión a mutualidad', 1);
insert into tipo_documento_empresa values(3, 'Certificado de tasa de accidentabilidad', 1);
insert into tipo_documento_empresa values(4, 'Inscripción de Faena (DT)', 1);
insert into tipo_documento_empresa values(5, 'Inscripción de RIOHS (DT)', 2);
insert into tipo_documento_empresa values(6, 'Inscripción de RIOHS (Seremi de Salud)', 2);
insert into tipo_documento_empresa values(7, 'F30', 1);
insert into tipo_documento_empresa values(8, 'F30-1', 1);
insert into tipo_documento_empresa values(9, 'Planilla de Pagos Obligaciones Laborales', 1);
insert into tipo_documento_empresa values(10, 'Copia Libro de Asistencia', 1);

create table documentos_empresa(
    id int not null auto_increment primary key,
    tipo int not null references tipo_documento_empresa(id),
    centrocosto int not null references centrocosto(id),
    documento varchar(200) not null,
    periodo date null,
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);


------Modificaciones

--------Agregar tipo de usuario a tabla users con valor por defecto 1 a referencia tipousuario(id)
alter table users add column tipousuario int not null references tipousuario(id) default 2 after token;
----------Cambiar cantidad de caracteres nombre causales de termino de contrato de 50 a 500
alter table causalterminocontrato modify column nombre varchar(500) not null;
----------Agregar una columna de articulo a causalterminocontrato despues de codigoprevired con 200 caracteres
alter table causalterminocontrato add column articulo varchar(200) not null after codigoprevired;
----------Agregar una columna de letra a causalterminocontrato despues de articulo con 50 caracteres
alter table causalterminocontrato add column letra varchar(50) not null after articulo;
----------Agregar una columna de articulo a codigolre despues de codigo con 200 caracteres
alter table comunas add column codigox varchar(20) not null default '1' after codigoprevired;
----------Agregar una columna de contrato a documento despues de empresa con referencia a contratos(id)
alter table documentos add column contrato int not null references contratos(id) after empresa;


create table mandante(
    id int not null auto_increment primary key,
    usuario int not null references users(id_usu),
    centrocosto int not null references centrocosto(id),
    register_at timestamp not null default current_timestamp
);


/***************Sistema de REmuneraciones*************************/
create table tipohaberes(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipohaberes values(null, 'Haberes');
insert into tipohaberes values(null, 'Descuentos');

create table imponible(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into imponible values(null, 'Si');
insert into imponible values(null, 'No');

create table tributable(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tributable values(null, 'Si');
insert into tributable values(null, 'No');

create table gratificacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into gratificacion values(null, 'Si');
insert into gratificacion values(null, 'No');

create table reservado(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into reservado values(null, 'Si');
insert into reservado values(null, 'No');


create table codigolre(
    id int not null auto_increment primary key,
    articulo varchar(200) null,
    codigo varchar(200) not null,
    codigoprevired varchar(200) not null,
    nombre text not null,
    register_at timestamp not null default current_timestamp
);

insert into codigolre values (null, "", "2101","2101", "Sueldo", now());
insert into codigolre values (null, "", "2102","2102", "Sobre Sueldo", now());
insert into codigolre values (null, "", "2103","2103", "Comisiones (mensual)", now());
insert into codigolre values (null, "Art. 45", "2104","2104", "Semana Corrida (mensual)", now());
insert into codigolre values (null, "", "2105","2105", "Participación (mensual)", now());
insert into codigolre values (null, "", "2106","2106", "Gratificación (mensual)", now());
insert into codigolre values (null, "Art. 38", "2107", "2107", "Recargo 30% día domingo", now());
insert into codigolre values (null, "Art. 71", "2108","2108", "Remuneración variables pagada en vacaciones", now());
insert into codigolre values (null, "Art. 38 DFL 2", "2109","2109", "Remuneración variables pagada en Clausura", now());
insert into codigolre values (null, "", "2110","2110", "Aguinaldo", now());
insert into codigolre values (null, "", "2111","2111", "Bonos u otras remuneraciones fijas mensuales", now());
insert into codigolre values (null, "", "2112","2112", "Tratos (mensual)", now());
insert into codigolre values (null, "", "2113","2113", "Bonos u otras remuneraciones variables mensuales o superiores a un mes", now());
insert into codigolre values (null, "Art. 17 N°8 LIR", "2114","2114", "Ejercicio opción no pactada en contrato", now());
insert into codigolre values (null, "", "2115","2115", "Beneficios en especie constitutivos de remuneción", now());
insert into codigolre values (null, "", "21024","21024", "Pago por horas de trabajo sindical", now());

create table tipohaber(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipohaber values(null, 'Master');
insert into tipohaber values(null, 'Empresa');

create table agrupacionhaber(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into agrupacionhaber values(1, 'Valor');
insert into agrupacionhaber values(2, 'Horas');
insert into agrupacionhaber values(3, 'Dias');

create table habres_descuentos(
    id int not null auto_increment primary key,
    codigo varchar(200) not null,
    descripcion text not null,
    tipo int not null references tipohaberes(id),
    imponible int not null references imponible(id),
    tributable int not null references tributable(id),
    gratificacion int not null references gratificacion(id),
    reservado int not null references reservado(id),    
    codigolre int not null references codigolre(id),
    agrupacion int not null references agrupacionhaber(id),
    aplicaformula int not null,
    formula text,
    tipohaber int not null references tipohaber(id),
    empresa int not null,
    register_at timestamp not null default current_timestamp
);

create table modalidad(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into modalidad values(null, 'Fijo');
insert into modalidad values(null, 'Proporcional');

create table haberes_descuentos_trabajador(
    id int not null auto_increment primary key,
    codigo int not null references habres_descuentos(id),
    periodo_inicio date not null,
    periodo_termino date not null,
    monto decimal(10,2) not null,
    dias int not null,
    horas decimal(10,2) not null,
    modalidad int not null references modalidad(id),
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    register_at timestamp not null default current_timestamp
);

create table formulas(
    id int not null auto_increment primary key,
    codigo varchar(200) not null,
    nombre text not null,
    representacion text not null,
    formula text not null,
    register_at timestamp not null default current_timestamp
);

create table horaspactadas(
    id int not null auto_increment primary key,
    horas int not null,
    contrato int not null references contratos(id),
    register_at timestamp not null default current_timestamp
);

create table estadoasistencia(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into estadoasistencia values(null, 'Presente');
insert into estadoasistencia values(null, 'Media Jornada');
insert into estadoasistencia values(null, 'Ausente');
insert into estadoasistencia values(null, 'Con licencia');

create table asistencia(
    id int not null auto_increment primary key,
    fecha date not null,
    estado int not null references estadoasistencia(id),
    trabajador int not null references trabajadores(id),
    contrato int not null references contratos(id),
    register_at timestamp not null default current_timestamp
);

create table liquidaciones(
    id int not null auto_increment primary key,
    folio int not null,
    contrato int not null references contratos(id),
    periodo date not null,
    empresa int not null references empresa(id),
    trabajador int not null references trabajadores(id),
    diastrabajados decimal(10,2) not null,
    sueldobase int not null,
    horasfalladas int not null,
    horasextras1 int not null,
    horasextras2 int not null,
    horasextras3 int not null,
    afp varchar(200) not null,
    porafp varchar(200) not null,
    porsis varchar(200) not null,
    salud varchar(200) not null,
    porsalud varchar(200) not null,    
    desafp int not null,   
    dessis int not null,   
    dessal int not null,
    gratificacion int not null,   
    totalimponible int not null,
    totalnoimponible int not null,
    totaltributable int not null,
    totaldeslegales int not null,
    totaldesnolegales int not null,
    fecha_liquidacion date not null,
    register_at timestamp not null default current_timestamp
);

create table tipohaberesliquidacion(
    id int not null auto_increment primary key,
    nombre varchar(200) not null
);

insert into tipohaberesliquidacion values(null, 'Haberes imponibles');
insert into tipohaberesliquidacion values(null, 'Haberes no imponibles');
insert into tipohaberesliquidacion values(null, 'Descuentos legales');
insert into tipohaberesliquidacion values(null, 'Descuentos no legales');

create table detalle_liquidacion(
    id int not null auto_increment primary key,
    liquidacion int not null references liquidaciones(id),
    codigo text not null,
    monto int not null,
    tipo int not null references tipohaberesliquidacion(id),
    register_at timestamp not null default current_timestamp
);

create table aporteempleador(
    id int not null auto_increment primary key,
    liquidacion int not null references liquidaciones(id),
    cesantia_empleador decimal(10,2) not null,
    cotizacionbasica decimal(10,2) not null,
    cotizacionleysanna decimal(10,2) not null,
    cotizacionadicional decimal(10,2) not null,
    seguroaccidentes decimal(10,2) not null,
    register_at timestamp not null default current_timestamp    
);

/************************************valores************************************/
--UF
create table uf(
    id int not null auto_increment primary key,
    periodo date not null,
    tasa decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table utm(
    id int not null auto_increment primary key,
    periodo date not null,
    tasa decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table uta(
    id int not null auto_increment primary key,
    periodo date not null,
    tasa decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table sueldominimo(
    id int not null auto_increment primary key,
    periodo date not null,
    tasa decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);

--tope imponible
create table topeafp(
    id int not null auto_increment primary key,
    periodo date not null,
    valor decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table topeips(
    id int not null auto_increment primary key,
    periodo date not null,
    valor decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table topecesantia(
    id int not null auto_increment primary key,
    periodo date not null,
    valor decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table topeapvmensual(
    id int not null auto_increment primary key,
    periodo date not null,
    valor decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);
create table topeapvanual(
    id int not null auto_increment primary key,
    ano int not null,
    valor decimal(10,2) not null,
    register_at timestamp not null default current_timestamp
);

/****************************Movimientos trabajadores************************/
create table movimientotrabajador(
    id int not null auto_increment primary key,
    trabajador int not null references trabajadores(id),
    empresa int not null references empresa(id),
    periodo date not null,
    tipo int not null,
    evento int not null references jornadas(id),
    fechainicio date not null,
    fechatermino date null,
    rutentidad varchar(200) null,
    nombreentidad varchar(200) null,
    register_at timestamp not null default current_timestamp
);

/**************************Sistema de Documentos Empresariales************************/

-- Tabla para tipos de documentos empresariales
CREATE TABLE IF NOT EXISTS tipo_documento_empresa_plantilla (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(200) NOT NULL,
    categoria ENUM('mandato_especial_empresa', 'mandato_especial_representante', 'contrato_arriendo', 'contrato_comodato') NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (categoria),
    INDEX idx_activo (activo)
);

-- Tabla para las plantillas base de documentos
CREATE TABLE IF NOT EXISTS plantillas_empresa (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_documento INT NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    contenido LONGTEXT NOT NULL,
    version VARCHAR(20) NOT NULL DEFAULT '1.0',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_documento) REFERENCES tipo_documento_empresa_plantilla(id) ON DELETE CASCADE,
    INDEX idx_tipo_documento (tipo_documento),
    INDEX idx_activo (activo)
);


-- Tabla para documentos generados
CREATE TABLE IF NOT EXISTS documentos_empresa_generados (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_documento INT NOT NULL,
    plantilla_id INT NULL,
    empresa INT NOT NULL,
    titulo VARCHAR(300) NOT NULL,
    contenido_generado LONGTEXT NOT NULL,
    archivo_pdf VARCHAR(500) NULL,
    usuario_creador INT NOT NULL,
    fecha_generacion DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_documento) REFERENCES tipo_documento_empresa_plantilla(id) ON DELETE CASCADE,
    FOREIGN KEY (plantilla_id) REFERENCES plantillas_empresa(id) ON DELETE SET NULL,
    FOREIGN KEY (empresa) REFERENCES empresa(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES users(id_usu) ON DELETE CASCADE,
    INDEX idx_empresa (empresa),
    INDEX idx_tipo_documento (tipo_documento),
    INDEX idx_fecha_generacion (fecha_generacion),
    INDEX idx_usuario_creador (usuario_creador)
);


-- Tabla para mandatarios (personas que reciben el mandato)
CREATE TABLE IF NOT EXISTS mandatarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario INT NOT NULL,
    documento int NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario) REFERENCES users(id_usu) ON DELETE CASCADE,
    FOREIGN KEY (documento) REFERENCES documentos_empresa_generados(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario),
    INDEX idx_documento (documento),
    UNIQUE KEY unique_mandatario_empresa (usuario, documento)
);

-- Tabla para registrar montos de arriendo
CREATE TABLE IF NOT EXISTS mandatos_arriendo (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    empresa INT NOT NULL,
    monto DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa) REFERENCES empresa(id) ON DELETE CASCADE,
    INDEX idx_empresa (empresa)
);

-- Tabla para conversión de números a letras (auxiliar)
CREATE TABLE IF NOT EXISTS numeros_letras (
    numero INT PRIMARY KEY,
    texto VARCHAR(50) NOT NULL
);

-- ==================================================================================
-- INSERTAR TIPOS DE DOCUMENTOS INICIALES
-- ==================================================================================

INSERT INTO tipo_documento_empresa_plantilla (codigo, nombre, categoria, descripcion) VALUES 
('ME001', 'Mandato Especial Empresa - Modelo Básico', 'mandato_especial_empresa', 'Mandato especial para representación empresarial básica'),
('ME002', 'Mandato Especial Empresa - Modelo Completo', 'mandato_especial_empresa', 'Mandato especial para representación empresarial con facultades amplias'),
('MR001', 'Mandato Especial Representante Legal - Básico', 'mandato_especial_representante', 'Mandato especial otorgado por representante legal'),
('MR002', 'Mandato Especial Representante Legal - Amplio', 'mandato_especial_representante', 'Mandato especial otorgado por representante legal con facultades extensas'),
('CA001', 'Contrato de Arriendo Comercial', 'contrato_arriendo', 'Contrato de arriendo para uso comercial con monto'),
('CA002', 'Contrato de Arriendo Habitacional', 'contrato_arriendo', 'Contrato de arriendo para uso habitacional con monto'),
('CC001', 'Contrato de Comodato Básico', 'contrato_comodato', 'Contrato de comodato uso gratuito básico'),
('CC002', 'Contrato de Comodato Completo', 'contrato_comodato', 'Contrato de comodato uso gratuito con cláusulas detalladas');

-- ==================================================================================
-- INSERTAR PLANTILLAS BASE
-- ==================================================================================

-- Plantilla Mandato Especial Empresa
INSERT INTO plantillas_empresa (tipo_documento, nombre, contenido, version) VALUES 
(1, 'Mandato Especial Empresa - Plantilla Base', 
'<div style="text-align: center; margin-bottom: 30px;">
<h2>MANDATO ESPECIAL</h2>
<h3>{NOMBRE_EMPRESA} A {MANDATARIO_1}</h3>
</div>

<p>{NOMBRE_EMPRESA}, persona jurídica del giro de su denominación, rol único tributario número {RUT_EMPRESA}, representada según se acreditará, por {REPRESENTANTE_LEGAL}, {NACIONALIDAD_MANDATARIO_1}, {ESTADO_CIVIL_MANDATARIO_1}, {PROFESION_MANDATARIO_1}, cédula nacional de identidad número {RUT_REPRESENTANTE_LEGAL}, ambos con domicilio para estos efectos en {DIRECCION_EMPRESA}, expone: Que por este acto, en la representación que inviste, confiere mandato especial extrajudicial</p>

<p><strong>PRIMERO:</strong> Mediante el presente acto el "Mandante", ya singularizado viene en conferir mandato extrajudicial, a don {MANDATARIO_1}, {NACIONALIDAD_MANDATARIO_1}, {ESTADO_CIVIL_MANDATARIO_1}, {PROFESION_MANDATARIO_1}, cédula nacional de identidad número {RUT_MANDATARIO_1}, con domicilio en [DOMICILIO MANDANTE], comuna de [COMUNA MANDANTE].</p>

<p><strong>SEGUNDO:</strong> En el desempeño del Mandato, los mandatarios podrán representar de forma separada o conjunta, facultándolos para realizar presentaciones, solicitudes y defensas en general, de las cuales, a título meramente ejemplar, y sin que sean taxativas, se mencionan las siguientes: Representar a los mandantes ante toda clase de personas, naturales o jurídicas, de derecho público o privado, o ante cualquier autoridad o institución pública o privada, fiscal, semifiscal, semifiscal de administración autónoma o mixta, administrativa, municipal, servicios y reparticiones y empresas del Estado.</p>

<div style="margin-top: 50px; text-align: center;">
<table style="width: 100%; border-collapse: collapse;">
<tr>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
{NOMBRE_EMPRESA}<br>
RUT: {RUT_EMPRESA}<br>
Representante Legal<br>
{REPRESENTANTE_LEGAL}<br>
{RUT_REPRESENTANTE_LEGAL}
</div>
</td>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
{MANDATARIO_1}<br>
C.I. N° {RUT_MANDATARIO_1}
</div>
</td>
</tr>
</table>
</div>

<p style="text-align: center; margin-top: 30px; font-size: 12px;">
Fecha de generación: {FECHA_GENERACION}
</p>', '1.0'),

-- Plantilla Contrato de Arriendo
(5, 'Contrato de Arriendo Comercial - Plantilla Base',
'<div style="text-align: center; margin-bottom: 30px;">
<h2>CONTRATO DE ARRIENDO</h2>
</div>

<p>En [CIUDAD], a {FECHA_CELEBRACION}, comparecen, por una parte, doña [NOMBRE ARRENDADOR], [NACIONALIDAD], [ESTADO CIVIL], [PROFESION], Rut N° [RUT ARRENDADOR], domiciliado para estos efectos en [DIRECCION ARRENDADOR], en adelante denominado indistintamente como el "arrendador", y por la otra, la empresa {NOMBRE_EMPRESA}, Rut {RUT_EMPRESA}, representado por {REPRESENTANTE_LEGAL}, {NACIONALIDAD_MANDATARIO_1}, {ESTADO_CIVIL_MANDATARIO_1}, de oficio {PROFESION_MANDATARIO_1}, cédula nacional de identidad {RUT_REPRESENTANTE_LEGAL}, domiciliada para estos efectos en {DIRECCION_EMPRESA}, en adelante denominados como "El Arrendataria". Identificadas como LAS PARTES, y basándose en los mutuos pactos y acuerdos reflejados en el presente contrato, ACUERDAN lo siguiente:</p>

<p><strong>PRIMERO: Propiedad</strong><br>
El arrendador da en arrendamiento al arrendatario, quien acepta para sí, la propiedad ubicada [DIRECCION INMUEBLE], en las condiciones que expresan las cláusulas del presente contrato.</p>

<p><strong>SEGUNDO: Uso del Inmueble</strong><br>
El inmueble individualizado en la cláusula anterior sólo podrá ser usado como oficina en las condiciones descritas en la Cláusula [NUMERO] de este contrato.</p>

<p><strong>TERCERO: Plazo</strong><br>
El arrendamiento empezará a regir el {FECHA_CELEBRACION} por un plazo de un año calendario, renovable por períodos de doce meses, debiendo las partes dar aviso por escrito de término del contrato con treinta (30) días de anticipación al vencimiento de lo pactado.</p>

<p><strong>CUARTO: Renta</strong><br>
La renta de arrendamiento será de {MONTO_ARRIENDO} ({MONTO_ARRIENDO_LETRAS} pesos), el pago se realizará mediante transferencia electrónica o depósito bancario directamente en la Cuenta Rut a nombre de [NOMBRE ARRENDADOR].</p>

<div style="margin-top: 50px; text-align: center;">
<table style="width: 100%; border-collapse: collapse;">
<tr>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
[NOMBRE ARRENDADOR]<br>
RUT: [RUT ARRENDADOR]<br>
ARRENDADOR
</div>
</td>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
{NOMBRE_EMPRESA}<br>
RUT {RUT_EMPRESA}<br>
Representante Legal<br>
{REPRESENTANTE_LEGAL}<br>
RUT: {RUT_REPRESENTANTE_LEGAL}
</div>
</td>
</tr>
</table>
</div>', '1.0'),

-- Plantilla Contrato de Comodato
(7, 'Contrato de Comodato - Plantilla Base',
'<div style="text-align: center; margin-bottom: 30px;">
<h2>CONTRATO DE COMODATO</h2>
</div>

<p>En [CIUDAD], a {FECHA_CELEBRACION}, comparecen, por una parte, [NOMBRE COMODANTE], [NACIONALIDAD], [ESTADO CIVIL], [PROFESION], RUT [RUT COMODANTE] representado por [REPRESENTANTE COMODANTE], domiciliado para estos efectos en [DIRECCION COMODANTE], en adelante denominado indistintamente como el "comodante", y por la otra, la empresa {NOMBRE_EMPRESA}, RUT {RUT_EMPRESA}, representada por {REPRESENTANTE_LEGAL}, domiciliada para estos efectos en {DIRECCION_EMPRESA}, en adelante denominado indistintamente como el "comodatario"; los comparecientes mayores de edad, que acreditan su identidad con las cédulas antes indicadas, y exponen: Que de común acuerdo han convenido en celebrar el siguiente Contrato de comodato de un bien raíz:</p>

<p><strong>PRIMERO: Inmueble</strong><br>
El comodante es propietario del inmueble ubicado [DIRECCION INMUEBLE], comuna de [COMUNA], región [REGION]. El rol de avalúo fiscal del bien raíz es el número [ROL AVALUO].</p>

<p><strong>SEGUNDO: Comodato</strong><br>
El comodante entrega en comodato, esto es, en préstamo gratuito de uso, el bien raíz indicado en la cláusula anterior al comodatario, quien toma y acepta para sí.</p>

<p><strong>TERCERO: Destino</strong><br>
El comodatario sólo podrá destinar el inmueble a uso comercial y tributario, siendo esta circunstancia determinante para la celebración del presente contrato.</p>

<p><strong>CUARTO: Duración</strong><br>
La vigencia del presente contrato comenzará el día {FECHA_CELEBRACION} y tendrá una duración de [DURACION] meses expirando en consecuencia el día [FECHA TERMINO].</p>

<p><strong>QUINTO: Entrega</strong><br>
La entrega material del bien raíz se realiza en este acto, a entera conformidad del comodatario, quien se obliga a restituirlo al término del presente contrato.</p>

<div style="margin-top: 50px; text-align: center;">
<table style="width: 100%; border-collapse: collapse;">
<tr>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
[NOMBRE COMODANTE]<br>
RUT: [RUT COMODANTE]<br>
Representante Legal<br>
[REPRESENTANTE COMODANTE]<br>
C.I. N° [RUT REPRESENTANTE COMODANTE]
</div>
</td>
<td style="text-align: center; padding: 20px;">
<div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
{NOMBRE_EMPRESA}<br>
RUT {RUT_EMPRESA}<br>
Representante Legal<br>
{REPRESENTANTE_LEGAL}<br>
C.I. N° {RUT_REPRESENTANTE_LEGAL}
</div>
</td>
</tr>
</table>
</div>', '1.0');

-- ==================================================================================
-- INSERTAR NÚMEROS PARA CONVERSIÓN A LETRAS (MUESTRA)
-- ==================================================================================

INSERT IGNORE INTO numeros_letras VALUES
(0, 'cero'), (1, 'uno'), (2, 'dos'), (3, 'tres'), (4, 'cuatro'),
(5, 'cinco'), (6, 'seis'), (7, 'siete'), (8, 'ocho'), (9, 'nueve'),
(10, 'diez'), (11, 'once'), (12, 'doce'), (13, 'trece'), (14, 'catorce'),
(15, 'quince'), (16, 'dieciséis'), (17, 'diecisiete'), (18, 'dieciocho'), (19, 'diecinueve'),
(20, 'veinte'), (21, 'veintiuno'), (22, 'veintidós'), (23, 'veintitrés'), (24, 'veinticuatro'),
(25, 'veinticinco'), (26, 'veintiséis'), (27, 'veintisiete'), (28, 'veintiocho'), (29, 'veintinueve'),
(30, 'treinta'), (40, 'cuarenta'), (50, 'cincuenta'), (60, 'sesenta'), (70, 'setenta'),
(80, 'ochenta'), (90, 'noventa'), (100, 'cien'), (200, 'doscientos'), (300, 'trescientos'),
(400, 'cuatrocientos'), (500, 'quinientos'), (600, 'seiscientos'), (700, 'setecientos'),
(800, 'ochocientos'), (900, 'novecientos'), (1000, 'mil');

-- ==================================================================================
-- TABLAS ADICIONALES PARA CONTRATOS - DISTRIBUCIÓN HORARIA Y ZONAS GEOGRÁFICAS
-- ==================================================================================

-- Tabla para almacenar la distribución horaria por turno y día
create table contrato_distribucion_horaria(
    id int not null auto_increment primary key,
    contrato_id int not null,
    tipo_turno varchar(20) not null comment 'normal, matutino, tarde, noche',
    dia_semana tinyint(1) not null comment '1=Lunes, 2=Martes, 3=Miercoles, 4=Jueves, 5=Viernes, 6=Sabado, 7=Domingo',
    dia_seleccionado tinyint(1) default 0 comment '0=No seleccionado, 1=Seleccionado',
    hora_inicio time null,
    hora_termino time null,
    register_at timestamp not null default current_timestamp,
    foreign key (contrato_id) references contratos(id) on delete cascade,
    unique key idx_contrato_turno_dia (contrato_id, tipo_turno, dia_semana)
) comment='Distribución horaria detallada por turno y día de la semana';

-- Tabla para almacenar las zonas geográficas de desplazamiento del contrato
create table contrato_zona_geografica(
    id int not null auto_increment primary key,
    contrato_id int not null,
    tipo_zona varchar(20) not null comment 'region, provincia, comuna',
    zona_id int not null comment 'ID de la región, provincia o comuna según tipo_zona',
    register_at timestamp not null default current_timestamp,
    foreign key (contrato_id) references contratos(id) on delete cascade,
    unique key idx_contrato_tipo_zona (contrato_id, tipo_zona, zona_id)
) comment='Zonas geográficas donde el trabajador puede desplazarse según contrato';

-- Índices para mejorar el rendimiento
create index idx_contrato_distribucion on contrato_distribucion_horaria(contrato_id);
create index idx_contrato_zona on contrato_zona_geografica(contrato_id);
create index idx_tipo_turno on contrato_distribucion_horaria(tipo_turno);
create index idx_tipo_zona on contrato_zona_geografica(tipo_zona);

-- ==================================================================================
-- TABLA PARA ESTIPULACIONES ADICIONALES DEL CONTRATO
-- ==================================================================================

create table contrato_estipulaciones(
    id int not null auto_increment primary key,
    contrato_id int not null,
    numero_estipulacion tinyint not null comment 'Número de la estipulación (1-13)',
    contenido text not null,
    register_at timestamp not null default current_timestamp,
    foreign key (contrato_id) references contratos(id) on delete cascade,
    unique key idx_contrato_estipulacion (contrato_id, numero_estipulacion)
) comment='Estipulaciones adicionales del contrato (cláusulas especiales)';

create index idx_contrato_estipulaciones on contrato_estipulaciones(contrato_id);