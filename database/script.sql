
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
    nombre varchar(50) not null
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

--Agregar tipo de usuario a tabla users con valor por defecto 1 a referencia tipousuario(id)
alter table users add column tipousuario int not null references tipousuario(id) default 2 after token;

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

--Agregar id centro de costo a tabla contratos despues de id empresa con valor por defecto 1 a referencia centrocosto(id)
alter table contratos add column centrocosto int not null references centrocosto(id) default 0 after empresa;

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

create table mandate(
    id int not null auto_increment primary key,
    usuario int not null references users(id),
    centrocosto int not null references centrocosto(id),
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
    id_doc int not null references documentos(id),
    empresa int not null references empresa(id),
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




--Cambiar cantidad de caracteres nombre causales de termino de contrato de 50 a 500
alter table causalterminocontrato modify column nombre varchar(500) not null;
--Agregar una columna de articulo a causalterminocontrato despues de codigoprevired con 200 caracteres
alter table causalterminocontrato add column articulo varchar(200) not null after codigoprevired;
--Agregar una columna de letra a causalterminocontrato despues de articulo con 50 caracteres
alter table causalterminocontrato add column letra varchar(50) not null after articulo;
--Agregar una columna de articulo a codigolre despues de codigo con 200 caracteres
alter table comunas add column codigox varchar(20) not null default '1' after codigoprevired;