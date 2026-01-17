<?php
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
if (isset($_SESSION['TRABAJADOR_ID'])) {
	$id = $_SESSION['TRABAJADOR_ID'];
	$trabajador = $c->buscartrabajador($id);
} else {
	header("Location: trabajadores.php");
}

if (isset($_GET['code'])) {
	$id = $_GET['code'];
	$prev = $c->buscarprevision($id);
	if ($prev != null) {
	} else {
		header("Location: menuinfo.php");
	}
} else {
	$prev = null;
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
	<title>Gestor de Documentos | Empresas</title>

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
							<h5 class="empresaname m-0">
								<h5>
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

			<div class="container-fluid">
				<div class="inner-body">

					<!-- Page Header -->
					<div class="page-header">
						<div class="page-header-1">
							<h1 class="main-content-title tx-30">Informacion Previsional</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->


					<!-- Row -->
					<div class="row ">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">

									<form id="PreviForm" name="PreviForm">

										<div class="row">
											<div class="col-md-6">
												<label>Periodo</label>
												<input type="month" required class="form-control text-dark" id="periodo" name="periodo" value="<?php if ($prev != null) {
																																					//Sacar Mes y Año de la Fecha
																																					$fecha = $prev->getPeriodo();
																																					$mes = date("m", strtotime($fecha));
																																					$anio = date("Y", strtotime($fecha));
																																					echo $anio . "-" . $mes;
																																				} else {
																																					echo date("Y-m");
																																				}
																																				?>">
											</div>
											<div class="col-md-6">
												<label>AFP</label>
												<select class="form-control text-dark" required id="TrabajadorAfp" name="TrabajadorAfp">
													<?php
													$afps = $c->listarafp();
													if (count($afps) > 0) {
														foreach ($afps as $l) {
															if ($prev != null) {
																if ($prev->getAfp() == $l->getId()) {
																	echo "<option value='" . $l->getId() . "' selected>" . $l->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															} else {
																echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
															}
														}
													} else {
														echo "<option value='0'>No hay AFP Registradas</option>";
													}
													?>
												</select>
											</div>
											<div class="col-md-6 ">
												<label>Es Jubilado:</label>
												<select class="form-control text-dark" required id="jubilado" name="jubilado" onchange="change()">
													<option value="1" <?php if ($prev != null) {
																			if ($prev->getJubilado() == 1) {
																				echo "selected";
																			}
																		} ?>>Si</option>
													<option value="2" <?php if ($prev != null) {
																			if ($prev->getJubilado() == 2) {
																				echo "selected";
																			}
																		} else {
																			echo "selected";
																		} ?>>No</option>
												</select>
											</div>
											<div class="col-md-6 ">
												<label>Seguro de Cesantía:</label>
												<select class="form-control text-dark" required id="cesantia" name="cesantia">
													<option value="1" <?php if ($prev != null) {
																			if ($prev->getCesantia() == 1) {
																				echo "selected";
																			}
																		} ?>>Si</option>
													<option value="2" <?php if ($prev != null) {
																			if ($prev->getCesantia() == 2) {
																				echo "selected";
																			}
																		} ?>>No</option>
												</select>
											</div>
											<div class="col-md-6 ">
												<label>Afecto Seguro Accidentes:</label>
												<select class="form-control text-dark" required id="seguro" name="seguro">
													<option value="1" <?php if ($prev != null) {
																			if ($prev->getSeguro() == 1) {
																				echo "selected";
																			}
																		} ?>>Si</option>
													<option value="2" <?php if ($prev != null) {
																			if ($prev->getSeguro() == 2) {
																				echo "selected";
																			}
																		} ?>>No</option>
												</select>
											</div>
											<div class="col-md-6">
												<label>Inicio Período Seguro Cesantía:</label>
												<input type="date" required class="form-control text-dark" id="periodocesantia" name="periodocesantia" value="<?php if ($prev != null) {
																																									echo $prev->getPeriodoCesantia();
																																								} ?>">
											</div>
											<div class="col-md-6">
												<label>Institución de Salud</label>
												<select onchange="validarpacto()" class="form-control text-dark" id="TrabajadorIsapre" name="TrabajadorIsapre">
													<?php
													$afps = $c->listarisapre();
													if (count($afps) > 0) {
														foreach ($afps as $l) {
															if ($prev != null) {
																if ($prev->getIsapre() == $l->getId()) {
																	echo "<option value='" . $l->getId() . "' selected>" . $l->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															} else {
																if ($l->getNombre() == "FONASA" || $l->getNombre() == "Fonasa" || $l->getNombre() == "fonasa") {
																	echo "<option value='" . $l->getId() . "' selected>" . $l->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															}
														}
													} else {
														echo "<option value='0'>No hay Instituciones de Salud Registradas</option>";
													}
													?>
												</select>
											</div>

											<input type="hidden" name="tipoIsapre" id="tipoIsapre">
										</div>
										<hr />
										<div class="row">
											<div class="col-md-6 pacto">
												<label>Tipo Monedo del Plan pactado</label>
												<select class="form-control text-dark pacto" id="TrabajadorMonedaPacto" name="TrabajadorMonedaPacto">
													<option value="2" <?php if ($prev != null) {
																			if ($prev->getMonedapacto() == 2) {
																				echo "selected";
																			}
																		} ?>>UF</option>
													<option value="1" <?php if ($prev != null) {
																			if ($prev->getMonedapacto() == 1) {
																				echo "selected";
																			}
																		} ?>>Pesos</option>

												</select>
											</div>
											<div class="col-md-6 pacto">
												<label>Monto del Plan pactado</label>
												<input type="number" step="0.1" placeholder="Monto Pactado" class="form-control text-dark pacto pactoInput" id="TrabajadorMonto" name="TrabajadorMonto" value="<?php if ($prev != null) {
																																																		echo $prev->getMonto();
																																																	} ?>" />
											</div>
											<div class="col-md-6 pacto">
												<label>Tipo Monedo GES</label>
												<select class="form-control text-dark pacto" id="TrabajadorTipoGes" name="TrabajadorTipoGes">
													<option value="2" <?php if ($prev != null) {
																			if ($prev->getTipoges() == 2) {
																				echo "selected";
																			}
																		} ?>>UF</option>
													<option value="1" <?php if ($prev != null) {
																			if ($prev->getTipoges() == 1) {
																				echo "selected";
																			}
																		} ?>>Pesos</option>
												</select>
											</div>
											<div class="col-md-6 pacto">
												<label>Monto GES</label>
												<input type="number" step="0.1" placeholder="Monto Ges" class="form-control text-dark pacto pactoInput" id="TrabajadorGes" name="TrabajadorGes" value="<?php if ($prev != null) {
																																																echo $prev->getGes();
																																															} ?>">
											</div>
										</div>
										<div class="row">

											<div class="col-lg-12 col-md-12">
												<div class="card">
													<div class="card-body">
														<div>
															<h6 class="main-content-label mb-1">Comentario</h6>
														</div>
														<div class="row">
															<div class="col-sm-12 col-md-12">
																<input class="form-control" maxlength="200" type="text" name="comentario" id="comentario" placeholder="Observacion" value="<?php
																																															if ($prev != null) {
																																																echo $prev->getComentario();
																																															} ?>" />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4">
												<div class="card">
													<div class="card-body">
														<div>
															<h6 class="main-content-label mb-1">Cargar Documento AFP</h6>
														</div>
														<div class="row">
															<div class="col-sm-12 col-md-12">
																<input type="file" name="documentoafp" id="documentoafp" class="dropify" data-height="200" <?php
																																									if ($prev != null) {
																																										//CARGAR DOCUMENTO al input file dropify

																																										$documento = $prev->getDocumentoafp();
																																										$carpeta = "uploads/";
																																										$directorio = opendir($carpeta);
																																										while ($archivo = readdir($directorio)) {
																																											if (!is_dir($archivo)) {
																																												if ($archivo == $documento) {
																																													echo "data-default-file='" . $carpeta . $archivo . "'";
																																												}
																																											}
																																										}
																																									}
																																									?> />
																<?php
																if ($prev != null) {
																	echo "<input type='hidden' name='name_afp_documento' id='name_afp_documento' value='" . $prev->getDocumentoafp() . "'>";
																} ?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4">
												<div class="card">
													<div class="card-body">
														<div>
															<h6 class="main-content-label mb-1">Cargar Documento SALUD</h6>
														</div>
														<div class="row">
															<div class="col-sm-12 col-md-12">
																<input type="file" name="documentosalud" id="documentosalud" class="dropify" data-height="200" <?php
																																								if ($prev != null) {
																																									//CARGAR DOCUMENTO al input file dropify

																																									$documento = $prev->getDocumentosalud();
																																									$carpeta = "uploads/";
																																									$directorio = opendir($carpeta);
																																									while ($archivo = readdir($directorio)) {
																																										if (!is_dir($archivo)) {
																																											if ($archivo == $documento) {
																																												echo "data-default-file='" . $carpeta . $archivo . "'";
																																											}
																																										}
																																									}
																																								}
																																								?> />
																<?php
																if ($prev != null) {
																	echo "<input type='hidden' name='name_salud_documento' id='name_salud_documento' value='" . $prev->getDocumentosalud() . "'>";
																} ?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4">
												<div class="card">
													<div class="card-body">
														<div>
															<h6 class="main-content-label mb-1">Cargar Documento Jubilacion</h6>
														</div>
														<div class="row">
															<div class="col-sm-12 col-md-12">
																<input type="file" <?php if ($prev != null) {
																						if ($prev->getJubilado() == 1) {
																							echo "required";
																						}
																					} ?> name="documentojubilacion" id="documentojubilacion" class="dropify" data-height="200" <?php
																																												if ($prev != null) {
																																													//CARGAR DOCUMENTO al input file dropify

																																													$documento = $prev->getDocumentojubilacion();
																																													$carpeta = "uploads/";
																																													$directorio = opendir($carpeta);
																																													while ($archivo = readdir($directorio)) {
																																														if (!is_dir($archivo)) {
																																															if ($archivo == $documento) {
																																																echo "data-default-file='" . $carpeta . $archivo . "'";
																																															}
																																														}
																																													}
																																												}
																																												?> />
																<?php
																if ($prev != null) {
																	echo "<input type='hidden' name='name_jubilacion_documento' id='name_jubilacion_documento' value='" . $prev->getDocumentojubilacion() . "'>";
																} ?>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										<div class="col-md-12 mt-3 text-right">
											<a href="menuinfo.php" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Volver</a>
											<?php
											if ($prev != null) {
												echo '<button type="submit" class="btn btn-success" name="actualizar" id="actualizar">Guardar Cambios</button>';
											} else {
											?>
												<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Registrar</button>
											<?php
											}
											?>
										</div>


								</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row m-3 d-none">
					<div class="col-md-12 table-responsive">
						<h4>Información Previsional</h4>
						<table class="table">
							<thead>
								<tr>
									<td>Periodo</td>
									<td>AFP</td>
									<td>Es Jubilado</td>
									<td>Seguro de Cesantia</td>
									<td>Seguro Accidentes</td>
									<td>Inicio Cesantia</td>
									<td>Institución de Salud</td>
									<td>Moneda Plan Pactado</td>
									<td>Monto</td>
									<td>Moneda GES</td>
									<td>Monto</td>
									<td>Comentario</td>
									<td>Documento</td>
								</tr>
							</thead>
							<tbody class="tableprevision">

							</tbody>

						</table>

					</div>
				</div>
			</div>
			<!-- End Main Content-->

			<!-- Main Footer-->
			<div class="main-footer text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<span>Copyright © 2022 - KaiserTech Todos los derechos reservados.</span>
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
		<script src="JsFunctions/Comunas.js"></script>
		<script src="JsFunctions/precargado.js"></script>

		<script src="JsFunctions/Trabajadores.js"></script>
		<?php
		if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
			$id = $_SESSION['CURRENT_ENTERPRISE'];
			echo "<script>";
			echo "window.onload = function(){
			validarpacto();
		mostrarEmpresa(" . $id . ");
	}";
			echo "</script>";
		}

		?>




</body>

</html>