<?php
require 'php/controller.php';
$c = new Controller();
?>
<?php
session_start();
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
} else {
	header("Location: index.php");
}
$lote = $c->buscarlote($_SESSION['USER_ID']);
if (count($lote) > 0) {
	$emp = $c->buscarEmpresavalor($empresa);
} else {
	header("Location: generarlote.php");
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
	<title>Gestor de Documentos</title>

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
		<!-- Main Content-->
		<div class="main-content side-content pt-0">

			<div class="container-fluid">
				<div class="inner-body">

					<!-- Page Header -->
					<div class="page-header">
						<div class="page-header-1">
							<h1 class="main-content-title tx-30">Contrato de Trabajo</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- ROW- opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card" id="style1">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Registro Contrato de Trabajo</h6>
									</div>
									<!----------Menu Encabezado-------------->
									<div class="text-wrap">
										<div class="example">
											<nav class="breadcrumb-5">
												<div class="breadcrumb flat">
													<a href="#" onclick="mostrar(1)" class="men1 active"><span class="badge badge-light mr-3">1</span><span class="breadcrumbitem">Identificacion de las Partes</span></a>
													<a href="#" onclick="mostrar(2)" class="men2"><span class="badge  badge-light mr-3">2</span><span class="breadcrumbitem">Funciones y Lugares de Prestación de los servicios</span></a>
													<a href="#" onclick="mostrar(3)" class="men3"><span class="badge badge-light mr-3">3</span><span class="breadcrumbitem">Remuneraciones</span></a>
													<a href="#" onclick="mostrar(4)" class="men4"><span class="badge badge-light mr-3">4</span><span class="breadcrumbitem">Jornada de trabajo y otras estipulaciones</span></a>
												</div>
											</nav>
										</div>
									</div>
									<!----------Fin Menu Encabezado-------------->
									<!----------Formulario Identificacion de las partes-------------->
									<form>
										<!----------------------Identificacion de las partes------------------------->
										<div class="identificacion mt-4">
											<div class="row">
												<div class="col-md-6">
													<label for="">Categoría de Contrato</label>
													<select class="form-control text-dark" id="categoria_contrato" name="categoria_contrato">
														<option value="1">Contrato de Trabajo Sujeta Reglas Generales</option>
													</select>
												</div>
											</div>

											<div class="row">
												<!-------------Region-------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Región:</label>
														<select id="regioncelebracion" name="regioncelebracion" onchange="listarcomunas()" required="" class="form-control text-dark regiones">
															<?php
															$lista = $c->listarregiones();
															if (count($lista) > 0) {
																foreach ($lista as $l) {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															} else {
																echo "<option value='0'>No hay Regiones</option>";
															}

															?>
														</select>
													</div>
												</div>
												<!------------------------------------------->
												<!----------------Comuna-------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Comuna:</label>
														<select id="comunacelebracion" name="comunacelebracion" required="" class="form-control text-dark comunas">
															<option value="">Seleccione una Comuna</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Fecha de Suscripcíon del Contrato:</label>
														<input type="date" class="form-control text-dark" id="fechacelebracion" name="fechacelebracion" required="">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Tipo de Documento:</label>
														<button class="btn btn-primary btn-sm fs-10" type="button" data-toggle="modal" data-target="#tipocontratomodal">Seleccionar</button>
														<label class="form-control" id="tipocontratotext"></label>
														<input type="hidden" class="form-control text-dark" id="tipocontratoid" name="tipocontratoid" required="" readonly>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="alert alert-info alert-dismissible fade show" role="alert">
														<span class="alert-inner--icon"><i class="fe fe-info"></i></span>
														<span class="alert-inner--text"><strong>Importante!</strong> Si necesitas actualizar esta información, debes volver a la ficha del trabajador o de la empresa efecturar las correciones correspondientes.</span>
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true"><i class="fe fe-x-circle"></i></span>
														</button>
													</div>
												</div>
												<!------Rut Empleador-------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">RUT Empleador:</label>
														<input type="text" class="form-control text-dark" id="rut_empleador" name="rut_empleador" required="" value="<?php echo $emp->getRut(); ?>" readonly>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Nombre o Razón Social:</label>
														<input type="text" class="form-control text-dark" id="nombre_razon_social" name="nombre_razon_social" required="" value="<?php echo $emp->getRazonSocial(); ?>" readonly>
													</div>
												</div>
												<!--------------------------------------------------->
												<!---------------------Representante Legal Pendiente-------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Representante Legal:</label>
														<select name="representante_legal" id="representante_legal" class="form-control select2">
															<?php
																$codigoactividad = $c->listarRepresentantelegal($emp->getId());
																if (count($codigoactividad) > 0) {
																	foreach ($codigoactividad as $l) {
																		echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . " " . $l->getApellido1() . " " . $l->getApellido2() . "</option>";
																	}
																} else {
																	echo "<option value='0'>No hay Codigo Actividad Economica</option>";
																}
															?>
														</select>
													</div>
												</div>
												<!--------------------------------------------------->
												<!------Correo Electronico--->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Correo Electronico:</label>
														<input type="email" class="form-control text-dark" id="correo_electronico" name="correo_electronico" required="" value="<?php echo $emp->getEmail(); ?>" readonly>
													</div>
												</div>
												<!--------------------------------------------------->
												<!------Telefono-------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Telefono:</label>
														<input type="text" class="form-control text-dark" id="telefono" name="telefono" required="" value="<?php echo $emp->getTelefono(); ?>" readonly>
													</div>
												</div>
												<!--------------------------------------------------->
												<!------Codigo Actividad Economica Pendiente-------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Codigo Actividad Economica:</label>
														<select name="codigoactividadid" id="codigoactividadid" class="form-control select2">
															<?php
																$codigoactividad = $c->ListarCodigoActividadEmpresa1($emp->getId());
																if (count($codigoactividad) > 0) {
																	foreach ($codigoactividad as $l) {
																		echo "<option value='" . $l->getId() . "'>" . $l->getCodigoSii() . " - " . $l->getNombre() . "</option>";
																	}
																} else {
																	echo "<option value='0'>No hay Codigo Actividad Economica</option>";
																}
															?>
														</select>
													</div>
												</div>

												<?php
												$dept = $emp->getDepartamento();
												//Extraer el numero de la direccion
												$numero = $emp->getNumero();
												//Extraer la letra de la direccion con todos los espacios en blanco
												$calle = $emp->getCalle();

												$direccion = $calle . " " . $numero;

												?>
												
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Domicilio:</label>
														<input type="text" class="form-control text-dark" id="domicilio" name="domicilio" required="" readonly value="<?php echo $direccion; ?>">
													</div>
												</div>
												<!--------------------------------------------------->
												<!-------------Region-------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Región:</label>
														<select id="empresaregion" name="empresaregion" required="" class="form-control text-dark" disabled>
															<?php
															$lista = $c->listarregiones();
															if (count($lista) > 0) {
																foreach ($lista as $l) {
																	if ($emp->getRegion() == $l->getId()) {
																		echo "<option selected value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																	}
																}
															} else {
																echo "<option value='0'>No hay Regiones</option>";
															}

															?>
														</select>
													</div>
												</div>
												<input type="hidden" value="<?php echo $emp->getId(); ?>" id="idempresa">
												<!------------------------------------------->
												<!----------------Comuna-------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Comuna:</label>
														<select id="empresacomuna" name="empresacomuna" required="" class="form-control text-dark" disabled>
															<?php
															$lista = $c->listarcomunas($emp->getRegion());
															if (count($lista) > 0) {
																foreach ($lista as $l) {
																	if ($emp->getComuna() == $l->getId()) {
																		echo "<option selected value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																	}
																}
															} else {
																echo "<option value='0'>No hay Comuna</option>";
															}

															?>
														</select>
													</div>
												</div>
												<!------------------------------------------->
												<!------Calle--------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Calle:</label>
														<input type="text" class="form-control text-dark" id="calle" name="calle" value="<?php echo $calle; ?>" required="" readonly>
													</div>
												</div>
												<!--------------------------------------------------->
												<!------Numero--------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Numero:</label>
														<input type="text" class="form-control text-dark" id="numero" name="numero" value="<?php echo $numero; ?>" required="" readonly>
													</div>
												</div>
												<!--------------------------------------------------->
												<!------Departamento--------------------------------->
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Departamento/Oficina (Opcional):</label>
														<input type="text" class="form-control text-dark" id="departamento" name="departamento">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<h3>Lote de Trabajadores</h3>
												</div>
											</div>
											<hr />
											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-12">
													<div class="card transcation-crypto1" id="transcation-crypto1">
														<div class="card-header bd-b-0">
															<h4 class="card-title font-weight-semibold mb-0">Lote de Trabajadores</h4>
														</div>
														<div class="card-body p-4">
															<div class="">
																<div class="table-responsive">
																	<table class="table text-nowrap" id="e2">
																		<thead class="border-top">
																			<tr>
																				<th class="bg-transparent">RUT</th>
																				<th class="bg-transparent">Nombre</th>
																				<th class="bg-transparent">Fecha de Nacimiento</th>
																				<th class="bg-transparent">Sexo</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
																			$lista = $c->buscarlote($_SESSION['USER_ID']);
																			foreach ($lista as $object) {
																				echo "<tr class='border-bottom-0'>";
																				echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
																				echo $object->getRut();
																				echo "</td>";
																				echo "<td class='text-muted fs-15 font-weight-semibold'>";
																				echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2();
																				echo "</td>";
																				echo "<td class='text-muted fs-15 font-weight-semibold'>";
																				echo date("d-m-Y", strtotime($object->getNacimiento()));
																				echo "</td>";
																				echo "<td class='text-muted fs-15 font-weight-semibold'>";
																				if ($object->getSexo() == 1) {
																					echo "Masculino";
																				} else {
																					echo "Femenino";
																				}
																				echo "</td>";
																				echo "</tr>";
																			}
																			?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 d-flex justify-content-between">
													<a href="generarlote.php" class="btn btn-danger btn-sm pl-4 pr-4"><i class="fa fa-arrow-left"> Volver </i></a>
													<button type="button" onclick="mostrar(2)" class="btn btn-primary btn-sm pl-4 pr-4">Siguiente <i class="fa fa-arrow-right"></i></button>

												</div>
											</div>
										</div>

										<!-----------Funciones y Lugares de Prestacion de Servicios------------>
										<div class="funciones mt-4 d-none">
											<h5>Naturaleza de los Servicios</h5>

											<hr />
											<div class="row">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Datos de Contrato</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Centro de Costo:</label>
														<select id="centrocosto" name="centrocosto" required="" class="form-control text-dark regiones">
															<?php
															$lista = $c->listarcentrocosto($empresa);
															if (count($lista) > 0) {
																foreach ($lista as $l) {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															} else {
																echo "<option value='0'>No hay Centro de Costo Disponible</option>";
															}

															?>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Cargo:</label>
														<select id="Charge" name="Charge" required="" class="form-control text-dark" required>
															<option value="Administrador de aplicaciones (TIC - ASUP)">Administrador de aplicaciones (TIC - ASUP)</option>
															<option value="Administrador de base de datos (TIC-DBAD)">Administrador de base de datos (TIC-DBAD)</option>
															<option value="Agente de mes de servicios (TIC-USUP)"></option>
															<option value="Analista de datos (TIC-DTAN)">Analista de datos (TIC-DTAN)</option>
															<option value="Analista desarrollador de aplicaciones de software (TIC-PROG)">Analista desarrollador de aplicaciones de software (TIC-PROG)</option>
															<option value="Coordinador de mes de servicios (TIC-DBDS)">Coordinador de mes de servicios (TIC-DBDS)</option>
															<option value="Diseñador de base de datos (TIC-DBDS)">Diseñador de base de datos (TIC-DBDS)</option>
															<option value="Mantenedor de redes e infraestructura (TIC-NTAS)">Mantenedor de redes e infraestructura (TIC-NTAS)</option>
															<?php
															$lista = $c->listarcargos($empresa);
															if (count($lista) > 0) {
																echo "<option value='0' disabled>OTRO</option>";
																foreach ($lista as $l) {
																	echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
																}
															}

															?>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Descripción del Cargo:</label>
														<input class="form-control" id="ChargeDescripcion" name="ChargeDescripcion" placeholder="Descripcion del Cargo" required>
													</div>
												</div>
											</div>
											<hr />
											<h5>Dirección específica (lugar de trabajo único)</h5>

											<div class="row">
												<div class="col-lg-6">
													<label>Región</label>
													<select id="regionespecifica" name="regionespecifica" onchange="listarcomunasespecifica()" required="" class="form-control text-dark regionespecifica">
														<?php
														$lista = $c->listarregiones();
														if (count($lista) > 0) {
															foreach ($lista as $l) {
																echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
															}
														} else {
															echo "<option value='0'>No hay Regiones</option>";
														}

														?>
													</select>
													</select>
												</div>
												<div class="col-lg-6">
													<label>Comuna</label>
													<select id="comunaespecifica" name="comunaespecifica" required="" class="form-control text-dark comunaespecifica">

													</select>
													</select>
												</div>
												<div class="col-lg-6">
													<label>Calle</label>
													<input class="form-control" id="calleespecifica" name="calleespecifica" placeholder="Calle" required>
													</select>
												</div>

												<div class="col-lg-6">
													<label>Número</label>
													<input class="form-control" id="numeroespecifica" name="numeroespecifica" placeholder="Número" required>
													</select>
												</div>

												<div class="col-lg-6">
													<label>Depto. / Oficina (opcional)</label>
													<input class="form-control" id="departamentoespecifica" name="departamentoespecifica" placeholder="Departamento">
													</select>
												</div>

											</div>
											<hr />
											<h5>Zona geográfica de prestación de los servicios del trabajador</h5>
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label class="custom-switch">
															<input value="0" onclick="todaslaszonas()" type="checkbox" name="territoriozona" id="territoriozona" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">Seleccionar todo el territorio nacional.</span>
														</label>
													</div>
												</div>
												<div class="col-lg-6 zone">
													<label>Región</label>
													<select id="zonaregion" name="zonaregion" required="" class="form-control text-dark zonaregion">
														<?php
														$lista = $c->listarregiones();
														if (count($lista) > 0) {
															foreach ($lista as $l) {
																echo "<option value='" . $l->getId() . "'>" . $l->getNombre() . "</option>";
															}
														} else {
															echo "<option value='0'>No hay Regiones</option>";
														}

														?>
													</select>
													<button type="button" class="btn btn-outline-info" onclick="agregarregion(<?php $trabajador = $_SESSION['USER_ID'];
																																echo $trabajador; ?>)"><i class="fa fa-plus"> Agregar</i></button>
													<button type="button" class="btn btn-outline-info ml-3" onclick="todaslasregiones(<?php $trabajador = $_SESSION['USER_ID'];
																																		echo $trabajador; ?>)"><i class="fa fa-plus"> Todos</i></button>
												</div>
												<div class="col-lg-6 zone">
													<label>Provincia</label>
													<select id="zonaprovincia" name="zonaprovincia" required="" class="form-control text-dark zonaprovincia">

													</select>
													<button type="button" class="btn btn-outline-info" onclick="agregarprovincia(<?php $trabajador = $_SESSION['USER_ID'];
																																	echo $trabajador; ?>)"><i class="fa fa-plus"> Agregar</i></button>
													<button type="button" class="btn btn-outline-info ml-3" onclick="todaslasprovincias(<?php $trabajador = $_SESSION['USER_ID'];
																																		echo $trabajador; ?>)"><i class="fa fa-plus"> Todos</i></button>
												</div>
												<div class="col-lg-6 zone">
													<label>Comuna</label>
													<select id="zonacomuna" name="zonacomuna" required="" class="form-control text-dark zonacomuna">

													</select>
													<button type="button" class="btn btn-outline-info" onclick="agregarcomuna(<?php $trabajador = $_SESSION['USER_ID'];
																																echo $trabajador; ?>)"><i class="fa fa-plus"> Agregar</i></button>
													<button type="button" class="btn btn-outline-info ml-3" onclick="todaslascomunas(<?php $trabajador = $_SESSION['USER_ID'];
																																		echo $trabajador; ?>)"><i class="fa fa-plus"> Todos</i></button>
												</div>
												<div class="col-lg-12 mt-3 zone d-flex justify-content-center align-items-center">
													<div class="row zone">
														<div class="col-md-4">
															<div class="card">
																<div class="card-header">
																	<h3 class="card-title">Regiones</h3>
																</div>
																<div class="card-body">
																	<div class="table-responsive">
																		<table class="table table-hover table-striped">
																			<thead>
																				<tr>
																					<th>Nombre</th>
																					<th>Eliminar</th>
																				</tr>
																			</thead>
																			<tbody id="tablazonaregiones">

																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="card">
																<div class="card-header">
																	<h3 class="card-title">Provincias</h3>
																</div>
																<div class="card-body">
																	<div class="table-responsive">
																		<table class="table table-hover table-striped">
																			<thead>
																				<tr>
																					<th>Nombre</th>
																					<th>Eliminar</th>
																				</tr>
																			</thead>
																			<tbody id="tablazonaprovincias">

																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="card">
																<div class="card-header">
																	<h3 class="card-title">Comunas</h3>
																</div>
																<div class="card-body">
																	<div class="table-responsive">
																		<table class="table table-hover table-striped">
																			<thead>
																				<tr>
																					<th>Nombre</th>
																					<th>Eliminar</th>
																				</tr>
																			</thead>
																			<tbody id="tablazonacomunas">

																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>


											</div>
											<hr />
											<div class="row">
												<!-----Declaracion 3---------------------------------------------->
												<div class="col-lg-12">
													<div class="form-group">
														<label class="custom-switch">
															<input value="0" onclick="subcontratacion()" type="checkbox" name="subcontratacionval" id="subcontratacionval" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">Trabajador Presta Servicios en Régimen de subcontratación.</span>
														</label>
													</div>
												</div>
												<div class="col-lg-6 subcontratacion d-none">
													<div class="form-group select2-lg ">
														<label for="">RUT :</label>
														<input class="form-control" id="subcontratacionrut" name="subcontratacionrut" placeholder="RUT">
													</div>
												</div>
												<div class="col-lg-6 subcontratacion d-none">
													<div class="form-group select2-lg">
														<label for="">Razón Social:</label>
														<input class="form-control" id="subcontratacionrazonsocial" name="subcontratacionrazonsocial" placeholder="Razón Social">
													</div>
												</div>

											</div>

											<hr />
											<div class="row">
												<!-----Declaracion 4---------------------------------------------->
												<div class="col-lg-12 ">
													<label class="custom-switch">
														<input value="0" onclick="transitorios()" type="checkbox" id="transitoriosval" name="transitoriosval" class="custom-switch-input">
														<span class="custom-switch-indicator"></span>
														<span class="custom-switch-description">Trabajador Presta servicios para empresa usuario de servicios transitorios (EST).</span>
													</label>
												</div>
												<div class="col-lg-6 transitorios d-none">
													<div class="form-group select2-lg">
														<label for="">RUT :</label>
														<input class="form-control" id="transitoriosrut" name="transitoriosrut" placeholder="RUT">
													</div>
												</div>
												<div class="col-lg-6 transitorios d-none">
													<div class="form-group select2-lg">
														<label for="">Razón Social:</label>
														<input class="form-control" id="transitoriosrazonsocial" name="transitoriosrazonsocial" placeholder="Razón Social">
													</div>
												</div>
											</div>



											<div class="row">
												<div class="col-md-12 d-flex justify-content-between">
													<a href="#" type="button" onclick="mostrar(1)" class="btn btn-danger btn-sm pl-4 pr-4"><i class="fa fa-arrow-left"> Volver </i></a>
													<button type="button" onclick="mostrar(3)" class="btn btn-primary btn-sm pl-4 pr-4">Siguiente <i class="fa fa-arrow-right"></i></button>

												</div>
											</div>
										</div>

										<!--------------Remuneraciones---------------------->
										<div class="Remuneraciones mt-4 d-none">
											<div class="row">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Remuneraciones</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Sueldo Base:</label>
														<select id="tiposueldo" name="tiposueldo" required="" class="form-control">
															<option value="1">Por Hora</option>
															<option value="2" selected>Mensual</option>
															<option value="3">Semanal</option>
															<option value="4">Diario</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Sueldo:</label>
														<input class="form-control" id="sueldo" name="sueldo" placeholder="Sueldo" required>
													</div>
												</div>
												<div class="col-lg-6 d-none">
													<div class="form-group select2-lg">
														<label for="">Asignación Zona Extrema:</label>
														<input type="text" class="form-control" id="asignacion" name="asignacion" placeholder="Asignación Zona Extrema" required>
													</div>
												</div>

											</div>
											<!---------Haberes Imponibles------------>
											<h6 class="main-content-label mb-1 d-none">Haberes Imponibles</h6>
											<hr />
											<div class="row d-none">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Haberes Imponibles Tributables</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Haber:</label>
														<select id="tipohaber" name="tipohaber" class="form-control">
															<option value="0">Seleccione</option>
															<option value="1">Sobresueldo</option>
															<option value="2">Comisiones (mensual)</option>
															<option value="3">Semana corrida mensual (Art. 45)</option>
															<option value="4">Participacion (mensual)</option>
															<option value="5">Gratificacion (mensual)</option>
															<option value="6">Recargo 30% día domingo (Art. 38)</option>
															<option value="7">Remuneración variable pagada en clausura (Art. 38 DFL 2)</option>
															<option value="8">Aguinaldo</option>
															<option value="9">Bonos u otras</option>
															<option value="10">Remuneraciones fijas mensuales</option>
															<option value="11">Tratos (mensual)</option>
															<option value="12">Bonos u otras</option>
															<option value="13">Remuneraciones variables Mensuales o superiores a un mes</option>
															<option value="14">Ejervicios opción no pactada en contrato (Art. 17 N°8 LIR)</option>
															<option value="16">Beneficios en especie constitutivos de remuneración</option>
															<option value="17">Remuneraciones bimestrales (devengo en dos meses)</option>
															<option value="18">Remuneraciones trimestrales (devengo en tres meses)</option>
															<option value="19">Remuneraciones cuatrimestrales (devengo en cuatro meses)</option>
															<option value="20">Remuneraciones semestrales (devengo en seis meses)</option>
															<option value="21">Remuneraciones anuales (devengo en doce meses)</option>
															<option value="22">Participación anual (devengo en doce meses)</option>
															<option value="23">Otra remuneraciones superiores a un mes</option>
															<option value="24">Pago por horas de trabajo sidical</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Monto ($)</label>
														<input class="form-control" id="montohaber" name="montohaber" placeholder="Monto">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Periodo de Pago:</label>
														<select id="periodohaber" name="periodohaber" class="form-control">
															<option value="1">Hora</option>
															<option value="2">Diario</option>
															<option value="3">Semanal</option>
															<option value="4">Quicenal</option>
															<option value="5">Mensual</option>
															<option value="6">Bimestral</option>
															<option value="7">Trimestral</option>
															<option value="8">Cuatrimestral</option>
															<option value="9">Semestral</option>
															<option value="10">Anual</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Detalle de remuneraciones</label>
														<input class="form-control" id="detallerenumeracion" name="detallerenumeracion" placeholder="">
													</div>
												</div>

											</div>

											<div class="row d-none">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Haberes Imponibles No Tributables</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Haber:</label>
														<select id="tipohabernotributable" name="tipohabernotributable" class="form-control">
															<option value="0">Seleccione</option>
															<option value="1">Subsidio por incapacidad laboral por licencia médica - total mensual</option>
															<option value="2">Beca de estudio (Art. 17 N°18 LIR)</option>
															<option value="3">Gratificaciones de zona (Art. 17 N°29 LIR)</option>
															<option value="4">Otros ingresos no constitutivos de renta (Art. 17 N°29 LIR)</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Monto ($)</label>
														<input class="form-control" name="montohabernotributable" id="montohabernotributable" placeholder="Monto">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Periodo de Pago:</label>
														<select id="periodohabernotributable" name="periodohabernotributable" class="form-control">
															<option value="1">Hora</option>
															<option value="2">Diario</option>
															<option value="3">Semanal</option>
															<option value="4">Quicenal</option>
															<option value="5">Mensual</option>
															<option value="6">Bimestral</option>
															<option value="7">Trimestral</option>
															<option value="8">Cuatrimestral</option>
															<option value="9">Semestral</option>
															<option value="10">Anual</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Detalle de remuneraciones</label>
														<input class="form-control" id="detallerenumeracionnotributable" name="detallerenumeracionnotributable" placeholder="">
													</div>
												</div>

											</div>
											<!------------------------------------------>

											<!---------Haberes No Imponibles------------>
											<h6 class="main-content-label mb-1 d-none">Haberes No Imponibles</h6>
											<hr />
											<div class="row d-none">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Haberes No Imponibles Tributables</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Haber:</label>
														<select id="tipohaberno" name="tipohaberno" class="form-control">
															<option value="0">Seleccione</option>
															<option value="1">Indemnizaciones voluntarias tributables</option>
															<option value="2">Indemnizaciones contractuales tributables</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Monto ($)</label>
														<input class="form-control" id="montohaberno" name="montohaberno" placeholder="Sueldo">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Periodo de Pago:</label>
														<select id="tiposueldo" id="periodohaberno" name="periodohaberno" class="form-control">
															<option value="1">Hora</option>
															<option value="2">Diario</option>
															<option value="3">Semanal</option>
															<option value="4">Quicenal</option>
															<option value="5">Mensual</option>
															<option value="6">Bimestral</option>
															<option value="7">Trimestral</option>
															<option value="8">Cuatrimestral</option>
															<option value="9">Semestral</option>
															<option value="10">Anual</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Detalle de remuneraciones</label>
														<input class="form-control" id="detallerenumeracionno" name="detallerenumeracionno" placeholder="">
													</div>
												</div>

											</div>

											<div class="row d-none">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Haberes No Imponibles No Tributables</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Haber:</label>
														<select id="tipohabernonotributable" name="tipohabernonotributable" class="form-control">
															<option value="0">Seleccione</option>
															<option value="1">Colación total mensual (Art. 41)</option>
															<option value="2">Movilización total mensual (Art. 41)</option>
															<option value="3">Viáticos total mensual (Art. 41)</option>
															<option value="4">Asignación de pérdida de caja total mensual (Art. 41)</option>
															<option value="5">Asignación de desgaste herramienta total mensual (Art. 41)</option>
															<option value="6">Asignación familiar legal total mensual (Art. 41)</option>
															<option value="7">Gastos por causa del trabajo (Art. 41)</option>
															<option value="8">gastos por cambio de residencia (Art. 53)</option>
															<option value="9">Sala cuna (Art. 203)</option>
															<option value="10">Asignación trabajo a distancia o teletrabajo</option>
															<option value="11">Depósito convenido hasta UF 900</option>
															<option value="12">Alojamiento por razones de trabajo (Art. 17 N°14 LIR)</option>
															<option value="13">Asignación de traslación (Art. 17 N°14 LIR)</option>
															<option value="14">Indemnización por feriado legal</option>
															<option value="15">Indemnización años de servicio</option>
															<option value="16">Indemnización sustitutiva del aviso previo</option>
															<option value="17">Indemnización fuero maternal (Art. 163 bis)</option>
															<option value="18">Indemnización a todo evento (Art. 164)</option>

														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Monto ($)</label>
														<input class="form-control" id="montohabernonotributable" name="montohabernonotributable" placeholder="Sueldo">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Periodo de Pago:</label>
														<select id="tiposueldo" id="periodohabernonotributable" name="periodohabernonotributable" class="form-control">
															<option value="1">Hora</option>
															<option value="2">Diario</option>
															<option value="3">Semanal</option>
															<option value="4">Quicenal</option>
															<option value="5">Mensual</option>
															<option value="6">Bimestral</option>
															<option value="7">Trimestral</option>
															<option value="8">Cuatrimestral</option>
															<option value="9">Semestral</option>
															<option value="10">Anual</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group select2-lg">
														<label for="">Detalle de remuneraciones</label>
														<input class="form-control" id="detallerenumeracionnonotributable" name="detallerenumeracionnonotributable" placeholder="">
													</div>
												</div>

											</div>
											<!------------------------------------------>
											<!--------------GRATIFICACIONES------------>
											<div class="row">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Gratificación</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Forma de pago:</label>
														<select id="formapago" onchange="detigra()" name="formapago" required="" class="form-control">
															<option value="1">No pactado en contrato de trabajo</option>
															<option value="2">Artículo 47 del Código del Trabajo</option>
															<option value="3">Modalidad convencional superior al mínimo legal</option>
															<option value="4">Artíuculo 50 del Código del Trabajo</option>
															<option value="5">Sin obligación legal de pago</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="alert alert-success" role="alert">
														<strong id="detitext">¡Las partes no pactan un sistema de pago de gratificación. Tener presente que en caso de ser de aquellas empresas señaladas en el artículo 47 del Código del Trabajo y obtener utilidades líquidas en su giro, tendrá la obligación de pagar esa.!</strong>
													</div>
												</div>
												<div class="col-lg-6  d-none periogat">
													<div class="form-group select2-lg ">
														<label for="">Periodo de Pago:</label>
														<select id="periodopagogra" name="periodopagogra" required="" class="form-control">
															<option value="1">Mensual</option>
															<option value="2">Bimestral</option>
															<option value="3">Trimestral</option>
															<option value="4">Cuatrimestral</option>
															<option value="5">Semestral</option>
															<option value="6">Anual</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3 d-none gratificacion detdrati">
													<div class="form-group select2-lg">
														<label for="">Detalle de remuneraciones</label>
														<input class="form-control" id="detallerenumeraciongra" name="detallerenumeraciongra" placeholder="" required>
													</div>
												</div>

											</div>
											<!------------------------------------------>
											<hr />
											<div class="row">
												<div class="col-md-12">
													<h6 class="main-content-label mb-1">Periodo Y Forma de Pago</h6>
													<p class="text-mutted card-sub-title"></p>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Periodo de pago:</label>
														<select id="periodopagot" name="periodopagot" required="" class="form-control">
															<option value="1">Semanal</option>
															<option value="2">Mensual</option>
															<option value="3">Quicenal</option>
															<option value="4">Diario</option>
															<option value="5">Por Hora</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Fecha de pago:</label>
														<select id="fechapagot" name="fechapagot" required="" class="form-control">
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
															<option value="13">13</option>
															<option value="14">14</option>
															<option value="15">15</option>
															<option value="16">16</option>
															<option value="17">17</option>
															<option value="18">18</option>
															<option value="19">19</option>
															<option value="20">20</option>
															<option value="21">21</option>
															<option value="22">22</option>
															<option value="23">23</option>
															<option value="24">24</option>
															<option value="25">25</option>
															<option value="26">26</option>
															<option value="27">27</option>
															<option value="28">28</option>
															<option value="29">29</option>
															<option value="30">30</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Forma de pago:</label>
														<select id="formapagot" onchange="formadepago()" name="formapagot" required="" class="form-control">
															<option value="1">Dinero en Efectivo</option>
															<option value="2">Cheque</option>
															<option value="3">Vale Vista</option>
															<option value="4">Deposito Bancario</option>
															<option value="5">Transferencia Bancaria</option>
														</select>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Anticipo:</label>
														<select id="anticipot" name="anticipot" required="" class="form-control">
															<option value="1">Sin Anticipo</option>
															<option value="2">Semanal</option>
															<option value="3">Quincenal</option>
														</select>
													</div>
												</div>
											</div>
											<hr />
											<div class="row">
												<!-----Declaracion 3---------------------------------------------->
												<div class="col-lg-12">
													<div class="form-group">
														<label class="custom-switch">
															<input value="0" onclick="checkpacto()" type="checkbox" id="badi" name="badi" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">Otros pactos de remuneraciones y beneficios adicionales.</span>
														</label>
													</div>
												</div>
												<div class="col-lg-6 d-none pacto">
													<div class="form-group select2-lg">
														<input class="form-control otrter" id="otrter" name="otrter" placeholder="Redacte los terminos">
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-md-12 d-flex justify-content-between">
													<a type="button" href="#" onclick="mostrar(2)" class="btn btn-danger btn-sm pl-4 pr-4"><i class="fa fa-arrow-left"> Volver </i></a>
													<button type="button" onclick="mostrar(4)" class="btn btn-primary btn-sm pl-4 pr-4">Siguiente <i class="fa fa-arrow-right"></i></button>

												</div>
											</div>
										</div>

										<!--------------Jornadas---------------------->
										<div class="jornada mt-4 d-none">
											<div class="row">
												<div class="colg-l-12">
													<div class="form-group">
														<label class="custom-switch">
															<input value="0" onclick="checkexcepcional()" type="checkbox" name="jornadaesc" id="jornadaesc" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">La Empresa posee un sistema de jornada excepcional autorizado por la dirección de trabajo donde se estipulan los dias de Trabajo donde se estipulan los días de trabajo y descanso para la respectiva faena.</span>
														</label>
													</div>
												</div>
												<div class="col-lg-6 excepcional d-none">
													<div class="form-group select2-lg">
														<label for="">N° de Resolución:</label>
														<input type="text" class="form-control noresolucion" name="noresolucion" id="noresolucion">
													</div>
												</div>
												<div class="col-lg-6 excepcional d-none">
													<div class="form-group select2-lg">
														<label for="">Fecha:</label>
														<input type="date" class="form-control desde" id="exfech" name="exfech">
													</div>
												</div>

												<div class="col-lg-12">
													<div class="form-group">
														<label class="custom-switch">
															<input value="0" onclick="checkexcluido()" type="checkbox" name="exluido" id="exluido" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">El trabajador se encuentra excluido de la limitación de jornada de trabajo conforme al Artículo 22 Inciso 2° del Código del Trabajo.</span>
														</label>
													</div>
												</div>
											</div>
											<div class="row excluido">
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Tipo de Jornada:</label>
														<select id="tipojornada" onchange="tipochange()" name="tipojornada" required="" class="form-control text-dark excluidoselect">
															<option value="1">Jornada Semanal ordinaria</option>
															<option value="2">Jornada Semana Extendida</option>
															<option value="3">Joranda Bisemanal</option>
															<option value="4">Jornada Mensual</option>
															<option value="5">Jornada diaria</option>
														</select>
													</div>
												</div>

												<div class="col-lg-12 joption1">
													<div class="form-group">
														<label class="custom-switch">
															<input value="1" type="checkbox" onclick="incluyedomingo()" id="incluye" name="incluye" class="custom-switch-input">
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">La Jornada de trabajo incluye días domingos y festivos conforme al Artículo 38 del Código del Trabajo.</span>
														</label>
													</div>
												</div>
												<!------------------------------------->
												<div class="col-lg-6  d-none joption2">
													<div class="form-group select2-lg">
														<label for="">Duración de Jornada (Horas):</label>
														<input class="form-control" id="dias" name="dias" placeholder="" required>
													</div>
												</div>
												<div class="col-lg-6 joption3">
													<div class="form-group select2-lg">
														<label for="">Duración de Jornada mensual(horas):</label>
														<select id="duracionjor" class="form-control" name="duracionjor">
															<option value="1">45 Horas</option>
															<option value="2">44 Horas</option>
															<option value="3">43 Horas</option>
															<option value="4">42 Horas</option>
															<option value="5">41 Horas</option>
															<option value="6">40 Horas</option>
															<option value="7">39 Horas</option>
															<option value="8">38 Horas</option>
															<option value="9">37 Horas</option>
															<option value="10">36 Horas</option>
															<option value="11">35 Horas</option>
															<option value="12">34 Horas</option>
															<option value="13">33 Horas</option>
															<option value="14">32 Horas</option>
															<option value="15">31 Horas</option>
															<option value="16">30 Horas</option>
															<option value="17">29 Horas</option>
															<option value="18">28 Horas</option>
															<option value="19">27 Horas</option>
															<option value="20">26 Horas</option>
															<option value="21">25 Horas</option>
															<option value="22">24 Horas</option>
															<option value="23">23 Horas</option>
															<option value="24">22 Horas</option>
															<option value="25">21 Horas</option>
															<option value="26">20 Horas</option>
															<option value="27">19 Horas</option>
															<option value="28">18 Horas</option>
															<option value="29">17 Horas</option>
															<option value="30">16 Horas</option>
															<option value="31">15 Horas</option>
															<option value="32">14 Horas</option>
															<option value="33">13 Horas</option>
															<option value="34">12 Horas</option>
															<option value="35">11 Horas</option>
															<option value="36">10 Horas</option>
															<option value="37">9 Horas</option>
															<option value="38">8 Horas</option>
															<option value="39">7 Horas</option>
															<option value="40">6 Horas</option>
															<option value="41">5 Horas</option>
															<option value="42">5 Horas</option>
															<option value="43">3 Horas</option>
															<option value="44">2 Horas</option>
															<option value="45">1 Hora</option>
															<option value="46">30 Minutos</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6 d-none joption4">
													<div class="form-group select2-lg">
														<label for="">Numero de días de la distribución de la Jornada:</label>
														<input class="form-control" id="diasf" name="diasf" placeholder="" required>
													</div>
												</div>
												<div class="col-lg-6 excluido">
													<div class="form-group select2-lg">
														<label for="">Horarios y Turnos:</label>
														<select onchange="checkturno()" id="horarioturno" name="horarioturno" required="" class="form-control text-dark">
															<option value="1">Horario fijo sin turnos</option>
															<option value="2">Turnos de trabajo especificados en el reglamento interno de orden, higiene y seguridad</option>
															<option value="3">Turno rotativo mañana y tarde</option>
															<option value="4">Turno rotativo tarde y noche</option>
															<option value="5">Turno rotativo mañana y noche</option>
															<option value="6">Turno rotativo mañana, tarde y noche</option>
														</select>
													</div>
												</div>
												<!------------------------------------->
											</div>
											<div class="row excluido ">
												<div class="col-lg-6 cola">
													<div class="form-group select2-lg">
														<label for="">Tiempo de Colación (minutos):</label>
														<input class="form-control" id="colacion" name="colacion" placeholder="" required>
													</div>
												</div>
												<div class="col-lg-6 rotativo d-none">
													<div class="form-group select2-lg">
														<label for="">Rotación:</label>
														<select class="form-control" id="rotativo">
															<option value="1">Diaria</option>
															<option value="2">Semanal</option>
															<option value="3">Quincenal</option>
															<option value="4">Mensual</option>
															<option value="5">Trimestral</option>
															<option value="6">Semestral</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6 cola">
													<div class="form-group select2-lg">
														<label for="">Tiempo de Colación imputable a la joranda de trabajo (minutos):</label>
														<input class="form-control" id="colaimpu" name="colanoipu" placeholder="" required>
													</div>
												</div>
												<div class="col-lg-6 cola">
													<div class="form-group select2-lg">
														<label for="">Tiempo de Colación no imputable a la joranda de trabajo (minutos):</label>
														<input class="form-control" id="colacionimp" name="colacionimp" placeholder="" required>
													</div>
												</div>
											</div>
											<div class="row excluido ">
												<div class="col-lg-12">
													<div class="alert alert-info">
														<ul style="list-style:none;">
															<li>a. La distribución de la joranda <strong>No puede superar 45 horas semanales</strong></li>
															<li>b. Si la Hora de término es menor a la hora de inicio, se considera como hora del día siguiente</li>
															<li>c. Si Marca "Todos" y se despliega una jornada superior a la maxima legal, debe ajustarla a los topes legales respectivos.</li>
														</ul>
													</div>
												</div>
												<!----------Distribucion General------------->
												<div class="col-lg-12 general excluido">
													<table class="table table-bordered">
														<thead>
															<tr>
																<td colspan="9" class="text-center">Distribución de Jornada Laboral</td>
															</tr>
															<tr>
																<td></td>
																<td class="text-center">Todos</td>
																<td class="text-center">Lunes</td>
																<td class="text-center">Martes</td>
																<td class="text-center">Miercoles</td>
																<td class="text-center">Jueves</td>
																<td class="text-center">Viernes</td>
																<td class="text-center">Sábado</td>
																<td class="text-center">Domingo</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Distribución</td>
																<td class="text-center"><input type="checkbox" id="todo" onclick="todoonclick()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias11" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias12" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias13" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias14" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias15" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias16" onclick="checktodo1()"></td>
																<td class="text-center"><input type="checkbox" class="dias1" id="dias17" onclick="checktodo1()" disabled></td>
															</tr>
															<tr>
																<td>Hora de Inicio</td>
																<td class="text-center"><input type="time" onchange="changetimeinit1()" min="08:00" step="1" value="08:00" class="hora1" id="hora10"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora11"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora12"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora13"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora14"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora15"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora16"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora1" id="hora17"></td>
															</tr>
															<tr>
																<td>Hora de Término</td>
																<td class="text-center"><input type="time" onchange="changetimeend1()" min="08:00" step="1" value="08:00" class="horat1" id="horat10"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat11"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat12"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat13"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat14"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat15"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat16"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat1" id="horat17"></td>
															</tr>
															<tr>
																<td colspan="9">Nota: Sr. Empleador, si usted marca "Todos" y se despliga una jornada superior a la maxima legar es su deber ajustarla a los topes legales respectivos.</td>
															</tr>

														</tbody>
													</table>

												</div>
												<!----------Distribucion Turno Matutino------------->
												<div class="col-lg-12 d-none matutino excluido">
													<table class="table table-bordered ">
														<thead>
															<tr>
																<td colspan="9" class="text-center">Distribución Turno Matutino</td>
															</tr>
															<tr>
																<td></td>
																<td class="text-center">Todos</td>
																<td class="text-center">Lunes</td>
																<td class="text-center">Martes</td>
																<td class="text-center">Miercoles</td>
																<td class="text-center">Jueves</td>
																<td class="text-center">Viernes</td>
																<td class="text-center">Sábado</td>
																<td class="text-center">Domingo</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Distribución</td>
																<td class="text-center"><input type="checkbox" id="todo1" onclick="todo1onclick()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias21" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias22" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias23" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias24" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias25" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias26" onclick="checktodo2()"></td>
																<td class="text-center"><input type="checkbox" class="dias2" id="dias27" disabled onclick="checktodo2()"></td>
															</tr>
															<tr>
																<td>Hora de Inicio</td>
																<td class="text-center"><input onchange="changetimeinit2()" type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora20"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora21"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora22"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora23"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora24"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora25"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora26"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora2" id="hora27"></td>
															</tr>
															<tr>
																<td>Hora de Término</td>
																<td class="text-center"><input onchange="changetimeend2()" type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat20"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat21"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat22"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat23"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat24"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat25"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat26"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat2" id="horat27"></td>
															</tr>
															<tr>
																<td colspan="9">Nota: Sr. Empleador, si usted marca "Todos" y se despliga una jornada superior a la maxima legar es su deber ajustarla a los topes legales respectivos.</td>
															</tr>

														</tbody>
													</table>

												</div>
												<!----------Distribucion Turno Tarde------------->
												<div class="col-lg-12  d-none tarde excluido">
													<table class="table table-bordered">
														<thead>
															<tr>
																<td colspan="9" class="text-center">Distribución Turno Tarde</td>
															</tr>
															<tr>
																<td></td>
																<td class="text-center">Todos</td>
																<td class="text-center">Lunes</td>
																<td class="text-center">Martes</td>
																<td class="text-center">Miercoles</td>
																<td class="text-center">Jueves</td>
																<td class="text-center">Viernes</td>
																<td class="text-center">Sábado</td>
																<td class="text-center">Domingo</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Distribución</td>
																<td class="text-center"><input type="checkbox" id="todo2" onclick="todo2onclick()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias31" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias32" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias33" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias34" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias35" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias36" onclick="checktodo3()"></td>
																<td class="text-center"><input type="checkbox" class="dias3" id="dias37" onclick="checktodo3()" disabled></td>
															</tr>
															<tr>
																<td>Hora de Inicio</td>
																<td class="text-center"><input onchange="changetimeinit3()" type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora30"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora31"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora32"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora33"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora34"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora35"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora36"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora3" id="hora37"></td>
															</tr>
															<tr>
																<td>Hora de Término</td>
																<td class="text-center"><input onchange="changetimeend3()" type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat30"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat31"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat32"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat33"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat34"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat35"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat36"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat3" id="horat37"></td>
															</tr>
															<tr>
																<td colspan="9">Nota: Sr. Empleador, si usted marca "Todos" y se despliga una jornada superior a la maxima legar es su deber ajustarla a los topes legales respectivos.</td>
															</tr>

														</tbody>
													</table>

												</div>
												<!----------Distribucion Turno Noche------------->
												<div class="col-lg-12  d-none noche excluido">
													<table class="table table-bordered">
														<thead>
															<tr>
																<td colspan="9" class="text-center">Distribución Turno Noche</td>
															</tr>
															<tr>
																<td></td>
																<td class="text-center">Todos</td>
																<td class="text-center">Lunes</td>
																<td class="text-center">Martes</td>
																<td class="text-center">Miercoles</td>
																<td class="text-center">Jueves</td>
																<td class="text-center">Viernes</td>
																<td class="text-center">Sábado</td>
																<td class="text-center">Domingo</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Distribución</td>
																<td class="text-center"><input type="checkbox" id="todo3" onclick="todo3onclick()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias41" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias42" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias43" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias44" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias45" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias46" onclick="checktodo4()"></td>
																<td class="text-center"><input type="checkbox" class="dias4" id="dias47" onclick="checktodo4()" disabled></td>
															</tr>
															<tr>
																<td>Hora de Inicio</td>
																<td class="text-center"><input onchange="changetimeinit4()" type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora40"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora41"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora42"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora43"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora44"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora45"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora46"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="hora4" id="hora47"></td>
															</tr>
															<tr>
																<td>Hora de Término</td>
																<td class="text-center"><input onchange="changetimeend4()" type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat40"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat41"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat42"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat43"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat44"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat45"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat46"></td>
																<td class="text-center"><input type="time" min="08:00" step="1" value="08:00" class="horat4" id="horat47"></td>
															</tr>
															<tr>
																<td colspan="9">Nota: Sr. Empleador, si usted marca "Todos" y se despliga una jornada superior a la maxima legar es su deber ajustarla a los topes legales respectivos.</td>
															</tr>

														</tbody>
													</table>

												</div>
											</div>
											<!----------------------------------------------------->
											<div class="row">
												<div class="col-lg-12">
													<h4 class="main-content-label mb-1">Lugar, Fecha y Plazo del Contrato</h4>
												</div>
												<div class="col-lg-12">
													<div class="alert alert-info">
														<i class="fa fa-info-circle"></i> Contrato a plazo fijo, duración máxima un año. Gerentes, profesiones o técnico, duración máxima 2 años.
													</div>
												</div>
												<div class="col-lg-12">
													<div class="row">
														<!------Tipos de Contrato------->
														<div class="col-lg-12">
															<label>Tipo Contrato</label>
														</div>
														<div class="col-lg-3">
															<input onclick="contratotipo(this)" type="radio" id="tipo_contrato1" name="tipo_contrato" value="1" checked> Indefinido
														</div>
														<div class="col-lg-3">
															<input onclick="contratotipo(this)" type="radio" id="tipo_contrato2" name="tipo_contrato" value="2"> Plazo Fijo
														</div>
														<div class="col-lg-3">
															<input onclick="contratotipo(this)" type="radio" id="tipo_contrato3" name="tipo_contrato" value="3"> Obra o Faena
														</div>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg">
														<label for="">Fecha de inicio relación laboral:</label>
														<input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group select2-lg terminor  d-none">
														<label for="">Fecha de Termino relación laboral:</label>
														<input type="date" id="fecha_termino" name="fecha_termino" class="form-control terminorinput">
													</div>
												</div>
											</div>
											<!----------------------------------------------------->
											<div class="row d-none">
												<div class="col-lg-12">
													<h4 class="main-content-label mb-1">Otras Estipulaciones Adicionales</h4>
												</div>
												<div class="col-lg-12">
													<h6 class="main-content-label mb-1">Indique si el contrato contiene alguna de las siguientes estipulaciones adicionales:</h6>
												</div>

												<div class="col-lg-12">
													<input value="Indemnizaciones contractuales" type="checkbox" id="estipulacion1" name="estipulacion1"> <span class="text-muted">Indemnizaciones contractuales </span><br />
													<input value="Feriado contractual" type="checkbox" id="estipulacion2" name="estipulacion2"> <span class="text-muted">Feriado contractual </span><br />
													<input value="Prohibición de negociaciones dentro del giro del negocio" type="checkbox" id="estipulacion3" name="estipulacion3"> <span class="text-muted">Prohibición de negociaciones dentro del giro del negocio </span><br />
													<input value="Propiedad intelectual e inductrial" type="checkbox" id="estipulacion4" name="estipulacion4"> <span class="text-muted">Propiedad intelectual e inductrial </span><br />
													<input value="Beneficios en pago de licencias médicas" type="checkbox" id="estipulacion5" name="estipulacion5"> <span class="text-muted">Beneficios en pago de licencias médicas </span><br />
													<input value="Sala Cuna " type="checkbox" id="estipulacion6" name="estipulacion6"> <span class="text-muted">Sala Cuna </span><br />
													<input value="Permisos Contactuales" type="checkbox" id="estipulacion7" name="estipulacion7"> <span class="text-muted">Permisos Contactuales </span><br />
													<input value="Pacto sobre condiciones especiales de trabajo" type="checkbox" id="estipulacion8" name="estipulacion8"> <span class="text-muted">Pacto sobre condiciones especiales de trabajo </span><br />
													<input value="Seguros" type="checkbox" id="estipulacion9" name="estipulacion9"> <span class="text-muted">Seguros </span><br />
													<input value="Stock Options" type="checkbox" id="estipulacion10" name="estipulacion10"> <span class="text-muted">Stock Options </span><br />
													<input value="Instrumento Colectivo" type="checkbox" id="estipulacion11" name="estipulacion11"> <span class="text-muted">Instrumento Colectivo</span><br />
													<input value="12" onclick="checkotraestipulacion()" type="checkbox" id="estipulacion12" onclick="" name="estipulacion12"> <span class="text-muted">Otro</span><br />
												</div>

												<div class="col-lg-12 otraestipulacion d-none">
													<input type="text" id="estipulacion13" name="estipulacion13" class="form-control" placeholder="Ingrese la Estipulación">
												</div>



											</div>
											<hr />
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label class="custom-switch">
															<input type="checkbox" value="1" checked id="juramento" name="juramento" class="custom-switch-input" required>
															<span class="custom-switch-indicator"></span>
															<span class="custom-switch-description">En virtud de lo dispuesto en el articulo 210 del Código Penal, declaro bajo juramento que la información incorporada el presente registro es veraz.</span>
														</label>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12 d-flex justify-content-between">
													<a href="#" onclick="mostrar(3)" class="btn btn-danger btn-sm pl-4 pr-4"><i class="fa fa-arrow-left"> Volver </i></a>
													<button type="button" class="btn btn-primary btn-sm pl-4 pr-4" onclick="finalizar()">Finalizar <i class="fa fa-arrow-right"></i></button>

												</div>
											</div>
										</div>


									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- ROW-4 END -->


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


	</div>
	<!-- End Page -->


	<!-- Modal TipoContrato-->
	<div class="modal fade" id="tipocontratomodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Seleccionar Tipo de Contrato</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 pt-1">
							<div class="p-4">
								<div class="table-responsive">
									<table class="table text-wrap w-100" id="example1">
										<thead class="border-top">
											<tr>
												<th class="bg-transparent">Codigo DT</th>
												<th class="bg-transparent">Codigo (Previred)</th>
												<th class="bg-transparent">Nombre</th>
												<th class="bg-transparent">Seleccionar</th>
												<th class="bg-transparent">Vista Previa</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$lista = $c->listartipodocumento1($_SESSION['CURRENT_ENTERPRISE']);
											if (count($lista) > 0) {
												foreach ($lista as $codigo) {
													echo "<tr>";
													echo "<td>" . $codigo->getCodigo() . "</td>";
													echo "<td>" . $codigo->getCodigoprevired() . "</td>";
													echo "<td>" . $codigo->getNombre() . "</td>";
													echo "<td><a href='#' type='button' data-dismiss='modal' class='btn btn-outline-success btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Seleccionar' onclick='seleccionartipodocumento(" . $codigo->getId() . "," . $codigo->getCodigo() . ",\"" . $codigo->getNombre() . "\")'><i class='fa fa-check'></i> </a></td>";
													echo "<td><a href='#' type='button' class='btn btn-outline-success btn-sm rounded-11 mr-2' data-toggle='modal'  data-target='#previadocument' onclick='previadocument(" . $codigo->getId() . ")'><i class='fa fa-eye'></i> </a></td>";
													echo "</tr>";
												}
											} else {
												echo "<tr>";
												echo "<td colspan='3' class='text-center'>No hay Tipo de Documento Registrado</td>";
												echo "</tr>";
											}
											?>
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


	<!-- Modal TipoContrato-->
	<div class="modal fade" id="previadocument" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Vista Previa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 previadocument">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal Codigo Actividad-->
	<div class="modal fade" id="codigoactividadmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Agregar Codigo de Actividad</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 pt-1">
							<div class="p-4">
								<div class="table-responsive">
									<table class="table text-nowrap" id="example1">
										<thead class="border-top">
											<tr>
												<th class="bg-transparent">Codigo SII</th>
												<th class="bg-transparent">Actividad</th>
												<th class="bg-transparent">Seleccionar</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$lista = $c->ListarCodigoActividadEmpresa1($empresa);
											if (count($lista) > 0) {
												foreach ($lista as $codigo) {
													echo "<tr>";
													echo "<td>" . $codigo->getCodigoSii() . "</td>";
													echo "<td>" . $codigo->getNombre() . "</td>";
													echo "<td><a href='#' type='button' data-dismiss='modal' class='btn btn-outline-success btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Seleccionar' onclick='SeleccionarCodigosii(" . $codigo->getId() . "," . $codigo->getCodigoSii() . ")'><i class='fa fa-check'></i> </a></td>";
													echo "</tr>";
												}
											} else {
												echo "<tr>";
												echo "<td colspan='3' class='text-center'>No hay códigos de actividad</td>";
												echo "</tr>";
											}
											?>
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

	<!-- Modal Representante Legal-->
	<div class="modal fade" id="representantelegalmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Agregar Representante Legal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 pt-1">
							<div class="p-4">
								<div class="table-responsive">
									<table class="table text-nowrap" id="example1">
										<thead class="border-top">
											<tr>
												<th class="bg-transparent">RUT</th>
												<th class="bg-transparent">Nombre</th>
												<th class="bg-transparent">Apellidos</th>
												<th class="bg-transparent">Seleccionar</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$lista = $c->listarRepresentantelegal($empresa);
											if (count($lista) > 0) {
												foreach ($lista as $codigo) {
													echo "<tr>";
													echo "<td>" . $codigo->getRut() . "</td>";
													echo "<td>" . $codigo->getNombre() . "</td>";
													echo "<td>" . $codigo->getApellido1() . " " . $codigo->getApellido2() . "</td>";
													echo "<td><a href='#' type='button' data-dismiss='modal' class='btn btn-outline-success btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Seleccionar' onclick='SeleccionarRepresentante(" . $codigo->getId() . ",\"" . $codigo->getRut() . "\",\"" . $codigo->getNombre() . "\",\"" . $codigo->getApellido1() . "\",\"" . $codigo->getApellido2() . "\")'><i class='fa fa-check'></i> </a></td>";
													echo "</tr>";
												}
											} else {
												echo "<tr>";
												echo "<td colspan='4' class='text-center'>No hay Representante Legal Registrados</td>";
												echo "</tr>";
											}
											?>
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

	<!-- Modal Representante Legal-->
	<div class="modal fade" id="modalvistaprevia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Vista Previa Documento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 pt-1">
							<div class="row">
								<div class="col-md-12">
									<iframe id="vistaprevia" width="100%" height="800">

									</iframe>
								</div>

							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-3">
									<button class="btn btn-danger btn-sm btn-block edit">Editar información</button>
								</div>
								<div class="col-md-3">
									<button class="btn btn-success btn-sm btn-block generar">Generar Contrato</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


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

	<!-- INTERNAL INDEX js -->
	<script src="assets/js/index.js"></script>

	<!-- Sticky js -->
	<script src="assets/js/sticky.js"></script>

	<!-- Custom js -->
	<script src="assets/js/custom.js"></script>
	<script src="JsFunctions/validation.js"></script>
	<script src="JsFunctions/Alert/toastify.js"></script>
	<script src="JsFunctions/precargado.js"></script>
	<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
	<script src="JsFunctions/Alert/alert.js"></script>
	<script src="JsFunctions/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
	<script src="JsFunctions/documentomasivo.js"></script>

	<?php
	$trabajador = $_SESSION['USER_ID'];
	if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
		$id = $_SESSION['CURRENT_ENTERPRISE'];
		echo "<script>";
		echo "window.onload = function(){
			actualizardatos($trabajador);
		mostrarEmpresa(" . $id . ");
		listarcomunas();
		listarcomunasespecifica();listarcomunas();
		listarcomunasespecifica();
		let myNumericInput = new AutoNumeric(('#sueldo'), {
			decimalPlaces: 0,
			digitGroupSeparator: '.',
			decimalCharacter: ',',
			minimumValue: '0'

		});

		
		document.querySelector('#sueldo').addEventListener('keyup', function(event) {});
	}";
		echo "</script>";
	}

	?>
	<script>
		function mas(id) {
			$.ajax({
				type: "POST",
				url: "php/cargar/mas.php",
				data: {
					id: id
				},
				success: function(data) {
					window.location.href = "menuinfo.php";
				}
			});
		}
	</script>
	<script>
		$(document).ready(function() {
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