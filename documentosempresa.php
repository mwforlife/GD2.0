<?php
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
require 'php/controller.php';
$c = new Controller();
?>
<?php
session_start();
unset($_SESSION['TRABJADOR_CONTRATO']);
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}
$permiso = $c->listarPermisosUsuario1($_SESSION['USER_ID']);
$gestion = false;
$_SESSION['GESTION_PERMISO'] = false;
$lectura = false;
$_SESSION['LECTURA_PERMISO'] = true;
$escritura = false;
$_SESSION['ESCRITURA_PERMISO'] = true;
$actualizacion = false;
$_SESSION['ACTUALIZACION_PERMISO'] = true;
$eliminacion = false;
$_SESSION['ELIMINACION_PERMISO'] = true;
foreach ($permiso as $p) {
    if ($p->getId() == 1) {
        $gestion = true;
        $_SESSION['GESTION_PERMISO'] = true;
    } else if ($p->getId() == 2) {
        $lectura = true;
        $_SESSION['LECTURA_PERMISO'] = true;
    } else if ($p->getId() == 3) {
        $escritura = true;
        $_SESSION['ESCRITURA_PERMISO'] = true;
    } else if ($p->getId() == 4) {
        $actualizacion = true;
        $_SESSION['ACTUALIZACION_PERMISO'] = true;
    } else if ($p->getId() == 5) {
        $eliminacion = true;
        $_SESSION['ELIMINACION_PERMISO'] = true;
    }
}
$emp = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $emp = $c->buscarempresa($empresa);
} else {
    header("Location: index.php");
}

