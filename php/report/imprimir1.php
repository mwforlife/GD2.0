<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';

$c = new Controller();
if (isset($_GET['cart'])) {
    //Cart es un json que contiene tipo, id, contrato, trabajador y ruta
    $cart = json_decode($_GET['cart']);
    $mpdf = new \Mpdf\Mpdf();
    foreach ($cart as $object) {
        $id = $object->id;
        $finiquito = $c->buscarfiniquitotext($id);
        if ($finiquito == false) {
            echo "No se encontro el registro";
        } else {
            $contrato = $finiquito->getContrato();
            $tipodocumento = $finiquito->getTipoDocumento();
            //Cambiar formato de fecha a dd-mm-YYYY
            $fechafiniquito = $finiquito->getFechafiniquito();
            $fechafiniquito = date("d-m-Y", strtotime($fechafiniquito));
            $fechainicio = $finiquito->getFechainicio();
            $fechainicio = date("d-m-Y", strtotime($fechainicio));
            $fechatermino = $finiquito->getFechatermino();
            $fechatermino = date("d-m-Y", strtotime($fechatermino));
            $causal = $finiquito->getCausal();

            $trabajador = $c->buscartrabajador($finiquito->getTrabajador());
            $dom = $c->ultimodomicilio($finiquito->getTrabajador());
            $contact = $c->ultimocontacto($finiquito->getTrabajador());
            $comunatra = $c->buscarcomuna($dom->getComuna());
            $comunatra = $comunatra->getNombre();
            $regiontra = $dom->getRegion();
            $regiontra = $c->buscarregion($regiontra);
            $regiontra = $regiontra->getNombre();

            $empresa = $c->buscarempresa($finiquito->getEmpresa());
            $comuna = $empresa->getComuna();
            $region = $empresa->getRegion();

            $contrato = $c->buscarcontratoid($finiquito->getContrato());
            $causal = $finiquito->getCausal();
            $repre = $c->BuscarRepresentanteLegalempresa($finiquito->getEmpresa());

            $detfin = $c->listardetallefiniquito($finiquito->getId());
            $detalle = "";
            $descuento = 0;
            $haber = 0;
            $saldo = 0;
            $detalle = $detalle . "<h4 style='text-align: center;'>Haberes</h4>";
            $detalle .= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
            foreach ($detfin as $df) {
                if ($df->getTipo() == 2) {
                    $detalle = $detalle . "<tr>";
                    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse; width:75%;'>" . $df->getIndemnizacion() . " - " . $df->getDescripcion() . "</td>";
                    $monto = $df->getMonto();
                    //Redondear sin decimales
                    $monto = round($monto, 0);
                    $monto1 = number_format($monto, 0, ',', '.');
                    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
                    $detalle = $detalle . "</tr>";
                    $haber = $haber + $monto;
                }
            }
            $detalle = $detalle . "<tr>";
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL HABERES</td>";
            $haber1 = number_format($haber, 0, ',', '.');
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $haber1 . "</td>";
            $detalle = $detalle . "</tr>";
            $detalle = $detalle . "</table>";

            $detalle = $detalle . "<h4 style='text-align: center;'>Descuentos</h4>";
            $detalle .= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
            foreach ($detfin as $df) {
                if ($df->getTipo() == 1) {
                    $detalle = $detalle . "<tr>";
                    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>" . $df->getIndemnizacion() . " - " . $df->getDescripcion() . "</td>";
                    $monto = $df->getMonto();
                    //Redondear sin decimales
                    $monto = round($monto, 0);
                    $monto1 = number_format($monto, 0, ',', '.');
                    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
                    $detalle = $detalle . "</tr>";
                    $descuento = $descuento + $df->getMonto();
                }
            }
            $detalle = $detalle . "<tr>";
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL DESCUENTOS</td>";
            $descuento1 = number_format($descuento, 0, ',', '.');
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $descuento1 . "</td>";
            $detalle = $detalle . "</tr>";
            $detalle = $detalle . "</table>";
            $detalle = $detalle . "<br/>";

            $detalle .= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
            $detalle = $detalle . "<tr>";
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:50%;'>TOTAL A PAGAR</td>";
            $saldo = $haber - $descuento;
            $saldo = round($saldo, 0);
            $saldo1 = number_format($saldo, 0, ',', '.');
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:50%;'>$ " . $saldo1 . "</td>";
            $detalle = $detalle . "</tr>";
            $detalle = $detalle . "</table>";
            $detalle = $detalle . "<br/>";

            $detalle .= "<table style='width:100%;  border-collapse: collapse;'>";
            $detalle = $detalle . "<tr>";
            $saldoletras = $c->convertirNumeroLetras($saldo);
            $detalle = $detalle . "<td style='border-collapse: collapse;width:100%; font-size:19px;'>Son " . $saldoletras . " Pesos</td>";
            $detalle = $detalle . "</tr>";
            $detalle = $detalle . "</table>";

            $nacionalidad = $c->buscarnacionalidad($trabajador->getNacionalidad());
            $estadocivil = $c->buscarestadocivil($trabajador->getCivil());
            $cuentabancaria = $c->ultimacuentabancariaregistrada1($trabajador->getId());

            $tipocuenta = "No Registrada";
            $numerocuenta = "No Registrada";
            $banco = "No Registrada";
            if ($cuentabancaria != false) {
                $tipocuenta = $cuentabancaria->getTipo();
                $numerocuenta = $cuentabancaria->getNumero();
                $banco = $cuentabancaria->getBanco();
            } else {
                $tipocuenta = "CuentaRut";
                //Numero de cuenta es igual al RUt del trabajar sin punto ni guion ni digito verificador
                $numerocuenta = str_replace(".", "", $trabajador->getRut());
                $numerocuenta = str_replace("-", "", $numerocuenta);
                $numerocuenta = substr($numerocuenta, 0, -1);
                $banco = "BancoEstado";
            }

            $swap_var = array(
                "{FECHA_FINIQUITO}" => $fechafiniquito,
                "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
                "{RUT_EMPRESA}" => $empresa->getRut(),
                "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
                "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
                "{CALLE_EMPRESA}" => $empresa->getCalle(),
                "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
                "{CORREO_EMPRESA}" => $empresa->getEmail(),
                "{NUMERO_EMPRESA}" => $empresa->getNumero(),
                "{FECHA_NACIMIENTO}" => $trabajador->getNacimiento(),
                "{DEPT_EMPRESA}" => $empresa->getDepartamento(),
                "{COMUNA_EMPRESA}" => $empresa->getComuna(),
                "{CEL_COMUNA}" => $empresa->getComuna(),
                "{REGION_EMPRESA}" => $empresa->getRegion(),
                "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
                "{APELLIDO_1}" => $trabajador->getApellido1(),
                "{APELLIDO_2}" => $trabajador->getApellido2(),
                "{CORREO_TRABAJADOR}" => $contact->getCorreo(),
                "{TELEFONO_TRABAJADOR}" => $contact->getTelefono(),
                "{RUT_TRABAJADOR}" => $trabajador->getRut(),
                "{CALLE_TRABAJADOR}" => $dom->getCalle(),
                "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
                "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
                "{COMUNA_TRABAJADOR}" => $comunatra,
                "{REGION_TRABAJADOR}" => $regiontra,
                "{NACIONALIDAD}" => $nacionalidad->getNombre(),
                "{ESTADO_CIVIL}" => $estadocivil->getNombre(),
                "{CARGO}" => $contrato->getCargo(),
                "{INICIO_CONTRATO}" => $fechainicio,
                "{TERMINO_CONTRATO}" => $fechatermino,
                "{CAUSAL_FINIQUITO}" => $causal,
                "{DETALLE_FINIQUITO}" => $detalle,
                "{FORMA_PAGO}" => "Transferencia Electrónica",
                "{TIPO_CUENTA}" => $tipocuenta,
                "{NUMERO_CUENTA}" => $numerocuenta,
                "{BANCO}" => $banco
            );

            $contenido = $c->buscarplantilla($tipodocumento);

            foreach (array_keys($swap_var) as $key) {
                $contenido = str_replace($key, $swap_var[$key], $contenido);
            }
            $mpdf->AddPage();
            $mpdf->title = 'Finiquito del Trabajador';
            $mpdf->author = 'KaiserTech - Gestor de Documentos';
            $mpdf->creator = 'WilkensTech';
            $mpdf->subject = 'Finiquito del Trabajador';
            $mpdf->keywords = 'Finiquito del Trabajador';
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($contenido);
            $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl</div>');
            $fecha = date('Ymdhis');
            //Generar nombre documento
        }

    }
    $nombre_documento = 'Finiquito' . $finiquito->getFechafiniquito() . '.pdf';
    $mpdf->Output($nombre_documento, 'I');
}