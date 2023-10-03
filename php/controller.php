<?php
// Include the classes
require 'Class/Afp.php';
require 'Class/Anotacion.php';
require 'Class/Auditoria.php';
require 'Class/Banco.php';
require 'Class/Cajacompensacion.php';
require 'Class/CargaFamiliar.php';
require 'Class/Cargos.php';
require 'Class/CausalTermino.php';
require 'Class/CentroCosto.php';
require 'Class/CifrasEnLetras.php';
require 'Class/Ciudades.php';
require 'Class/CodigoActividad.php';
require 'Class/Comunas.php';
require 'Class/Contrato.php';
require 'Class/CuentaBancaria.php';
require 'Class/DiasFeriados.php';
require 'Class/Documento.php';
require 'Class/Empresa.php';
require 'Class/Finiquitos.php';
require 'Class/Indemnizacion.php';
require 'Class/Isapres.php';
require 'Class/Jornadas.php';
require 'Class/Licencias.php';
require 'Class/lotes_contrato.php';
require 'Class/Mutuales.php';
require 'Class/Nacionalidad.php';
require 'Class/Notificacion.php';
require 'Class/PagadoresSubsidio.php';
require 'Class/Permisos.php';
require 'Class/Prevision.php';
require 'Class/Provincias.php';
require 'Class/Regiones.php';
require 'Class/RepresentanteLegal.php';
require 'Class/ResumenFiniquito.php';
require 'Class/Tasa.php';
require 'Class/TipoContrato.php';
require 'Class/TipoDocumento.php';
require 'Class/TipoSueldo.php';
require 'Class/TrabajadorCargo.php';
require 'Class/TrabajadorContacto.php';
require 'Class/TrabajadorDomicilio.php';
require 'Class/Trabajadores.php';
require 'Class/TrabajadorRemuneracion.php';
require 'Class/Tramos.php';
require 'Class/Users.php';
require 'Class/Vacaciones.php';
require 'Class/DocumentoSubido.php';
require 'Class/Anexo.php';
require 'Class/Clausulaanexo.php';

//Class definition
class Controller
{
    private $host = "localhost";
    /*Variables*/
    private $user = "root";
    private $pass = "";
    private $bd = "gestordocumentos";


    /*Variables BD Remota
    private $user = 'kaiserte_admin';
    private $pass = 'Kaiser2022$';
    private $bd = 'kaiserte_gd';

    /**Variables globales */
    private $mi;
    private $v;
    //Conexion
    private function conexion()
    {
        $this->mi = new mysqli($this->host, $this->user, $this->pass, $this->bd);
        if ($this->mi->connect_errno) {
            echo "Error al conectar con la base de datos";
        }
    }

    //Desconexion
    private function desconectar()
    {
        $this->mi->close();
    }
    /*********************************************************************************** */
    /**Validations */
    //Escape String 
    public function escapeString($text)
    {
        $this->conexion();
        $text = $this->mi->real_escape_string($text);
        $this->desconectar();
        return $text;
    }

    //Convertir numero a letras
    public function convertirNumeroLetras($numero)
    {
        $this->conexion();
        $this->v = new CifrasEnLetras();
        $text = $this->v->convertirCifrasEnLetras($numero);
        $this->desconectar();
        return $text;
    }