if ($emp == null) {
    header("Location: index.php");
}
?>

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
    <title>Gestor de Documentos | Documentos Empresas</title>

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
    <!-- Internal Daterangepicker css-->
    <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- InternalFileupload css-->
    <link href="assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />

    <!-- InternalFancy uploader css-->
    <link href="assets/plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />

    <!-- Internal TelephoneInput css-->
    <link rel="stylesheet" href="assets/plugins/telephoneinput/telephoneinput.css">

    <!-- Internal DataTables css-->
    <link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

    <!-- Sidemenu css-->
    <link href="assets/css/sidemenu/sidemenu.css" rel="stylesheet">

    <link rel="stylesheet" href="JsFunctions/Alert/loader.css">
    <script src="JsFunctions/Alert/loader.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .main-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--primary-color);
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-card.primary {
            border-left: 4px solid var(--primary-color);
        }

        .stats-card.success {
            border-left: 4px solid var(--success-color);
        }

        .stats-card.warning {
            border-left: 4px solid var(--warning-color);
        }

        .stats-card.info {
            border-left: 4px solid var(--info-color);
        }

        .custom-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 1.5rem;
            border: none;
        }

        .document-editor {
            min-height: 500px;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            position: relative;
            background: #fafafa;
        }

        .document-editor.active {
            border-color: var(--primary-color);
            background: white;
        }

        .editor-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
            color: #64748b;
        }

        .editor-content {
            padding: 2rem;
            min-height: 500px;
            line-height: 1.8;
            font-size: 14px;
            background: white;
            display: none;
        }

        .editor-content.active {
            display: block;
        }

        .variable-item {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            margin: 0.25rem 0;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }

        .variable-item:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(4px);
        }

        .mandatario-card {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            position: relative;
        }

        .mandatario-card .remove-mandatario {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: var(--danger-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .table-custom {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-custom thead {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }

        .accordion-button-custom {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: none;
            font-weight: 500;
        }

        .accordion-button-custom:not(.collapsed) {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.75rem;
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .modal-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }

        .badge-custom {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .precio-input {
            position: relative;
        }

        .precio-input::before {
            content: '$';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 500;
            z-index: 2;
        }

        .precio-input input {
            padding-left: 2rem;
        }

        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1rem;
            }

            .document-editor {
                min-height: 300px;
            }

            .editor-placeholder {
                height: 300px;
                padding: 1rem;
                text-align: center;
            }
        }
    </style>

</head>

<body class="main-body leftmenu">

    <!-- Loader -->
    <div id="global-loader">
        <div class="loader-box">
            <div class="loading-wrapper">
                <div class="loader">
                    <div class="loader-inner">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Loader -->


    <!-- Page -->
    <div class="page">


        <!-- Sidemenu -->
        <div class="main-sidebar main-sidebar-sticky side-menu">
            <div class="sidemenu-logo">
                <a class="main-logo" href="index.php">
                    <img src="assets/img/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                    <img src="assets/img/brand/icon.png" class="header-brand-img icon-logo" alt="logo">
                    <img src="assets/img/brand/dark-logo.png" class="header-brand-img desktop-logo theme-logo" alt="logo">
                    <img src="assets/img/brand/icon.png" class="header-brand-img icon-logo theme-logo" alt="logo">
                </a>
            </div>

            <div class="main-sidebar-body">
                <?php
                $user = $c->buscarusuario($_SESSION['USER_ID']);
                if ($user != null) {
                    if ($user->getTipo() != 3) {
                ?>
                        <ul class="nav">
							<li class="nav-header"><span class="nav-label">Dashboard</span></li>

							<?php

							if (isset($_SESSION['GESTION_PERMISO']) || isset($_SESSION['LECTURA_PERMISO']) || isset($_SESSION['ESCRITURA_PERMISO']) || isset($_SESSION['ACTUALIZACION_PERMISO']) || isset($_SESSION['ELIMINACION_PERMISO'])) {
								if ($_SESSION['GESTION_PERMISO'] == true) {

							?>
									<li class="nav-item">
										<a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span
												class="sidemenu-label">Definiciones</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="nav-sub">
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="isapres.php">Institución de Salud</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="afp.php">AFP</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="segurosocial_expectativadevida.php">Seguro Social / Expectativa de Vida</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="segurosocial_rentabilidadprotegida.php">Seguro Social / Rentabilidad Protegida</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="segurosocial_sis.php">Seguro Social / Seguro de Invalidez Y Sobrevivencia (SIS)</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="pagadoressubsidio.php">PAGADORES SUBSIDIO</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="regiones.php">REGIONES</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="comunas.php">COMUNAS</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="nacionalidad.php">NACIONALIDADES</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="jornadas.php">MOVIMIENTO PERSONAL</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="tiposueldo.php">TIPO SUELDO BASE</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="cajacompensacion.php">CAJAS DE COMPENSACIÓN</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="mutuales.php">MUTUALES DE SEGURIDAD</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="asignacionfamiliar.php">TRAMOS ASIGNACION FAMILIAR</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="tipocontrato.php">TIPO CONTRATO LABORAL</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="causaltermino.php">CAUSAL TERMINO CONTRATO</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="diasferiados.php">DIAS FERIADOS</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="codigolre.php">CODIGOS LRE</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="uf.php">UF</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="utm.php">UTM</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="uta.php">UTA</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="sminimo.php">SUELDO MÍNIMO</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="topeafp.php">Tope AFP</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="topeips.php">TOPE IPS</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="topecesantia.php">TOPE SEGURO CESANTÍA</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="topeapv.php">TOPE APV MENSUAL</a>
											</li>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="topeapvanual.php">TOPE APV ANUAL</a>
											</li>
										</ul>
									</li>
								<?php
								}
								?>
								<li class="nav-header"><span class="nav-label">FUNCIONES</span></li>


								<li class="nav-item">
									<a class="nav-link with-sub" href="#"><i class="fe fe-message-square sidemenu-icon"></i><span
											class="sidemenu-label">Maestros</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="nav-sub">
										<?php
										if ($_SESSION['GESTION_PERMISO'] == true || $_SESSION['ESCRITURA_PERMISO'] == true) {
										?>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="empresas.php">Empresas</a>
											</li>
										<?php
										}
										?>
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="asignarcentrocosto.php">Gestionar Mandante</a>
										</li>
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="trabajadores.php">Trabajadores</a>
										</li>
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="haberes.php">Haberes y Descuentos</a>
										</li>

										<?php
										if ($_SESSION['GESTION_PERMISO'] == true) {
										?>
											<li class="nav-sub-item">
												<a class="nav-sub-link" href="tipodocumento.php">Escritos</a>
											</li>
										<?php
										}
										?>

										<?php
										if (isset($_SESSION['GESTION_PERMISO'])) {
											if ($_SESSION['GESTION_PERMISO'] == true) {

										?>
												<li class="nav-sub-item">
													<a class="nav-sub-link" href="usuarios.php">Usuarios</a>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</li>
							<?php
							}

							if ($_SESSION['GESTION_PERMISO'] == true) {
							?>
								<li class="nav-item">
									<a class="nav-link with-sub" href="#"><i class="fe fe-droplet sidemenu-icon"></i><span
											class="sidemenu-label">Auditoria</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="nav-sub">
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="auditoriatrabajadores.php">Auditoria de trabajadores</a>
										</li>
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="auditoriaeventos.php">Auditoria de eventos</a>
										</li>

									</ul>
								</li>
							<?php
							}
							?>
							<!--------------------Generarion de documentos------------------>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span
										class="sidemenu-label">Documentos</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="contratoindividual.php">Contrato Individual</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="generarlote.php">Contratos Masivos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="generarloteanexo.php">Anexos Masivos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="finiquitoindividual.php">Finiquito Individual</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="generarlotefiniquito.php">Finiquitos Masivos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="notificacionindividual.php">Notificacion Individual</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="generarlotenotificacion.php">Notificación Masiva</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="documentospersonalizados.php">Documentos Individual</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="generarlotepersonalizado.php">Documentos Masivos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="documentosempresa.php">Documentos Empresa</a>
									</li>
								</ul>
							</li>
							<!--------------------------------------------------------------->
							<!--------------------Remuneraciones------------------>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-dollar-sign sidemenu-icon"></i><span
										class="sidemenu-label">Remuneraciones</span><i
										class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="habmaster.php">Haberes y Descuentos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="asistencia.php">Asistencia</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="cargaasistencia.php">Cargar Asistencia</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="repmovimientos.php">Movimiento de Personal</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="procesar.php">Procesar Trabajadores</a>
									</li>
								</ul>
							</li>
							<!--------------------------------------------------------------->
							<!--------------------Carga de documentos------------------>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-upload sidemenu-icon"></i><span
										class="sidemenu-label">Carga de Documentos</span><i
										class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="cargatrabajador.php">Trabajadores</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="cargaempresa.php">Empresa</a>
									</li>
								</ul>
							</li>
							<!--------------------Reportes------------------>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span
										class="sidemenu-label">Reportes</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="impresiondocumentos.php">Impresión Documentos</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="impresionmasiva.php">Impresión Masiva</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="documentosfirmados.php">Documentos Firmados</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="liquidaciones.php">Reporte Liquidaciones</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="librosremuneraciones.php">Libros de Remuneraciones</a>
									</li>
								</ul>
							</li>
							<!--------------------------------------------------------------->

						</ul>
                    <?php
                    } else if ($user->getTipo() == 3) {
                    ?>
                        <ul class="nav">
                            <li class="nav-header"><span class="nav-label">Reporte Mandante</span></li>
                            <!-----------------------------Mandante--------------------------------->
                            <li class="nav-item">
                                <a class="nav-link with-sub" href="#"><i class="fe fe-user sidemenu-icon"></i><span
                                        class="sidemenu-label">Mandante</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="nav-sub">
                                    <li class="nav-sub-item">
                                        <a class="nav-sub-link" href="mandanteempresa.php">Documentos Empresa</a>
                                    </li>
                                    <li class="nav-sub-item">
                                        <a class="nav-sub-link" href="mandantetrabajadores.php">Documentos Trabajadores

                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                <?php

                    }
                }
                ?>

            </div>
        </div>
        <!-- End Sidemenu -->
        <!-- Main Header-->
        <div class="main-header side-header sticky">
            <div class="container-fluid">
                <div class="main-header-left">
                    <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
                </div>
                <div class="main-header-center">
                    <div class="responsive-logo">
                        <a href="index.php"><img src="assets/img/brand/dark-logo.png" class="mobile-logo" alt="logo"></a>
                        <a href="index.php"><img src="assets/img/brand/logo.png" class="mobile-logo-dark" alt="logo"></a>
                    </div>
                    <div class="input-group">
                        <div class="d-flex justify-content-center align-items-center">
                            <h5 class="empresaname m-0"><?php echo $emp->getRazonSocial(); ?><h5>
                        </div>
                    </div>
                </div>
                <div class="main-header-right">
                    <div class="dropdown d-md-flex">
                        <a class="nav-link icon full-screen-link fullscreen-button" href="">
                            <i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg></i>
                            <i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                </svg></i>
                        </a>
                    </div>
                    <div class="dropdown main-profile-menu">
                        <a class="d-flex" href="">
                            <span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="header-navheading">
                                <h6 class="main-notification-title">
                                    <?php echo $_SESSION['USER_NAME'];
                                    ?></h6>
                            </div>
                            <a class="dropdown-item" href="close.php">
                                <i class="fe fe-power"></i> Cerrar Sesíon
                            </a>
                        </div>
                    </div>
                    <button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                    </button><!-- Navresponsive closed -->
                </div>
            </div>
        </div>
        <!-- End Main Header-->

        <!-- Mobile-header -->
        <div class="mobile-main-header">
            <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="dropdown">
                            <a class="nav-link icon full-screen-link fullscreen-button" href=""><i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                    </svg></i>
                                <i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                    </svg></i>
                            </a>
                        </div>
                        <div class="dropdown main-profile-menu">
                            <a class="d-flex" href="#">
                                <span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <h6 class="main-notification-title"><?php echo $_SESSION['USER_NAME']; ?></h6>
                                </div>

                                <a class="dropdown-item" href="close.php">
                                    <i class="fe fe-power"></i> Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile-header closed -->


        <!-- Main Content-->
        <div class="main-content side-content pt-0">

            <div class="container-fluid py-4">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">
                                <i class="fas fa-building me-2 text-primary"></i>
                                Documentos Empresariales
                            </h2>
                            <p class="text-muted mb-0">Gestiona mandatos especiales, contratos de arriendo y comodato</p>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inicio</a></li>
                                <li class="breadcrumb-item active">Documentos Empresa</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Documentos Creados</h6>
                                    <h3 class="mb-0 text-primary" id="totalDocumentos">1,587</h3>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-file-plus fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Plantillas Activas</h6>
                                    <h3 class="mb-0 text-success" id="totalPlantillas">24</h3>
                                </div>
                                <div class="text-success">
                                    <i class="fas fa-layer-group fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Mandatarios Activos</h6>
                                    <h3 class="mb-0 text-warning" id="totalMandatarios">8</h3>
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Documentos Pendientes</h6>
                                    <h3 class="mb-0 text-info" id="totalPendientes">164</h3>
                                </div>
                                <div class="text-info">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <!-- Editor Section -->
                    <div class="col-lg-8">
                        <div class="custom-card">
                            <div class="card-header-custom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-eye me-2"></i>
                                        Vista de Plantilla
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Document Configuration -->
                                <div class="p-3 border-bottom bg-light">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Tipo de Documento:</label>
                                            <select class="form-select form-control-custom" id="documentType" required>
                                                <option value="">Seleccionar tipo...</option>
                                                <?php
                                                $tipos = $c->listarTipoDocumentoEmpresa1();
                                                foreach ($tipos as $tipo) {
                                                    echo '<option value="' . $tipo->id . '" data-type="' . $tipo->categoria . '">' . $tipo->nombre . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Plantilla Base:</label>
                                            <select class="form-select form-control-custom" id="templateBase" disabled>
                                                <option value="">Seleccionar plantilla...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Rol avaluo fiscal <span class="text-muted">(opcional)</span>:</label>
                                            <input type="text" class="form-control form-control-custom" id="avaluoFiscal"
                                                placeholder="Ingrese rol avaluo fiscal" required>
                                        </div>
                                        <div class="col-md-12" id="montoArriendoContainer" style="display: none;">
                                            <label class="form-label fw-bold">Monto Arriendo:</label>
                                            <div class="precio-input">
                                                <input type="number" class="form-control form-control-custom" id="montoArriendo"
                                                    placeholder="0" min="0" step="1000">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Editor Area -->
                                <div class="position-relative">
                                    <div class="loading-overlay" id="editorLoading">
                                        <div class="spinner"></div>
                                    </div>
                                    <div id="documentEditor" class="document-editor">
                                        <textarea class="editor-content" id="editorContent"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Tools -->
                    <div class="col-lg-4">
                        <!-- Variables Panel -->
                        <div class="custom-card mb-4">
                            <div class="card-header-custom">
                                <h6 class="mb-0">
                                    <i class="fas fa-code me-2"></i>
                                    Variables de Campo
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="accordion" id="variablesAccordion">
                                    <!-- Empresa Variables -->
                                    <div class="accordion-item border-0">
                                        <h6 class="accordion-header">
                                            <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#empresaVars">
                                                <i class="fas fa-building me-2"></i>
                                                Datos de Empresa
                                            </button>
                                        </h6>
                                        <div id="empresaVars" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion">
                                            <div class="accordion-body p-2">
                                                <div class="variable-item" data-variable="{RUT_EMPRESA}">
                                                    {RUT_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{RUT_EMPRESA_EN_LETRAS}">
                                                    {RUT_EMPRESA_EN_LETRAS}
                                                </div>
                                                <div class="variable-item" data-variable="{NOMBRE_EMPRESA}">
                                                    {NOMBRE_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{REPRESENTANTE_LEGAL}">
                                                    {REPRESENTANTE_LEGAL}
                                                </div>
                                                <div class="variable-item" data-variable="{RUT_REPRESENTANTE_LEGAL}">
                                                    {RUT_REPRESENTANTE_LEGAL}
                                                </div>
                                                <div class="variable-item" data-variable="{RUT_REPRESENTANTE_LEGAL_EN_LETRAS}">
                                                    {RUT_REPRESENTANTE_LEGAL_EN_LETRAS}
                                                </div>
                                                <div class="variable-item" data-variable="{DIRECCION_EMPRESA}">
                                                    {DIRECCION_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{REGION_EMPRESA}">
                                                    {REGION_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{COMUNA_EMPRESA}">
                                                    {COMUNA_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{CIUDAD_EMPRESA}">
                                                    {CIUDAD_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{VILLA_EMPRESA}">
                                                    {VILLA_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{GIRO_EMPRESA}">
                                                    {GIRO_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{TELEFONO_EMPRESA}">
                                                    {TELEFONO_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{CORREO_EMPRESA}">
                                                    {CORREO_EMPRESA}
                                                </div>
                                                <div class="variable-item" data-variable="{AVALUO_FISCAL}">
                                                    {AVALUO_FISCAL}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mandatarios Variables -->
                                    <div class="accordion-item border-0">
                                        <h6 class="accordion-header">
                                            <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#mandatarioVars">
                                                <i class="fas fa-users me-2"></i>
                                                Datos de Mandatarios
                                            </button>
                                        </h6>
                                        <div id="mandatarioVars" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion">
                                            <div class="accordion-body p-2">
                                                <div class="variable-item" data-variable="{DATOS_MANDATARIOS_ENCABEZADO}">
                                                    {DATOS MANDATARIOS ENZABEZADO}
                                                </div>
                                                <div class="variable-item" data-variable="{DATOS_MANDATARIOS}">
                                                    {DATOS MANDATARIOS}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fechas y Otros -->
                                    <div class="accordion-item border-0">
                                        <h6 class="accordion-header">
                                            <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#otrosVars">
                                                <i class="fas fa-calendar me-2"></i>
                                                Fechas y Otros
                                            </button>
                                        </h6>
                                        <div id="otrosVars" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion">
                                            <div class="accordion-body p-2">
                                                <div class="variable-item" data-variable="{FECHA_GENERACION}">
                                                    {FECHA_GENERACION}
                                                </div>
                                                <div class="variable-item" data-variable="{FECHA_CELEBRACION}">
                                                    {FECHA_CELEBRACION}
                                                </div>
                                                <div class="variable-item" data-variable="{MONTO_ARRIENDO}">
                                                    {MONTO_ARRIENDO}
                                                </div>
                                                <div class="variable-item" data-variable="{MONTO_ARRIENDO_LETRAS}">
                                                    {MONTO_ARRIENDO_LETRAS}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mandatarios Panel -->
                        <div class="custom-card mb-4">
                            <div class="card-header-custom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Gestión de Mandatarios
                                    </h6>
                                    <button class="btn btn-light btn-sm" id="addMandatarioBtn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="mandatariosList" class="mandatarios-container">
                                    <div class="text-center text-muted py-3" id="noMandatarios">
                                        <i class="fas fa-users fa-3x mb-2"></i>
                                        <p class="mb-0">No hay mandatarios asignados</p>
                                        <small>Haz clic en + para agregar</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Panel -->
                        <div class="custom-card">
                            <div class="card-header-custom">
                                <h6 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>
                                    Acciones Rápidas
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary" id="previewDocumentBtn" disabled>
                                        <i class="fas fa-eye me-2"></i>
                                        Vista Previa
                                    </button>
                                    <button class="btn btn-outline-success" id="generateDocumentBtn" disabled>
                                        <i class="fas fa-download me-2"></i>
                                        Generar PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Management Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card" id="tab">
                            <div class="card-body">
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="border">
                                            <div class="bg-light-1 nav-bg">
                                                <nav class="nav nav-tabs">
                                                    <a class="nav-link active" data-toggle="tab" href="#tabCont1"><i class="fas fa-file-alt me-2"></i>Plantillas de Documentos</a>
                                                    <a class="nav-link" data-toggle="tab" href="#tabCont2"><i class="fas fa-file-pdf me-2"></i>Documentos Generados</a>
                                                </nav>
                                            </div>
                                            <div class="card-body tab-content">
                                                <div class="tab-pane active show" id="tabCont1">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="mb-0">
                                                            <i class="fas fa-folder me-2"></i>
                                                            Plantillas Base
                                                        </h5>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-primary btn-sm" id="createTemplateBtn">
                                                                <i class="fas fa-plus me-1"></i>
                                                                Nueva Plantilla
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="table-responsive" id="templatesTableContainer">
                                                                        <table class="table table-hover" id="templatesTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Tipo</th>
                                                                                    <th>Nombre</th>
                                                                                    <th>Categoría</th>
                                                                                    <th>Última Modificación</th>
                                                                                    <th>Estado</th>
                                                                                    <th>Acciones</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tab-pane" id="tabCont2">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="mb-0">
                                                            <i class="fas fa-file-pdf me-2"></i>
                                                            Documentos Generados
                                                        </h5>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-custom" id="generatedTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Título</th>
                                                                                    <th>Tipo</th>
                                                                                    <th>Mandatarios</th>
                                                                                    <th>Fecha Generación</th>
                                                                                    <th>Estado</th>
                                                                                    <th>Acciones</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modals -->

            <!-- Add Mandatario Modal -->
            <div class="modal fade" id="addMandatarioModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title text-white">
                                <i class="fas fa-user-plus me-2"></i>
                                Agregar Mandatario
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Seleccionar Usuario:</label>
                                    <select class="form-control select2 w-100  form-control-custom" id="selectUsuario" required>
                                        <option value="">Seleccionar usuario...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">RUT:</label>
                                        <input type="text" class="form-control form-control-custom" id="rutMandatario" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre Completo:</label>
                                        <input type="text" class="form-control form-control-custom" id="nombreMandatario" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nacionalidad:</label>
                                        <input type="text" class="form-control form-control-custom" id="nacionalidadMandatario" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Estado Civil:</label>
                                        <input type="text" class="form-control form-control-custom" id="estadoCivilMandatario" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profesión:</label>
                                <input type="text" class="form-control form-control-custom" id="profesionMandatario" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary btn-primary-custom" id="saveMandatarioBtn">
                                <i class="fas fa-save me-1"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create/Edit Template Modal -->
            <div class="modal fade" id="templateModal" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title text-white" id="templateModalTitle">
                                <i class="fas fa-plus me-2"></i>
                                Nueva Plantilla
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <form id="templateForm">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nombre de la Plantilla:</label>
                                                <input type="text" class="form-control form-control-custom" id="templateName" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Categoría:</label>
                                                <select class="form-select form-control-custom" id="templateCategory" required>
                                                    <?php
                                                    $tipos = $c->listarTipoDocumentoEmpresa1();
                                                    foreach ($tipos as $tipo) {
                                                        echo '<option value="' . $tipo->id . '">' . $tipo->nombre . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Descripción:</label>
                                            <textarea class="form-control form-control-custom" id="templateDescription" rows="2"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Contenido de la Plantilla:</label>
                                            <textarea class="form-control form-control-custom" id="templateContent" rows="25" placeholder="Escriba el contenido de la plantilla aquí. Use variables como {RUT_EMPRESA}, {NOMBRE_EMPRESA}, etc."></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <!-- Variables Panel -->
                                    <div class="custom-card mb-4">
                                        <div class="card-header-custom">
                                            <h6 class="mb-0">
                                                <i class="fas fa-code me-2"></i>
                                                Variables de Campo
                                            </h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="accordion" id="variablesAccordion1">
                                                <!-- Empresa Variables -->
                                                <div class="accordion-item border-0">
                                                    <h6 class="accordion-header">
                                                        <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#empresaVars1">
                                                            <i class="fas fa-building me-2"></i>
                                                            Datos de Empresa
                                                        </button>
                                                    </h6>
                                                    <div id="empresaVars1" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion1">
                                                        <div class="accordion-body p-2">
                                                            <div class="variable-item" data-variable="{RUT_EMPRESA}">
                                                                {RUT_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{RUT_EMPRESA_EN_LETRAS}">
                                                                {RUT_EMPRESA_EN_LETRAS}
                                                            </div>
                                                            <div class="variable-item" data-variable="{NOMBRE_EMPRESA}">
                                                                {NOMBRE_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{REPRESENTANTE_LEGAL}">
                                                                {REPRESENTANTE_LEGAL}
                                                            </div>
                                                            <div class="variable-item" data-variable="{RUT_REPRESENTANTE_LEGAL}">
                                                                {RUT_REPRESENTANTE_LEGAL}
                                                            </div>
                                                            <div class="variable-item" data-variable="{RUT_REPRESENTANTE_LEGAL_EN_LETRAS}">
                                                                {RUT_REPRESENTANTE_LEGAL_EN_LETRAS}
                                                            </div>
                                                            <div class="variable-item" data-variable="{DIRECCION_EMPRESA}">
                                                                {DIRECCION_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{REGION_EMPRESA}">
                                                                {REGION_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{COMUNA_EMPRESA}">
                                                                {COMUNA_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{CIUDAD_EMPRESA}">
                                                                {CIUDAD_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{VILLA_EMPRESA}">
                                                                {VILLA_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{GIRO_EMPRESA}">
                                                                {GIRO_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{TELEFONO_EMPRESA}">
                                                                {TELEFONO_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{CORREO_EMPRESA}">
                                                                {CORREO_EMPRESA}
                                                            </div>
                                                            <div class="variable-item" data-variable="{AVALUO_FISCAL}">
                                                                {AVALUO_FISCAL}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Mandatarios Variables -->
                                                <div class="accordion-item border-0">
                                                    <h6 class="accordion-header">
                                                        <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#mandatarioVars1">
                                                            <i class="fas fa-users me-2"></i>
                                                            Datos de Mandatarios
                                                        </button>
                                                    </h6>
                                                    <div id="mandatarioVars1" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion1">
                                                        <div class="accordion-body p-2">
                                                            <div class="variable-item" data-variable="{DATOS_MANDATARIOS_ENCABEZADO}">
                                                                {DATOS MANDATARIOS ENZABEZADO}
                                                            </div>
                                                            <div class="variable-item" data-variable="{DATOS_MANDATARIOS}">
                                                                {DATOS MANDATARIOS}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fechas y Otros -->
                                                <div class="accordion-item border-0">
                                                    <h6 class="accordion-header">
                                                        <button class="accordion-button accordion-button-custom collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#otrosVars1">
                                                            <i class="fas fa-calendar me-2"></i>
                                                            Fechas y Otros
                                                        </button>
                                                    </h6>
                                                    <div id="otrosVars1" class="accordion-collapse collapse" data-bs-parent="#variablesAccordion1">
                                                        <div class="accordion-body p-2">
                                                            <div class="variable-item" data-variable="{FECHA_GENERACION}">
                                                                {FECHA_GENERACION}
                                                            </div>
                                                            <div class="variable-item" data-variable="{FECHA_CELEBRACION}">
                                                                {FECHA_CELEBRACION}
                                                            </div>
                                                            <div class="variable-item" data-variable="{MONTO_ARRIENDO}">
                                                                {MONTO_ARRIENDO}
                                                            </div>
                                                            <div class="variable-item" data-variable="{MONTO_ARRIENDO_LETRAS}">
                                                                {MONTO_ARRIENDO_LETRAS}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-primary-custom" id="saveTemplateBtn">
                                <i class="fas fa-save me-1"></i>
                                Guardar Plantilla
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <div class="modal fade" id="previewModal" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title">
                                <i class="fas fa-eye me-2"></i>
                                Vista Previa del Documento
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div id="previewContent" class="p-4" style="min-height: 500px; background: white;">
                                <!-- Preview content will be loaded here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success" id="downloadPdfBtn">
                                <i class="fas fa-download me-1"></i>
                                Generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title">
                                <i class="fas fa-filter me-2"></i>
                                Filtros de Búsqueda
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo de Documento:</label>
                                <select class="form-select form-control-custom" id="filterDocumentType">
                                    <option value="">Todos los tipos</option>
                                    <option value="mandato_especial_empresa">Mandato Especial Empresa</option>
                                    <option value="mandato_especial_representante">Mandato Especial Representante Legal</option>
                                    <option value="contrato_arriendo">Contrato de Arriendo</option>
                                    <option value="contrato_comodato">Contrato de Comodato</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha Desde:</label>
                                        <input type="date" class="form-control form-control-custom" id="filterDateFrom">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha Hasta:</label>
                                        <input type="date" class="form-control form-control-custom" id="filterDateTo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-outline-warning" id="clearFiltersBtn">
                                <i class="fas fa-eraser me-1"></i>
                                Limpiar
                            </button>
                            <button type="button" class="btn btn-primary btn-primary-custom" id="applyFiltersBtn">
                                <i class="fas fa-check me-1"></i>
                                Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Footer-->
            <div class="main-footer text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <span>Copyright © <?php echo date("Y"); ?> iustax. Todos los derechos reservados.</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer-->

            <!-- Sidebar -->
            <div class="sidebar sidebar-right sidebar-animate">
                <div class="sidebar-icon">
                    <a href="#" class="text-right float-right text-dark fs-20" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <!-- End Sidebar -->

        </div>
        <!-- End Page -->

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

        <!-- Internal Fileuploads js-->
        <script src="assets/plugins/fileuploads/js/fileupload.js"></script>
        <script src="assets/plugins/fileuploads/js/file-upload.js"></script>

        <!-- InternalFancy uploader js-->
        <script src="assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.fileupload.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
        <script src="assets/plugins/fancyuploder/fancy-uploader.js"></script>

        <!-- Internal Form-elements js-->
        <script src="assets/js/advanced-form-elements.js"></script>
        <script src="assets/js/select2.js"></script>

        <!-- Internal TelephoneInput js-->
        <script src="assets/plugins/telephoneinput/telephoneinput.js"></script>
        <script src="assets/plugins/telephoneinput/inttelephoneinput.js"></script>

        <!-- Internal Data Table js -->
        <script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
        <script src="assets/js/table-data.js"></script>
        <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>


        <!-- JavaScript Libraries -->

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

        <?php
        if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
            $id = $_SESSION['CURRENT_ENTERPRISE'];
            echo "<script>";
            echo "window.onload = function(){
                    mostrarEmpresa(" . $id . ");
                }";
            echo "</script>";
        }

        ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.all.min.js"></script>
        <script src="JsFunctions/tinymce.min.js"></script>
        <script src="JsFunctions/documento_empresa.js"></script>
</body>

</html>