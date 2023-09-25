<!--Function Contrato Individual contratoindividual.php-->
<!--Idenficacion de las partes-->
--listarcomunas();

<!--------Identificacion de las partes--------------->
--seleccionartipodocumento();
--SeleccionarRepresentante();
--seleccionarCodigo();

<!------------Funciones y lugares de prestacion de servicios---------------->
--listarcomunasespecificas();
--agregarregion();
todaslasregiones
--agregarprovincia();
todaslasprovincias
--agregarcomuna();
todaslascomunas

--subcontratacion();
--transitorios();


<!------------IDENFIFICAdores------------------->
<!-----------------Identificacion de las partes--------------->
<!-------Informacion de la Celebracion------>
#categoria_contrato &categoria_contrato
#regioncelebracion &regioncelebracion
#comunacelebracion &comunacelebracion
#fechacelebracion &fechacelebracion
#tipocontratoid &tipocontratoid

<!---------Antecedentes de la Empresa--------------------------->
#nombre_razon_social &nombre_razon_social
#rut_empleador &rut_empleador
#representante_legal &representante_legal
#correo_electronico &correo_electronico
#telefono &telefono
#codigoactividadid &codigoactividadid
#empresaregion &empresaregion
#empresacomuna &empresacomuna
#calle &calle
#numero &numero
#departamento &departamento

<!-----------------Antecedentes del Trabajador------------------->
#ruttrabajador &ruttrabajador
#nombretrabajador &nombretrabajador
#apellidos &apellidos
#fechanacimiento &fechanacimiento
#sexo &sexo
#nacionalidad &nacionalidad
#correotrabajador &correotrabajador
#telefonotrabajador &telefonotrabajador
#trabajadorregion &trabajadorregion
#trabajadorcomuna &trabajadorcomuna
#calletrabajador &calletrabajador
#numerotrabajador &numerotrabajador
#departamentotrabajador &departamentotrabajador
#discapacidad &discapacidad
#pensionado &pensionado


<!----------------Functiones y lugares de prestacion de los servicios------------------->
<!-------------Naturaleza de los servicios------------------------>
#centrocosto &centrocosto
#Charge &Charge
#ChargeDescripcion &ChargeDescripcion

<!---------------Direccion Especifica-------------------------->
#regionespecifica &regionespecifica
#comunaespecifica &comunaespecifica
#calleespecifica &calleespecifica
#numeroespecifica &numeroespecifica
#departamentoespecifica &departamentoespecifica

<!---------------Zona Geografica de prestacion de los servicios-------------------------->
#zonaregion &zonaregion
#zonaprovincia &zonaprovincia
#zonacomuna &zonacomuna
#subcontratacion &subcontratacion
#subcontratacionrut &subcontratacionrut
#subcontratacionrazonsocial &subcontratacionrazonsocial
#transitorios &transitorios
#transitoriosrut &transitoriosrut
#transitoriosrazonsocial &transitoriosrazonsocial




<!---------------------Remuneracion-------------------------->
#tiposueldo &tiposueldo
#sueldo &sueldo
#asignacion &asignacion
<!-----------Haberes imponibles-------------------------->
<!-----------Haberes imponibles tributables-------------------------->
#tipohaber &tipohaber
#montohaber &montohaber
#periodohaber &periodohaber
#detallerenumeracion &detallerenumeracion

<!-----------Haberes imponibles no tributables-------------------------->
#tipohabernotributable &tipohabernotributable
#montohabernotributable &montohabernotributable
#periodohabernotributable &periodohabernotributable
#detallerenumeracionnotributable &detallerenumeracionnotributable

<!-----------Haberes no imponibles tributables-------------------------->
#tipohaberno &tipohaberno
#montohaberno &montohaberno
#periodohaberno &periodohaberno
#detallerenumeracionno &detallerenumeracionno

<!-----------Haberes no imponibles no tributables-------------------------->
#tipohabernonotributable &tipohabernonotributable
#montohabernonotributable &montohabernonotributable
#periodohabernonotributable &periodohabernonotributable
#detallerenumeracionnonotributable &detallerenumeracionnonotributable

<!-----------Gratificaciones-------------------------->
#formapago &formapago
#periodopagogra &periodopagogra
$detallerenumeraciongra &detallerenumeraciongra

<!-----------Periodo y forma de pago-------------------------->
#periodopagot &periodopagot
#fechapagot &fechapagot
#formapagot &formapagot
#anticipot &anticipot
#afp &afp
#salud &salud
#badi &badi
#otrter &otrter

<!-----------------Jornada de trabajo  y otras estipulaciones-------------------------->
#jornadaesc &jornadaesc
#noresolucion &noresolucion
#fecharesolucion &fecharesolucion

#exluido &exluido
#tipojornada &tipojornada