    //Query
    public function query($sql)
    {
        $this->conexion();
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //validar usuario
    public function validarusuario($correo, $rut)
    {
        $this->conexion();
        $sql = "select * from users where email = '$correo' or rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        } else {
            $this->desconectar();
            return false;
        }
    }
    //validar usuario
    public function validarusuario1($correo, $rut, $id)
    {
        $this->conexion();
        $sql = "select * from users where (email = '$correo' or rut = '$rut') and id_usu != $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return json_encode(true);
        } else {
            $this->desconectar();
            return json_encode(false);
        }
    }

    //Login
    public function login($user, $pass)
    {
        $this->conexion();
        $sql = "select * from users where rut = '$user' or email = '$user' and password = sha1('$pass')";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id_usu'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update);
            $this->desconectar();
            return $user;
        }
        $this->desconectar();
        return null;
    }

    public function crearsesion($usuario, $token)
    {
        $this->conexion();
        $sql = "delete from sesionusuario where id_usu = $usuario";
        $result = $this->mi->query($sql);
        $sql = "insert into sesionusuario values(null, $usuario, '$token', now(), now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    public function validarsesion($usuario, $token)
    {
        $this->conexion();
        $sql = "select * from sesionusuario where id_usu = $usuario and token = '$token'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Validar Permiso de Usuario
    public function validarPermiso($usuario, $permiso)
    {
        $this->conexion();
        $sql = "select * from permisosusuarios where idusuario = $usuario and idpermiso = $permiso";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }



    //validarEmpresa
    public function validarEmpresa($rut)
    {
        $this->conexion();
        $sql = "select * from empresa where rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //AsignarUsuarioEmpresa
    public function asignarUsuarioEmpresa($idusuario, $idempresa)
    {
        $this->conexion();
        $sql = "insert into usuarioempresa values(null, $idusuario, $idempresa, 1)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //ValidarUsuarioEmpresa
    public function validarUsuarioEmpresa($idusuario, $idempresa)
    {
        $this->conexion();
        $sql = "select * from usuarioempresa where usuario = $idusuario and empresa = $idempresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }


    //Cambiar Estado Usuario Empresa
    public function cambiarEstadoUsuarioEmpresa($id, $estado)
    {
        $this->conexion();
        $sql = "update usuarioempresa set estado = $estado where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Empresa Usuario

    //Registar Comunas
    public function registrarcentrocosto($codigo, $codigoPrevired, $nombre, $region)
    {
        $this->conexion();
        $sql = "insert into centrocosto values (null, '$codigo', '$codigoPrevired', '$nombre', $region)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Function to Insert information in the database
    //Registrar Regiones
    public function registrarregiones($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into regiones values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registar Comunas
    public function registrarprovincias($codigo, $codigoPrevired, $nombre, $region)
    {
        $this->conexion();
        $sql = "insert into provincias values (null, '$codigo', '$codigoPrevired', '$nombre', $region)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registar Comunas
    public function registrarcomunas($codigo, $codigoPrevired, $nombre, $region, $provincia)
    {
        $this->conexion();
        $sql = "insert into comunas values (null, '$codigo', '$codigoPrevired', '$nombre', $region, $provincia)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Registrar Ciudades
    public function registrarciudad($codigo, $codigoPrevired, $nombre, $region)
    {
        $this->conexion();
        $sql = "insert into ciudades values (null, '$codigo', '$codigoPrevired', '$nombre', $region)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }



    //Registrar Nacionalidad
    public function registrarnacionalidad($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into nacionalidad values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Pagadored Subsidio
    public function registrarpagador($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into pagadoressubsidio values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Afp
    public function registrarafp($codigo, $codigoPrevired, $nombre, $tasa)
    {
        $this->conexion();
        $sql = "insert into afp values (null, '$codigo', '$codigoPrevired', '$nombre', '$tasa')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Isapre
    public function registrarisapre($codigo, $codigoPrevired, $nombre, $tipo)
    {
        $this->conexion();
        $sql = "insert into isapre values (null, '$codigo', '$codigoPrevired', '$nombre', $tipo)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Jornadas
    public function registrarjornada($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into jornadas values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tipo Sueldo
    public function registrartiposueldo($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into tiposueldo values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Cargos
    public function registrarcargo($codigo, $codigoPrevired, $nombre, $empresa)
    {
        $this->conexion();
        $sql = "insert into cargos values (null, '$codigo', '$codigoPrevired', '$nombre',$empresa)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Cajas Compensacion
    public function registrarcajacompensacion($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into cajascompensacion values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Mutuales
    public function registrarmutual($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into mutuales values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tramos Asignación Familiar
    public function registrartramos($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into tramosasignacionfamiliar values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tipo Contrato
    public function registrartipocontrato($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into tipocontrato values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Causal Termino Contrato
    public function registrarcausaltermino($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into causalterminocontrato values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tipo Documento
    public function registrartipodocumento($codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "insert into tipodocumento values (null, '$codigo', '$codigoPrevired', '$nombre')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Usuarios
    public function registrarusuario($rut, $nombre, $apellido, $correo, $direccion, $region, $comuna, $telefono, $pass)
    {
        $this->conexion();
        $sql = "insert into users values(null, '$rut', '$nombre', '$apellido', '$correo', '$direccion', $region, $comuna, '$telefono', sha1('$pass'), 1, sha1('$correo'), now(), now());";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Asignar Permiso a Usuario
    public function asignarPermisos($usuario, $permiso)
    {
        $this->conexion();
        $sql = "insert into permisosusuarios values(null, $usuario, $permiso)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Empresa
    public function RegistrarEmpresa($rut, $razonsocial, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasica, $cotizacionleysanna, $cotizacionadicional)
    {
        $this->conexion();
        $sql = "insert into empresa values(null, '$rut', '$razonsocial', '$Enterprisecalle','$Enterprisevilla','$Enterprisenumero', '$Enterprisedept', $region, $comuna, $ciudad, '$telefono', '$email','$giro', $cajascompensacion, $mutuales, $cotizacionbasica, $cotizacionleysanna, $cotizacionadicional,now(), now());";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //RegistrarCodigoActividad Empresa
    public function RegistrarCodigoActividadEmpresa($empresa, $codigoactividad)
    {
        $this->conexion();
        $sql = "insert into nubcodigoactividad values(null, $codigoactividad, $empresa)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Platilla
    function registrarplatilla($tipo, $contenido)
    {
        $this->conexion();
        $sql = "insert into plantillas values(null, $tipo, '$contenido', now());";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Buscar plantilla
    function buscarplantilla($tipo)
    {
        $this->conexion();
        $sql = "select * from plantillas where tipodocumento = $tipo";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            $contenido = $rs['contenido'];
            return $contenido;
        } else {
            $this->desconectar();
            return false;
        }
    }

    function actualizarplantilla($tipo, $contenido)
    {
        $this->conexion();
        $sql = "update plantillas set contenido = '$contenido' where tipodocumento = $tipo";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //ValidarCodigoActividad Empresa
    public function ValidarCodigoActividadEmpresa($empresa, $codigoactividad)
    {
        $this->conexion();
        $sql = "select * from nubcodigoactividad where empresa = $empresa and codigo = $codigoactividad";
        $result = $this->mi->query($sql);
        $this->desconectar();
        if ($rs = mysqli_fetch_array($result)) {
            return true;
        } else {
            return false;
        }
    }

    //Listar Codigo Actividad Empresa
    public function ListarCodigoActividadEmpresa($empresa)
    {
        $this->conexion();
        $sql = "select nubcodigoactividad.id as id, codigoactividad.codigosii as codigosii, codigoactividad.nombre as nombre from nubcodigoactividad, codigoactividad where nubcodigoactividad.codigo = codigoactividad.id and nubcodigoactividad.empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigosii = $rs['codigosii'];
            $nombre = $rs['nombre'];
            $cod  = new CodigoActividad($id, $codigosii, $nombre);
            $lista[] = $cod;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Codigo Actividad Empresa
    public function ListarCodigoActividadEmpresa1($empresa)
    {
        $this->conexion();
        $sql = "select nubcodigoactividad.codigo as id, codigoactividad.codigosii as codigosii, codigoactividad.nombre as nombre from nubcodigoactividad, codigoactividad where nubcodigoactividad.codigo = codigoactividad.id and nubcodigoactividad.empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigosii = $rs['codigosii'];
            $nombre = $rs['nombre'];
            $cod  = new CodigoActividad($id, $codigosii, $nombre);
            $lista[] = $cod;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar Codigo Actividad Empresa
    public function EliminarCodigoActividadEmpresa($id)
    {
        $this->conexion();
        $sql = "delete from nubcodigoactividad where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Representante Legal
    public function RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa)
    {
        $this->conexion();
        $sql = "insert into representantelegal values(null, '$rut', '$nombre', '$apellido1', '$apellido2', $empresa);";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Validar Representante Legal
    public function ValidarRepresentanteLegal($rut, $empresa)
    {
        $this->conexion();
        $sql = "select * from representantelegal where rut = '$rut' and empresa = $empresa";
        $result = $this->mi->query($sql);
        $this->desconectar();
        if ($rs = mysqli_fetch_array($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function listarRepresentantelegal($empresa)
    {
        $this->conexion();
        $sql = "select * from representantelegal where empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $rep = new RepresentanteLegal($id, $rut, $nombre, $apellido1, $apellido2, $empresa);
            $lista[] = $rep;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Representante Legal
    public function BuscarRepresentanteLegal1($id)
    {
        $this->conexion();
        $sql = "select * from representantelegal where empresa = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $empresa = $rs['empresa'];
            $rep = new RepresentanteLegal($id, $rut, $nombre, $apellido1, $apellido2, $empresa);
            $this->desconectar();
            return $rep;
        } else {
            $this->desconectar();
            return false;
        }
    }
    //Buscar Representante Legal
    public function BuscarRepresentanteLegal($id)
    {
        $this->conexion();
        $sql = "select * from representantelegal where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $empresa = $rs['empresa'];
            $rep = new RepresentanteLegal($id, $rut, $nombre, $apellido1, $apellido2, $empresa);
            $this->desconectar();
            return $rep;
        } else {
            $this->desconectar();
            return false;
        }
    }
    //Buscar Representante Legal por empresa
    public function BuscarRepresentanteLegalempresa($empresa)
    {
        $this->conexion();
        $sql = "select * from representantelegal where empresa = $empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $empresa = $rs['empresa'];
            $rep = new RepresentanteLegal($id, $rut, $nombre, $apellido1, $apellido2, $empresa);
            $this->desconectar();
            return $rep;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Eliminar Representante Legal
    public function EliminarRepresentanteLegal($id)
    {
        $this->conexion();
        $sql = "delete from representantelegal where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tasa AFP
    public function registrartasaafp($id, $periodo, $tasa)
    {
        $this->conexion();
        $sql = "insert into tasaafp values(null, $id, '$periodo', $tasa)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tasa mutual
    public function registrartasamutual($periodo, $tasabasica, $tasaleysanna)
    {
        $this->conexion();
        $sql = "insert into tasamutual values(null, '$periodo', $tasabasica, $tasaleysanna)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Tasa Caja Compensacion
    public function registrartasacaja($periodo, $tasa)
    {
        $this->conexion();
        $sql = "insert into tasacaja values(null, '$periodo', $tasa)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar Tasa AFP
    public function listartasaafp($idins)
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano, tasa from tasaafp where afp = $idins order by fecha desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $mes = "";
            if ($rs['mes'] == 1) {
                $mes = "Enero";
            } else if ($rs['mes'] == 2) {
                $mes = "Febrero";
            } else if ($rs['mes'] == 3) {
                $mes = "Marzo";
            } else if ($rs['mes'] == 4) {
                $mes = "Abril";
            } else if ($rs['mes'] == 5) {
                $mes = "Mayo";
            } else if ($rs['mes'] == 6) {
                $mes = "Junio";
            } else if ($rs['mes'] == 7) {
                $mes = "Julio";
            } else if ($rs['mes'] == 8) {
                $mes = "Agosto";
            } else if ($rs['mes'] == 9) {
                $mes = "Septiembre";
            } else if ($rs['mes'] == 10) {
                $mes = "Octubre";
            } else if ($rs['mes'] == 11) {
                $mes = "Noviembre";
            } else if ($rs['mes'] == 12) {
                $mes = "Diciembre";
            }
            $periodo = $mes . " " . $rs['ano'];
            $tasa = $rs['tasa'];
            $T = new Tasa($id, $idins, $periodo, $tasa);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tasa Mutual
    public function listartasamutual()
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano, tasabasica, tasaleysanna from tasamutual  order by fecha desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $mes = "";
            if ($rs['mes'] == 1) {
                $mes = "Enero";
            } else if ($rs['mes'] == 2) {
                $mes = "Febrero";
            } else if ($rs['mes'] == 3) {
                $mes = "Marzo";
            } else if ($rs['mes'] == 4) {
                $mes = "Abril";
            } else if ($rs['mes'] == 5) {
                $mes = "Mayo";
            } else if ($rs['mes'] == 6) {
                $mes = "Junio";
            } else if ($rs['mes'] == 7) {
                $mes = "Julio";
            } else if ($rs['mes'] == 8) {
                $mes = "Agosto";
            } else if ($rs['mes'] == 9) {
                $mes = "Septiembre";
            } else if ($rs['mes'] == 10) {
                $mes = "Octubre";
            } else if ($rs['mes'] == 11) {
                $mes = "Noviembre";
            } else if ($rs['mes'] == 12) {
                $mes = "Diciembre";
            }
            $periodo = $mes . " " . $rs['ano'];
            $tasabasica = $rs['tasabasica'];
            $tasaleysanna = $rs['tasaleysanna'];
            $T = new Tasa($id, $tasabasica, $periodo, $tasaleysanna);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Ultima Tasa Mutual
    public function ultimatasamutual()
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano, tasabasica, tasaleysanna from tasamutual  order by fecha desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $mes = "";
            if ($rs['mes'] == 1) {
                $mes = "Enero";
            } else if ($rs['mes'] == 2) {
                $mes = "Febrero";
            } else if ($rs['mes'] == 3) {
                $mes = "Marzo";
            } else if ($rs['mes'] == 4) {
                $mes = "Abril";
            } else if ($rs['mes'] == 5) {
                $mes = "Mayo";
            } else if ($rs['mes'] == 6) {
                $mes = "Junio";
            } else if ($rs['mes'] == 7) {
                $mes = "Julio";
            } else if ($rs['mes'] == 8) {
                $mes = "Agosto";
            } else if ($rs['mes'] == 9) {
                $mes = "Septiembre";
            } else if ($rs['mes'] == 10) {
                $mes = "Octubre";
            } else if ($rs['mes'] == 11) {
                $mes = "Noviembre";
            } else if ($rs['mes'] == 12) {
                $mes = "Diciembre";
            }
            $periodo = $mes . " " . $rs['ano'];
            $tasabasica = $rs['tasabasica'];
            $tasaleysanna = $rs['tasaleysanna'];
            $T = new Tasa($id, $tasabasica, $periodo, $tasaleysanna);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return null;
    }

    //Listar Tasa Caja Compensacion
    public function listartasacaja()
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano, tasa from tasacaja order by fecha desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $mes = "";
            if ($rs['mes'] == 1) {
                $mes = "Enero";
            } else if ($rs['mes'] == 2) {
                $mes = "Febrero";
            } else if ($rs['mes'] == 3) {
                $mes = "Marzo";
            } else if ($rs['mes'] == 4) {
                $mes = "Abril";
            } else if ($rs['mes'] == 5) {
                $mes = "Mayo";
            } else if ($rs['mes'] == 6) {
                $mes = "Junio";
            } else if ($rs['mes'] == 7) {
                $mes = "Julio";
            } else if ($rs['mes'] == 8) {
                $mes = "Agosto";
            } else if ($rs['mes'] == 9) {
                $mes = "Septiembre";
            } else if ($rs['mes'] == 10) {
                $mes = "Octubre";
            } else if ($rs['mes'] == 11) {
                $mes = "Noviembre";
            } else if ($rs['mes'] == 12) {
                $mes = "Diciembre";
            }
            $periodo = $mes . " " . $rs['ano'];
            $tasa = $rs['tasa'];
            $T = new Tasa($id, 1, $periodo, $tasa);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Validar Tasa AFP por año y mes
    public function validartasaafp($id, $periodo)
    {
        $this->conexion();
        $sql = "select * from tasaafp where afp = $id and month(fecha) = month('$periodo') and year(fecha) = year('$periodo')";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Validar Tasa Mutual por año y mes
    public function validartasamutual($periodo)
    {
        $this->conexion();
        $sql = "select * from tasamutual where  month(fecha) = month('$periodo') and year(fecha) = year('$periodo')";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Validar Tasa Caja por año y mes
    public function validartasacaja($periodo)
    {
        $this->conexion();
        $sql = "select * from tasacaja where  month(fecha) = month('$periodo') and year(fecha) = year('$periodo')";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }



    //Actualizar Tasa AFP
    public function actualizartasaafp($tasa, $idtasa)
    {
        $this->conexion();
        $sql = "update tasaafp set tasa = $tasa where id = $idtasa";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Tasa Mutual
    public function actualizartasamutual($tasa, $tasa2, $idtasa)
    {
        $this->conexion();
        $sql = "update tasamutual set tasabasica = $tasa, tasaleysanna= $tasa2 where id = $idtasa";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Tasa Caja
    public function actualizartasacaja($tasa, $idtasa)
    {
        $this->conexion();
        $sql = "update tasacaja set tasa = $tasa where id = $idtasa";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Buscar estado Civil
    public function buscarestadocivil($id){
        $this->conexion();
        $sql = "select * from estadocivil where id = $id";
        $result = $this->mi->query($sql);
        if($rs = mysqli_fetch_array($result)){
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $this->desconectar();
            $ec = new Banco($id, $nombre);
            return $ec;
        }
        $this->desconectar();
        return null;
    }

    //Registrar Trabajadores
    public function registrartrabajador($rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa)
    {
        $this->conexion();
        $sql = "insert into trabajadores values(null, '$rut', '$dni', '$nombre', '$apellido1', '$apellido2', '$nacimiento', $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Domicilio Trabajador
    public function registrardomicilio($calle, $villa, $numero, $depto, $region, $comuna, $ciudad, $trabajador)
    {
        $this->conexion();
        $sql = "insert into trabajadordomicilio values(null, '$calle','$villa', '$numero', '$depto', $region, $comuna, $ciudad, $trabajador,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Domicio Trabajador
    public function eliminardomicilio($id)
    {
        $this->conexion();
        $sql = "delete from trabajadordomicilio where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Contacto Trabajador
    public function registrarcontacto($telefono, $email, $trabajador)
    {
        $this->conexion();
        $sql = "insert into trabajadorcontacto values(null, '$telefono', '$email', $trabajador,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Contacto Trabajador
    public function eliminarcontacto($id)
    {
        $this->conexion();
        $sql = "delete from trabajadorcontacto where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Trabajador Cargo
    public function registrartrabajadorcargo($trabajador, $centrocosto, $cargo, $descripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas)
    {
        $this->conexion();
        $sql = "insert into trabajadorcargo values(null, $trabajador, $centrocosto, $cargo, '$descripcion', $tipocontrato, '$desde', '$hasta', $jornada, $horaspactadas,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Trabajador Cargo
    public function eliminartrabajadorcargo($id)
    {
        $this->conexion();
        $sql = "delete from trabajadorcargo where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Registrar Trabajador Remuneracion
    public function registrartrabajadorremuneracion($trabajador, $tiposueldo, $sueldo, $asignacion)
    {
        $this->conexion();
        $sql = "insert into trabajadorremuneracion values(null, $trabajador, $tiposueldo, $sueldo, $asignacion,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Trabajador Remuneracion
    public function eliminartrabajadorremuneracion($id)
    {
        $this->conexion();
        $sql = "delete from trabajadorremuneracion where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Validar Trabajador
    public function validartrabajador($rut, $empresa)
    {
        $this->conexion();
        $sql = "select * from trabajadores where rut = '$rut' and empresa = $empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Listar Trabajadores
    public function listartrabajadores($empresa)
    {
        $this->conexion();
        $sql = "select * from trabajadores where empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "register_at";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Trabajador por Rut
    public function buscartrabajadorbyRut($rut)
    {
        $this->conexion();
        $sql = "select * from trabajadores where rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "register_at";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }


    //Listar Trabajadores Activos
    public function listartrabajadoresactivos($empresa)
    {
        $this->conexion();
        $sql = "select distinct trabajadores.id as id, rut, dni, nombre, primerapellido,segundoapellido,fechanacimiento, fechainicio as fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension, trabajadores.empresa as empresa from trabajadores,contratos where trabajadores.id=contratos.trabajador and trabajadores.empresa = $empresa and estado=1 group by trabajadores.id;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Trabajadores Activos
    public function listartrabajadoresfiniquitados($empresa)
    {
        $this->conexion();
        $sql = "select distinct trabajadores.id as id, rut, dni, nombre, primerapellido,segundoapellido,fechanacimiento, fechainicio as fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension, trabajadores.empresa as empresa from trabajadores,finiquito where trabajadores.id=finiquito.trabajador and trabajadores.empresa = $empresa group by trabajadores.id;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Trabajadores Inactivos
    public function listartrabajadoresinactivos($empresa)
    {
        $this->conexion();
        $sql = "select distinct trabajadores.id as id, rut, dni, nombre, primerapellido,segundoapellido,fechanacimiento, fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension, trabajadores.empresa as empresa from trabajadores,contratos where trabajadores.id!=contratos.trabajador or (trabajadores.id=contratos.trabajador and contratos.estado=2) and trabajadores.empresa = $empresa;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Domicilio Trabajador
    public function listardomicilio($trabajador)
    {
        $this->conexion();
        $sql = "select * from trabajadordomicilio where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $depto = $rs['depto'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorDomicilio($id, $calle, $villa, $numero, $depto, $region, $comuna, $ciudad, $fecha);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar ultimo registro de domicilio
    public function ultimodomicilio($trabajador)
    {
        $this->conexion();
        $sql = "select * from trabajadordomicilio where trabajador = $trabajador order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $depto = $rs['depto'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorDomicilio($id, $calle, $villa, $numero, $depto, $region, $comuna, $ciudad, $fecha);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Buscar Ultimo Domicilio texto
    public function ultimodomiciliotexto($trabajador)
    {
        $this->conexion();
        $sql = "select trabajadordomicilio.id as id, calle,villa, numero, depto, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, trabajador, register_at from trabajadordomicilio, regiones, comunas, ciudades where trabajador = $trabajador and trabajadordomicilio.region = regiones.id and trabajadordomicilio.comuna = comunas.id and trabajadordomicilio.ciudad = ciudades.id order by trabajadordomicilio.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $depto = $rs['depto'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorDomicilio($id, $calle, $villa, $numero, $depto, $region, $comuna, $ciudad, $fecha);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }
    //Buscar domicilio
    public function buscardomicilio($id)
    {
        $this->conexion();
        $sql = "select * from trabajadordomicilio where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $depto = $rs['depto'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorDomicilio($id, $calle, $villa, $numero, $depto, $region, $comuna, $ciudad, $fecha);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Actualizar Domicilio
    public function actualizardomicilio($id, $calle, $villa, $numero, $depto, $region, $comuna, $ciudad)
    {
        $this->conexion();
        $sql = "update trabajadordomicilio set calle = '$calle', villa='$villa', numero = '$numero', depto = '$depto', region = '$region', comuna = '$comuna', ciudad = '$ciudad' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Contacto Trabajador
    public function listarcontacto($trabajador)
    {
        $this->conexion();
        $sql = "select * from trabajadorcontacto where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorContacto($id, $telefono, $email, $fecha);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar ultimo registro de contacto
    public function ultimocontacto($trabajador)
    {
        $this->conexion();
        $sql = "select * from trabajadorcontacto where trabajador = $trabajador order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorContacto($id, $telefono, $email, $fecha);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Buscar contacto
    public function buscarcontacto($id)
    {
        $this->conexion();
        $sql = "select * from trabajadorcontacto where id = $id order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $trabajador = $rs['trabajador'];
            $fecha = $rs['register_at'];
            $T = new TrabajadorContacto($id, $telefono, $email, $fecha);
            $this->desconectar();
            return $T;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Actualizar Contacto
    public function actualizarcontacto($id, $telefono, $email)
    {
        $this->conexion();
        $sql = "update trabajadorcontacto set telefono = '$telefono', email = '$email' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    /*   //Listar Trabajador Cargo
    public function listartrabajadorcargo($trabajador)
    {
        $this->conexion();
        $sql = "select trabajadorcargo.id as id, centrocosto.nombre as centrocosto, cargos.nombre as cargo, descripcion, tipocontrato.nombre as tipocontrato, desde, hasta, jornadas.nombre as jornada, horaspactadas,register_at from trabajadorcargo, centrocosto, cargos, tipocontrato, jornadas where trabajadorcargo.centrocosto = centrocosto.id and trabajadorcargo.cargo = cargos.id and trabajadorcargo.tipocontrato = tipocontrato.id and trabajadorcargo.jornada = jornadas.id and trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $descripcion = $rs['descripcion'];
            $tipocontrato = $rs['tipocontrato'];
            $desde = $rs['desde'];
            $hasta = $rs['hasta'];
            $jornada = $rs['jornada'];
            $horaspactadas = $rs['horaspactadas'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorCargo($id, $trabajador, $centrocosto, $cargo, $descripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas, $fecha);
            $lista[] = $t;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar ultimo registro de cargo
    public function ultimocargo($trabajador)
    {
        $this->conexion();
        $sql = "sselect trabajadorcargo.id as id, centrocosto.nombre as centrocosto, cargos.nombre as cargo, descripcion, tipocontrato.nombre as tipocontrato, desde, hasta, jornadas.nombre as jornada, horaspactadas,register_at from trabajadorcargo, centrocosto, cargos, tipocontrato, jornadas where trabajadorcargo.centrocosto = centrocosto.id and trabajadorcargo.cargo = cargos.id and trabajadorcargo.tipocontrato = tipocontrato.id and trabajadorcargo.jornada = jornadas.id and trabajador = $trabajador order by trabajadorcargo.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $descripcion = $rs['descripcion'];
            $tipocontrato = $rs['tipocontrato'];
            $desde = $rs['desde'];
            $hasta = $rs['hasta'];
            $jornada = $rs['jornada'];
            $horaspactadas = $rs['horaspactadas'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorCargo($id, $trabajador, $centrocosto, $cargo, $descripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas, $fecha);
            $this->desconectar();
            return $t;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Buscar cargo Trabajador
    public function buscartrabajadorcargo($id)
    {
        $this->conexion();
        $sql = "select * from trabajadorcargo where trabajadorcargo.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $descripcion = $rs['descripcion'];
            $tipocontrato = $rs['tipocontrato'];
            $desde = $rs['desde'];
            $hasta = $rs['hasta'];
            $jornada = $rs['jornada'];
            $horaspactadas = $rs['horaspactadas'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorCargo($id, $trabajador, $centrocosto, $cargo, $descripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas, $fecha);
            $this->desconectar();
            return $t;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Actualizar cargo Trabajador
    public function actualizartrabajadorcargo($id, $trabajador, $centrocosto, $cargo, $descripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas)
    {
        $this->conexion();
        $sql = "update trabajadorcargo set contrato = $trabajador, centrocosto = $centrocosto, cargo = $cargo, descripcion = '$descripcion', tipocontrato = $tipocontrato, desde = '$desde', hasta = '$hasta', jornada = $jornada, horaspactadas = $horaspactadas where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Trabajador Remuneraciones
    public function listartrabajadorremuneraciones($trabajador)
    {
        $this->conexion();
        $sql = "select trabajadorremuneracion.id as id, contrato, tiposueldobase.nombre as tiposueldo, sueldobase, zonaextrema, register_at from trabajadorremuneracion, tiposueldobase where trabajadorremuneracion.tiposueldobase = tiposueldobase.id and trabajador = $trabajador order by trabajadorremuneracion.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['contrato'];
            $tiposueldo = $rs['tiposueldo'];
            $sueldobase = $rs['sueldobase'];
            $zonaextrema = $rs['zonaextrema'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorRemuneracion($id, $trabajador, $tiposueldo, $sueldobase, $zonaextrema, $fecha);
            $lista[] = $t;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Ultima Remuneracion Trabajador
    public function buscarultimaremuneraciontrabajador($trabajador)
    {
        $this->conexion();
        $sql = "select trabajadorremuneracion.id as id, trabajador, tiposueldobase.nombre as tiposueldo, sueldobase, zonaextrema, register_at from trabajadorremuneracion, tiposueldobase where trabajadorremuneracion.tiposueldo = tiposueldobase.id and trabajador = $trabajador order by trabajadorremuneracion.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $tiposueldo = $rs['tiposueldo'];
            $sueldobase = $rs['sueldobase'];
            $zonaextrema = $rs['zonaextrema'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorRemuneracion($id, $trabajador, $tiposueldo, $sueldobase, $zonaextrema, $fecha);
            $this->desconectar();
            return $t;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Buscar Remuneracion Trabajador
    public function buscarremuneraciontrabajador($id)
    {
        $this->conexion();
        $sql = "select trabajadorremuneracion.id as id, trabajador, tiposueldobase.nombre as tiposueldo, sueldobase, zonaextrema, register_at from trabajadorremuneracion, tiposueldobase where trabajadorremuneracion.tiposueldo = tiposueldobase.id and trabajadorremuneracion.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $tiposueldo = $rs['tiposueldo'];
            $sueldobase = $rs['sueldobase'];
            $zonaextrema = $rs['zonaextrema'];
            $fecha = $rs['register_at'];
            $t = new TrabajadorRemuneracion($id, $trabajador, $tiposueldo, $sueldobase, $zonaextrema, $fecha);
            $this->desconectar();
            return $t;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Actualizar Remuneracion Trabajador
    public function actualizarremuneraciontrabajador($id, $trabajador, $tiposueldo, $sueldobase, $zonaextrema)
    {
        $this->conexion();
        $sql = "update trabajadorremuneracion set trabajador = $trabajador, tiposueldo = $tiposueldo, sueldobase = $sueldobase, zonaextrema = $zonaextrema where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }
*/

    //Actualizar Trabajadores
    public function actualizartrabajador($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension)
    {
        $this->conexion();
        $sql = "update trabajadores set rut = '$rut', dni = '$dni', nombre = '$nombre', primerapellido = '$apellido1', segundoapellido = '$apellido2', fechanacimiento = '$nacimiento', sexo = $sexo, estadocivil = $estadocivil, nacionalidad = $nacionalidad, discapacidad = $discapacidad, pension = $pension where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Buscar Trabajador
    public function buscartrabajador($id)
    {
        $this->conexion();
        $sql = "select * from trabajadores where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $fecha = $rs['register_at'];
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $fecha);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return false;
    }

    //BUscar trabajador text
    public function buscartrabajadortext($id)
    {
        $this->conexion();
        $sql = "select trabajadores.id as id, trabajadores.rut as rut, trabajadores.dni as dni, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, trabajadores.fechanacimiento as fechanacimiento, sexo.nombre as sexo, estadocivil.nombre as estadocivil, nacionalidad.nombre as nacionalidad, discapacidad.nombre as discapacidad, pension.nombre as pension, trabajadores.empresa as empresa, trabajadores.register_at as register_at from trabajadores, sexo, estadocivil, nacionalidad, discapacidad, pension where trabajadores.sexo = sexo.id and trabajadores.estadocivil = estadocivil.id and trabajadores.nacionalidad = nacionalidad.id and trabajadores.discapacidad = discapacidad.id and trabajadores.pension = pension.id and trabajadores.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $fecha = $rs['register_at'];
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $fecha);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return false;
    }

    //Buscar Trabajador por RUT y Empresa
    public function buscartrabajadorporrut($rut, $empresa)
    {
        $this->conexion();
        $sql = "select * from trabajadores where rut = '$rut' and empresa = $empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $fecha = $rs['register_at'];
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $fecha);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return false;
    }

    //Listar Comunas
    public function listarcentrocosto($id)
    {
        $this->conexion();
        $sql = "select * from centrocosto where empresa = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $centro = new CentroCosto($id, $codigo, $codigoPrevired, $nombre, $id);
            $lista[] = $centro;
        }
        $this->desconectar();
        return $lista;
    }



    /********************************************************************************** */
    //Function to get information from the database
    //Listar Regiones
    public function listarregiones()
    {
        $this->conexion();
        $sql = "select * from regiones";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $region = new Regiones($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $region;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Comunas
    public function listarprovincias($id)
    {
        $this->conexion();
        $sql = "select * from provincias where region = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $comuna = new Provincias($id, $codigo, $codigoPrevired, $nombre, $id);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Comunas
    public function listarcomunas($id)
    {
        $this->conexion();
        $sql = "select * from comunas where region = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $nombre, $id, $provincia);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Comunas
    public function listartodaslascomunas()
    {
        $this->conexion();
        $sql = "select * from comunas;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $nombre, $id, $provincia);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Comunas
    public function listarcomunas2($id)
    {
        $this->conexion();
        $sql = "select * from comunas where provincia = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $nombre, $id, $provincia);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Comunas
    public function listarcomunas1($id)
    {
        $this->conexion();
        $sql = "select comunas.id as id, comunas.codigo as codigo, comunas.codigoprevired as codigoprevired, comunas.nombre as nombre , provincias.nombre as provincia from comunas, provincias where comunas.provincia = provincias.id and comunas.region = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $nombre, $id, $provincia);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Ciudades
    public function listarciudades($id)
    {
        $this->conexion();
        $sql = "select * from ciudades where region = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $ciudad = new Ciudades($id, $codigo, $codigoPrevired, $nombre, $id);
            $lista[] = $ciudad;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Ciudades
    public function listarnacionalidad()
    {
        $this->conexion();
        $sql = "select * from nacionalidad";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $ciudad = new Nacionalidad($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $ciudad;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Pagadores Subsidio
    public function listarpagadores()
    {
        $this->conexion();
        $sql = "select * from pagadoressubsidio";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $pagador = new PagadoresSubsidio($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $pagador;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Ciudades
    public function listarestadocivil()
    {
        $this->conexion();
        $sql = "select * from estadocivil";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $ciudad = new Nacionalidad($id, $id, $id, $nombre);
            $lista[] = $ciudad;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Afp
    public function listarafp()
    {
        $this->conexion();
        $sql = "select * from afp";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tasa = $rs['tasa'];
            $afp = new AFP($id, $codigo, $codigoPrevired, $nombre, $tasa);
            $lista[] = $afp;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Isapre
    public function listarisapre()
    {
        $this->conexion();
        $sql = "select * from isapre";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipo = $rs['tipo'];
            $isapre = new ISAPRES($id, $codigo, $codigoPrevired, $nombre, $tipo);
            $lista[] = $isapre;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Isapre
    public function listarisapre1()
    {
        $this->conexion();
        $sql = "select isapre.id as id, codigo, codigoprevired, isapre.nombre as nombre, tipoisapre.nombre as tipo from isapre, tipoisapre where isapre.tipo = tipoisapre.id;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipo = $rs['tipo'];
            $isapre = new ISAPRES($id, $codigo, $codigoPrevired, $nombre, $tipo);
            $lista[] = $isapre;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Jornada
    public function listarjornada()
    {
        $this->conexion();
        $sql = "select * from jornadas";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipojornada = new Jornadas($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tipojornada;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tipo Sueldo
    public function listartiposueldo()
    {
        $this->conexion();
        $sql = "select * from tiposueldo";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tiposueldo = new TipoSueldo($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tiposueldo;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Cargos
    public function listarcargos($empresa)
    {
        $this->conexion();
        $sql = "select * from cargos where empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $cargo = new Cargos($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $cargo;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Cajas Compensacion
    public function listarcajascompensacion()
    {
        $this->conexion();
        $sql = "select * from cajascompensacion";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $caja = new Cajacompensacion($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $caja;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Mutuales
    public function listarmutuales()
    {
        $this->conexion();
        $sql = "select * from mutuales";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $mutual = new Mutuales($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $mutual;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tramos Asignación Familiar
    public function listartramosasignacionfamiliar()
    {
        $this->conexion();
        $sql = "select * from tramosasignacionfamiliar";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tramo = new Tramos($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tramo;
        }
        $this->desconectar();
        return $lista;
    }

    //listar tipo carga
    public function listartipocausante()
    {
        $this->conexion();
        $sql = "select * from tipocausante;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['id'];
            $codigoPrevired = $rs['id'];
            $nombre = $rs['nombre'];
            $tipocarga = new Tramos($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tipocarga;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tipo Contrato
    public function listartipocontrato()
    {
        $this->conexion();
        $sql = "select * from tipocontrato";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipocontrato = new TipoContrato($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tipocontrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Causal Terminación Contrato
    public function listarcausalterminacioncontrato()
    {
        $this->conexion();
        $sql = "select * from causalterminocontrato";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $causal = new CausalTermino($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $causal;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tipo Documento
    public function listartipodocumento()
    {
        $this->conexion();
        $sql = "select * from tipodocumento";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipodocumento = new TipoDocumento($id, $codigo, $codigoPrevired, $nombre);
            $lista[] = $tipodocumento;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Usuarios
    public function listarusuarios()
    {
        $this->conexion();
        $sql = "select * from users";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id_usu'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update);
            $lista[] = $user;
        }
        $this->desconectar();
        return $lista;
    }

    //Permisos
    public function listarPermisos()
    {
        $this->conexion();
        $sql = "select * from permisos";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $descripcion = $rs['descripcion'];
            $permiso = new Permisos($id, $nombre, $descripcion);
            $lista[] = $permiso;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Permisos de Usuario
    public function listarPermisosUsuario($usuario)
    {
        $this->conexion();
        $sql = "select permisosusuarios.id as id, nombre from permisosusuarios,permisos where permisosusuarios.idpermiso = permisos.id and idusuario = $usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $permiso = $rs['nombre'];
            $permisoUsuario = new Permisos($id, $permiso, $usuario);
            $lista[] = $permisoUsuario;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Permisos de Usuario
    public function listarPermisosUsuario1($usuario)
    {
        $this->conexion();
        $sql = "select permisos.id as id, nombre from permisosusuarios,permisos where permisosusuarios.idpermiso = permisos.id and idusuario = $usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $permiso = $rs['nombre'];
            $permisoUsuario = new Permisos($id, $permiso, $usuario);
            $lista[] = $permisoUsuario;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Empresas
    public function listarEmpresas()
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email, giro, cajascompensacion.nombre as cajascompensacion, mutuales.nombre as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $lista[] = $empresa;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Planes
    public function listarplanes()
    {
        $this->conexion();
        $sql = "select * from plan";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result))
        {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $plan = new Banco($id, $nombre);
            $lista[] = $plan;
        }
        $this->desconectar();
        return $lista;
    }

    //Asignar plan a empresa
    public function asignarplan($empresa, $plan)
    {
        $this->conexion();
        $sql = "insert into planempresa (plan,empresa) values ($plan,$empresa)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar plan a empresa
    public function actualizarplan($empresa, $plan)
    {
        $this->conexion();
        $sql = "update planempresa set plan = $plan where empresa = $empresa";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar plan empresa
    public function buscarplanempresa($empresa)
    {
        $this->conexion();
        $sql = "select plan from planempresa where empresa = $empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result))
        {
            $id = $rs['plan'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return null;
    }       

    public function listarCodigoActividad()
    {
        $this->conexion();
        $sql = "select * from codigoactividad";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigosii'];
            $descripcion = $rs['nombre'];
            $codigoactividad = new CodigoActividad($id, $codigo, $descripcion);
            $lista[] = $codigoactividad;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar codigo actividad
    public function buscarCodigoActividad($id)
    {
        $this->conexion();
        $sql = "select * from codigoactividad where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigosii'];
            $descripcion = $rs['nombre'];
            $codigoactividad = new CodigoActividad($id, $codigo, $descripcion);
            $this->desconectar();
            return $codigoactividad;
        }
        $this->desconectar();
        return null;
    }
    //Actualizar Comuna
    public function actualizarcentrocosto($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update centrocosto set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    /****************************************************************************** */
    //Update Information in Database
    //Actualizar Region
    public function actualizarregion($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update regiones set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Provincia
    public function actualizarprovincia($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update provincias set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Comuna
    public function actualizarcomuna($id, $codigo, $codigoPrevired, $nombre, $provincia)
    {
        $this->conexion();
        $sql = "update comunas set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre', provincia=$provincia where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Ciudades
    public function actualizarciudad($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update ciudades set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Nacionalidad
    public function actualizarnacionalidad($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update nacionalidad set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Pagadores Subsidio
    public function actualizarpagadoresubsidio($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update pagadoressubsidio set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }
    //Actualizar AFP
    public function actualizarafp($id, $codigo, $codigoPrevired, $nombre, $tasa)
    {
        $this->conexion();
        $sql = "update afp set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre', tasa='$tasa' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar isapre
    public function actualizarisapre($id, $codigo, $codigoPrevired, $nombre, $tipo)
    {
        $this->conexion();
        $sql = "update isapre set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre', tipo=$tipo where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }


    //Actualizar Jornada
    public function actualizarjornada($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update jornadas set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar tipo Sueldo
    public function actualizartiposueldo($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update tiposueldo set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Cargo
    public function actualizarcargo($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update cargos set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Caja Compensacion
    public function actualizarcajacompensacion($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update cajascompensacion set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Mutual
    public function actualizarmutual($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update mutuales set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Tramos Asignacion Familiar
    public function actualizartromosasignacionfamiliar($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update tramosasignacionfamiliar set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Tipo Contrato
    public function actualizartipocontrato($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update tipocontrato set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Causal Termino Contrato
    public function actualizarcausalterminocontrato($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update causalterminocontrato set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar tipo Documento
    public function actualizartipodocumento($id, $codigo, $codigoPrevired, $nombre)
    {
        $this->conexion();
        $sql = "update tipodocumento set codigo='$codigo', codigoprevired='$codigoPrevired', nombre='$nombre' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Usuario
    public function actualizarusuario($id, $rut, $nombre, $apellido, $correo, $direccion, $region, $comuna, $telefono)
    {
        $this->conexion();
        $sql = "update users set rut = '$rut', nombre = '$nombre', apellidos = '$apellido', email = '$correo', direccion = '$direccion', region = $region, comuna = $comuna, telefono = '$telefono', updated_at = now() where id_usu = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Estado
    public function actualizarestado($id, $estado)
    {
        $this->conexion();
        $sql = "update users set estado = $estado where id_usu = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Contraseña
    public function actualizarpass($id, $pass)
    {
        $this->conexion();
        $sql = "update users set password = '$pass' where id_usu = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Actualizar Empresa
    public function actualizarEmpresa($id, $rut, $razonsocial, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasica, $cotizacionleysanna, $cotizacionadicional)
    {
        $this->conexion();
        $sql = "update empresa set rut = '$rut', razonsocial = '$razonsocial', calle = '$Enterprisecalle', villa='$Enterprisevilla',numero = '$Enterprisenumero', dept= '$Enterprisedept', region = $region, comuna = $comuna, ciudad = $ciudad, telefono = '$telefono', email = '$email', giro='$giro', cajascompensacion = $cajascompensacion, mutuales = $mutuales, cotizacionbasica = $cotizacionbasica, cotizacionleysanna = $cotizacionleysanna, cotizacionadicional = $cotizacionadicional, updated_at = now() where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Comunas
    public function eliminarcentrocosto($id)
    {
        $this->conexion();
        $sql = "delete from centrocosto where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    /****************************************************************************** */
    //Delete Information in Database
    //Eliminar Regiones
    public function eliminarregion($id)
    {
        $this->conexion();
        $sql = "delete from regiones where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Comunas
    public function eliminarprovincia($id)
    {
        $this->conexion();
        //Verificar si existe en la tabla de trabajadores
        $sql = "select * from trabajadordomicilio where region = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        $sql = "delete from provincias where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Comunas
    public function eliminarcomuna($id)
    {
        $this->conexion();
        //Verificar si existe en la tabla de trabajadores
        $sql = "select * from trabajadordomicilio where comuna = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        //Verificar si existe en la tabla de empresas
        $sql = "select * from empresa where comuna = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        //Verificar si existe en la tabla de usuarios
        $sql = "select * from users where comuna = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }

        $sql = "delete from comunas where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Ciudad
    public function eliminarciudad($id)
    {
        $this->conexion();
        $sql = "delete from ciudades where id = $id";
        //Verificar si existe en la tabla de trabajadores
        $sql = "select * from trabajadordomicilio where ciudad = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Eliminar Nacionalidad
    public function eliminarnacionalidad($id)
    {
        $this->conexion();
        $sql = "delete from nacionalidad where id = $id";
        //Verificar si existe en la tabla de trabajadores
        $sql = "select * from trabajadores where nacionalidad = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Pagadores Subsidio
    public function eliminarpagadoresubsidio($id)
    {
        $this->conexion();
        $sql = "delete from pagadoressubsidio where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar AFP
    public function eliminarafp($id)
    {
        $this->conexion();
        //Validar si existe en la tabla de previsiontrabajador
        $sql = "select * from previsiontrabajador where afp = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        $sql = "delete from afp where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Isapre
    public function eliminarisapre($id)
    {
        $this->conexion();
        //Validar si existe en la tabla de previsiontrabajador
        $sql = "select * from previsiontrabajador where isapre = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }

        $sql = "delete from isapre where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Jornadas
    public function eliminarjornadas($id)
    {
        $this->conexion();
        $sql = "delete from jornadas where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Tipo Sueldo
    public function eliminartiposueldo($id)
    {
        $this->conexion();
        $sql = "delete from tiposueldo where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Cargos
    public function eliminarcargo($id)
    {
        $this->conexion();
        $sql = "delete from cargos where id = $id";

        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Cajas Compensacion
    public function eliminarcaja($id)
    {
        $this->conexion();
        $sql = "delete from cajascompensacion where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Mutual
    public function eliminarmutual($id)
    {
        $this->conexion();
        $sql = "delete from mutuales where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Tramos Asignacion Familiar
    public function eliminartromasignacionfamiliar($id)
    {
        $this->conexion();
        $sql = "delete from tramosasignacionfamiliar where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Tipo Contrato
    public function eliminartipocontrato($id)
    {
        $this->conexion();
        $sql = "delete from tipocontrato where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Causal Termino Contrato
    public function eliminarcausalterminocontrato($id)
    {   
        //Verificar si existe en la tabla de finiquitos o notificaciones
        $this->conexion();
        $sql = "select * from finiquito where causalterminocontrato = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }
        $sql = "select * from notificaciones where causalterminocontrato = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return false;
        }

        $sql = "delete from causalterminocontrato where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    

    //Eliminar Tipo Documento
    public function eliminartipodocumento($id)
    {
        $this->conexion();
        $sql = "delete from tipodocumento where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Usuario
    public function eliminarusuario($id)
    {
        $this->conexion();
        $sql = "delete from users where id_usu = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Permiso de Usuario
    public function eliminarPermisoUsuario($id)
    {
        $this->conexion();
        $sql = "delete from permisosusuarios where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    ///Eliminar Todos los Permisos de Usuario
    public function eliminarPermisoUsuario1($id)
    {
        $this->conexion();
        $sql = "delete from permisosusuarios where idusuario = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Empresa
    public function eliminarEmpresa($id)
    {
        $this->conexion();
        $sql = "delete from empresa where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }




    /****************************************************************************** */
    //Search Information in Database
    //Buscar Region
    public function buscarregion($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM regiones WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $region = new Regiones($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $region;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar provincia
    public function buscarprovincia($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM provincias WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $comuna = new Provincias($id, $codigo, $codigoprevired, $nombre, $region);
            $this->desconectar();
            return $comuna;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Comuna
    public function buscarcomuna($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM comunas WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoprevired, $nombre, $region, $provincia);
            $this->desconectar();
            return $comuna;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Comuna
    public function buscarcentrcosto($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM centrocosto WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $empresa = $rs['empresa'];
            $centrocosto = new CentroCosto($id, $codigo, $codigoprevired, $nombre, $empresa);
            $this->desconectar();
            return $centrocosto;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Comuna
    public function buscarnacionalidad($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM nacionalidad WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $comuna = new Nacionalidad($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $comuna;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Pagadores Subsidio
    public function buscarpagadoresubsidio($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM pagadoressubsidio WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $comuna = new PagadoresSubsidio($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $comuna;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar afp
    public function buscarafp($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM afp WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tasa = $rs['tasa'];
            $afp = new Afp($id, $codigo, $codigoprevired, $nombre, $tasa);
            $this->desconectar();
            return $afp;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Isapre
    public function buscarisapre($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM isapre WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipo = $rs['tipo'];
            $isapre = new Isapres($id, $codigo, $codigoprevired, $nombre, $tipo);
            $this->desconectar();
            return $isapre;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Jornada
    public function buscarjornada($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM jornadas WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $jornada = new Jornadas($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $jornada;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Tipo Sueldo
    public function buscartiposueldo($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM tiposueldo WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tiposueldo = new Tiposueldo($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $tiposueldo;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar cargos
    public function buscarcargo($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM cargos WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $cargo = new Cargos($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $cargo;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar cajascompensacion
    public function buscarcaja($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM cajascompensacion WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $caja = new Cajacompensacion($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $caja;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Mutual
    public function buscarmutual($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM mutuales WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipomutual = new Mutuales($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $tipomutual;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Tramos Asignacion Familiar
    public function buscartramosasignacionfamiliar($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM tramosasignacionfamiliar WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tramosasignacionfamiliar = new Tramos($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $tramosasignacionfamiliar;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Tipo Contrato
    public function buscartipocontrato($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM tipocontrato WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipocontrato = new Tipocontrato($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $tipocontrato;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Causal Terminacion Contrato
    public function buscarcausalterminacioncontrato($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM causalterminocontrato WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $causal = new CausalTermino($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $causal;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Tipo Documento
    public function buscartipodocumento($id)
    {
        $this->conexion();
        $sql = "SELECT * FROM tipodocumento WHERE id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $tipodocumento = new TipoDocumento($id, $codigo, $codigoprevired, $nombre);
            $this->desconectar();
            return $tipodocumento;
        } else {
            $this->desconectar();
            return null;
        }
    }

    //Buscar Usuario
    public function getuser($id)
    {
        $this->conexion();
        $sql = "select * from users where id_usu = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id_usu'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update);
            $this->desconectar();
            return $user;
        }
        $this->desconectar();
        return null;
    }

    //Buscar Empresa
    public function buscarEmpresa($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, cajascompensacion.nombre as cajascompensacion, mutuales.nombre as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and empresa.id = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }



    //Buscar Empresa
    public function buscarEmpresavalor($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.id as region, comunas.id as comuna, ciudades.id as ciudad, telefono, email,giro, cajascompensacion.id as cajascompensacion, mutuales.id as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and empresa.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }

    
    //Buscar Empresa
    public function buscarEmpresavalor1($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.id as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, cajascompensacion.nombre as cajascompensacion, mutuales.id as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and empresa.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }

    //Buscar Empresa
    public function buscarEmpresavalor2($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, cajascompensacion.nombre as cajascompensacion, mutuales.nombre as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and empresa.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }
    //Buscar Empresa Usuario
    public function buscarEmpresausuario($id)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle, villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, cajascompensacion.nombre as cajascompensacion, mutuales.nombre as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales, usuarioempresa where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and usuarioempresa.empresa = empresa.id and usuarioempresa.usuario = $id and usuarioempresa.estado = 1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $lista[] = $empresa;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Empresa
    public function buscarEmpresa1($id)
    {
        $this->conexion();
        $sql = "select * from empresa where id = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }

    //Buscar Empresa por RUT
    public function buscarEmpresaporRUT($rut)
    {
        $this->conexion();
        $sql = "select empresa.id as id, rut, razonsocial, calle,villa, numero, dept, regiones.nombre as region, comunas.nombre as comuna, ciudades.nombre as ciudad, telefono, email,giro, cajascompensacion.nombre as cajascompensacion, mutuales.nombre as mutuales, cotizacionbasica, cotizacionleysanna, cotizacionadicional, created_at, updated_at from empresa, regiones, comunas, ciudades, cajascompensacion, mutuales where empresa.region = regiones.id and empresa.comuna = comunas.id and empresa.ciudad = ciudades.id and empresa.cajascompensacion = cajascompensacion.id and empresa.mutuales = mutuales.id and empresa.rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $razonsocial = $rs['razonsocial'];
            $calle = $rs['calle'];
            $villa = $rs['villa'];
            $numero = $rs['numero'];
            $dept = $rs['dept'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $ciudad = $rs['ciudad'];
            $telefono = $rs['telefono'];
            $email = $rs['email'];
            $giro = $rs['giro'];
            $cajascompensacion = $rs['cajascompensacion'];
            $mutuales = $rs['mutuales'];
            $cotizacionbasico = $rs['cotizacionbasica'];
            $cotizacionleysanna = $rs['cotizacionleysanna'];
            $cotizacionadicional = $rs['cotizacionadicional'];
            $created_at = $rs['created_at'];
            $updated_at = $rs['updated_at'];
            $empresa = new Empresa($id, $rut, $razonsocial, $calle, $villa, $numero, $dept, $region, $comuna, $ciudad, $telefono, $email, $giro, $cajascompensacion, $mutuales, $cotizacionbasico, $cotizacionleysanna, $cotizacionadicional, $created_at, $updated_at);
            $this->desconectar();
            return $empresa;
        }
        $this->desconectar();
        return null;
    }

    //Buscar Usuario texto
    public function getuser1($id)
    {
        $this->conexion();
        $sql = "select id_usu,rut, users.nombre as nombre, apellidos, email, direccion, regiones.nombre as region, comunas.nombre as comuna, telefono, password, status.nombre as estado, token, created_at, updated_at from users, regiones, comunas, status where regiones.id = users.region and comunas.id = users.comuna and status.id = users.estado and users.id_usu = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id_usu'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update);
            $this->desconectar();
            return $user;
        }
        $this->desconectar();
        return null;
    }

    //Listar Usuario empresa
    public function listarusuarioempresa($empresa)
    {
        $this->conexion();
        $sql = "select usuarioempresa.id as id_usu ,rut, users.nombre as nombre, apellidos, email, direccion, regiones.nombre as region, comunas.nombre as comuna, telefono, password, usuarioempresa.estado as estado, token, created_at, updated_at from users, regiones, comunas,usuarioempresa where regiones.id = users.region and comunas.id = users.comuna  and usuarioempresa.usuario = users.id_usu and usuarioempresa.empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id_usu'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update);
            $lista[] = $user;
        }
        $this->desconectar();
        return $lista;
    }

    //Registrar Movimiento en el sistema
    public function RegistrarAuditoriaEventos($usuario, $evento)
    {
        $this->conexion();
        $sql = "insert into AuditoriaEventos values (null, $usuario, '$evento', now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Movimiento en el sistema
    public function listarAuditoriaEventos()
    {
        $this->conexion();
        $sql = "select AuditoriaEventos.id as id, rut, users.nombre as nombre, apellidos, email, direccion, regiones.nombre as region, comunas.nombre as comuna, telefono, password, status.nombre as estado, token, created_at, updated_at, AuditoriaEventos.evento as evento, AuditoriaEventos.fecha as fecha from users, regiones, comunas, status, AuditoriaEventos where regiones.id = users.region and comunas.id = users.comuna and status.id = users.estado and AuditoriaEventos.idusuario = users.id_usu";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombre'];
            $apellidos = $rs['apellidos'];
            $email = $rs['email'];
            $direccion = $rs['direccion'];
            $region = $rs['region'];
            $comuna = $rs['comuna'];
            $telefono = $rs['telefono'];
            $pass = $rs['password'];
            $estado = $rs['estado'];
            $token = $rs['token'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $evento = $rs['evento'];
            $fecha = $rs['fecha'];
            $user = new Auditoria($id, $nombre . " " . $apellidos, $fecha, $evento);
            $lista[] = $user;
        }
        $this->desconectar();
        return $lista;
    }

    public function insertarprevision($periodo, $TrabajadorAFP, $jubilado, $cesantia, $seguro, $periodocesantia, $TrabajadorIsapre, $TrabajadorMonedaPacto, $TrabajadorMonto, $TrabajadorTipoGes, $TrabajadorGes, $TrabajadorId, $comentario, $documentoafp, $documentosalud, $documentojubilacion)
    {
        $this->conexion();
        $sql = "insert into previsiontrabajador values (null,$TrabajadorId, '$periodo', $TrabajadorAFP, $jubilado,$cesantia, $seguro, '$periodocesantia', $TrabajadorIsapre, $TrabajadorMonedaPacto, $TrabajadorMonto, $TrabajadorTipoGes, $TrabajadorGes, '$comentario', '$documentoafp', '$documentosalud', '$documentojubilacion')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar prevision
    public function eliminarprevision($id)
    {
        $this->conexion();
        $sql = "delete from previsiontrabajador where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    public function listarprevision($trabajador)
    {
        $this->conexion();
        $sql = "select previsiontrabajador.id as id, trabajador, month(periodo) as mes, year(periodo) as anio, afp.nombre as afp, jubilado.nombre jubilado, cesantia.nombre as cesantia, accidente.nombre as seguro, fechacesantiainicio as periodocesantia, isapre.nombre as isapre, planpactado, valorplanpactado, ges, valorges,comentario,documentoafp, documentosalud, documentojubilacion from previsiontrabajador, jubilado, cesantia, accidente, isapre, tipomoneda,afp where previsiontrabajador.jubilado = jubilado.id and previsiontrabajador.cesantia = cesantia.id and previsiontrabajador.accidente = accidente.id and previsiontrabajador.isapre = isapre.id and previsiontrabajador.ges = tipomoneda.id and afp.id=previsiontrabajador.afp and trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $mes = $rs['mes'];
            if ($mes == 1) {
                $mes = "Enero";
            } else if ($mes == 2) {
                $mes = "Febrero";
            } else if ($mes == 3) {
                $mes = "Marzo";
            } else if ($mes == 4) {
                $mes = "Abril";
            } else if ($mes == 5) {
                $mes = "Mayo";
            } else if ($mes == 6) {
                $mes = "Junio";
            } else if ($mes == 7) {
                $mes = "Julio";
            } else if ($mes == 8) {
                $mes = "Agosto";
            } else if ($mes == 9) {
                $mes = "Septiembre";
            } else if ($mes == 10) {
                $mes = "Octubre";
            } else if ($mes == 11) {
                $mes = "Noviembre";
            } else if ($mes == 12) {
                $mes = "Diciembre";
            }
            $anio = $rs['anio'];
            $afp = $rs['afp'];
            $jubilado = $rs['jubilado'];
            $cesantia = $rs['cesantia'];
            $seguro = $rs['seguro'];
            $periodocesantia = $rs['periodocesantia'];
            $isapre = $rs['isapre'];
            $planpactado = $rs['planpactado'];
            $valorplanpactado = $rs['valorplanpactado'];
            $ges = $rs['ges'];
            $valorges = $rs['valorges'];
            $comentario = $rs['comentario'];
            $documentoafp = $rs['documentoafp'];
            $documentosalud = $rs['documentosalud'];
            $documentojubilacion = $rs['documentojubilacion'];
            $prevision = new Prevision($id, $trabajador, $mes . " " . $anio, $afp, $jubilado, $cesantia, $seguro, $periodocesantia, $isapre, $planpactado, $valorplanpactado, $ges, $valorges, $comentario, $documentoafp, $documentosalud, $documentojubilacion);
            $lista[] = $prevision;
        }
        $this->desconectar();
        return $lista;
    }

    //Ultima prevision del trabajador
    public function ultimaprevision($trabajador)
    {
        $this->conexion();
        $sql = "select previsiontrabajador.id as id, trabajador, month(periodo) as mes, year(periodo) as anio, afp.nombre as afp, jubilado.nombre jubilado, cesantia.nombre as cesantia, accidente.nombre as seguro, fechacesantiainicio as periodocesantia, isapre.nombre as isapre, planpactado, valorplanpactado, ges, valorges,comentario,documentoafp, documentosalud, documentojubilacion from previsiontrabajador, jubilado, cesantia, accidente, isapre, tipomoneda,afp where previsiontrabajador.jubilado = jubilado.id and previsiontrabajador.cesantia = cesantia.id and previsiontrabajador.accidente = accidente.id and previsiontrabajador.isapre = isapre.id and previsiontrabajador.ges = tipomoneda.id and afp.id=previsiontrabajador.afp and trabajador = $trabajador order by periodo desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $mes = $rs['mes'];
            if ($mes == 1) {
                $mes = "Enero";
            } else if ($mes == 2) {
                $mes = "Febrero";
            } else if ($mes == 3) {
                $mes = "Marzo";
            } else if ($mes == 4) {
                $mes = "Abril";
            } else if ($mes == 5) {
                $mes = "Mayo";
            } else if ($mes == 6) {
                $mes = "Junio";
            } else if ($mes == 7) {
                $mes = "Julio";
            } else if ($mes == 8) {
                $mes = "Agosto";
            } else if ($mes == 9) {
                $mes = "Septiembre";
            } else if ($mes == 10) {
                $mes = "Octubre";
            } else if ($mes == 11) {
                $mes = "Noviembre";
            } else if ($mes == 12) {
                $mes = "Diciembre";
            }
            $anio = $rs['anio'];
            $afp = $rs['afp'];
            $jubilado = $rs['jubilado'];
            $cesantia = $rs['cesantia'];
            $seguro = $rs['seguro'];
            $periodocesantia = $rs['periodocesantia'];
            $isapre = $rs['isapre'];
            $planpactado = $rs['planpactado'];
            $valorplanpactado = $rs['valorplanpactado'];
            $ges = $rs['ges'];
            $valorges = $rs['valorges'];
            $comentario = $rs['comentario'];
            $documentoafp = $rs['documentoafp'];
            $documentosalud = $rs['documentosalud'];
            $documentojubilacion = $rs['documentojubilacion'];
            $prevision = new Prevision($id, $trabajador, $mes . " " . $anio, $afp, $jubilado, $cesantia, $seguro, $periodocesantia, $isapre, $planpactado, $valorplanpactado, $ges, $valorges, $comentario, $documentoafp, $documentosalud, $documentojubilacion);
            $this->desconectar();
            return $prevision;
        }
        $this->desconectar();
        return false;
    }

    //Buscar prevision
    public function buscarprevision($id)
    {
        $this->conexion();
        $sql = "select * from previsiontrabajador where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $periodo = $rs['periodo'];
            $afp = $rs['afp'];
            $jubilado = $rs['jubilado'];
            $cesantia = $rs['cesantia'];
            $seguro = $rs['accidente'];
            $periodocesantia = $rs['fechacesantiainicio'];
            $isapre = $rs['isapre'];
            $planpactado = $rs['planpactado'];
            $valorplanpactado = $rs['valorplanpactado'];
            $ges = $rs['ges'];
            $valorges = $rs['valorges'];
            $comentario = $rs['comentario'];
            $documentoafp = $rs['documentoafp'];
            $documentosalud = $rs['documentosalud'];
            $documentojubilacion = $rs['documentojubilacion'];
            $prevision = new Prevision($id, $trabajador, $periodo, $afp, $jubilado, $cesantia, $seguro, $periodocesantia, $isapre, $planpactado, $valorplanpactado, $ges, $valorges, $comentario, $documentoafp, $documentosalud, $documentojubilacion);
            $this->desconectar();
            return $prevision;
        }
        $this->desconectar();
        return null;
    }

    public function buscarprevisiontrabajador($id)
    {
        $this->conexion();
        $sql = "select * from previsiontrabajador where trabajador = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $periodo = $rs['periodo'];
            $afp = $rs['afp'];
            $jubilado = $rs['jubilado'];
            $cesantia = $rs['cesantia'];
            $seguro = $rs['accidente'];
            $periodocesantia = $rs['fechacesantiainicio'];
            $isapre = $rs['isapre'];
            $planpactado = $rs['planpactado'];
            $valorplanpactado = $rs['valorplanpactado'];
            $ges = $rs['ges'];
            $valorges = $rs['valorges'];
            $comentario = $rs['comentario'];
            $documentoafp = $rs['documentoafp'];
            $documentosalud = $rs['documentosalud'];
            $documentojubilacion = $rs['documentojubilacion'];
            $prevision = new Prevision($id, $trabajador, $periodo, $afp, $jubilado, $cesantia, $seguro, $periodocesantia, $isapre, $planpactado, $valorplanpactado, $ges, $valorges, $comentario, $documentoafp, $documentosalud, $documentojubilacion);
            $this->desconectar();
            return $prevision;
        }
        $this->desconectar();
        return null;
    }

    //Validar Previsiion por periodo y trabajador
    public function validarprevision($periodo, $trabajador)
    {
        $this->conexion();
        $sql = "select * from previsiontrabajador where periodo = '$periodo' and trabajador = $trabajador";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Actualizar Previosion
    public function actualizarprevision($id, $TrabajadorAFP, $jubilado, $cesantia, $seguro, $periodocesantia, $TrabajadorIsapre, $TrabajadorMonedaPacto, $TrabajadorMonto, $TrabajadorTipoGes, $TrabajadorGes, $comentario, $documentoafp, $documentosalud, $documentojubilacion)
    {
        $this->conexion();
        $sql = "update previsiontrabajador set afp = '$TrabajadorAFP', jubilado = '$jubilado', cesantia = '$cesantia', accidente = '$seguro', fechacesantiainicio = '$periodocesantia', isapre = '$TrabajadorIsapre', planpactado = '$TrabajadorMonedaPacto', valorplanpactado = '$TrabajadorMonto', ges = '$TrabajadorTipoGes', valorges = '$TrabajadorGes', comentario = '$comentario' ";
        if ($documentoafp != "") {
            $sql .= ",documentoafp = '$documentoafp'";
        }
        if ($documentosalud != "") {
            $sql .= ",documentosalud = '$documentosalud'";
        }
        if ($documentojubilacion != "") {
            $sql .= ",documentojubilacion = '$documentojubilacion'";
        }
        $sql .= " where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //REGISTRAR CARGA FAMILIAR
    public function registrarcarga($rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $trabajador, $comentario)
    {
        $this->conexion();
        $sql = "insert into cargastrabajador values(null, '$rut', '$nombre', '$apellido1', '$apellido2', '$nacimiento', $civil, '$reconocimiento', '$pago', '$vigencia', $tipocausante, $sexo, $tipocarga, '$documento', now(), $trabajador, '$comentario')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Carga
    public function eliminarcarga($id)
    {
        $this->conexion();
        $sql = "delete from cargastrabajador where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //LISTAR CARGAS FAMILIARES
    public function listarcargas($trabajador)
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, rut, nombres, primerapellido, segundoapellido, fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, register_at, trabajador,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar where cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['trabajador'];
            $comentario = $rs['comentario'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Carga por ID
    public function buscarcarga($id)
    {
        $this->conexion();
        $sql = "select * from cargastrabajador where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['civil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['trabajador'];
            $comentario = $rs['comentario'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $this->desconectar();
            return $carga;
        }
        $this->desconectar();
        return null;
    }

    //Actualizar Carga
    public function actualizarcarga($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $trabajador, $comentario)
    {
        $this->conexion();
        $sql = "update cargastrabajador set rut = '$rut', nombres = '$nombre', primerapellido = '$apellido1', segundoapellido = '$apellido2', fechanacimiento = '$nacimiento', civil = $civil, fechareconocimiento = '$reconocimiento', fechapago = '$pago', vigencia = '$vigencia', tipocausante = $tipocausante, sexo = $sexo, tipocarga = $tipocarga, documento = '$documento', register_at = now(), trabajador = $trabajador, comentario = '$comentario' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Carga1
    public function actualizarcarga1($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $trabajador,  $comentario)
    {
        $this->conexion();
        $sql = "update cargastrabajador set rut = '$rut', nombres = '$nombre', primerapellido = '$apellido1', segundoapellido = '$apellido2', fechanacimiento = '$nacimiento', civil = $civil, fechareconocimiento = '$reconocimiento', fechapago = '$pago', vigencia = '$vigencia', tipocausante = $tipocausante, sexo = $sexo, tipocarga = $tipocarga, register_at = now(), trabajador = $trabajador, comentario = '$comentario' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Validar Carga Familiar
    public function validarcargas($trabajador, $rut)
    {
        $this->conexion();
        $sql = "select * from cargastrabajador where trabajador = $trabajador and rut = '$rut'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        } else {
            $this->desconectar();
            return false;
        }
    }

    //Registrar Licencias Medicas
    public function registrarlicencia($folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $licencia, $tramite, $trabajador)
    {
        $this->conexion();
        $sql = "insert into licenciamedica  values (null,'$folio',$tipolicencia, '$inicio', '$fin', $pagadora, '$comentario', '$licencia','$tramite', $trabajador, now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar Licencias Medicas
    public function listarlicencias($trabajador)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajador, register_at from licenciamedica,tipolicencia, pagadoressubsidio where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.pagadora = pagadoressubsidio.id and trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['trabajador'];
            $registro = $rs['rut'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Licencia Medica
    public function buscarlicencia($id)
    {
        $this->conexion();
        $sql = "select * from licenciamedica where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagadora'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['trabajador'];
            $registro = $rs['register_at'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $this->desconectar();
            return $licencia;
        }
        $this->desconectar();
        return null;
    }

    //Eliminar Licencias Medicas
    public function eliminarlicencia($id)
    {
        $this->conexion();
        $sql = "delete from licenciamedica where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Actualizar Licencias Medicas
    public function actualizarlicencia($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite)
    {
        $this->conexion();
        $sql = "";

        $sql = "update licenciamedica set folio='$folio',tipolicencia=$tipolicencia, fechainicio = '$inicio', fechatermino = '$fin', pagadora = $pagadora, comentario = '$comentario'";
        if ($documentolicencia != "") {
            $sql .= ", documentolicencia = '$documentolicencia'";
        }
        if ($comprobantetramite != "") {
            $sql .= ", comprobantetramite = '$comprobantetramite'";
        }
        $sql .= ", register_at = now() where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Crear Lote
    public function crearlote($trabajador, $token, $usuario)
    {
        $this->conexion();
        $sql = "insert into lote values(null, $trabajador, '$token', $usuario)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar Trabajadores del Lote
    public function buscarlote($usuario)
    {
        $this->conexion();
        $sql = "select lote.id as id, trabajadores.id as empresa, rut, dni, nombre, primerapellido, segundoapellido, fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension from trabajadores, lote where trabajadores.id = lote.trabajador and lote.usuario = $usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Validar Lote
    public function validarlote($trabajador, $usuario)
    {
        $this->conexion();
        $sql = "select * from lote where trabajador = $trabajador and usuario = $usuario;";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar Trabajadores del Lote
    public function eliminarlote($id)
    {
        $this->conexion();
        $sql = "delete from lote where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar Todo los Trabajadores del Lote
    public function eliminartodoellote($usuario)
    {
        $this->conexion();
        $sql = "delete from lote where usuario = $usuario";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Eliminar trabajador del lote
    public function eliminartrabajadorlote($trabajador, $usuario)
    {
        $this->conexion();
        $sql = "delete from lote where trabajador = $trabajador and usuario = $usuario";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }


    //Listar vacaciones
    function listarvacaciones($usuario)
    {
        $this->conexion();
        //Listar los meses y años de los periodos
        $sql = "select id, trabajador, date_format(periodo_inicio, '%m') as mes, date_format(periodo_inicio, '%Y') as anio, date_format(periodo_termino, '%m') as mes2, date_format(periodo_termino, '%Y') as anio2, diasacumulados, anosacumulados, diasprograsivas,tipodocumento, fechainicio, fechatermino, diashabiles, diasinhabiles, diasferiados, totales, diasrestantes, observacion, comprobantetramitefirmado, register_at from vacaciones where trabajador=$usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $periodoinicio = "";
            switch ($rs['mes']) {
                case '01':
                    $periodoinicio = "Enero" . " " . $rs['anio'];
                    break;
                case '02':
                    $periodoinicio = "Febrero" . " " . $rs['anio'];
                    break;
                case '03':
                    $periodoinicio = "Marzo" . " " . $rs['anio'];
                    break;
                case '04':
                    $periodoinicio = "Abril" . " " . $rs['anio'];
                    break;
                case '05':
                    $periodoinicio = "Mayo" . " " . $rs['anio'];
                    break;
                case '06':
                    $periodoinicio = "Junio" . " " . $rs['anio'];
                    break;
                case '07':
                    $periodoinicio = "Julio" . " " . $rs['anio'];
                    break;
                case '08':
                    $periodoinicio = "Agosto" . " " . $rs['anio'];
                    break;
                case '09':
                    $periodoinicio = "Septiembre" . " " . $rs['anio'];
                    break;
                case '10':
                    $periodoinicio = "Octubre" . " " . $rs['anio'];
                    break;
                case '11':
                    $periodoinicio = "Noviembre" . " " . $rs['anio'];
                    break;
                case '12':
                    $periodoinicio = "Diciembre" . " " . $rs['anio'];
                    break;
            }
            $periodotermino = "";

            switch ($rs['mes2']) {
                case '01':
                    $periodotermino = "Enero" . " " . $rs['anio2'];
                    break;
                case '02':
                    $periodotermino = "Febrero" . " " . $rs['anio2'];
                    break;
                case '03':
                    $periodotermino = "Marzo" . " " . $rs['anio2'];
                    break;
                case '04':
                    $periodotermino = "Abril" . " " . $rs['anio2'];
                    break;
                case '05':
                    $periodotermino = "Mayo" . " " . $rs['anio2'];
                    break;
                case '06':
                    $periodotermino = "Junio" . " " . $rs['anio2'];
                    break;
                case '07':
                    $periodotermino = "Julio" . " " . $rs['anio2'];
                    break;
                case '08':
                    $periodotermino = "Agosto" . " " . $rs['anio2'];
                    break;
                case '09':
                    $periodotermino = "Septiembre" . " " . $rs['anio2'];
                    break;
                case '10':
                    $periodotermino = "Octubre" . " " . $rs['anio2'];
                    break;
                case '11':
                    $periodotermino = "Noviembre" . " " . $rs['anio2'];
                    break;
                case '12':
                    $periodotermino = "Diciembre" . " " . $rs['anio2'];
                    break;
            }
            $diasacumulados = $rs['diasacumulados'];
            $diasprograsivas = $rs['diasprograsivas'];
            $anoacumulados = $rs['anosacumulados'];
            $tipodocumento = $rs['tipodocumento'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $diashabiles = $rs['diashabiles'];
            $diasinhabiles = $rs['diasinhabiles'];
            $diasferiados = $rs['diasferiados'];
            $totales = $rs['totales'];
            $diasrestantes = $rs['diasrestantes'];
            $observacion = $rs['observacion'];
            $comprobantefirmado = $rs['comprobantetramitefirmado'];
            $registro = $rs['register_at'];
            $V = new Vacaciones($id, $trabajador, $periodoinicio, $periodotermino, $diasacumulados,$anoacumulados, $diasprograsivas, $tipodocumento, $fechainicio, $fechatermino, $diashabiles, $diasinhabiles, $diasferiados, $totales, $diasrestantes, $observacion, $comprobantefirmado,$registro);
            $lista[] = $V;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar vacaciones
    function buscarvacacion($id)
    {
        $this->conexion();
        $sql = "select * from vacaciones where id = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $periodoinicio = $rs['periodo_inicio'];
            $periodotermino = $rs['periodo_termino'];
            $diasacumulados = $rs['diasacumulados'];
            $diasprograsivas = $rs['diasprograsivas'];
            $anoacumulados = $rs['anosacumulados'];
            $tipodocumento = $rs['tipodocumento'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $diashabiles = $rs['diashabiles'];
            $diasinhabiles = $rs['diasinhabiles'];
            $diasferiados = $rs['diasferiados'];
            $totales = $rs['totales'];
            $diasrestantes = $rs['diasrestantes'];
            $observacion = $rs['observacion'];
            $comprobantefirmado = $rs['comprobantetramitefirmado'];
            $registro = $rs['register_at'];
            $V = new Vacaciones($id, $trabajador, $periodoinicio, $periodotermino, $diasacumulados,$anoacumulados, $diasprograsivas, $tipodocumento, $fechainicio, $fechatermino, $diashabiles, $diasinhabiles, $diasferiados, $totales, $diasrestantes, $observacion, $comprobantefirmado,$registro);
            $this->desconectar();
            return $V;
        }
        $this->desconectar();
        return false;
    }

    //Sumar dias de vacaciones ya tomadas de un trabajador
    function sumardiasvacaciones($trabajador)
    {
        $this->conexion();
        $sql = "select sum(diashabiles) as dias from vacaciones where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $dias = $rs['dias'];
            $this->desconectar();
            return $dias;
        }
        $this->desconectar();
        return 0;
    }


    //Listar Dias Feriados
    function listardiasferiados()
    {
        $this->conexion();
        $sql = "select * from diasferiado";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $periodo = $rs['periodo'];
            $fecha = $rs['fecha'];
            $descripcion = $rs['descripcion'];
            $DF = new DiasFeriados($id, $periodo, $fecha, $descripcion);
            $lista[] = $DF;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Dias Feriados
    function listardiasferiadosperiodo($periodo)
    {
        $this->conexion();
        $sql = "select * from diasferiado where periodo = $periodo";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $periodo = $rs['periodo'];
            $fecha = $rs['fecha'];
            $descripcion = $rs['descripcion'];
            $DF = new DiasFeriados($id, $periodo, $fecha, $descripcion);
            $lista[] = $DF;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar feriado por fecha
    function buscarferiadoporfecha($fecha)
    {
        $this->conexion();
        $sql = "select * from diasferiado where fecha = '$fecha'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $periodo = $rs['periodo'];
            $fecha = $rs['fecha'];
            $descripcion = $rs['descripcion'];
            $DF = new DiasFeriados($id, $periodo, $fecha, $descripcion);
            $this->desconectar();
            return $DF;
        }
        $this->desconectar();
        return false;
    }

    //Contar Dias Feriados
    function contardiasferiados($fechainicio, $fechatermino)
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from diasferiado where fecha between '$fechainicio' and '$fechatermino'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $cantidad = $rs['cantidad'];
            $this->desconectar();
            return $cantidad;
        }
        $this->desconectar();
        return 0;
    }

    //Eliminar vacaciones
    public function eliminarvacaciones($id)
    {
        $this->conexion();
        $sql = "delete from vacaciones where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }



    //Agregar zona region
    public function zonaregion($trabajador, $region)
    {
        $this->conexion();
        $sql = "insert into resumenregion values(null, $region, $trabajador)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Verificar zona region
    public function verificarzonaregion($trabajador, $region)
    {
        $this->conexion();
        $sql = "select * from resumenregion where usuario = $trabajador and region = $region";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }
    //Eliminar zona region
    public function eliminarzonaregion($id, $trabajador)
    {
        $this->conexion();
        $sql = "delete from resumenregion where region = $id and usuario = $trabajador";
        $result = $this->mi->query($sql);
        $this->desconectar();
    }


    //Agregar zona provincia
    public function zonaprovincia($trabajador, $provincia)
    {
        $this->conexion();
        $sql = "insert into resumenprovincia values(null, $provincia, $trabajador)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Verificar zona provincia
    public function verificarzonaprovincia($trabajador, $provincia)
    {
        $this->conexion();
        $sql = "select * from resumenprovincia where usuario = $trabajador and provincia = $provincia";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar zona provincia
    public function eliminarzonaprovincia($id, $trabajador)
    {
        $this->conexion();
        $sql = "delete from resumenprovincia where provincia = $id and usuario = $trabajador";
        $result = $this->mi->query($sql);
        $this->desconectar();
    }

    //Agregar zona comuna
    public function zonacomuna($trabajador, $comuna)
    {
        $this->conexion();
        $sql = "insert into resumencomuna values(null, $comuna, $trabajador)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Verificar zona comuna
    public function verificarzonacomuna($trabajador, $comuna)
    {
        $this->conexion();
        $sql = "select * from resumencomuna where usuario = $trabajador and comuna = $comuna";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar zona comuna
    public function eliminarzonacomuna($id, $trabajador)
    {
        $this->conexion();
        $sql = "delete from resumencomuna where comuna = $id and usuario = $trabajador";
        $result = $this->mi->query($sql);
        $this->desconectar();
    }


    //listar zonas region
    function listarzonasregion($trabajador)
    {
        $this->conexion();
        $sql = "select resumenregion.id as id, regiones.id as regionid, regiones.nombre as region  from resumenregion,regiones where usuario = $trabajador and regiones.id = resumenregion.region";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $regionid = $rs['regionid'];
            $region = $rs['region'];
            $region = new Regiones($id, $regionid, $regionid, $region);
            $lista[] = $region;
        }
        $this->desconectar();
        return $lista;
    }

    //listarzonaprovincia($sql)
    function listarzonaprovincia($sql)
    {
        $this->conexion();
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $comuna = new Provincias($id, $codigo, $codigoPrevired, $nombre, $id);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar zona provincia por trabajador
    function listarzonaprovinciatrabajador($trabajador)
    {
        $this->conexion();
        $sql = "select resumenprovincia.id as id, provincias.id as provinciaid, provincias.nombre as provincia  from resumenprovincia,provincias where usuario = $trabajador and provincias.id = resumenprovincia.provincia";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $provinciaid = $rs['provinciaid'];
            $provincia = $rs['provincia'];
            $provincia = new Provincias($id, $provinciaid, $provinciaid, $provincia, $id);
            $lista[] = $provincia;
        }
        $this->desconectar();
        return $lista;
    }

    //listarzonacomuna($sql)
    function listarzonacomunas($sql)
    {
        $this->conexion();
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $nombre, $id, $id);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar zona comuna por trabajador
    function listarzonacomunatrabajador($trabajador)
    {
        $this->conexion();
        $sql = "select resumencomuna.id as id, comunas.id as comunaid, comunas.nombre as comuna  from resumencomuna,comunas where usuario = $trabajador and comunas.id = resumencomuna.comuna";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $comunaid = $rs['comunaid'];
            $comuna = $rs['comuna'];
            $comuna = new Comunas($id, $comunaid, $comunaid, $comuna, $id, $id);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //function listarcontratos($trabajador)
    function listarcontratos($trabajador)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.trabajador = $trabajador and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //listar contratos activos por empresa
    function listarcontratosactivosempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.rut as rut,trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and contratos.estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {

            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['rut'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }


    //Buscar contrato por id
    function buscarcontratoid($id)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.id as traid, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.id = $id and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['traid'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //Buscar el ultimo contrato activo del trabajador
    function buscarultimocontratoactivo($trabajador)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.id as traid, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.trabajador=$trabajador and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and contratos.estado=1 order by contratos.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['traid'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //Buscar Fecha de inicio del ultimo contrato registrado
    function buscarfechainicioultimocontrato($trabajador)
    {
        $this->conexion();
        $sql = "select fechainicio from contratos where trabajador = $trabajador and estado=1 order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $fechainicio = $rs['fechainicio'];
            $this->desconectar();
            return $fechainicio;
        }
        $this->desconectar();
        return false;
    }

    //Buscar Fecha de inicio del ultimo contrato registrado
    function buscarfechainiciocontrato($id)
    {
        $this->conexion();
        $sql = "select fechainicio from contratos where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $fechainicio = $rs['fechainicio'];
            $this->desconectar();
            return $fechainicio;
        }
        $this->desconectar();
        return false;
    }

    //Buscar Fecha de inicio del ultimo contrato registrado
    function buscarfechaterminocontrato($id)
    {
        $this->conexion();
        $sql = "select fechatermino from contratos where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $fechainicio = $rs['fechatermino'];
            $this->desconectar();
            return $fechainicio;
        }
        $this->desconectar();
        return false;
    }

    //Registrar fechatermino contrato
    function registrarfechaterminocontrato($id, $fecha)
    {
        $this->conexion();
        $sql = "update contratos set fechatermino='$fecha', estado=2 where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Buscar fecha termino del ultimo periodo de vacaciones
    function buscarfechaterminoultimoperiodovacaciones($trabajador)
    {
        $this->conexion();
        $sql = "select periodo_termino from vacaciones where trabajador = $trabajador order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $fechatermino = $rs['periodo_termino'];
            $this->desconectar();
            return $fechatermino;
        }
        $this->desconectar();
        return false;
    }

    function contarmesesdesdequeinicioelcontrato($trabajador)
    {
        $this->conexion();
        $sql = "select datediff(curdate(),fechainicio) as dias from contratos where trabajador = $trabajador and estado = 1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $dias = $rs['dias'];
            $meses = $dias / 30;
            $meses = round($meses);
            $lista[] = $meses;
        }
        $this->desconectar();
        return $lista;
    }

    function cargarcomprobantefirmado($comprobante, $id)
    {
        $this->conexion();
        $sql = "update vacaciones set comprobantetramitefirmado = '$comprobante' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function registrarafectovacaciones($trabajador, $fechainicio, $estado)
    {
        $this->conexion();
        $sql = "insert into afectoavacaciones values(null, $trabajador, '$fechainicio', $estado,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function actualizarafectovacaciones($trabajador, $fechainicio, $estado)
    {
        $this->conexion();
        $sql = "update afectoavacaciones set fechainicio = '$fechainicio', register_at=now() where trabajador = $trabajador;";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function validarafectovacaciones($trabajador)
    {
        $this->conexion();
        $sql = "select * from afectoavacaciones where trabajador = $trabajador and estadoafectoavacaciones = 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    function eliminarafectovacaciones($trabajador)
    {
        $this->conexion();
        $sql = "delete from afectoavacaciones where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function buscarfechaafectovacaciones($trabajador)
    {
        $this->conexion();
        $sql = "select fechainicio from afectoavacaciones where trabajador = $trabajador and estadoafectoavacaciones = 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $fechainicio = $rs['fechainicio'];
            $this->desconectar();
            return $fechainicio;
        }
        $this->desconectar();
        return false;
    }

    function contardiasnaturales($fechainicio, $fechatermino)
    {
        $this->conexion();
        $sql = "select datediff('$fechatermino','$fechainicio') as dias";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $dias = $rs['dias'];
            $this->desconectar();
            return $dias;
        }
        $this->desconectar();
        return false;
    }

    /****************************************************************************************** */
    //Informacion Bancaria
    function listarbancos()
    {
        $this->conexion();
        $sql = "select * from banco";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $b = new Banco($id, $nombre);
            $lista[] = $b;
        }
        $this->desconectar();
        return $lista;
    }

    /****************************************************************************************** */
    //Informacion Bancaria
    function listartipocuenta()
    {
        $this->conexion();
        $sql = "select * from tipocuenta";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $b = new Banco($id, $nombre);
            $lista[] = $b;
        }
        $this->desconectar();
        return $lista;
    }

    /****************************************************************************************** */
    //Informacion Bancaria
    function registrarcuentabancaria($banco, $tipocuenta, $numerocuenta, $trabajador)
    {
        $this->conexion();
        $sql = "insert into cuentabancaria values(null,$trabajador, $banco, $tipocuenta, '$numerocuenta', now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function listarcuentasbancarias($trabajador)
    {
        $this->conexion();
        $sql = "select * from cuentabancaria where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $banco = $rs['banco'];
            $tipocuenta = $rs['tipocuenta'];
            $numerocuenta = $rs['numero'];
            $registro = $rs['register_at'];
            $c = new CuentaBancaria($id, $trabajador, $banco, $tipocuenta, $numerocuenta, $registro);
            $lista[] = $c;
        }
        $this->desconectar();
        return $lista;
    }

    function buscarcuentabancaria($id)
    {
        $this->conexion();
        $sql = "select * from cuentabancaria where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $banco = $rs['banco'];
            $tipocuenta = $rs['tipocuenta'];
            $numerocuenta = $rs['numero'];
            $registro = $rs['register_at'];
            $c = new CuentaBancaria($id, $trabajador, $banco, $tipocuenta, $numerocuenta, $registro);
            $this->desconectar();
            return $c;
        }
        $this->desconectar();
        return false;
    }

    function ultimacuentabancariaregistrada($trabajador)
    {
        $this->conexion();
        $sql = "select * from cuentabancaria where trabajador = $trabajador order by id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $banco = $rs['banco'];
            $tipocuenta = $rs['tipocuenta'];
            $numerocuenta = $rs['numero'];
            $registro = $rs['register_at'];
            $c = new CuentaBancaria($id, $trabajador, $banco, $tipocuenta, $numerocuenta, $registro);
            $this->desconectar();
            return $c;
        }
        $this->desconectar();
        return false;
    }

    function ultimacuentabancariaregistrada1($trabajador)
    {
        $this->conexion();
        $sql = "select cuentabancaria.id as id, banco.nombre as banco, tipocuenta.nombre as tipocuenta, cuentabancaria.numero as numerocuenta, cuentabancaria.register_at as register_at from cuentabancaria inner join banco on cuentabancaria.banco = banco.id inner join tipocuenta on cuentabancaria.tipocuenta = tipocuenta.id where cuentabancaria.trabajador = $trabajador order by cuentabancaria.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $banco = $rs['banco'];
            $tipocuenta = $rs['tipocuenta'];
            $numerocuenta = $rs['numerocuenta'];
            $registro = $rs['register_at'];
            $c = new CuentaBancaria($id, $trabajador, $banco, $tipocuenta, $numerocuenta, $registro);
            $this->desconectar();
            return $c;
        }
        $this->desconectar();
        return false;
    }

    function actualizarcuentabancaria($id, $banco, $tipocuenta, $numerocuenta)
    {
        $this->conexion();
        $sql = "update cuentabancaria set banco = $banco, tipocuenta = $tipocuenta, numero = '$numerocuenta' where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function eliminarcuentabancaria($id)
    {
        $this->conexion();
        $sql = "delete from cuentabancaria where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function listarcuentasbancariastexto($trabajador)
    {
        $this->conexion();
        $sql = "select cuentabancaria.id as id, banco.nombre as banco, tipocuenta.nombre as tipocuenta, cuentabancaria.numero as numerocuenta, cuentabancaria.register_at as register_at from cuentabancaria inner join banco on cuentabancaria.banco = banco.id inner join tipocuenta on cuentabancaria.tipocuenta = tipocuenta.id where cuentabancaria.trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $banco = $rs['banco'];
            $tipocuenta = $rs['tipocuenta'];
            $numerocuenta = $rs['numerocuenta'];
            $registro = $rs['register_at'];
            $c = new CuentaBancaria($id, $trabajador, $banco, $tipocuenta, $numerocuenta, $registro);
            $lista[] = $c;
        }
        $this->desconectar();
        return $lista;
    }


    /*********Informacion De Finiquitos */
    //Listar Indemnizacion
    function listarindemnizacion()
    {
        $this->conexion();
        $sql = "select * from indemnizacion;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $tipo = $rs['tipoindezacion'];
            $in = new Indemnizacion($id, $nombre, $tipo);
            $lista[] = $in;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar TIpo de Indeminizacion
    function buscartipoindezacion($id)
    {
        $this->conexion();
        $sql = "select * from indemnizacion where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $tipo = $rs['tipodeindezacion'];
            $this->desconectar();
            return $tipo;
        }
        $this->desconectar();
        return false;
    }

    //Registrar resumen finiquito
    function registrarresumenfiniquito($indemnizacion, $tipo, $descripcion, $monto, $usuario)
    {
        $this->conexion();
        $sql = "insert into resumenfiniquito values (null,$indemnizacion,$tipo,'$descripcion',$monto,$usuario)";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar Resumen Finiquito
    function eliminarresumenfiniquito($id)
    {
        $this->conexion();
        $sql = "delete from resumenfiniquito where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar resumen finiquito
    function listarresumenfiniquito($usuario)
    {
        $this->conexion();
        $sql = "select resumenfiniquito.id as id, indemnizacion.nombre as indemnizacion, resumenfiniquito.tipoindemnizacion as tipo, resumenfiniquito.descripcion as descripcion, resumenfiniquito.monto as monto from resumenfiniquito inner join indemnizacion on resumenfiniquito.indemnizacion = indemnizacion.id where resumenfiniquito.usuario = $usuario order by tipo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $indemnizacion = $rs['indemnizacion'];
            $tipo = $rs['tipo'];
            $descripcion = $rs['descripcion'];
            $monto = $rs['monto'];
            $r = new ResumenFiniquito($id, $indemnizacion, $tipo, $descripcion, $monto);
            $lista[] = $r;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar resumen finiquito 
    function listarresumenfiniquitoids($usuario)
    {
        $this->conexion();
        $sql = "select * from resumenfiniquito where usuario = $usuario;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $indemnizacion = $rs['indemnizacion'];
            $tipo = $rs['tipoindemnizacion'];
            $descripcion = $rs['descripcion'];
            $monto = $rs['monto'];
            $r = new ResumenFiniquito($id, $indemnizacion, $tipo, $descripcion, $monto);
            $lista[] = $r;
        }
        $this->desconectar();
        return $lista;
    }


    //Buscar el ultimo ID del finiquito registrado para el trabajador
    function buscarultimoidfiniquito($usuario)
    {
        $this->conexion();
        $sql = "select max(id) as id from finiquito where trabajador = $usuario";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Listar finiquito
    function listarfiniquito($usuario)
    {
        $this->conexion();
        $sql = "select * from finiquito where trabajador = $usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Finiquito Empresa
    function buscarfiniquitoempresa($id)
    {
        $this->conexion();
        $sql = "select * from finiquito where empresa = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Finiquito text
    function listarfiniquitotext($trabajador)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, contrato, finiquito.tipodocumento as tipodocumento, fechafiniqito, fechainicio, fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajador, finiquito.empresa as empresa, finiquito.register_at as register_at from finiquito, causalterminocontrato where finiquito.causalterminocontrato = causalterminocontrato.id and  finiquito.trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Finiquitos por empresa
    function listarfiniquitosempresa($empresa)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, contrato, finiquito.tipodocumento as tipodocumento, fechafiniqito, fechainicio, fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from finiquito,trabajadores, causalterminocontrato where finiquito.causalterminocontrato = causalterminocontrato.id and  finiquito.empresa = $empresa and finiquito.trabajador = trabajadores.id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['rut'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Finiquito text
    function listarfiniquitofiniquitosnonotificados()
    {
        $this->conexion();
        $sql = "select finiquito.id as id, contrato, finiquito.tipodocumento as tipodocumento, fechafiniqito, fechainicio, fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from finiquito inner join causalterminocontrato on finiquito.causalterminocontrato = causalterminocontrato.id inner join trabajadores on finiquito.trabajador = trabajadores.id left outer join notificaciones on finiquito.id = notificaciones.finiquito where notificaciones.finiquito is null";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Finiquitotext por id de finiquito
    function buscarfiniquitotext($id)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, contrato, tipodocumento, fechafiniqito, fechainicio, fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajador, empresa, register_at from finiquito inner join causalterminocontrato on finiquito.causalterminocontrato = causalterminocontrato.id where finiquito.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $this->desconectar();
            return $finiquito;
        }
        $this->desconectar();
        return false;
    }


    //Eliminar finiquito
    function eliminarfiniquito($id)
    {
        $this->conexion();
        $sql = "delete from finiquito where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar id contrato en finiquito
    function buscaridcontratofiniquito($id)
    {
        $this->conexion();
        $sql = "select contrato from finiquito where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $contrato = $rs['contrato'];
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar detalle finiquito
    function eliminardetallefiniquito($id)
    {
        $this->conexion();
        $sql = "delete from detallefiniquito where finiquito = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar Contrato
    function eliminarcontrato($id)
    {
        $this->conexion();
        $sql = "delete from contratos where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Detalle finiquito
    function listardetallefiniquito($finiquito)
    {
        $this->conexion();
        $sql = "select detallefiniquito.id as id, indemnizacion.nombre as indemnizacion, detallefiniquito.tipoindemnizacion as tipo, detallefiniquito.descripcion as descripcion, detallefiniquito.monto as monto from detallefiniquito inner join indemnizacion on detallefiniquito.indemnizacion = indemnizacion.id where detallefiniquito.finiquito = $finiquito order by tipo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $indemnizacion = $rs['indemnizacion'];
            $tipo = $rs['tipo'];
            $descripcion = $rs['descripcion'];
            $monto = $rs['monto'];
            $r = new ResumenFiniquito($id, $indemnizacion, $tipo, $descripcion, $monto);
            $lista[] = $r;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Detalle finiquito
    function listardetallefiniquitoids($finiquito)
    {
        $this->conexion();
        $sql = "select detallefiniquito.id as id, indemnizacion, detallefiniquito.tipoindemnizacion as tipo, detallefiniquito.descripcion as descripcion, detallefiniquito.monto as monto from detallefiniquito inner join indemnizacion on detallefiniquito.indemnizacion = indemnizacion.id where detallefiniquito.finiquito = $finiquito order by tipo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $indemnizacion = $rs['indemnizacion'];
            $tipo = $rs['tipo'];
            $descripcion = $rs['descripcion'];
            $monto = $rs['monto'];
            $r = new ResumenFiniquito($id, $indemnizacion, $tipo, $descripcion, $monto);
            $lista[] = $r;
        }
        $this->desconectar();
        return $lista;
    }

    //Registrar Notificaciones
    function registrarnotificacion($fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto)
    {
        $this->conexion();
        $sql = "insert into notificaciones values (null,'$fechanotificacion',$finiquito,$tipodocumento, $causal, '$causalhechos', '$cotizacionprevisional', $comunicacion, $acreditacion, '$comuna','$texto', now())";
        echo $sql;
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }
    //Listar Notificaciones
    function listarnotificaciones($trabajador)
    {
        $this->conexion();
        $sql = "select notificaciones.id as id, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at from notificaciones inner join finiquito on notificaciones.finiquito = finiquito.id inner join comunicacion on notificaciones.comunicacion = comunicacion.id where finiquito.trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['finiquito'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['causalhechos'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['comunicacion'];
            $acreditacion = $rs['acreditacion'];
            $comuna = $rs['comuna'];
            $texto = $rs['texto'];
            $register_at = $rs['register_at'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $lista[] = $n;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Notificaciones
    function listarnotificacionestext($trabajador)
    {
        $this->conexion();
        $sql = "select notificaciones.id as id, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causalterminocontrato.nombre as causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at from notificaciones inner join finiquito on notificaciones.finiquito = finiquito.id inner join comunicacion on notificaciones.comunicacion = comunicacion.id inner join causalterminocontrato on notificaciones.causal = causalterminocontrato.id where finiquito.trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['finiquito'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['causalhechos'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['comunicacion'];
            $acreditacion = $rs['acreditacion'];
            $comuna = $rs['comuna'];
            $texto = $rs['texto'];
            $register_at = $rs['register_at'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $lista[] = $n;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Notificaciones por empresa
    function listarnotificacionesempresa($empresa)
    {
        $this->conexion();
        $sql = "select notificaciones.id as id, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido from notificaciones inner join finiquito on notificaciones.finiquito = finiquito.id inner join comunicacion on notificaciones.comunicacion = comunicacion.id inner join trabajadores on finiquito.trabajador = trabajadores.id where finiquito.empresa = $empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['finiquito'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['causalhechos'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['nombre'] . " " . $rs['apellido'];
            $acreditacion = $rs['rut'];
            $comuna = $rs['comuna'];
            $texto = $rs['texto'];
            $register_at = $rs['register_at'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $lista[] = $n;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Notificacion
    function buscarnotificacion($id)
    {
        $this->conexion();
        $sql = "select * from notificaciones where notificaciones.id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['finiquito'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['causalhechos'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['comunicacion'];
            $acreditacion = $rs['acreditacion'];
            $comuna = $rs['comuna'];
            $texto = $rs['texto'];
            $register_at = $rs['register_at'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $this->desconectar();
            return $n;
        }
        $this->desconectar();
        return false;
    }

    //Copiar informacion dentro de parentisis en un texto
    function extrartexto($texto)
    {
        //copiar el texto que esta dentro de los parentesis

        $parte1 = explode('(', $texto);
        $parte2 = explode(')', $parte1[1]);

        $parentesis = $parte2[0];

        return $parentesis;
    }

    //eliminarnotificacion
    function eliminarnotificacion($id)
    {
        $this->conexion();
        $sql = "delete from notificaciones where id = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar id del ultimo Contrato registrado
    function buscaridultimocontrato()
    {
        $this->conexion();
        $sql = "select max(id) as id from contratos";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Buscar id del ultimo lote registrado
    function buscaridultimolote()
    {
        $this->conexion();
        $sql = "select max(id) as id from lotes";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Listar Lotes con contratos activos
    function listarlotestext($empresa)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato, detallelotes.id as id, lotes.nombre as nombre, contratos.tipocontrato as tipocontrato, fechainicio, fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 1 and lotes=$empresa order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['tipocontrato'];
            if($contrato=="Contrato a Plazo Fijo"){
                $contrato = "Plazo Fijo";
            }else if($contrato=="Contrato Indefinido"){
                $contrato = "Indefinido";
            }
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'] ;
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    function validarloteids($id, $contrato){
        $this->conexion();
        $sql = "select * from detallelotes where contrato = $contrato and lotes = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }


    //Listar Lotes con contratos activos
    function listarlotesids($empresa)
    {
        $this->conexion();
        $sql = "select detallelotes.id as id, lotes.nombre as nombre, contrato, fechainicio, fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 1 and lotes=$empresa order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'] . " " . $contrato;
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar lotes contrato
    function listarlotescontrato($empresa)
    {
        $this->conexion();
        $sql = "select * from lotes where empresa=$empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $registro = $rs['register_at'];
            $l = new Lotes_contrato($id, "", "", $nombre, "", $registro);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    /*************************************Creacion de lote Finiquito ****** */
    //Buscar Id contrato en lotes
    function buscaridcontratolote($lote)
    {
        $this->conexion();
        $sql = "select contrato from detallelotes where id=$lote";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['contrato'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return false;
    }

    //Registrar lote finiquito
    function registrarlotefiniquito($contrato, $usuario)
    {
        $this->conexion();
        $sql = "insert into lote2 values(null,$contrato,$usuario,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }
    //Registrar lote Anexo
    function registrarloteanexo($contrato, $usuario)
    {
        $this->conexion();
        $sql = "insert into lote4 values(null,$contrato,$usuario,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Validar lote finiquito
    function validarlotefiniquito($contrato, $usuario)
    {
        $this->conexion();
        $sql = "select * from lote2 where contrato=$contrato and usuario=$usuario";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //Validar lote Anexo
    function validarloteanexo($contrato, $usuario)
    {
        $this->conexion();
        $sql = "select * from lote4 where contrato=$contrato and usuario=$usuario";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //buscarlotefiniquito
    function buscarlotefiniquito($usuario)
    {
        $this->conexion();
        $sql = "select lote2.id as id, lote2.contrato as contrato, tipocontrato, cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as registro,trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from lote2, contratos, trabajadores where lote2.contrato = contratos.id and contratos.trabajador = trabajadores.id and usuario=$usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['contrato'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $lote = $rs['id'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $l = new Contrato($id, $trabajador, $lote, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $registro);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Lote Anexo
    function buscarloteanexo($usuario){
        $this->conexion();
        $sql = "select lote4.id as id, lote4.contrato as contrato, tipocontrato, cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as registro,trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from lote4, contratos, trabajadores where lote4.contrato = contratos.id and contratos.trabajador = trabajadores.id and usuario=$usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)){
            $id = $rs['contrato'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $lote = $rs['id'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $l = new Contrato($id, $trabajador, $lote, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $registro);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar en lote de finiquito
    function eliminarlotefiniquito($id)
    {
        $this->conexion();
        $sql = "delete from lote2 where id=$id";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Eliminar en lote de Anexo
    function eliminarloteanexo($id)
    {
        $this->conexion();
        $sql = "delete from lote4 where id=$id";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Eliminar todo el lote
    function eliminartodolotefiniquito($usuario)
    {
        $this->conexion();
        $sql = "delete from lote2 where usuario=$usuario";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Eliminar todo el lote Anexo
    function eliminartodoloteanexo($usuario)
    {
        $this->conexion();
        $sql = "delete from lote4 where usuario=$usuario";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Registrar Axexo
    function registraraenxo($contrato, $tipocontratoid, $fechaanexo, $trabajadorid, $empresa){
        $this->conexion();
        $sql = "insert into anexos values(null, $contrato, $tipocontratoid, '$fechaanexo', $trabajadorid, $empresa,now());";
        $result = $this->mi->query($sql);
        $id_insert = mysqli_insert_id($this->mi);
        $this->desconectar();
        return $id_insert;
    }


    //Registrar lote Notificaciones
    function registrarlotenotificacion($finiquito, $usuario)
    {
        $this->conexion();
        $sql = "insert into lote3 values(null,$finiquito,$usuario,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Validar lote Notificaciones
    function validarlotenotificacion($finiquito, $usuario)
    {
        $this->conexion();
        $sql = "select * from lote3 where finiquito=$finiquito and usuario=$usuario";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //buscarlote Notificaciones
    function buscarlotenotifacion($usuario)
    {
        $this->conexion();
        $sql = "select lote3.id as id, lote3.finiquito as finiquito,tipodocumento, fechafiniqito,fechainicio, fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.nombre as nombretra,  trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2,finiquito.empresa as empresa,finiquito.register_at as register_at from lote3, finiquito, trabajadores,causalterminocontrato where lote3.finiquito = finiquito.id and finiquito.trabajador = trabajadores.id and finiquito.causalterminocontrato = causalterminocontrato.id and usuario=$usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['finiquito'];
            $finiquito = $rs['id'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniqito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $register_at = $rs['register_at'];
            $l = new Finiquito($id, $finiquito, $tipodocumento, $fechafiniqito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar en lote de Notificaciones
    function eliminarlotenotificacion($id)
    {
        $this->conexion();
        $sql = "delete from lote3 where id=$id";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Eliminar todo el lote
    function eliminartodolotenotificacion($usuario)
    {
        $this->conexion();
        $sql = "delete from lote3 where usuario=$usuario";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Buscar estado contrato
    function estadocontrato($trabajador)
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from contratos where trabajador=$trabajador and estado=1;";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $cantidad = $rs['cantidad'];
            $this->desconectar();
            if ($cantidad > 0) {
                return true;
            } else {
                return false;
            }
        }
        $this->desconectar();
        return false;
    }

    //Registrar Documento
    function registrardocumento($trabajador, $empresa, $tipodocumento, $fechageneracion, $documento)
    {
        $this->conexion();
        $sql = "insert into documentos values(null, $trabajador, $empresa, $tipodocumento, '$fechageneracion','$documento',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar documento por trabajador
    function listardocumentostrabajador($trabajador)
    {
        $this->conexion();
        $sql = "select * from documentos where trabajador=$trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $tipodocumento = $rs['tipodocumento'];
            $fechageneracion = $rs['fechageneracion'];
            //cambiar formato de fecha a dd/mm/yyyy
            $fechageneracion = date("d/m/Y", strtotime($fechageneracion));
            $documento = $rs['documento'];
            $register_at = $rs['register_at'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar documento
    function eliminardocumento($id)
    {
        $this->conexion();
        $sql = "delete from documentos where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar documentos text    
    function listardocumentostext($trabajador)
    {
        $this->conexion();
        $sql = "select documentos.id as id, trabajador, empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documento, documentos.register_at as register_at from documentos, tipodocumento where documentos.tipodocumento = tipodocumento.id and trabajador=$trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $tipodocumento = $rs['tipodocumento'];
            $fechageneracion = $rs['fechageneracion'];
            //cambiar formato de fecha a dd/mm/yyyy
            $fechageneracion = date("d/m/Y", strtotime($fechageneracion));
            $documento = $rs['documento'];
            $register_at = $rs['register_at'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

     //Listar documentos text empresa
     function listardocumentostextempresa($empresa)
     {
         $this->conexion();
         $sql = "select documentos.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documento, documentos.register_at as register_at from trabajadores,documentos, tipodocumento where documentos.tipodocumento = tipodocumento.id and documentos.empresa=$empresa and trabajadores.id = documentos.trabajador";
         $result = $this->mi->query($sql);
         $lista = array();
         while ($rs = mysqli_fetch_array($result)) {
             $id = $rs['id'];
             $trabajador = $rs['nombre'] . " " . $rs['apellido'];
             $empresa = $rs['rut'];
             $tipodocumento = $rs['tipodocumento'];
             $fechageneracion = $rs['fechageneracion'];
             //cambiar formato de fecha a dd/mm/yyyy
             $fechageneracion = date("d/m/Y", strtotime($fechageneracion));
             $documento = $rs['documento'];
             $register_at = $rs['register_at'];
             $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
             $lista[] = $l;
         }
         $this->desconectar();
         return $lista;
     }

    //Registrar Anotacion
    public function registraranotacion($trabajador, $empresa, $tipo, $anotacion)
    {
        $this->conexion();
        $sql = "insert into anotacion values(null, $trabajador, $empresa, $tipo, '$anotacion', now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Listar anotaciones por trabajador
    public function listarporanotacion($trabajador)
    {
        $this->conexion();
        $sql = "select anotacion.id as id, trabajador, empresa, tipoanotacion.nombre as tipo, anotacion, anotacion.register_at as register_at from anotacion, tipoanotacion where anotacion.tipoanotacion = tipoanotacion.id and trabajador=$trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $anotacion = $rs['anotacion'];
            $register_at = $rs['register_at'];
            $l = new Anotacion($id, $trabajador, $empresa, $tipo, $anotacion, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //BUscar anotacion por id
    public function buscaranotacionporid($id)
    {
        $this->conexion();
        $sql = "select * from anotacion where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $anotacion = $rs['anotacion'];
            $this->desconectar();
            return $anotacion;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar eliminaranotacion
    public function eliminaranotacion($id)
    {
        $this->conexion();
        $sql = "delete from anotacion where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Cantidad de dias de vacacionea acumulados
    public function cantidadvacaciones($id)
    {
        $inicio = $this->buscarfechainicioultimocontrato($id);
        if ($inicio == false) {
            return 0;
        }
        $iniciocal = $inicio;
        $fecafec = $this->buscarfechaafectovacaciones($id);
        $tomadas = $this->sumardiasvacaciones($id);
        $inicomparacion = "";
        if ($fecafec > $iniciocal) {
            $inicomparacion = $fecafec;
        } else {
            $inicomparacion = $iniciocal;
        }
        $datetime1 = new DateTime($inicomparacion);
        $datetime2 = new DateTime(date('Y-m-d'));
        $interval = $datetime1->diff($datetime2);
        $anios = $interval->format('%y');

        //Calcular vacaciones progresivas sumando 1 dias por cada 3 años trabajados
        $canti = $anios / 3;
        $vacacionesprogresivas = floor($canti) * 1;

        //Calcular cantidad de meses desde la fecha de inicio hasta hoy
        //Agregar la hora a la fecha de inicio para poder calcular la diferencia
        $inicio = $inicio . " 00:00:00";
        $fin = date('Y-m-d H:i:s');
        $datetime1 = new DateTime($iniciocal);
        $datetime2 = new DateTime($fin);

        # obtenemos la diferencia entre las dos fechas
        $interval = $datetime2->diff($datetime1);

        # obtenemos la diferencia en meses
        $intervalMeses = $interval->format("%m");
        # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
        $intervalAnos = $interval->format("%y") * 12;
        # sumamos los meses
        $intervalMeses = $intervalMeses + $intervalAnos;
        //Calcular cantidad de dias de vacaciones que le corresponden al trabajador
        $diasvacaciones = $intervalMeses * 1.25;
        $diasvacaciones = $diasvacaciones - $tomadas;
        if ($diasvacaciones < 0) {
            $diasvacaciones = 0;
        }
        return (int)($diasvacaciones);
    }


    /*****************************************************SECCIOn de REPORTES***************************************************************** */
    //Listar los contratos que terminan dentro de los proximos 30 dias
    function listarcontratosquevenceranenlosproximos30diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar los contratos que terminan dentro de los proximos 30 dias
    function listarcontratosquevenceranenlosproximos30dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar los contratos que terminan dentro de los proximos 60 dias
    function listarcontratosquevenceranenlosproximos60diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 60 dias
    function listarcontratosquevenceranenlosproximos60dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 90 dias
    function listarcontratosquevenceranenlosproximos90diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 90 dias
    function listarcontratosquevenceranenlosproximos90dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Cantidad de Contratos Generados por empresa
    function cantidadcontratosgeneradosempresa($empresa)
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from contratos where empresa = $empresa";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de Contratos Generados
    function cantidadcontratosgenerados()
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from contratos";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de Finiquitos Generados por empresa
    function cantidadfiniquitosgeneradosempresa($empresa)
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from finiquito where empresa = $empresa";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de Finiquitos Generados
    function cantidadfiniquitosgenerados()
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from finiquito";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de trabajadores con licencia medica
    function cantidadtrabajadoresconlicenciamedica()
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from licenciamedica where fechatermino >= curdate()";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de trabajadores con licencia medica por empresa
    function cantidadtrabajadoresconlicenciamedicaempresa($empresa)
    {
        $this->conexion();
        $sql = "select count(licenciamedica.trabajador) as cantidad from licenciamedica,trabajadores where fechatermino >= curdate() and trabajadores.empresa = $empresa and licenciamedica.trabajador = trabajadores.id";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de trabajadores con vacaciones
    function cantidadtrabajadoresconvacaciones()
    {
        $this->conexion();
        $sql = "select count(*) as cantidad from vacaciones where fechatermino >= curdate()";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Cantidad de trabajadores con vacaciones por empresa
    function cantidadtrabajadoresconvacacionesempresa($empresa)
    {
        $this->conexion();
        $sql = "select count(vacaciones.trabajador) as cantidad from vacaciones,trabajadores where fechatermino >= curdate() and trabajadores.empresa = $empresa and vacaciones.trabajador = trabajadores.id";
        $result = $this->mi->query($sql);
        $rs = mysqli_fetch_array($result);
        $cantidad = $rs['cantidad'];
        $this->desconectar();
        return $cantidad;
    }

    //Acumulacion de vacaciones superiores a 30 dias
    public function acumulaciondevacaciones()
    {
        $this->conexion();
        $sql = "select distinct trabajadores.id as id, trabajadores.rut, dni, nombre, primerapellido,segundoapellido,fechanacimiento, fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension, empresa.razonsocial as empresa from trabajadores,contratos,empresa where trabajadores.id=contratos.trabajador and trabajadores.empresa = empresa.id  and estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Acumulacion de vacaciones superiores a 30 dias por empresa
    public function acumulaciondevacacionesempresa($empresa)
    {
        $this->conexion();
        $sql = "select distinct trabajadores.id as id, trabajadores.rut, dni, nombre, primerapellido,segundoapellido,fechanacimiento, fechanacimiento, sexo, estadocivil, nacionalidad, discapacidad, pension, empresa.razonsocial as empresa from trabajadores,contratos,empresa where trabajadores.id=contratos.trabajador and trabajadores.empresa = empresa.id and trabajadores.empresa = $empresa and estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $dni = $rs['dni'];
            $nombre = $rs['nombre'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $sexo = $rs['sexo'];
            $estadocivil = $rs['estadocivil'];
            $nacionalidad = $rs['nacionalidad'];
            $discapacidad = $rs['discapacidad'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = "";
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //Licencias medicas registradas en los ultimos 30 dias
    public function licenciamedicasdelosultimos30dias()
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and fechainicio >= DATE_SUB(NOW(), INTERVAL 30 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }

    //Licencias medicas registradas en los ultimos 30 dias por empresa
    public function licenciamedicasdelosultimos30diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and empresa=$empresa and fechainicio >= DATE_SUB(NOW(), INTERVAL 30 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }

    //Licencias medicas registradas en los ultimos 60 dias
    public function licenciamedicasdelosultimos60dias()
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and fechainicio >= DATE_SUB(NOW(), INTERVAL 60 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }
    //Licencias medicas registradas en los ultimos 60 dias por empresa
    public function licenciamedicasdelosultimos60diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and empresa=$empresa and fechainicio >= DATE_SUB(NOW(), INTERVAL 60 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }

    //Licencias medicas registradas en los ultimos 90 dias
    public function licenciamedicasdelosultimos90dias()
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and fechainicio >= DATE_SUB(NOW(), INTERVAL 90 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }
    //Licencias medicas registradas en los ultimos 60 dias por empresa
    public function licenciamedicasdelosultimos90diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1tra, trabajadores.segundoapellido as apellido2tra , empresa.razonsocial from licenciamedica,tipolicencia, pagadoressubsidio,trabajadores,empresa where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and licenciamedica.pagadora = pagadoressubsidio.id and empresa=$empresa and fechainicio >= DATE_SUB(NOW(), INTERVAL 90 DAY) order by fechainicio desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $tipolicencia = $rs['tipolicencia'];
            $inicio = $rs['fechainicio'];
            $fin = $rs['fechatermino'];
            $pagadora = $rs['pagado'];
            $comentario = $rs['comentario'];
            $documentolicencia = $rs['documentolicencia'];
            $comprobantetramite = $rs['comprobantetramite'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1tra'] . " " . $rs['apellido2tra'];
            $registro = $rs['razonsocial'];
            $licencia = new Licencias($id, $folio, $tipolicencia, $inicio, $fin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro);
            $lista[] = $licencia;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 30 dias
    public function listarcargasporvenceren30dias()
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and vigencia between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['nomtra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 30 dias
    public function listarcargasporvenceren30diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and empresa=$empresa and vigencia between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['trabajador'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 60 dias
    public function listarcargasporvenceren60dias()
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and vigencia between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['nomtra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 60 dias
    public function listarcargasporvenceren60diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and empresa=$empresa and vigencia between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['trabajador'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 90 dias
    public function listarcargasporvenceren90dias()
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and vigencia between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['nomtra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargas familiares por vencer el los proximos 90 dias
    public function listarcargasporvenceren90diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select cargastrabajador.id as id, cargastrabajador.rut as rut, nombres, cargastrabajador.primerapellido as primerapellido, cargastrabajador.segundoapellido as segundoapellido, cargastrabajador.fechanacimiento as fechanacimiento, estadocivil.nombre as estadocivil, fechareconocimiento, fechapago, vigencia, tipocausante.nombre as tipocausante, sexo.nombre as sexo, tramosasignacionfamiliar.nombre as tipocarga, documento, cargastrabajador.register_at as register_at, trabajadores.nombre as nomtra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa,comentario from cargastrabajador, estadocivil, tipocausante, sexo, tramosasignacionfamiliar,trabajadores, empresa where cargastrabajador.trabajador=trabajadores.id and trabajadores.empresa=empresa.id and cargastrabajador.civil = estadocivil.id and cargastrabajador.tipocausante = tipocausante.id and cargastrabajador.sexo = sexo.id and cargastrabajador.tipocarga = tramosasignacionfamiliar.id and empresa=$empresa and vigencia between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $rut = $rs['rut'];
            $nombre = $rs['nombres'];
            $apellido1 = $rs['primerapellido'];
            $apellido2 = $rs['segundoapellido'];
            $nacimiento = $rs['fechanacimiento'];
            $civil = $rs['estadocivil'];
            $reconocimiento = $rs['fechareconocimiento'];
            $pago = $rs['fechapago'];
            $vigencia = $rs['vigencia'];
            $tipocausante = $rs['tipocausante'];
            $sexo = $rs['sexo'];
            $tipocarga = $rs['tipocarga'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $trabajador = $rs['trabajador'];
            $comentario = $rs['empresa'];
            $carga = new CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $tipocausante, $sexo, $tipocarga, $documento, $registro, $trabajador, $comentario);
            $lista[] = $carga;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar documentos subidos
    function listardocumentossubidos($trabajador)
    {
        $this->conexion();
        $sql = "select documentosubido.id as id, titulo, tipodocumentosubido.nombre as tipo, observacion, trabajador, empresa, documento, register_at from documentosubido, tipodocumentosubido where documentosubido.tipodocumento = tipodocumentosubido.id and trabajador=$trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $titulo = $rs['titulo'];
            $tipo = $rs['tipo'];
            $observacion = $rs['observacion'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $documentosubido = new DocumentoSubido($id, $titulo, $tipo, $observacion, $trabajador, $empresa, $documento, $registro);
            $lista[] = $documentosubido;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar documento subido
    function eliminardocumentosubido($id)
    {
        $this->conexion();
        $sql = "delete from documentosubido where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function calcularDias($fechaInicio, $fechaFin) {
        $diasHabiles = 0;
        $diasFinSemana = 0;
        
        $fechaInicio = strtotime($fechaInicio);
        $fechaFin = strtotime($fechaFin);
        $diasferiados =0;
        while ($fechaInicio <= $fechaFin) {
            $diaSemana = date('N', $fechaInicio);
            
            if ($diaSemana >= 1 && $diaSemana <= 5) {
                // Día hábil
                $diasHabiles++;
                $feriado = $this->buscarferiadoporfecha(date('Y-m-d', $fechaInicio));
                if($feriado != false){
                    $diasferiados++;
                }
            } else {
                // Día fin de semana
                $diasFinSemana++;
            }
            
            $fechaInicio = strtotime('+1 day', $fechaInicio);
        }
        
        //$diasFeriados = count(array_intersect($feriados, obtenerFechas($fechaInicio, $fechaFin)));
        
        $diasHabiles -= $diasferiados;
        $totales = $diasHabiles + $diasFinSemana + $diasferiados;
        
        return [
            'diasHabiles' => $diasHabiles,
            'diasFinSemana' => $diasFinSemana,
            'diasFeriados' => $diasferiados,
            'totales' => $totales
        ];
    }

    
    
    function obtenerFechas($fechaInicio, $fechaFin) {
        $fechas = array();
        while ($fechaInicio <= $fechaFin) {
            $fechas[] = date('Y-m-d', $fechaInicio);
            $fechaInicio = strtotime('+1 day', $fechaInicio);
        }
        return $fechas;
    }
    
}
