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
require 'Class/Tipousuario.php';
require 'Class/Users.php';
require 'Class/Vacaciones.php';
require 'Class/DocumentoSubido.php';
require 'Class/Anexo.php';
require 'Class/Clausulaanexo.php';
require 'Class/Codigolre.php';
require 'Class/Haber.php';
require 'Class/Haber_trabajador.php';
require 'Class/Documentofirmado.php';
require 'Class/Notificacionfirmado.php';
require 'Class/Documentoempresa.php';
require 'Class/mandante.php';
require 'Class/Formula.php';
require 'Class/Liquidacion.php';
require 'Class/Detalle_liquidacion.php';

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

    //Query return ID
    public function query_id($sql)
    {
        $this->conexion();
        $result = $this->mi->query($sql);
        $id = $this->mi->insert_id;
        $this->desconectar();
        return $id;
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
        $sql = "select * from users where (rut = '$user' or email = '$user') and password = sha1('$pass')";
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
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
    public function registrarcomunas($codigo, $codigoPrevired, $codigox, $nombre, $region, $provincia)
    {
        $this->conexion();
        $sql = "insert into comunas values (null, '$codigo', '$codigoPrevired','$codigox', '$nombre', $region, $provincia)";
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
    public function registrarcausaltermino($codigo, $codigoPrevired, $articulo, $letra, $nombre)
    {
        $this->conexion();
        $sql = "insert into causalterminocontrato values (null, '$codigo', '$codigoPrevired', '$articulo','$letra','$nombre')";
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

    //Listar Tipo Usuario
    function listartipousuario()
    {
        $this->conexion();
        $sql = "select * from tipousuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $tipousuario = new TipoUsuario($id, $nombre);
            $lista[] = $tipousuario;
        }
        $this->desconectar();
        return $lista;
    }

    //Registrar Usuarios
    public function registrarusuario($rut, $nombre, $apellido, $correo, $direccion, $region, $comuna, $telefono, $pass, $tipo)
    {
        $this->conexion();
        $sql = "insert into users values(null, '$rut', '$nombre', '$apellido', '$correo', '$direccion', $region, $comuna, '$telefono', sha1('$pass'), 1,$tipo, sha1('$correo'), now(), now());";
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

    //Eliminar plantilla
    function eliminarplantilla($tipo)
    {
        $this->conexion();
        $sql = "delete from plantillas where tipodocumento = $tipo";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
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
    public function registrartasaafp($id, $periodo,$tasasis, $tasa)
    {
        $this->conexion();
        $sql = "insert into tasaafp values(null, $id, '$periodo',$tasasis, $tasa)";
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
        $sql = "select id, month(fecha) as mes, year(fecha) as ano,tasasis, tasa from tasaafp where afp = $idins order by fecha desc";
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
            $tasasis = $rs['tasasis'];
            $T = new Tasa($id, $tasasis, $periodo, $tasa);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }

    //buscar tasa afp
    public function buscartasaafp($afp, $mes, $ano)
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano, tasasis,tasa from tasaafp where afp = $afp and month(fecha) = $mes and year(fecha) = $ano";
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
            $tasasis = $rs['tasasis'];
            $tasa = $rs['tasa'];
            $T = new Tasa($id, $tasasis, $periodo, $tasa);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return null;
    }

    //Buscar ultima tasa afp

    public function buscarultimatasaafp($afp)
    {
        $this->conexion();
        $sql = "select id, month(fecha) as mes, year(fecha) as ano,tasasis, tasa from tasaafp where afp = $afp order by fecha desc limit 1";
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
            $tasasis = $rs['tasasis'];
            $tasa = $rs['tasa'];
            $T = new Tasa($id, $tasasis, $periodo, $tasa);
            $this->desconectar();
            return $T;
        }
        $this->desconectar();
        return null;
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
    public function buscarestadocivil($id)
    {
        $this->conexion();
        $sql = "select * from estadocivil where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
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
        $sql = "select trabajadores.id as id, contratos.id as contrato, rut, dni, trabajadores.nombre as nombre, primerapellido,segundoapellido,fechanacimiento, fechainicio as fechanacimiento, sexo, centrocosto.nombre as centrocosto, estadocivil, nacionalidad, discapacidad,contratos.id as centroid, pension, trabajadores.empresa as empresa from centrocosto,trabajadores,contratos where trabajadores.id=contratos.trabajador and trabajadores.empresa = $empresa and contratos.estado=1 and centrocosto.id=contratos.centrocosto group by trabajadores.id;";
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
            $nacionalidad = $rs['centroid'];
            $discapacidad = $rs['centrocosto'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = $rs["contrato"];
            $T = new Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $estadocivil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar);
            $lista[] = $T;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Trabajadores Activos
    public function listartrabajadoresactivoscenter($empresa, $centrocosto)
    {
        $this->conexion();
        $sql = "select trabajadores.id as id, contratos.id as contrato, rut, dni, trabajadores.nombre as nombre, primerapellido,segundoapellido,fechanacimiento, fechainicio as fechanacimiento, sexo, centrocosto.nombre as centrocosto, estadocivil, nacionalidad, contratos.id as centroid, discapacidad, pension, trabajadores.empresa as empresa from centrocosto,trabajadores,contratos where trabajadores.id=contratos.trabajador and trabajadores.empresa = $empresa and contratos.estado=1 and centrocosto.id=contratos.centrocosto and centrocosto.id=$centrocosto group by trabajadores.id;";
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
            $nacionalidad = $rs['centroid'];
            $discapacidad = $rs['centrocosto'];
            $pension = $rs['pension'];
            $empresa = $rs['empresa'];
            $registrar = $rs["contrato"];
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
            $codigox = $rs['codigox'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $codigox, $nombre, $id, $provincia);
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
            $codigox = $rs['codigox'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $codigox, $nombre, $id, $provincia);
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
            $codigox = $rs['codigox'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $codigox, $nombre, $id, $provincia);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Comunas
    public function listarcomunas1($id)
    {
        $this->conexion();
        $sql = "select comunas.id as id, comunas.codigo as codigo, comunas.codigoprevired as codigoprevired, comunas.codigox as codigox, comunas.nombre as nombre , provincias.nombre as provincia from comunas, provincias where comunas.provincia = provincias.id and comunas.region = $id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoPrevired = $rs['codigoprevired'];
            $codigox = $rs['codigox'];
            $nombre = $rs['nombre'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $codigox, $nombre, $id, $provincia);
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
            $articulo = $rs['articulo'];
            $letra = $rs['letra'];
            $nombre = $rs['nombre'];
            $causal = new CausalTermino($id, $codigo, $codigoPrevired, $articulo, $letra, $nombre);
            $lista[] = $causal;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Tipo Documento
    public function listartipodocumento()
    {
        $this->conexion();
        $sql = "select * from tipodocumento;";
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


    //Listar Tipo Documento
    public function listartipodocumento1($empresa)
    {
        $this->conexion();
        $sql = "select tipodocumento.id as id, tipodocumento.codigo as codigo, tipodocumento.codigoprevired as codigoprevired, tipodocumento.nombre as nombre from tipodocumento, escritoempresa where tipodocumento.id = escritoempresa.tipodocumento and escritoempresa.empresa = $empresa;";
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

    //Asignar Documento a Empresa
    public function asignardocumento($empresa, $documento)
    {
        $this->conexion();
        $sql = "insert into escritoempresa (tipodocumento, empresa) values ($documento, $empresa);";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //REtirar Documento a Empresa
    public function retirardocumento($empresa, $documento)
    {
        $this->conexion();
        $sql = "delete from escritoempresa where tipodocumento = $documento and empresa = $empresa;";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Validar Documento Empresa
    public function validardocumento($empresa, $documento)
    {
        $this->conexion();
        $sql = "select * from escritoempresa where tipodocumento = $documento and empresa = $empresa;";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
            $lista[] = $user;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Usuarios
    public function listarusuariostipo($tipo)
    {
        $this->conexion();
        $sql = "select * from users where tipousuario=$tipo;";
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
            $lista[] = $user;
        }
        $this->desconectar();
        return $lista;
    }


    //Buscar Usuario
    public function buscarusuario($id)
    {
        $this->conexion();
        $sql = "select * from users where id_usu = $id;";
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
            $this->desconectar();
            return $user;
        }
        $this->desconectar();
        return null;
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
        while ($rs = mysqli_fetch_array($result)) {
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
        if ($rs = mysqli_fetch_array($result)) {
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
    public function actualizarcomuna($id, $codigo, $codigoPrevired, $codigox, $nombre, $provincia)
    {
        $this->conexion();
        $sql = "update comunas set codigo='$codigo', codigoprevired='$codigoPrevired', codigox='$codigox', nombre='$nombre', provincia=$provincia where id=$id";
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
    public function actualizarcausalterminocontrato($id, $codigo, $codigoPrevired, $articulo, $letra, $nombre)
    {
        $this->conexion();
        $sql = "update causalterminocontrato set codigo='$codigo', codigoprevired='$codigoPrevired', articulo='$articulo', letra='$letra', nombre='$nombre' where id=$id";
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
    public function actualizarusuario($id, $rut, $nombre, $apellido, $correo, $direccion, $region, $comuna, $telefono, $tipo)
    {
        $this->conexion();
        $sql = "update users set rut = '$rut', nombre = '$nombre', apellidos = '$apellido', email = '$correo', direccion = '$direccion', region = $region, comuna = $comuna, telefono = '$telefono', tipousuario=$tipo, updated_at = now() where id_usu = $id";
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
            $codigox = $rs['codigox'];
            $nombre = $rs['nombre'];
            $region = $rs['region'];
            $provincia = $rs['provincia'];
            $comuna = new Comunas($id, $codigo, $codigoprevired, $codigox, $nombre, $region, $provincia);
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
            $articulo = $rs['articulo'];
            $letra = $rs['letra'];
            $nombre = $rs['nombre'];
            $causal = new CausalTermino($id, $codigo, $codigoprevired, $articulo, $letra, $nombre);
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
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
        $sql = "select id_usu,rut, users.nombre as nombre, apellidos, email, direccion,tipousuario, regiones.nombre as region, comunas.nombre as comuna, telefono, password, status.nombre as estado, token, created_at, updated_at from users, regiones, comunas, status where regiones.id = users.region and comunas.id = users.comuna and status.id = users.estado and users.id_usu = $id";
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
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
            $tipo = $rs['tipousuario'];
            $registro = $rs['created_at'];
            $update = $rs['updated_at'];
            $user = new Users($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $tipo, $registro, $update);
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

    public function buscarprevisiones($trabajador)
    {
        $this->conexion();
        $sql = "select * from previsiontrabajador where trabajador = $trabajador";
        $result = $this->mi->query($sql);
        $lista = array();
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

    //Buscar licencia medicas por trabajador y fecha
    public function buscarlicencias($trabajador, $inicio, $fin)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajador, register_at from licenciamedica,tipolicencia, pagadoressubsidio where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.pagadora = pagadoressubsidio.id and trabajador = $trabajador and fechainicio between '$inicio' and '$fin'";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
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
            $this->desconectar();
            return $licencia;
        }
        $this->desconectar();
        return null;
    }

    //Ultima Licencia Medica mostrando RUT pagador subsidio
    public function ultimalicencia($trabajador)
    {
        $this->conexion();
        $sql = "select licenciamedica.id as id,folio, tipolicencia.nombre as tipolicencia, fechainicio, fechatermino,pagadoressubsidio.codigoprevired as rut, pagadoressubsidio.nombre as pagado, comentario, documentolicencia,comprobantetramite, trabajador, register_at from licenciamedica,tipolicencia, pagadoressubsidio where tipolicencia.id=licenciamedica.tipolicencia and licenciamedica.pagadora = pagadoressubsidio.id and trabajador = $trabajador order by register_at desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
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
            $this->desconectar();
            return $licencia;
        }
        $this->desconectar();
        return false;
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
            $V = new Vacaciones($id, $trabajador, $periodoinicio, $periodotermino, $diasacumulados, $anoacumulados, $diasprograsivas, $tipodocumento, $fechainicio, $fechatermino, $diashabiles, $diasinhabiles, $diasferiados, $totales, $diasrestantes, $observacion, $comprobantefirmado, $registro);
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
            $V = new Vacaciones($id, $trabajador, $periodoinicio, $periodotermino, $diasacumulados, $anoacumulados, $diasprograsivas, $tipodocumento, $fechainicio, $fechatermino, $diashabiles, $diasinhabiles, $diasferiados, $totales, $diasrestantes, $observacion, $comprobantefirmado, $registro);
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
            $comuna = new Comunas($id, $codigo, $codigoPrevired, $id, $nombre, $id, $id);
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
            $comuna = new Comunas($id, $comunaid, $comunaid, $comunaid, $comuna, $id, $id);
            $lista[] = $comuna;
        }
        $this->desconectar();
        return $lista;
    }

    //function listarcontratos($trabajador)
    function listarcontratos($trabajador)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, contratos.centrocosto as centrocosto, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.trabajador = $trabajador and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    function buscarcontrato($trabajador)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, contratos.centrocosto as centrocosto, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.trabajador = $trabajador and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and contratos.estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    function buscarcontratobyID($id)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, contratos.centrocosto as centrocosto, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.id=$id and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and contratos.estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //listar contratos activos por empresa
    function listarcontratosactivosempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.rut as rut,trabajadores.nombre as nombre, centrocosto.nombre as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos,centrocosto, trabajadores, empresa where contratos.empresa = $empresa and trabajadores.id = contratos.trabajador and contratos.centrocosto=centrocosto.id and empresa.id = contratos.empresa and contratos.estado=1";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {

            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['rut'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }


    //Buscar contrato por id
    function buscarcontratoid($id)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.id as traid,contratos.centrocosto as centrocosto, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.id = $id and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['traid'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //Search COntrato
    function searchcontrato($id)
    {
        $this->conexion();
        $sql = "select * from contratos where id = $id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $tipocontrato = $rs['tipocontrato'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $trabajador, $empresa, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $this->desconectar();
            return $contrato;
        }
        $this->desconectar();
        return false;
    }

    //Buscar contrato por id
    function buscarcontratoid1($id)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.id as traid,contratos.centrocosto as centrocosto, trabajadores.nombre as nombre, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.id as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.id = $id and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['traid'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
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
        $sql = "select contratos.id as id, trabajadores.id as traid, trabajadores.nombre as nombre,contratos.centrocosto as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.trabajador=$trabajador and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and contratos.estado=1 order by contratos.id desc limit 1";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['traid'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
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
        $sql = "select finiquito.id as id, centrocosto.nombre as centrocosto, finiquito.contrato as contrato, finiquito.tipodocumento as tipodocumento, finiquito.fechafiniqito as fechafiniqito, finiquito.fechainicio as fechainicio, finiquito.fechatermino as fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from contratos,centrocosto, finiquito,trabajadores, causalterminocontrato where finiquito.causalterminocontrato = causalterminocontrato.id and  finiquito.empresa = $empresa and finiquito.trabajador = trabajadores.id and finiquito.contrato = contratos.id and contratos.centrocosto = centrocosto.id";
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
            $register_at = $rs['centrocosto'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Finiquito valores por id
    function buscarfiniquito1($id)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, centrocosto.id as centrocosto, finiquito.contrato as contrato, finiquito.tipodocumento as tipodocumento, finiquito.fechafiniqito as fechafiniqito, finiquito.fechainicio as fechainicio, finiquito.fechatermino as fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from contratos,centrocosto, finiquito,trabajadores, causalterminocontrato where finiquito.causalterminocontrato = causalterminocontrato.id  and finiquito.trabajador = trabajadores.id and finiquito.contrato = contratos.id and contratos.centrocosto = centrocosto.id and finiquito.id = $id";
        $result = $this->mi->query($sql);
        $finiquito = null;
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['rut'];
            $register_at = $rs['centrocosto'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
        }
        $this->desconectar();
        return $finiquito;
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


    //Listar Lotes con contratos Inactivos
    function listarlotestext4($lote)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato, detallelotes.id as id, finiquito.id as nombre, contratos.tipocontrato as tipocontrato, finiquito.fechainicio as fechainicio,finiquito.fechatermino as fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, notificaciones.id as notifid, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto from comunicacion, detallelotes, lotes, contratos, finiquito,trabajadores, notificaciones where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and finiquito.contrato=contratos.id and notificaciones.finiquito=finiquito.id and contratos.trabajador = trabajadores.id and contratos.estado = 2 and lotes=$lote and comunicacion.id = notificaciones.comunicacion order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['notifid'];
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
            $register_at = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
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
        $sql = "select notificaciones.id as id, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causalterminocontrato.nombre as causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto from notificaciones,causalterminocontrato, finiquito,contratos, comunicacion, trabajadores, centrocosto where notificaciones.finiquito = finiquito.id and finiquito.contrato = contratos.id and finiquito.trabajador = trabajadores.id and comunicacion.id = notificaciones.comunicacion and contratos.centrocosto = centrocosto.id and finiquito.empresa = $empresa and causalterminocontrato.id = notificaciones.causal";
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
            $texto = $rs['comunicacion'];
            $register_at = $rs['centrocosto'];
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
        $sql = "select distinct detallelotes.contrato, detallelotes.id as id, lotes.nombre as nombre, contratos.tipocontrato as tipocontrato, fechainicio, fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, contratos.documento as documento, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 1 and lotes=$empresa order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['tipocontrato'];
            if ($contrato == "Contrato a Plazo Fijo") {
                $contrato = "Plazo Fijo";
            } else if ($contrato == "Contrato Indefinido") {
                $contrato = "Indefinido";
            }
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Lotes con contratos activos
    function listarlotestext2($empresa)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato as idcont, detallelotes.id as id, lotes.nombre as nombre, contratos.tipocontrato as tipocontrato, fechainicio, fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, contratos.documento as documento, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 1 and lotes=$empresa order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['tipocontrato'];
            if ($contrato == "Contrato a Plazo Fijo") {
                $contrato = "Plazo Fijo";
            } else if ($contrato == "Contrato Indefinido") {
                $contrato = "Indefinido";
            }
            $contrato = $contrato . " - " . date("d-m-Y", strtotime($rs['fechainicio']));
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fechainicio = $rs['documento'];
            $fechatermino = $rs['idcont'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Lotes con contratos activos
    function listarlotestext3($lote)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato  as idcontrato, detallelotes.id as id, lotes.nombre as nombre, fechainicio, fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, contratos.documento as documento, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 1 and lotes=$lote order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['idcontrato'];
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fechainicio = $rs['documento'];
            $fechatermino = $rs['fechatermino'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }


    //Eliminar lote
    function eliminarlotecontrato($id)
    {
        $this->conexion();
        $sql = "delete from lotes where id = $id";
        $result = $this->mi->query($sql);
        $sql = "delete from detallelotes where lotes = $id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function eliminarcontratohoraspactadas($contrato){
        $this->conexion();
        $sql = "delete from horaspactadas where contrato = $contrato";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Lotes con contratos Inactivos
    function listarlotestext1($lote)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato, detallelotes.id as id, finiquito.id as nombre, contratos.tipocontrato as tipocontrato, finiquito.fechainicio as fechainicio,finiquito.fechatermino as fechatermino, trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from detallelotes, lotes, contratos, finiquito,trabajadores where detallelotes.lotes = lotes.id and detallelotes.contrato = contratos.id and finiquito.contrato=contratos.id and contratos.trabajador = trabajadores.id and contratos.estado = 2 and lotes=$lote order by lotes.nombre asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['tipocontrato'];
            if ($contrato == "Contrato a Plazo Fijo") {
                $contrato = "Plazo Fijo";
            } else if ($contrato == "Contrato Indefinido") {
                $contrato = "Indefinido";
            }
            $lote = $rs['nombre'];
            $nombre = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $l = new Lotes_contrato($id, $contrato, $nombre, $lote, $fechainicio, $fechatermino);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }


    function validarloteids($id, $contrato)
    {
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

    //Listar lotes contrato
    function listarlotescontratoactivos($empresa)
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

    //Listar lotes contrato
    function listarlotescontratoinactivos($empresa)
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
    function registrarloteanexo($contrato, $usuario, $empresa)
    {
        $this->conexion();
        $sql = "insert into lote4 values(null,$contrato,$usuario,$empresa,now())";
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
    function validarloteanexo($contrato, $usuario, $empresa)
    {
        $this->conexion();
        $sql = "select * from lote4 where contrato=$contrato and usuario=$usuario and empresa=$empresa";
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
        $sql = "select lote2.id as id, lote2.contrato as contrato, tipocontrato,contratos.centrocosto as centrocosto, cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as registro,trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from lote2, contratos, trabajadores where lote2.contrato = contratos.id and contratos.trabajador = trabajadores.id and usuario=$usuario";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['contrato'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $lote = $rs['id'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $l = new Contrato($id, $trabajador, $lote, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $registro);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Lote Anexo
    function buscarloteanexo($usuario, $empresa)
    {
        $this->conexion();
        $sql = "select lote4.id as id, lote4.contrato as contrato, contratos.centrocosto as centrocosto, tipocontrato, cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as registro,trabajadores.nombre as nombretra, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2 from lote4, contratos, trabajadores where lote4.contrato = contratos.id and contratos.trabajador = trabajadores.id and usuario=$usuario and lote4.empresa=$empresa";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['contrato'];
            $trabajador = $rs['nombretra'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $lote = $rs['id'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $registro = $rs['registro'];
            $l = new Contrato($id, $trabajador, $lote, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $registro);
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
    function eliminartodoloteanexo($usuario, $empresa)
    {
        $this->conexion();
        $sql = "delete from lote4 where usuario=$usuario and empresa=$empresa";
        $result = $this->mi->query($sql);
        return json_encode($result);
    }

    //Registrar Axexo
    function registraraenxo($contrato, $fechageneracion, $base, $sueldo_base, $estado)
    {
        $this->conexion();
        $sql = "insert into anexoscontrato values(null, $contrato, '$fechageneracion', $base, $sueldo_base, $estado, now())";
        $result = $this->mi->query($sql);
        $id_insert = mysqli_insert_id($this->mi);
        $this->desconectar();
        return $id_insert;
    }

    //Listar Anexo
    function listaranexo($contrato)
    {
        $this->conexion();
        $sql = "select * from anexoscontrato where contrato=$contrato";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $fechageneracion = $rs['fechageneracion'];
            $base = $rs['base'];
            $sueldo_base = $rs['sueldo_base'];
            $estado = $rs['estado'];
            $registro = $rs['register_at'];
            $a = new Anexo($id, $contrato, $fechageneracion, $base, $sueldo_base, $estado, $registro);
            $lista[] = $a;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Anexo
    function buscaranexo($id)
    {
        $this->conexion();
        $sql = "select * from anexoscontrato where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['contrato'];
            $fechageneracion = $rs['fechageneracion'];
            $base = $rs['base'];
            $sueldo_base = $rs['sueldo_base'];
            $estado = $rs['estado'];
            $registro = $rs['register_at'];
            $a = new Anexo($id, $contrato, $fechageneracion, $base, $sueldo_base, $estado, $registro);
            $this->desconectar();
            return $a;
        }
        $this->desconectar();
        return null;
    }

    //Eliminar anexo
    function eliminaranexo($id)
    {
        $this->conexion();
        $sql = "delete from anexoscontrato where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return json_encode($result);
    }

    //Buscar Clausula Anexo
    function buscarclausulaanexo($anexo)
    {
        $this->conexion();
        $sql = "select * from clausulasanexos where anexo=$anexo";
        $result = $this->mi->query($sql);
        $lista = array();
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $anexo = $rs['anexo'];
            $clausula = $rs['clausula'];
            $tipodocumento = $rs['tipodocumento'];
            $registro = $rs['register_at'];
            $a = new ClausulaAnexo($id, $anexo, $clausula, $tipodocumento, $registro);
            $lista[] = $a;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar Clausula Anexo
    function eliminarclausulaanexo($id)
    {
        $this->conexion();
        $sql = "delete from clausulasanexos where anexo=$id";
        $result = $this->mi->query($sql);
        return json_encode($result);
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
    function registrardocumento($trabajador, $empresa, $contrato, $tipodocumento, $fechageneracion, $documento)
    {
        $this->conexion();
        $sql = "insert into documentos values(null, $trabajador, $empresa,$contrato, $tipodocumento, '$fechageneracion','$documento',now())";
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
        $sql = "select documentos.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documentos.documento as documento, documentos.register_at as register_at from centrocosto,contratos, trabajadores,documentos, tipodocumento where documentos.tipodocumento = tipodocumento.id and documentos.empresa=$empresa and trabajadores.id = documentos.trabajador and documentos.contrato=contratos.id and contratos.centrocosto = centrocosto.id";
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
            $register_at = $rs['centrocosto'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar documentos text empresa
    function listardocumentostextempresa2($empresa)
    {
        $this->conexion();
        $sql = "select otrosdocumentosfirmados.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, otrosdocumentosfirmados.documento as documento, documentos.register_at as register_at from centrocosto, trabajadores,documentos,otrosdocumentosfirmados, tipodocumento where documentos.tipodocumento = tipodocumento.id and otrosdocumentosfirmados.empresa=$empresa and trabajadores.id = documentos.trabajador and otrosdocumentosfirmados.centrocosto = centrocosto.id and otrosdocumentosfirmados.id_doc=documentos.id";
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
            $register_at = $rs['centrocosto'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }



    function listardocumentostextempresa1($empresa)
    {
        $this->conexion();
        $sql = "select documentos.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.id as centrocosto, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documentos.documento as documento, documentos.register_at as register_at from centrocosto,contratos, trabajadores,documentos, tipodocumento where documentos.tipodocumento = tipodocumento.id and documentos.empresa=$empresa and trabajadores.id = documentos.trabajador and documentos.contrato=contratos.id and contratos.centrocosto = centrocosto.id";
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
            $register_at = $rs['centrocosto'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Documento por id
    function buscardocumentoporid($id)
    {
        $this->conexion();
        $sql = "select documentos.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.id as centrocosto, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documentos.documento as documento, documentos.register_at as register_at from centrocosto,contratos, trabajadores,documentos, tipodocumento where documentos.tipodocumento = tipodocumento.id and documentos.id=$id and trabajadores.id = documentos.trabajador and documentos.contrato=contratos.id and contratos.centrocosto = centrocosto.id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['rut'];
            $tipodocumento = $rs['tipodocumento'];
            $fechageneracion = $rs['fechageneracion'];
            //cambiar formato de fecha a dd/mm/yyyy
            $fechageneracion = date("d/m/Y", strtotime($fechageneracion));
            $documento = $rs['documento'];
            $register_at = $rs['centrocosto'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $this->desconectar();
            return $l;
        }
        $this->desconectar();
        return null;
    }

    //Listar Lotes con contratos Inactivos
    function listarlotestext5($lote)
    {
        $this->conexion();
        $sql = "select distinct detallelotes.contrato, detallelotes.id as id, documentos.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, documentos.documento as documento, documentos.register_at as register_at from detallelotes, trabajadores,documentos, tipodocumento, contratos where documentos.tipodocumento = tipodocumento.id and lotes=$lote and trabajadores.id = documentos.trabajador and contratos.trabajador = trabajadores.id and contratos.estado = 1 and detallelotes.contrato = contratos.id";
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
        $sql = "select contratos.id as id, trabajadores.nombre as nombre,contratos.centrocosto as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar los contratos que terminan dentro de los proximos 30 dias
    function listarcontratosquevenceranenlosproximos30dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre,contratos.centrocosto as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 30 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar los contratos que terminan dentro de los proximos 60 dias
    function listarcontratosquevenceranenlosproximos60diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre,contratos.centrocosto as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 60 dias
    function listarcontratosquevenceranenlosproximos60dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, contratos.centrocosto as centrocostom, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 60 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 90 dias
    function listarcontratosquevenceranenlosproximos90diasempresa($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, contratos.centrocosto as centrocosto,trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where contratos.empresa = $empresa and fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar los contratos que terminan dentro de los proximos 90 dias
    function listarcontratosquevenceranenlosproximos90dias()
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.nombre as nombre, contratos.centrocosto as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, documento, estado, contratos.register_at as register_at from contratos, trabajadores, empresa where fechatermino!='' and estado=1 and trabajadores.id = contratos.trabajador and empresa.id = contratos.empresa and fechatermino between curdate() and date_add(curdate(), interval 90 day)";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['register_at'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
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

    function calcularDias($fechaInicio, $fechaFin)
    {
        $diasHabiles = 0;
        $diasFinSemana = 0;

        $fechaInicio = strtotime($fechaInicio);
        $fechaFin = strtotime($fechaFin);
        $diasferiados = 0;
        while ($fechaInicio <= $fechaFin) {
            $diaSemana = date('N', $fechaInicio);

            if ($diaSemana >= 1 && $diaSemana <= 5) {
                // Día hábil
                $diasHabiles++;
                $feriado = $this->buscarferiadoporfecha(date('Y-m-d', $fechaInicio));
                if ($feriado != false) {
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

    function obtenerFechas($fechaInicio, $fechaFin)
    {
        $fechas = array();
        while ($fechaInicio <= $fechaFin) {
            $fechas[] = date('Y-m-d', $fechaInicio);
            $fechaInicio = strtotime('+1 day', $fechaInicio);
        }
        return $fechas;
    }

    /*****************************************************Sistema de Remunereaciones********************************************************************* */
    //Listar Codigo lre
    function listarcodigoslre()
    {
        $this->conexion();
        $sql = "select * from codigolre order by codigo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $articulo = $rs['articulo'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $descripcion = $rs['nombre'];
            $registro = $rs['register_at'];
            $codigolre = new Codigolre($id, $articulo, $codigo, $codigoprevired, $descripcion, $registro);
            $lista[] = $codigolre;
        }
        $this->desconectar();
        return $lista;
    }

    //Registrar Codigo lre
    function registrarcodigolre($articulo, $codigo, $codigoprevired, $descripcion)
    {
        $this->conexion();
        $sql = "insert into codigolre(articulo,codigo,codigoprevired,nombre) values('$articulo','$codigo','$codigoprevired','$descripcion')";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar Codigo lre
    function eliminarcodigolre($id)
    {
        $this->conexion();
        $sql = "delete from codigolre where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Editar Codigo lre
    function editarcodigolre($id, $articulo, $codigo, $codigoprevired, $descripcion)
    {
        $this->conexion();
        $sql = "update codigolre set articulo='$articulo', codigo='$codigo', codigoprevired='$codigoprevired', nombre='$descripcion' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar Codigo lre
    function buscarcodigolre($id)
    {
        $this->conexion();
        $sql = "select * from codigolre where id=$id";
        $result = $this->mi->query($sql);
        $codigolre = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $articulo = $rs['articulo'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $descripcion = $rs['nombre'];
            $registro = $rs['register_at'];
            $codigolre = new Codigolre($id, $articulo, $codigo, $codigoprevired, $descripcion, $registro);
        }
        $this->desconectar();
        return $codigolre;
    }

    //Listar Haberes y descuentos
    function listarhaberesydescuentos()
    {
        $this->conexion();
        $sql = "select * from habres_descuentos order by codigo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $descripcion = $rs['descripcion'];
            $tipo = $rs['tipo'];
            $imponible = $rs['imponible'];
            $tributable = $rs['tributable'];
            $gratificacion = $rs['gratificacion'];
            $reservado = $rs['reservado'];
            $codigolre = $rs['codigolre'];
            $aplicaformula = $rs['aplicaformula'];
            $formula = $rs['formula'];
            $agrupacion = $rs['agrupacion'];
            $tipohaber = $rs['tipohaber'];
            $registro = $rs['register_at'];
            $haber = new Haber($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $aplicaformula, $formula, $agrupacion, $tipohaber, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Descuentos relacional
    function listarhaberesydescuentostext()
    {
        $this->conexion();
        $sql = "select habres_descuentos.id as id, habres_descuentos.codigo as codigo, habres_descuentos.descripcion as descripcion, habres_descuentos.tipo as tipo, habres_descuentos.imponible as imponible, habres_descuentos.tributable as tributable, habres_descuentos.gratificacion as gratificacion, habres_descuentos.reservado as reservado, habres_descuentos.codigolre as codigolre, habres_descuentos.agrupacion as agrupacion,habres_descuentos.aplicaformula as aplicaformula, habres_descuentos.formula as formula, habres_descuentos.tipohaber as tipohaber, habres_descuentos.register_at as register_at, codigolre.articulo as articulo, codigolre.codigo as codigolre, codigolre.codigoprevired as codigoprevired, codigolre.nombre as nombre from habres_descuentos, codigolre where habres_descuentos.codigolre=codigolre.id order by habres_descuentos.codigo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $descripcion = $rs['descripcion'];
            $tipo = $rs['tipo'];
            $imponible = $rs['imponible'];
            $tributable = $rs['tributable'];
            $gratificacion = $rs['gratificacion'];
            $reservado = $rs['reservado'];
            $codigolre = $rs['codigolre'];
            $tipohaber = $rs['tipohaber'];
            $registro = $rs['register_at'];
            $articulo = $rs['articulo'];
            $codigolre = $rs['nombre'] . " (" . $rs['codigolre'] . ")";
            $aplicaformula = $rs['aplicaformula'];
            $formula = $rs['formula'];
            $agrupacion = $rs['agrupacion'];
            $tipohaber = $rs['tipohaber'];
            $registro = $rs['register_at'];
            $haber = new Haber($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $aplicaformula, $formula, $agrupacion, $tipohaber, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Haberes y descuentos por empresa
    function listarhaberesydescuentosempresa($empresa)
    {
        $this->conexion();
        $sql = "select * from habres_descuentos where empresa=$empresa or tipohaber=1 order by codigo asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $descripcion = $rs['descripcion'];
            $tipo = $rs['tipo'];
            $imponible = $rs['imponible'];
            $tributable = $rs['tributable'];
            $gratificacion = $rs['gratificacion'];
            $reservado = $rs['reservado'];
            $codigolre = $rs['codigolre'];
            $aplicaformula = $rs['aplicaformula'];
            $formula = $rs['formula'];
            $agrupacion = $rs['agrupacion'];
            $tipohaber = $rs['tipohaber'];
            $registro = $rs['register_at'];
            $haber = new Haber($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $aplicaformula, $formula, $agrupacion, $tipohaber, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Buscar Haberes y descuentos
    function buscarhaberesydescuentos($id)
    {
        $this->conexion();
        $sql = "select * from habres_descuentos where id=$id";
        $result = $this->mi->query($sql);
        $haber = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $descripcion = $rs['descripcion'];
            $tipo = $rs['tipo'];
            $imponible = $rs['imponible'];
            $tributable = $rs['tributable'];
            $gratificacion = $rs['gratificacion'];
            $reservado = $rs['reservado'];
            $codigolre = $rs['codigolre'];
            $aplicaformula = $rs['aplicaformula'];
            $formula = $rs['formula'];
            $agrupacion = $rs['agrupacion'];
            $tipohaber = $rs['tipohaber'];
            $registro = $rs['register_at'];
            $haber = new Haber($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $aplicaformula, $formula, $agrupacion, $tipohaber, $registro);
        }
        $this->desconectar();
        return $haber;
    }

    //Registrar Haberes y descuentos
    function registrarhaberesydescuentos($codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $agrupacion, $aplicaformula, $formula, $tipohaber, $empresa)
    {
        $this->conexion();
        $sql = "insert into habres_descuentos values(null,'$codigo','$descripcion',$tipo,$imponible,$tributable,$gratificacion,$reservado,$codigolre,$agrupacion,$aplicaformula,'$formula',$tipohaber, $empresa, now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Verificar si existe el codigo
    function validarcodigohaberes($tipohaber, $empresa, $codigo)
    {
        $this->conexion();
        $sql = "";
        if ($tipohaber == 1) {
            $sql = "select * from habres_descuentos where (tipohaber=1 or tipohaber=2) and codigo='$codigo'";
        } else if ($tipohaber == 2) {
            $sql = "select * from habres_descuentos where codigo='$codigo' and (empresa=$empresa or empresa=0)";
        }
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $this->desconectar();
            return true;
        }
        $this->desconectar();
        return false;
    }

    //Eliminar Haberes y descuentos
    function eliminarhaberesydescuentos($id)
    {
        $this->conexion();
        $sql = "delete from habres_descuentos where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Editar Haberes y descuentos
    function editarhaberesydescuentos($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $codigolre, $aplicaformula, $formula, $agrupacion)
    {
        $this->conexion();
        $sql = "update habres_descuentos set codigo='$codigo', descripcion='$descripcion', tipo=$tipo, imponible=$imponible, tributable=$tributable, gratificacion=$gratificacion, reservado=$reservado, codigolre=$codigolre, aplicaformula=$aplicaformula, formula='$formula', agrupacion=$agrupacion where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Registrar Haberes Y Descuentos
    function registrarhaberes_descuentos_trabajador($codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa)
    {
        $this->conexion();
        $sql = "insert into haberes_descuentos_trabajador values(null,$codigo,'$periodo_inicio','$periodo_termino',$monto,$dias,$horas,$modalidad,$trabajador,$empresa,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Haberes Y Descuentos por periodo
    function listarhaberes_descuento($periodo_ini, $periodo_ter, $empresa)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.periodo_inicio between '$periodo_ini' and '$periodo_ter' and haberes_descuentos_trabajador.empresa=$empresa order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Haberes Y Descuentos por periodo
    function listarhaberes_descuentotrababajador($periodo_ini, $periodo_ter, $empresa, $trabajador)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id,habres_descuentos.id as habid, habres_descuentos.descripcion as codigo,habres_descuentos.aplicaformula as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, habres_descuentos.imponible as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.periodo_inicio between  '$periodo_ini' and '$periodo_ter' and haberes_descuentos_trabajador.empresa=$empresa and haberes_descuentos_trabajador.trabajador=$trabajador order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['habid'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Haberes Y Descuentos por periodo
    function listarhaberes_descuentotipo($periodo_ini, $periodo_ter, $empresa, $tipo)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id,habres_descuentos.id as habid, habres_descuentos.descripcion as codigo,habres_descuentos.aplicaformula as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, habres_descuentos.imponible as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.periodo_inicio between  '$periodo_ini' and '$periodo_ter' and haberes_descuentos_trabajador.empresa=$empresa and habres_descuentos.tipo=$tipo  order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['habid'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }


    //Listar Haberes Y Descuentos por periodo
    function buscarhaberes_descuentotrababajadortipo($periodo_ini, $periodo_ter, $empresa, $trabajador, $tipo)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.periodo_inicio between  '$periodo_ini' and '$periodo_ter' and haberes_descuentos_trabajador.empresa=$empresa and haberes_descuentos_trabajador.trabajador=$trabajador and habres_descuentos.tipo=$tipo order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }



    //Listar Haberes Y Descuentos por periodo
    function buscarhaberes_descuentotrababajador($periodo_ini, $periodo_ter, $empresa, $trabajador, $tipo)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.periodo_inicio between  '$periodo_ini' and '$periodo_ter' and haberes_descuentos_trabajador.empresa=$empresa and haberes_descuentos_trabajador.trabajador=$trabajador order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar todo Haberes Y Descuentos
    function listarhaberesdescuentos($empresa)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.empresa=$empresa order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar todo Haberes Y Descuentos
    function listarhaberesdescuentos1($empresa)
    {
        $this->conexion();
        $sql = "select * from haberes_descuentos_trabajador where empresa=$empresa order by periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $tipo = 0;
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    function obtenerValorHaberPorID($id, $trabajador, $empresa)
    {
        $this->conexion();
        $sql = "select * from haberes_descuentos_trabajador where empresa=$empresa and trabajador=$trabajador and codigo=$id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['trabajador'];
            $empresa = $rs['empresa'];
            $tipo = 0;
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Haberes y Descuentos del Mes actual
    function listarhaberesdescuentosactual($empresa)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.empresa=$empresa and month(haberes_descuentos_trabajador.periodo_inicio)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_inicio)=year(curdate()) and month(haberes_descuentos_trabajador.periodo_termino)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_termino)=year(curdate()) order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar Haberes y Descuentos del Mes actual
    function listarhaberesdescuentosactualtrabajador($empresa, $trabajador)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.empresa=$empresa and month(haberes_descuentos_trabajador.periodo_inicio)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_inicio)=year(curdate()) and month(haberes_descuentos_trabajador.periodo_termino)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_termino)=year(curdate()) and trabajadores.id=$trabajador order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Haberes y Descuentos del Mes actual
    function listarhaberesdescuentosactualtrabajadorhaber($empresa, $trabajador, $tipo)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.empresa=$empresa and month(haberes_descuentos_trabajador.periodo_inicio)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_inicio)=year(curdate()) and month(haberes_descuentos_trabajador.periodo_termino)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_termino)=year(curdate()) and trabajadores.id=$trabajador and habres_descuentos.tipo=$tipo order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Haberes y Descuentos del Mes actual
    function listarhaberesdescuentosactualhaber($empresa, $tipo)
    {
        $this->conexion();
        $sql = "select haberes_descuentos_trabajador.id as id, habres_descuentos.descripcion as codigo,habres_descuentos.tipo as tipo, haberes_descuentos_trabajador.periodo_inicio as periodo_inicio, haberes_descuentos_trabajador.periodo_termino as periodo_termino, haberes_descuentos_trabajador.monto as monto, haberes_descuentos_trabajador.dias as dias, haberes_descuentos_trabajador.horas as horas, haberes_descuentos_trabajador.modalidad as modalidad, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, empresa.razonsocial as empresa, haberes_descuentos_trabajador.register_at as register_at from haberes_descuentos_trabajador, habres_descuentos, trabajadores, empresa where haberes_descuentos_trabajador.codigo=habres_descuentos.id and haberes_descuentos_trabajador.trabajador=trabajadores.id and haberes_descuentos_trabajador.empresa=empresa.id and haberes_descuentos_trabajador.empresa=$empresa and month(haberes_descuentos_trabajador.periodo_inicio)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_inicio)=year(curdate()) and month(haberes_descuentos_trabajador.periodo_termino)=month(curdate()) and year(haberes_descuentos_trabajador.periodo_termino)=year(curdate())  and habres_descuentos.tipo=$tipo order by haberes_descuentos_trabajador.periodo_inicio asc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $periodo_inicio = $rs['periodo_inicio'];
            $periodo_termino = $rs['periodo_termino'];
            $monto = $rs['monto'];
            $dias = $rs['dias'];
            $horas = $rs['horas'];
            $modalidad = $rs['modalidad'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $empresa = $rs['empresa'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $haber = new haberes_trabajador($id, $codigo, $periodo_inicio, $periodo_termino, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro);
            $lista[] = $haber;
        }
        $this->desconectar();
        return $lista;
    }

    function eliminarhaberesdescuentos($id)
    {
        $this->conexion();
        $sql = "delete from haberes_descuentos_trabajador where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }


    /******************Documento Firmado *****************************************/
    /******************Contrato Firmado *****************************************/
    //Registrar Contrato Firmado
    function registrarcontratofirmado($empresa, $centrocosto, $contrato, $documento)
    {
        $this->conexion();
        $sql = "insert into contratosfirmados values(null,$empresa,$centrocosto,$contrato,'$documento',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar Contrato Firmado
    function buscarcontratofirmado($contrato)
    {
        $this->conexion();
        $sql = "select * from contratosfirmados where contrato=$contrato";
        $result = $this->mi->query($sql);
        $contrato = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $contrato = $rs['contrato'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $contrato = new DocumentoFirmado($id, $empresa, $centrocosto, $contrato, $documento, $registro);
        }
        $this->desconectar();
        return $contrato;
    }
    //Buscar Contrato Firmado
    function buscarcontratofirmado1($contrato)
    {
        $this->conexion();
        $sql = "select * from contratosfirmados where id=$contrato";
        $result = $this->mi->query($sql);
        $contrato = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $contrato = $rs['contrato'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $contrato = new DocumentoFirmado($id, $empresa, $centrocosto, $contrato, $documento, $registro);
        }
        $this->desconectar();
        return $contrato;
    }

    //actualizar Contrato Firmado
    function actualizarcontratofirmado($id, $documento)
    {
        $this->conexion();
        $sql = "update contratosfirmados set documento='$documento' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar Contrato Firmado
    function eliminarcontratofirmado($id)
    {
        $this->conexion();
        $sql = "delete from contratosfirmados where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //listar contratos activos por empresa
    function listarcontratosfirmados($empresa)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.rut as rut,trabajadores.nombre as nombre, centrocosto.nombre as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, contratosfirmados.documento as documento, estado, contratos.register_at as register_at from contratosfirmados,contratos,centrocosto, trabajadores, empresa where contratos.empresa = $empresa and trabajadores.id = contratos.trabajador and contratos.centrocosto=centrocosto.id and empresa.id = contratos.empresa and contratos.estado=1 and contratosfirmados.contrato=contratos.id order by contratos.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {

            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['rut'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }

    //listar contratos activos por Centro de costo
    function listarcontratosfirmados1($centros)
    {
        $this->conexion();
        $sql = "select contratos.id as id, trabajadores.rut as rut,trabajadores.nombre as nombre, centrocosto.nombre as centrocosto, trabajadores.primerapellido as primerapellido, trabajadores.segundoapellido as segundoapellido, empresa.razonsocial as razonsocial, contratos.tipocontrato as tipocontrato,cargo, sueldo, fechainicio, fechatermino, contratosfirmados.documento as documento, estado, contratos.register_at as register_at from contratosfirmados,contratos,centrocosto, trabajadores, empresa where trabajadores.id = contratos.trabajador and contratos.centrocosto=centrocosto.id and empresa.id = contratos.empresa and contratos.estado=1 and contratosfirmados.contrato=contratos.id";
        $i = 0;
        foreach ($centros as $centro) {
            if ($i == 0) {
                $sql = $sql . " and (contratosfirmados.centrocosto=$centro";
            } else {
                $sql = $sql . " or contratosfirmados.centrocosto=$centro";
            }
            $i++;
        }

        $sql .= ") ";
        $sql .= "order by contratos.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {

            $id = $rs['id'];
            $nombre = $rs['nombre'] . " " . $rs['primerapellido'] . " " . $rs['segundoapellido'];
            $razonsocial = $rs['razonsocial'];
            $tipocontrato = $rs['tipocontrato'];
            $centrocosto = $rs['centrocosto'];
            $cargo = $rs['cargo'];
            $sueldo = $rs['sueldo'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $documento = $rs['documento'];
            $estado = $rs['estado'];
            $register_at = $rs['rut'];
            $contrato = new Contrato($id, $nombre, $razonsocial, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $register_at);
            $lista[] = $contrato;
        }
        $this->desconectar();
        return $lista;
    }
    /************************************************************************************************************************ */
    /**************************************************Finiquito Firmado*************************************************** */

    //Registrar Finiquito Firmado
    function registrarfiniquitofirmado($empresa, $centrocosto, $finiquito, $documento)
    {
        $this->conexion();
        $sql = "insert into finiquitosfirmados values(null,$empresa,$centrocosto,$finiquito,'$documento',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar Finiquito Firmado
    function buscarfiniquitofirmado($finiquito)
    {
        $this->conexion();
        $sql = "select * from finiquitosfirmados where finiquito=$finiquito";
        $result = $this->mi->query($sql);
        $finiquito = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $finiquito = $rs['finiquito'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $finiquito = new DocumentoFirmado($id, $empresa, $centrocosto, $finiquito, $documento, $registro);
        }
        $this->desconectar();
        return $finiquito;
    }
    //Buscar Finiquito Firmado
    function buscarfiniquitofirmado1($finiquito)
    {
        $this->conexion();
        $sql = "select * from finiquitosfirmados where id=$finiquito";
        $result = $this->mi->query($sql);
        $finiquito = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $finiquito = $rs['finiquito'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $finiquito = new DocumentoFirmado($id, $empresa, $centrocosto, $finiquito, $documento, $registro);
        }
        $this->desconectar();
        return $finiquito;
    }

    //actualizar Finiquito Firmado
    function actualizarfiniquitofirmado($id, $documento)
    {
        $this->conexion();
        $sql = "update finiquitosfirmados set documento='$documento' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //eliminar Finiquito Firmado
    function eliminarfiniquitofirmado($id)
    {
        $this->conexion();
        $sql = "delete from finiquitosfirmados where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar Finiquitos Firmados

    function listarfiniquitofirmados($empresa)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, centrocosto.nombre as centrocosto, finiquito.contrato as contrato, finiquito.tipodocumento as tipodocumento, finiquito.fechafiniqito as fechafiniqito, finiquitosfirmados.documento as documento, finiquito.fechainicio as fechainicio, finiquito.fechatermino as fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from contratos,centrocosto, finiquito,trabajadores, causalterminocontrato, finiquitosfirmados where finiquito.causalterminocontrato = causalterminocontrato.id and  finiquito.empresa = $empresa and finiquito.trabajador = trabajadores.id and finiquito.contrato = contratos.id and contratos.centrocosto = centrocosto.id and finiquitosfirmados.finiquito=finiquito.id order by finiquito.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['documento'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['rut'];
            $register_at = $rs['centrocosto'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Finiquitos Firmados Centro de Costo

    function listarfiniquitofirmados1($centros)
    {
        $this->conexion();
        $sql = "select finiquito.id as id, centrocosto.nombre as centrocosto, finiquito.contrato as contrato, finiquito.tipodocumento as tipodocumento, finiquito.fechafiniqito as fechafiniqito, finiquitosfirmados.documento as documento, finiquito.fechainicio as fechainicio, finiquito.fechatermino as fechatermino, causalterminocontrato.nombre as causalterminocontrato, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, finiquito.empresa as empresa, finiquito.register_at as register_at from contratos,centrocosto, finiquito,trabajadores, causalterminocontrato, finiquitosfirmados where finiquito.causalterminocontrato = causalterminocontrato.id and finiquito.trabajador = trabajadores.id and finiquito.contrato = contratos.id and contratos.centrocosto = centrocosto.id and finiquitosfirmados.finiquito=finiquito.id ";
        $i = 0;
        foreach ($centros as $centro) {
            if ($i == 0) {
                $sql = $sql . " and (finiquitosfirmados.centrocosto=$centro";
            } else {
                $sql = $sql . " or finiquitosfirmados.centrocosto=$centro";
            }
            $i++;
        }
        $sql .= ") ";
        $sql .= "order by finiquito.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $contrato = $rs['documento'];
            $tipodocumento = $rs['tipodocumento'];
            $fechafiniquito = $rs['fechafiniqito'];
            $fechainicio = $rs['fechainicio'];
            $fechatermino = $rs['fechatermino'];
            $causalterminocontrato = $rs['causalterminocontrato'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido'];
            $empresa = $rs['rut'];
            $register_at = $rs['centrocosto'];
            $finiquito = new Finiquito($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causalterminocontrato, $trabajador, $empresa, $register_at);
            $lista[] = $finiquito;
        }
        $this->desconectar();
        return $lista;
    }

    /************************************************************************************************************************ */
    /**************************************************Notificaciones Firmadas*************************************************** */
    //Registrar Notificacion Firmada
    function registrarnotificacionfirmada($empresa, $centrocosto, $notificacion, $documento, $carta)
    {
        $this->conexion();
        $sql = "insert into notificacionesfirmadas values(null,$empresa,$centrocosto,$notificacion,'$documento','$carta',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }


    //actualizar Notificacion Firmada
    function actualizarnotificacionfirmada($id, $documento)
    {
        $this->conexion();
        $sql = "update notificacionesfirmadas set documento='$documento' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //actualizar Notificacion Firmada Carta
    function actualizarnotificacionfirmadacarta($id, $carta)
    {
        $this->conexion();
        $sql = "update notificacionesfirmadas set carta='$carta' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar Notificacion Firmada
    function eliminarnotificacionfirmada($id)
    {
        $this->conexion();
        $sql = "delete from notificacionesfirmadas where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Buscar Notificacion Firmada
    function buscarnotificacionfirmada($notificacion)
    {
        $this->conexion();
        $sql = "select * from notificacionesfirmadas where notificacion=$notificacion";
        $result = $this->mi->query($sql);
        $notificacion = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $notificacion = $rs['notificacion'];
            $documento = $rs['documento'];
            $carta = $rs['carta'];
            $registro = $rs['register_at'];
            $notificacion = new NotificacionFirmada($id, $empresa, $centrocosto, $notificacion, $documento, $carta, $registro);
        }
        $this->desconectar();
        return $notificacion;
    }
    //Buscar Notificacion Firmada
    function buscarnotificacionfirmada1($id)
    {
        $this->conexion();
        $sql = "select * from notificacionesfirmadas where id=$id";
        $result = $this->mi->query($sql);
        $notificacion = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $notificacion = $rs['notificacion'];
            $documento = $rs['documento'];
            $carta = $rs['carta'];
            $registro = $rs['register_at'];
            $notificacion = new NotificacionFirmada($id, $empresa, $centrocosto, $notificacion, $documento, $carta, $registro);
        }
        $this->desconectar();
        return $notificacion;
    }

    //Listar Notificaciones Firmadas

    //Listar Notificaciones por empresa
    function listarnotificacionesfirmadas($empresa)
    {
        $this->conexion();
        $sql = "select notificacionesfirmadas.id as id, notificacionesfirmadas.documento as documento, notificacionesfirmadas.carta as carta, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causalterminocontrato.nombre as causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto from notificaciones,causalterminocontrato, finiquito,contratos, comunicacion, trabajadores, centrocosto, notificacionesfirmadas where notificaciones.finiquito = finiquito.id and finiquito.contrato = contratos.id and finiquito.trabajador = trabajadores.id and comunicacion.id = notificaciones.comunicacion and contratos.centrocosto = centrocosto.id and finiquito.empresa = $empresa and causalterminocontrato.id = notificaciones.causal and notificacionesfirmadas.notificacion=notificaciones.id order by notificaciones.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['carta'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['documento'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['nombre'] . " " . $rs['apellido'];
            $acreditacion = $rs['rut'];
            $comuna = $rs['comuna'];
            $texto = $rs['comunicacion'];
            $register_at = $rs['centrocosto'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $lista[] = $n;
        }
        $this->desconectar();
        return $lista;
    }
    //Listar Notificaciones por empresa
    function listarnotificacionesfirmadas1($centros)
    {
        $this->conexion();
        $sql = "select notificacionesfirmadas.id as id, notificacionesfirmadas.documento as documento, notificacionesfirmadas.carta as carta, fechanotificacion, finiquito, notificaciones.tipodocumento as tipodocumento, causalterminocontrato.nombre as causal, causalhechos, cotizacionprevisional, comunicacion.nombre as comunicacion, acreditacion, comuna,texto, notificaciones.register_at as register_at, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto from notificaciones,causalterminocontrato, finiquito,contratos, comunicacion, trabajadores, centrocosto, notificacionesfirmadas where notificaciones.finiquito = finiquito.id and finiquito.contrato = contratos.id and finiquito.trabajador = trabajadores.id and comunicacion.id = notificaciones.comunicacion and contratos.centrocosto = centrocosto.id and causalterminocontrato.id = notificaciones.causal and notificacionesfirmadas.notificacion=notificaciones.id";
        $i = 0;
        foreach ($centros as $centro) {
            if ($i == 0) {
                $sql = $sql . " and (notificacionesfirmadas.centrocosto=$centro";
            } else {
                $sql = $sql . " or notificacionesfirmadas.centrocosto=$centro";
            }
            $i++;
        }
        $sql .= ") ";
        $sql .= "order by notificaciones.id desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $fechanotificacion = $rs['fechanotificacion'];
            $finiquito = $rs['carta'];
            $tipodocumento = $rs['tipodocumento'];
            $causal = $rs['causal'];
            $causalhechos = $rs['documento'];
            $cotizacionprevisional = $rs['cotizacionprevisional'];
            $comunicacion = $rs['nombre'] . " " . $rs['apellido'];
            $acreditacion = $rs['rut'];
            $comuna = $rs['comuna'];
            $texto = $rs['comunicacion'];
            $register_at = $rs['centrocosto'];
            $n = new Notificacion($id, $fechanotificacion, $finiquito, $tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acreditacion, $comuna, $texto, $register_at);
            $lista[] = $n;
        }
        $this->desconectar();
        return $lista;
    }



    //Registrar Otros Documentos Firmados
    function registrarotrosdocumentosfirmados($empresa, $centrocosto, $id_doc, $documento)
    {
        $this->conexion();
        $sql = "insert into otrosdocumentosfirmados values(null,$empresa,$centrocosto,$id_doc,'$documento',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar Otros Documentos Firmados
    function actualizarotrosdocumentosfirmados($id, $documento)
    {
        $this->conexion();
        $sql = "update otrosdocumentosfirmados set documento='$documento' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //listar Otros documentos firmados
    function buscarotrosdocumentosfirmados($id_doc)
    {
        $this->conexion();
        $sql = "select * from otrosdocumentosfirmados where id_doc=$id_doc";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $id_doc = $rs['id_doc'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $documento = new DocumentoFirmado($id, $empresa, $centrocosto, $id_doc, $documento, $registro);
            $this->desconectar();
            return $documento;
        }
        $this->desconectar();
        return false;
    }
    function buscarotrosdocumentosfirmadosid($id)
    {
        $this->conexion();
        $sql = "select * from otrosdocumentosfirmados where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $empresa = $rs['empresa'];
            $centrocosto = $rs['centrocosto'];
            $id_doc = $rs['id_doc'];
            $documento = $rs['documento'];
            $registro = $rs['register_at'];
            $documento = new DocumentoFirmado($id, $empresa, $centrocosto, $id_doc, $documento, $registro);
            $this->desconectar();
            return $documento;
        }
        $this->desconectar();
        return false;
    }


    //Listar documentos text empresa
    function listardocumentosfirmados($centros)
    {
        $this->conexion();
        $sql = "select otrosdocumentosfirmados.id as id, trabajadores.rut as rut, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido, centrocosto.nombre as centrocosto, documentos.empresa as empresa, tipodocumento.nombre as tipodocumento, fechageneracion, otrosdocumentosfirmados.documento as documento, documentos.register_at as register_at from centrocosto, trabajadores,documentos,otrosdocumentosfirmados, tipodocumento where documentos.tipodocumento = tipodocumento.id and trabajadores.id = documentos.trabajador and otrosdocumentosfirmados.centrocosto = centrocosto.id and otrosdocumentosfirmados.id_doc=documentos.id";
        $i = 0;
        foreach ($centros as $centro) {
            if ($i == 0) {
                $sql = $sql . " and (otrosdocumentosfirmados.centrocosto=$centro";
            } else {
                $sql = $sql . " or otrosdocumentosfirmados.centrocosto=$centro";
            }
            $i++;
        }
        $sql .= ") ";
        $sql .= "order by otrosdocumentosfirmados.id desc";
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
            $register_at = $rs['centrocosto'];
            $l = new Documento($id, $trabajador, $empresa, $tipodocumento, $fechageneracion, $documento, $register_at);
            $lista[] = $l;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar Otros Documentos Firmados
    function eliminarotrosdocumentosfirmados($id)
    {
        $this->conexion();
        $sql = "delete from otrosdocumentosfirmados where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }




    /*****************************************************Documentos Empresa*****************************************************/

    //Listar tipo_documento_empresa
    function listartipodocumentoempresa()
    {
        $this->conexion();
        $sql = "select * from tipo_documento_empresa;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $periodo = $rs['periodo'];
            $tipo = new Regiones($id, $periodo, $nombre, $nombre);
            $lista[] = $tipo;
        }
        $this->desconectar();
        return $lista;
    }

    //Listar tipo_documento_empresa del periodo x
    function listartipodocumentoempresaperiodo($periodo)
    {
        $this->conexion();
        $sql = "select * from tipo_documento_empresa where periodo=$periodo;";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $nombre = $rs['nombre'];
            $periodo = $rs['periodo'];
            $tipo = new Regiones($id, $periodo, $nombre, $nombre);
            $lista[] = $tipo;
        }
        $this->desconectar();
        return $lista;
    }

    //Cargar documento empresa
    function registrardocumentoempresa($tipo, $centrocosto, $documento, $periodo, $empresa)
    {
        $this->conexion();
        $sql = "insert into documentos_empresa values(null,$tipo,$centrocosto,'$documento','$periodo',$empresa,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function listardocumentoempresa($empresa, $centrocosto, $tipo)
    {
        $this->conexion();
        $sql = "select * from documentos_empresa where empresa=$empresa and centrocosto=$centrocosto and tipo=$tipo order by register_at desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
            $lista[] = $documento;
        }
        $this->desconectar();
        return $lista;
    }

    //Eliminar Documento empresa
    function eliminardocumentoempresa($id)
    {
        $this->conexion();
        $sql = "delete from documentos_empresa where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //buscar documento empresa por documento
    function buscardocumentoempresadocumento($documento)
    {
        $this->conexion();
        $sql = "select * from documentos_empresa where documento='$documento'";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
            $lista[] = $documento;
        }
        $this->desconectar();
        return $lista;
    }

    //buscar documento empresa por id
    function buscardocumentoempresaid($id)
    {
        $this->conexion();
        $sql = "select * from documentos_empresa where id=$id";
        $result = $this->mi->query($sql);
        $documento = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
        }
        $this->desconectar();
        return $documento;
    }

    //Buscar DOcumento
    function buscardocumentoempresa($empresa, $tipo)
    {
        $this->conexion();
        $sql = "select * from documentos_empresa where empresa=$empresa and tipo=$tipo order by register_at desc";
        $result = $this->mi->query($sql);
        $documento = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            if ($periodo == "0000-00-00" || $periodo == "" || $periodo == null) {
                $periodo = "Documento Unico";
            } else {
                $mes = date("m", strtotime($periodo));
                $anio = date("Y", strtotime($periodo));

                switch ($mes) {
                    case 1:
                        $mes = "Enero";
                        break;
                    case 2:
                        $mes = "Febrero";
                        break;
                    case 3:
                        $mes = "Marzo";
                        break;
                    case 4:
                        $mes = "Abril";
                        break;
                    case 5:
                        $mes = "Mayo";
                        break;
                    case 6:
                        $mes = "Junio";
                        break;
                    case 7:
                        $mes = "Julio";
                        break;
                    case 8:
                        $mes = "Agosto";
                        break;
                    case 9:
                        $mes = "Septiembre";
                        break;
                    case 10:
                        $mes = "Octubre";
                        break;
                    case 11:
                        $mes = "Noviembre";
                        break;
                    case 12:
                        $mes = "Diciembre";
                        break;
                }
                $periodo = $mes . " " . $anio;
            }
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
        }
        $this->desconectar();
        return $documento;
    }

    //Buscar DOcumento
    function buscardocumentoempresa1($empresas, $tipo)
    {
        $this->conexion();
        $sql = "select * from documentos_empresa where tipo=$tipo ";
        $i = 0;
        foreach ($empresas as $empresa) {
            $sql .= " and empresa=$empresa";
        }
        $sql .= " order by register_at desc";
        $result = $this->mi->query($sql);
        $documento = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            if ($periodo == "0000-00-00" || $periodo == "" || $periodo == null) {
                $periodo = "Documento Unico";
            } else {
                $mes = date("m", strtotime($periodo));
                $anio = date("Y", strtotime($periodo));

                switch ($mes) {
                    case 1:
                        $mes = "Enero";
                        break;
                    case 2:
                        $mes = "Febrero";
                        break;
                    case 3:
                        $mes = "Marzo";
                        break;
                    case 4:
                        $mes = "Abril";
                        break;
                    case 5:
                        $mes = "Mayo";
                        break;
                    case 6:
                        $mes = "Junio";
                        break;
                    case 7:
                        $mes = "Julio";
                        break;
                    case 8:
                        $mes = "Agosto";
                        break;
                    case 9:
                        $mes = "Septiembre";
                        break;
                    case 10:
                        $mes = "Octubre";
                        break;
                    case 11:
                        $mes = "Noviembre";
                        break;
                    case 12:
                        $mes = "Diciembre";
                        break;
                }
                $periodo = $mes . " " . $anio;
            }
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
        }
        $this->desconectar();
        return $documento;
    }

    function listardocumentoempresa1($empresa, $centrocosto, $tipo)
    {
        $this->conexion();
        $sql = "select documentos_empresa.id as id, tipo_documento_empresa.nombre as tipo, centrocosto.nombre as centrocosto, documentos_empresa.documento as documento, documentos_empresa.periodo as periodo, empresa.razonsocial as empresa, documentos_empresa.register_at as register_at from documentos_empresa , tipo_documento_empresa, centrocosto, empresa where documentos_empresa.empresa=empresa.id and documentos_empresa.tipo=tipo_documento_empresa.id and documentos_empresa.centrocosto=centrocosto.id and documentos_empresa.empresa=$empresa and documentos_empresa.tipo=$tipo";
        $i = 0;
        foreach ($centrocosto as $cc) {
            if ($i == 0) {
                $sql .= " and (documentos_empresa.centrocosto=$cc";
            } else {
                $sql .= " or documentos_empresa.centrocosto=$cc";
            }
            $i++;
        }
        $sql .= ")";
        $sql .= " order by documentos_empresa.register_at desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            if ($periodo == "0000-00-00" || $periodo == "" || $periodo == null) {
                $periodo = "Documento Unico";
            } else {
                $mes = date("m", strtotime($periodo));
                $anio = date("Y", strtotime($periodo));

                switch ($mes) {
                    case 1:
                        $mes = "Enero";
                        break;
                    case 2:
                        $mes = "Febrero";
                        break;
                    case 3:
                        $mes = "Marzo";
                        break;
                    case 4:
                        $mes = "Abril";
                        break;
                    case 5:
                        $mes = "Mayo";
                        break;
                    case 6:
                        $mes = "Junio";
                        break;
                    case 7:
                        $mes = "Julio";
                        break;
                    case 8:
                        $mes = "Agosto";
                        break;
                    case 9:
                        $mes = "Septiembre";
                        break;
                    case 10:
                        $mes = "Octubre";
                        break;
                    case 11:
                        $mes = "Noviembre";
                        break;
                    case 12:
                        $mes = "Diciembre";
                        break;
                }
                $periodo = $mes . " " . $anio;
            }
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
            $lista[] = $documento;
        }
        $this->desconectar();
        return $lista;
    }

    function listardocumentoempresa2($empresas, $centrocosto, $tipo)
    {
        $this->conexion();
        $sql = "select documentos_empresa.id as id, tipo_documento_empresa.nombre as tipo, centrocosto.nombre as centrocosto, documentos_empresa.documento as documento, documentos_empresa.periodo as periodo, empresa.razonsocial as empresa, documentos_empresa.register_at as register_at from documentos_empresa , tipo_documento_empresa, centrocosto, empresa where documentos_empresa.empresa=empresa.id and documentos_empresa.tipo=tipo_documento_empresa.id and documentos_empresa.centrocosto=centrocosto.id and documentos_empresa.tipo=$tipo";
        $i = 0;
        foreach ($centrocosto as $cc) {
            if ($i == 0) {
                $sql .= " and (documentos_empresa.centrocosto=$cc";
            } else {
                $sql .= " or documentos_empresa.centrocosto=$cc";
            }
            $i++;
        }
        $sql .= ")";
        $sql .= " order by documentos_empresa.register_at desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $tipo = $rs['tipo'];
            $centrocosto = $rs['centrocosto'];
            $documento = $rs['documento'];
            $periodo = $rs['periodo'];
            if ($periodo == "0000-00-00" || $periodo == "" || $periodo == null) {
                $periodo = "Documento Unico";
            } else {
                $mes = date("m", strtotime($periodo));
                $anio = date("Y", strtotime($periodo));

                switch ($mes) {
                    case 1:
                        $mes = "Enero";
                        break;
                    case 2:
                        $mes = "Febrero";
                        break;
                    case 3:
                        $mes = "Marzo";
                        break;
                    case 4:
                        $mes = "Abril";
                        break;
                    case 5:
                        $mes = "Mayo";
                        break;
                    case 6:
                        $mes = "Junio";
                        break;
                    case 7:
                        $mes = "Julio";
                        break;
                    case 8:
                        $mes = "Agosto";
                        break;
                    case 9:
                        $mes = "Septiembre";
                        break;
                    case 10:
                        $mes = "Octubre";
                        break;
                    case 11:
                        $mes = "Noviembre";
                        break;
                    case 12:
                        $mes = "Diciembre";
                        break;
                }
                $periodo = $mes . " " . $anio;
            }
            $empresa = $rs['empresa'];
            $registro = $rs['register_at'];
            $documento = new DocumentoEmpresa($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $registro);
            $lista[] = $documento;
        }
        $this->desconectar();
        return $lista;
    }

    /*****************************************Mandante************************** */
    //asignar Centro costo
    function asignarcentrocosto($usuario, $centrocosto)
    {
        $this->conexion();
        $sql = "insert into mandante values(null, $usuario, $centrocosto, now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    function validarcentrocosto($usuario, $centrocosto)
    {
        $this->conexion();
        $sql = "select * from mandante where usuario=$usuario and centrocosto=$centrocosto";
        $result = $this->mi->query($sql);
        $mandante = false;
        if ($rs = mysqli_fetch_array($result)) {
            $mandante = true;
        }
        $this->desconectar();
        return $mandante;
    }

    //Revocar Centro costo
    function revocarcentrocosto($usuario, $centrocosto)
    {
        $this->conexion();
        $sql = "delete from mandante where usuario=$usuario and centrocosto=$centrocosto";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar centro de costo por usuario
    function listarcentrocostomandate($usuario)
    {
        $this->conexion();
        $sql = "select centrocosto.id as id, centrocosto.codigo as codigo, centrocosto.codigoprevired as codigoprevired, centrocosto.nombre as nombre, centrocosto.empresa as empresa from centrocosto, mandante where mandante.usuario=$usuario and mandante.centrocosto=centrocosto.id";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $codigoprevired = $rs['codigoprevired'];
            $nombre = $rs['nombre'];
            $empresa = $rs['empresa'];
            $centrocosto = new CentroCosto($id, $codigo, $codigoprevired, $nombre, $empresa);
            $lista[] = $centrocosto;
        }
        $this->desconectar();
        return $lista;
    }

    /***********************Formulas*********************************** */
    //registrar formula
    function registrarformula($codigo, $nombre, $representacion, $formula)
    {
        $this->conexion();
        $sql = "insert into formulas values(null,'$codigo','$nombre','$representacion','$formula',now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //listar formulas
    function listarformulas()
    {
        $this->conexion();
        $sql = "select * from formulas";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $representacion = $rs['representacion'];
            $formula = $rs['formula'];
            $registro = $rs['register_at'];
            $formula = new Formula($id, $codigo, $nombre, $representacion, $formula, $registro);
            $lista[] = $formula;
        }
        $this->desconectar();
        return $lista;
    }

    //buscar formula
    function buscarformula($id)
    {
        $this->conexion();
        $sql = "select * from formulas where id=$id";
        $result = $this->mi->query($sql);
        $formula = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $representacion = $rs['representacion'];
            $formula = $rs['formula'];
            $registro = $rs['register_at'];
            $formula = new Formula($id, $codigo, $nombre, $representacion, $formula, $registro);
        }
        $this->desconectar();
        return $formula;
    }

    //Buscar formula por representacion
    function buscarformularepresentacion($representacion)
    {
        $this->conexion();
        $sql = "select * from formulas where representacion='$representacion'";
        $result = $this->mi->query($sql);
        $formula = false;
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $codigo = $rs['codigo'];
            $nombre = $rs['nombre'];
            $representacion = $rs['representacion'];
            $formula = $rs['formula'];
            $registro = $rs['register_at'];
            $formula = new Formula($id, $codigo, $nombre, $representacion, $formula, $registro);
        }
        $this->desconectar();
        return $formula;
    }

    //Actualizar formula
    function actualizarformula($id, $codigo, $nombre, $representacion, $formula)
    {
        $this->conexion();
        $sql = "update formulas set codigo='$codigo', nombre='$nombre', representacion='$representacion', formula='$formula' where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Eliminar formula
    function eliminarformula($id)
    {
        $this->conexion();
        $sql = "delete from formulas where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Comprobar asistencia
    function comprobarasistencia($trabajador, $contrato, $fecha)
    {
        $this->conexion();
        $sql = "select * from asistencia where trabajador=$trabajador and fecha='$fecha' and contrato=$contrato";
        $result = $this->mi->query($sql);
        $asistencia = false;
        if ($rs = mysqli_fetch_array($result)) {
            $estado = $rs['estado'];
            $this->desconectar();
            return $estado;
        }
        $this->desconectar();
        return false;
    }

    //Validar asistencia
    function validarasistencia($trabajador, $contrato, $fecha)
    {
        $this->conexion();
        $sql = "select * from asistencia where trabajador=$trabajador and fecha='$fecha' and contrato=$contrato";
        $result = $this->mi->query($sql);
        $asistencia = false;
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $this->desconectar();
            return $id;
        }
        $this->desconectar();
        return $asistencia;
    }

    //Registrar asistencia
    function registrarasistencia($trabajador, $contrato, $fecha, $estado)
    {
        $this->conexion();
        $sql = "insert into asistencia values(null,'$fecha',$estado,$trabajador,$contrato,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Actualizar asistencia
    function actualizarasistencia($id, $estado)
    {
        $this->conexion();
        $sql = "update asistencia set estado=$estado where id=$id";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Cantidad de dias de ausencia en un mes
    function cantidadausencias($trabajador, $contrato, $mes, $anio)
    {
        $this->conexion();
        $sql = "select count(estado) as cantidad from asistencia where trabajador=$trabajador and contrato=$contrato and month(fecha)=$mes and year(fecha)=$anio and estado=3";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $cantidad = $rs['cantidad'];
            $this->desconectar();
            return $cantidad;
        }
        $this->desconectar();
        return 0;
    }

    //Cantidad de medio dias de ausencia en un mes
    function cantidadmediodiaausencias($trabajador, $contrato, $mes, $anio)
    {
        $this->conexion();
        $sql = "select count(estado) as cantidad from asistencia where trabajador=$trabajador and contrato=$contrato and month(fecha)=$mes and year(fecha)=$anio and estado=2";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $cantidad = $rs['cantidad'];
            $cantidad = $cantidad * 0.5;
            $this->desconectar();
            return $cantidad;
        }
        $this->desconectar();
        return 0;
    }


    //********************************************************************Liquidaciones********************************** */
    //Ultimo folio liquidacion
    function ultimofolioliquidacion($empresa)
    {
        $this->conexion();
        $sql = "select * from liquidaciones where empresa=$empresa order by folio desc limit 1";
        $result = $this->mi->query($sql);
        $folio = 0;
        if ($rs = mysqli_fetch_array($result)) {
            $folio = $rs['folio'];
        }
        $this->desconectar();
        return $folio;
    }

    //Registrar liquidacion
    /*
    id int not null auto_increment primary key,
    folio int not null,
    contrato int not null references contratos(id),
    periodo date not null,
    empresa int not null references empresa(id),
    trabajador int not null references trabajadores(id),
    diastrabajados int not null,
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
    register_at timestamp not null default current_timestamp*/

    function registrarliquidacion($folio, $contrato, $periodo, $empresa, $trabajador, $diastrabajaos, $sueldobase, $horasfalladas, $horasextras1, $horasextras2, $horasextras3, $afp, $porafp,$porsis, $salud, $porsalud,$desafp,$desis,$dessal, $gratificacion, $totalimponible, $totalnoimponible, $totaltributable, $totaldeslegales, $totaldesnolegales, $fecha_liquidacion)
    {
        $this->conexion();
        $sql = "insert into liquidaciones values(null,$folio,$contrato,'$periodo',$empresa,$trabajador,$diastrabajaos,$sueldobase,$horasfalladas,$horasextras1,$horasextras2,$horasextras3,'$afp','$porafp','$salud','$porsalud',$totalimponible,$totalnoimponible,$totaltributable,$totaldeslegales,$totaldesnolegales,'$fecha_liquidacion',now())";
        $result = $this->mi->query($sql);
        //Id liquidacion
        $id = mysqli_insert_id($this->mi);
        $this->desconectar();
        return $id;
    }

    //Registrar detalle liquidacion
    function registrardetalleliquidacion($liquidacion, $codigo, $monto, $tipo)
    {
        $this->conexion();
        $sql = "insert into detalle_liquidacion values(null,$liquidacion,'$codigo',$monto,$tipo,now())";
        $result = $this->mi->query($sql);
        $this->desconectar();
        return $result;
    }

    //Listar liquidaciones
    function listarliquidaciones($empresa)
    {
        $this->conexion();
        $sql = "select liquidaciones.id as id, liquidaciones.folio as folio, liquidaciones.contrato as contrato, liquidaciones.periodo as periodo, centrocosto.nombre as empresa, trabajadores.nombre as nombre, trabajadores.primerapellido as apellido1, trabajadores.segundoapellido as apellido2, liquidaciones.diastrabajados as diastrabajados, liquidaciones.sueldobase as sueldobase, liquidaciones.horasfalladas as horasfalladas, liquidaciones.horasextras1 as horasextras1, liquidaciones.horasextras2 as horasextras2, liquidaciones.horasextras3 as horasextras3, liquidaciones.afp as afp, liquidaciones.porafp as porafp, liquidaciones.salud as salud, liquidaciones.porsalud as porsalud, liquidaciones.totalimponible as totalimponible, liquidaciones.totalnoimponible as totalnoimponible, liquidaciones.totaltributable as totaltributable, liquidaciones.totaldeslegales as totaldeslegales, liquidaciones.totaldesnolegales as totaldesnolegales, liquidaciones.fecha_liquidacion as fecha_liquidacion, liquidaciones.register_at as register_at from liquidaciones, centrocosto, trabajadores where liquidaciones.empresa=centrocosto.id and liquidaciones.trabajador=trabajadores.id and liquidaciones.empresa=$empresa order by liquidaciones.register_at desc";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $contrato = $rs['contrato'];
            $periodo = $rs['periodo'];
            $empresa = $rs['empresa'];
            $trabajador = $rs['nombre'] . " " . $rs['apellido1'] . " " . $rs['apellido2'];
            $diastrabajados = $rs['diastrabajados'];
            $sueldobase = $rs['sueldobase'];
            $horasfalladas = $rs['horasfalladas'];
            $horasextras1 = $rs['horasextras1'];
            $horasextras2 = $rs['horasextras2'];
            $horasextras3 = $rs['horasextras3'];
            $afp = $rs['afp'];
            $porafp = $rs['porafp'];
            $salud = $rs['salud'];
            $porsalud = $rs['porsalud'];
            $totalimponible = $rs['totalimponible'];
            $totalnoimponible = $rs['totalnoimponible'];
            $totaltributable = $rs['totaltributable'];
            $totaldeslegales = $rs['totaldeslegales'];
            $totaldesnolegales = $rs['totaldesnolegales'];
            $fecha_liquidacion = $rs['fecha_liquidacion'];
            $registro = $rs['register_at'];
            $liquidacion = new Liquidacion($id, $folio, $contrato, $periodo, $empresa, $trabajador, $diastrabajados, $sueldobase, $horasfalladas, $horasextras1, $horasextras2, $horasextras3, $afp, $porafp, $salud, $porsalud, $totalimponible, $totalnoimponible, $totaltributable, $totaldeslegales, $totaldesnolegales, $fecha_liquidacion, $registro);
            $lista[] = $liquidacion;
        }
        $this->desconectar();
        return $lista;
    }

    function buscardetallesliquidacion($liquidacion)
    {
        $this->conexion();
        $sql = "select * from detalle_liquidacion where liquidacion=$liquidacion";
        $result = $this->mi->query($sql);
        $lista = array();
        while ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $liquidacion = $rs['liquidacion'];
            $codigo = $rs['codigo'];
            $monto = $rs['monto'];
            $tipo = $rs['tipo'];
            $registro = $rs['register_at'];
            $detalle = new Detalle_liquidacion($id, $liquidacion, $codigo, $monto, $tipo, $registro);
            $lista[] = $detalle;
        }
        $this->desconectar();
        return $lista;
    }

    //buscarhoras pactadas
    function buscarhoraspactadas($contrato)
    {
        $this->conexion();
        $sql = "select * from horaspactadas where  contrato=$contrato";
        $result = $this->mi->query($sql);
        $horas = 45;
        if ($rs = mysqli_fetch_array($result)) {
            $horas = $rs['horas'];
        }
        $this->desconectar();
        return $horas;
    }

    function buscarliquidacion($id)
    {
        $this->conexion();
        $sql = "select * from liquidaciones where id=$id";
        $result = $this->mi->query($sql);
        if ($rs = mysqli_fetch_array($result)) {
            $id = $rs['id'];
            $folio = $rs['folio'];
            $contrato = $rs['contrato'];
            $periodo = $rs['periodo'];
            $empresa = $rs['empresa'];
            $trabajador = $rs['trabajador'];
            $diastrabajados = $rs['diastrabajados'];
            $sueldobase = $rs['sueldobase'];
            $horasfalladas = $rs['horasfalladas'];
            $horasextras1 = $rs['horasextras1'];
            $horasextras2 = $rs['horasextras2'];
            $horasextras3 = $rs['horasextras3'];
            $afp = $rs['afp'];
            $porafp = $rs['porafp'];
            $salud = $rs['salud'];
            $porsalud = $rs['porsalud'];
            $totalimponible = $rs['totalimponible'];
            $totalnoimponible = $rs['totalnoimponible'];
            $totaltributable = $rs['totaltributable'];
            $totaldeslegales = $rs['totaldeslegales'];
            $totaldesnolegales = $rs['totaldesnolegales'];
            $fecha_liquidacion = $rs['fecha_liquidacion'];
            $registro = $rs['register_at'];
            $liquidacion = new Liquidacion($id, $folio, $contrato, $periodo, $empresa, $trabajador, $diastrabajados, $sueldobase, $horasfalladas, $horasextras1, $horasextras2, $horasextras3, $afp, $porafp, $salud, $porsalud, $totalimponible, $totalnoimponible, $totaltributable, $totaldeslegales, $totaldesnolegales, $fecha_liquidacion, $registro);
            $this->desconectar();
            return $liquidacion;
        }
        return null;
    }
}