#incluye &incluye
#horaspactadas &horaspactadas
#dias &dias
#horarioturno &horarioturno
#colacion &colacion
#colacionimp &colacionimp

<!------------------------Distribucion de la jornada-------------------------->
<!------------------------Distribucion de la jornada Normal-------------------------->
.general
.normales

#todos &todos
#lunes &lunes
#martes &martes
#miercoles &miercoles
#jueves &jueves
#viernes &viernes
#sabado &sabado
#domingo &domingo

#luneshorainicio &luneshorainicio
#luneshoratermino &luneshoratermino

#marteshorainicio &marteshorainicio
#marteshoratermino &marteshoratermino

#miercoleshorainicio &miercoleshorainicio
#miercoleshoratermino &miercoleshoratermino

#jueveshorainicio &jueveshorainicio
#jueveshoratermino &jueveshoratermino

#vierneshorainicio &vierneshorainicio
#vierneshoratermino &vierneshoratermino

#sabadohorainicio &sabadohorainicio
#sabadohoratermino &sabadohoratermino

#domingohorainicio &domingohorainicio
#domingohoratermino &domingohoratermino

<!------------------------Distribucion de la jornada Matutino-------------------------->
.matutino
.matutinos

#todosm &todosm
#lunesm &lunesm
#martesm &martesm
#miercolesm &miercolesm
#juevesm &juevesm
#viernem &viernem
#sabadom &sabadom
#domingom &domingom

#luneshorainiciom &luneshorainiciom
#luneshoraterminom &luneshoraterminom

#marteshorainiciom &marteshorainiciom
#marteshoraterminom &marteshoraterminom

#miercoleshorainiciom &miercoleshorainiciom
#miercoleshoraterminom &miercoleshoraterminom

#jueveshorainiciom &jueveshorainiciom
#jueveshoraterminom &jueveshoraterminom

#vierneshorainiciom &vierneshorainiciom
#vierneshoraterminom &vierneshoraterminom

#sabadohorainiciom &sabadohorainiciom
#sabadohoraterminom &sabadohoraterminom

#domingohorainiciom &domingohorainiciom
#domingohoraterminom &domingohoraterminom

<!------------------------Distribucion de la jornada Tarde-------------------------->
.tarde
.tardes

#todost &todost
#lunest &lunest
#martest &martest
#miercolest &miercolest
#juevest &juevest
#viernest &viernest
#sabadot &sabadot
#domingot &domingot

#luneshorainiciot &luneshorainiciot
#luneshoraterminot &luneshoraterminot

#marteshorainiciot &marteshorainiciot
#marteshoraterminot &marteshoraterminot

#miercoleshorainiciot &miercoleshorainiciot
#miercoleshoraterminot &miercoleshoraterminot

#jueveshorainiciot &jueveshorainiciot
#jueveshoraterminot &jueveshoraterminot

#vierneshorainiciot &vierneshorainiciot
#vierneshoraterminot &vierneshoraterminot

#sabadohorainiciot &sabadohorainiciot
#sabadohoraterminot &sabadohoraterminot

#domingohorainiciot &domingohorainiciot
#domingohoraterminot &domingohoraterminot

<!------------------------Distribucion de la jornada Noche-------------------------->
.noche
.noches

#todosn &todosn
#lunesn &lunesn
#martesn &martesn
#miercolesn &miercolesn
#juevesn &juevesn
#viernesn &viernesn
#sabadon &sabadon
#domingon &domingon

#luneshorainicion &luneshorainicion
#luneshoraterminon &luneshoraterminon

#marteshorainicion &marteshorainicion
#marteshoraterminon &marteshoraterminon

#miercoleshorainicion &miercoleshorainicion
#miercoleshoraterminon &miercoleshoraterminon

#jueveshorainicion &jueveshorainicion
#jueveshoraterminon &jueveshoraterminon

#vierneshorainicion &vierneshorainicion
#vierneshoraterminon &vierneshoraterminon

#sabadohorainicion &sabadohorainicion
#sabadohoraterminon &sabadohoraterminon

#domingohorainicion &domingohorainicion
#domingohoraterminon &domingohoraterminon

<!-------------------Lugar, Fecha y plazo del contrato-------------------------->
#tipo_contrato &tipo_contrato
#fecha_inicio &fecha_inicio
#fecha_termino &fecha_termino

#estipulacion1 &estipulacion1
#estipulacion2 &estipulacion2
#estipulacion3 &estipulacion3
#estipulacion4 &estipulacion4
#estipulacion5 &estipulacion5
#estipulacion6 &estipulacion6
#estipulacion7 &estipulacion7
#estipulacion8 &estipulacion8
#estipulacion9 &estipulacion9
#estipulacion10 &estipulacion10
#estipulacion11 &estipulacion11
#estipulacion12 &estipulacion12
#estipulacion13 &estipulacion13

#juramento &juramento