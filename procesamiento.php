<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />

    <!-- Title -->
    <title>Gestor de Documentos | Procesamiento Liquidaciones</title>

    <!-- Bootstrap css-->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Icons css-->
    <link href="assets/css/icons.css" rel="stylesheet" />
    <link href="assets/css/toastify.min.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/dark-boxed.css" rel="stylesheet">
    <link href="assets/css/boxed.css" rel="stylesheet">
    <link href="assets/css/skins.css" rel="stylesheet">
    <link href="assets/css/dark-style.css" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/css/colors/color.css">

    <!-- Select2 css -->
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Internal DataTables css-->
    <link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

    <!-- Sidemenu css-->
    <link href="assets/css/sidemenu/sidemenu.css" rel="stylesheet">

    <link rel="stylesheet" href="JsFunctions/Alert/loader.css">
    <script src="JsFunctions/Alert/loader.js"></script>

</head>

<body class="main-body container">

    <?php
    require 'php/controller.php';
    $c = new Controller();
    session_start();
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($empresa);

    if (isset($_GET['trabajadores'])) {
        //recibimos el array de trabajadores
        $trabajadores = $_GET['trabajadores'];
        $arrayfinal = $_GET['trabajadores'];
        //recorremos el array
        $trabajadores = json_decode($trabajadores);
        foreach ($trabajadores as $object) {
            //obtenemos el trabajador
            $id = $object->id;
            $rut = $object->rut;
            $nombre = $object->nombre;
            $contrato = $c->buscarcontrato($id);
            $trabajador = $c->buscartrabajador($id);
            $centrocosto = $c->buscarcentrcosto($contrato->getCentroCosto());
            $prevision = $c->buscarprevisiontrabajador($id);
            $mes = date('m');
            $mes1 = date('m');
            $anio = date('Y');
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
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center">LIQUIDACION DE SUELDO</h5>
                    <h6>Remuneraciones Mes de:
                        <?php echo $mes . " " . $anio; ?>
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Razon Social:<br />
                                <?php echo $empresa->getRazonSocial(); ?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h6>Rut:<br />
                                <?php echo $empresa->getRut(); ?>
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Rut:<br />
                                <?php echo $trabajador->getRut(); ?>
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Trabajador:<br />
                                <?php echo $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2(); ?>
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Centro de Costo:<br />
                                <?php echo $centrocosto->getNombre(); ?>
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <h6>AFP</h6>
                            <p>
                                <?php
                                $afp = $c->buscarafp($prevision->getAfp());
                                echo $afp->getNombre() . "<br/> ";
                                $tasa = $c->buscartasaafp($afp->getId(), $mes1, $anio);
                                if ($tasa == null) {
                                    $tasa = $c->buscarultimatasaafp($afp->getId());
                                    if ($tasa == null) {
                                        echo 0;
                                    } else {
                                        echo $tasa->getTasa();
                                    }
                                } else {
                                    echo $tasa->getTasa();
                                }
                                ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6>Isapre</h6>
                            <p>
                                <?php
                                $isapre = $c->buscarisapre($prevision->getIsapre());
                                echo $isapre->getNombre() . " <br/>";
                                if ($isapre->getTipo() == 1) {
                                    echo "7% <br/>";
                                } else {

                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table w-100">
                                <tr>
                                    <th>Dias</th>
                                    <th>HH Extras</th>
                                    <th>HH Faltadas</th>
                                    <th>Cargas</th>
                                    <th>Imponible</th>
                                    <th>Tributable</th>
                                </tr>
                                <tr>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        <?php echo $contrato->getSueldo(); ?>
                                    </td>
                                    <td>
                                        <?php echo $contrato->getSueldo(); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-center">HABERES</h5>
                                    <table class="table">
                                        <?php
                                        $periodo = date($anio . "-" . $mes1 . "-01");
                                        $haberes = $c->listarhaberes_descuentotrababajador($periodo,$periodo,$empresa->getId(),$trabajador->getId(),1);
                                        ?>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-center">HABERES</h5>
                                    <table class="table">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            echo "<br/> <br/> <hr>";

        }
    }
    ?>

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

    <!-- Jquery js-->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap js-->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Internal Chart.Bundle js-->
    <script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>

    <!-- Peity js-->
    <script src="assets/plugins/peity/jquery.peity.min.js"></script>

    <!--Internal Apexchart js-->
    <script src="assets/js/apexcharts.js"></script>

    <!-- Internal Data Table js -->
    <script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/table-data.js"></script>
    <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>


    <!-- Perfect-scrollbar js -->
    <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Select2 js-->
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/select2.js"></script>

    <!-- Sidemenu js -->
    <script src="assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- Sidebar js -->
    <script src="assets/plugins/sidebar/sidebar.js"></script>


    <!-- Sticky js -->
    <script src="assets/js/sticky.js"></script>

    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>
    <script src="JsFunctions/validation.js"></script>
    <script src="JsFunctions/Alert/toastify.js"></script>
    <script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
    <script src="JsFunctions/Alert/alert.js"></script>
    <script src="JsFunctions/main.js"></script>
    <script src="JsFunctions/procesar.js"></script>
    <script src="JsFunctions/precargado.js"></script>

    <script>
        $(document).ready(function () {
            mostrarEmpresa();
        });


    </script>
    <script>
        $(document).ready(function () {
            //Add Datatable
            $('#e2').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ datos/página",
                    "zeroRecords": "No se encontraron resultados en su búsqueda",
                    "searchPlaceholder": "Buscar registros",
                    "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                    "infoEmpty": "No existen registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });


        });
    </script>


</body>

</html>