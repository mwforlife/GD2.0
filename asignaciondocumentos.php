
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
$empresa =0;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
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
							<h1 class="main-content-title tx-30">ASIGNACION DE ESCRITOS</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->
					<!-- Selector de Empresa -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card overflow-hidden">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-lg-6">
											<div class="form-group mb-0">
												<label class="font-weight-bold text-dark">
													<i class="fe fe-briefcase mr-2"></i>Seleccione una Empresa
												</label>
												<select name="empresa" id="empresa" class="form-control select2" data-empresa-sesion="<?php echo $empresa; ?>">
													<option value="">-- Seleccionar Empresa --</option>
													<?php
													$lista = $c->listarEmpresas();
													if (count($lista) > 0) {
														foreach ($lista as $l) {
															$selected = ($empresa == $l->getId()) ? "selected" : "";
															echo "<option value='" . $l->getId() . "' $selected>" . $l->getRazonSocial() . "</option>";
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-6 text-right">
											<a href="tipodocumento.php" class="btn btn-outline-danger waves-effect waves-light">
												<i class="fe fe-arrow-left mr-1"></i> Volver
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Estadísticas -->
					<div class="row mb-3" id="statsSection" style="display: none;">
						<div class="col-lg-4">
							<div class="card bg-primary-gradient text-white">
								<div class="card-body p-4">
									<div class="d-flex align-items-center">
										<div class="mr-3">
											<i class="fe fe-file-text" style="font-size: 2.5rem; opacity: 0.8;"></i>
										</div>
										<div>
											<h6 class="mb-1 text-white-50">Total Documentos</h6>
											<h3 class="mb-0 font-weight-bold" id="totalDocs">0</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card bg-success-gradient text-white">
								<div class="card-body p-4">
									<div class="d-flex align-items-center">
										<div class="mr-3">
											<i class="fe fe-check-circle" style="font-size: 2.5rem; opacity: 0.8;"></i>
										</div>
										<div>
											<h6 class="mb-1 text-white-50">Documentos Asignados</h6>
											<h3 class="mb-0 font-weight-bold" id="totalAsignados">0</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card bg-warning-gradient text-white">
								<div class="card-body p-4">
									<div class="d-flex align-items-center">
										<div class="mr-3">
											<i class="fe fe-clock" style="font-size: 2.5rem; opacity: 0.8;"></i>
										</div>
										<div>
											<h6 class="mb-1 text-white-50">Documentos Disponibles</h6>
											<h3 class="mb-0 font-weight-bold" id="totalDisponibles">0</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Contenedor Principal de Documentos -->
					<div class="row" id="documentosSection" style="display: none;">
						<!-- Documentos Asignados -->
						<div class="col-xl-6 col-lg-12">
							<div class="card">
								<div class="card-header bg-success-gradient d-flex justify-content-between align-items-center">
									<div>
										<h4 class="card-title text-white mb-0">
											<i class="fe fe-check-circle mr-2"></i>Documentos Asignados
										</h4>
										<small class="text-white-50">Documentos actualmente asignados a la empresa</small>
									</div>
									<button type="button" class="btn btn-sm btn-light" id="btnDesasignarTodos" title="Desasignar todos los documentos">
										<i class="fe fe-x-circle mr-1"></i> Desasignar Todos
									</button>
								</div>
								<div class="card-body p-0">
									<!-- Buscador Asignados -->
									<div class="p-3 border-bottom">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text bg-white border-right-0">
													<i class="fe fe-search text-muted"></i>
												</span>
											</div>
											<input type="text" class="form-control border-left-0" id="buscarAsignados" placeholder="Buscar documento asignado...">
										</div>
									</div>
									<div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
										<table class="table table-hover mb-0">
											<thead class="bg-light sticky-top">
												<tr>
													<th class="border-0 text-center" style="width: 100px;">Código DT</th>
													<th class="border-0 text-center" style="width: 120px;">Código Previred</th>
													<th class="border-0">Nombre del Documento</th>
													<th class="border-0 text-center" style="width: 100px;">Acción</th>
												</tr>
											</thead>
											<tbody id="escritosAsignados">
												<tr id="noAsignados">
													<td colspan="4" class="text-center py-5 text-muted">
														<i class="fe fe-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
														<p class="mt-3 mb-0">No hay documentos asignados</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<!-- Documentos Disponibles -->
						<div class="col-xl-6 col-lg-12">
							<div class="card">
								<div class="card-header bg-warning-gradient d-flex justify-content-between align-items-center">
									<div>
										<h4 class="card-title text-white mb-0">
											<i class="fe fe-file-plus mr-2"></i>Documentos Disponibles
										</h4>
										<small class="text-white-50">Documentos que pueden ser asignados</small>
									</div>
									<button type="button" class="btn btn-sm btn-light" id="btnAsignarTodos" title="Asignar todos los documentos">
										<i class="fe fe-plus-circle mr-1"></i> Asignar Todos
									</button>
								</div>
								<div class="card-body p-0">
									<!-- Buscador Disponibles -->
									<div class="p-3 border-bottom">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text bg-white border-right-0">
													<i class="fe fe-search text-muted"></i>
												</span>
											</div>
											<input type="text" class="form-control border-left-0" id="buscarDisponibles" placeholder="Buscar documento disponible...">
										</div>
									</div>
									<div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
										<table class="table table-hover mb-0">
											<thead class="bg-light sticky-top">
												<tr>
													<th class="border-0 text-center" style="width: 100px;">Código DT</th>
													<th class="border-0 text-center" style="width: 120px;">Código Previred</th>
													<th class="border-0">Nombre del Documento</th>
													<th class="border-0 text-center" style="width: 100px;">Acción</th>
												</tr>
											</thead>
											<tbody id="escritosDisponibles">
												<tr id="noDisponibles">
													<td colspan="4" class="text-center py-5 text-muted">
														<i class="fe fe-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
														<p class="mt-3 mb-0">No hay documentos disponibles</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Mensaje cuando no hay empresa seleccionada -->
					<div class="row" id="noEmpresaSection">
						<div class="col-12">
							<div class="card">
								<div class="card-body text-center py-5">
									<i class="fe fe-alert-circle text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
									<h5 class="mt-4 text-muted">Seleccione una empresa</h5>
									<p class="text-muted mb-0">Para ver y gestionar los documentos, primero debe seleccionar una empresa del listado superior.</p>
								</div>
							</div>
						</div>
					</div>
					<!-- END -->


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



		<!-- Edit Modal -->
		<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Edición</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="content">

						</div>
					</div>
				</div>
			</div>
		</div>
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
	<!-- Custom js -->
	<script src="assets/js/custom.js"></script>
	<script src="JsFunctions/Alert/toastify.js"></script>
	<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
	<script src="JsFunctions/Alert/alert.js"></script>
	<script src="JsFunctions/main.js"></script>
	<script>
		// Variables globales para almacenar los datos y permitir filtrado
		var documentosAsignados = [];
		var documentosDisponibles = [];

		$(document).ready(function(){
			mostrarEmpresa();

			// Verificar si hay empresa en sesión y cargar datos automáticamente
			var empresaSesion = $("#empresa").data("empresa-sesion");
			if(empresaSesion && empresaSesion > 0){
				// Forzar el valor en select2 si está inicializado
				setTimeout(function(){
					$("#empresa").val(empresaSesion).trigger('change.select2');
					$("#noEmpresaSection").hide();
					$("#statsSection").fadeIn();
					$("#documentosSection").fadeIn();
					cargarDocumentos();
				}, 100);
			}

			// Evento cambio de empresa
			$("#empresa").on("change", function(){
				var empresa = $(this).val();
				if(empresa && empresa > 0){
					$("#noEmpresaSection").hide();
					$("#statsSection").fadeIn();
					$("#documentosSection").fadeIn();
					$("#buscarAsignados").val('');
					$("#buscarDisponibles").val('');
					cargarDocumentos();
				} else {
					$("#noEmpresaSection").show();
					$("#statsSection").hide();
					$("#documentosSection").hide();
				}
			});

			// Buscador documentos asignados
			$("#buscarAsignados").on("keyup", function(){
				var filtro = $(this).val().toLowerCase();
				filtrarTabla(documentosAsignados, filtro, 'asignados');
			});

			// Buscador documentos disponibles
			$("#buscarDisponibles").on("keyup", function(){
				var filtro = $(this).val().toLowerCase();
				filtrarTabla(documentosDisponibles, filtro, 'disponibles');
			});

			// Botón Asignar Todos
			$("#btnAsignarTodos").on("click", function(){
				var empresa = $("#empresa").val();
				if(!empresa || empresa <= 0){
					ToastifyError("Debe seleccionar una empresa");
					return;
				}

				Swal.fire({
					title: '¿Asignar todos los documentos?',
					text: "Se asignarán todos los documentos disponibles a la empresa seleccionada",
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#28a745',
					cancelButtonColor: '#6c757d',
					confirmButtonText: '<i class="fe fe-check mr-1"></i> Sí, asignar todos',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						$("#global-loader").fadeIn("slow");
						$.ajax({
							type: "POST",
							url: "php/insert/escrito_masivo.php",
							data: { empresa: empresa, accion: 'asignar_todos' },
							dataType: 'json',
							success: function(data){
								$("#global-loader").fadeOut("slow");
								if(data.success){
									ToastifySuccess(data.message);
									cargarDocumentos();
								} else {
									ToastifyError(data.message);
								}
							},
							error: function(){
								$("#global-loader").fadeOut("slow");
								ToastifyError("Error de conexión");
							}
						});
					}
				});
			});

			// Botón Desasignar Todos
			$("#btnDesasignarTodos").on("click", function(){
				var empresa = $("#empresa").val();
				if(!empresa || empresa <= 0){
					ToastifyError("Debe seleccionar una empresa");
					return;
				}

				Swal.fire({
					title: '¿Desasignar todos los documentos?',
					text: "Se retirarán todos los documentos asignados de la empresa seleccionada",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#dc3545',
					cancelButtonColor: '#6c757d',
					confirmButtonText: '<i class="fe fe-x mr-1"></i> Sí, desasignar todos',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						$("#global-loader").fadeIn("slow");
						$.ajax({
							type: "POST",
							url: "php/insert/escrito_masivo.php",
							data: { empresa: empresa, accion: 'desasignar_todos' },
							dataType: 'json',
							success: function(data){
								$("#global-loader").fadeOut("slow");
								if(data.success){
									ToastifySuccess(data.message);
									cargarDocumentos();
								} else {
									ToastifyError(data.message);
								}
							},
							error: function(){
								$("#global-loader").fadeOut("slow");
								ToastifyError("Error de conexión");
							}
						});
					}
				});
			});
		});

		function cargarDocumentos(){
			var empresa = $("#empresa").val();
			if(!empresa || empresa <= 0){
				return;
			}

			$.ajax({
				type: "POST",
				url: "php/listar/escritos_empresa.php",
				data: { empresa: empresa },
				dataType: 'json',
				success: function(data){
					if(data.success){
						// Guardar en variables globales para filtrado
						documentosAsignados = data.asignados;
						documentosDisponibles = data.disponibles;

						renderizarAsignados(data.asignados);
						renderizarDisponibles(data.disponibles);
						$("#totalAsignados").text(data.totalAsignados);
						$("#totalDisponibles").text(data.totalDisponibles);
						$("#totalDocs").text(data.totalDocumentos);
					} else {
						ToastifyError(data.message || "Error al cargar documentos");
					}
				},
				error: function(){
					ToastifyError("Error de conexión");
				}
			});
		}

		function filtrarTabla(documentos, filtro, tipo){
			var documentosFiltrados = documentos.filter(function(doc){
				return doc.codigo.toLowerCase().includes(filtro) ||
					   doc.codigoPrevired.toLowerCase().includes(filtro) ||
					   doc.nombre.toLowerCase().includes(filtro);
			});

			if(tipo === 'asignados'){
				renderizarAsignados(documentosFiltrados);
			} else {
				renderizarDisponibles(documentosFiltrados);
			}
		}

		function renderizarAsignados(documentos){
			var html = '';
			if(documentos && documentos.length > 0){
				documentos.forEach(function(doc){
					html += '<tr class="fade-in" data-id="' + doc.id + '">' +
						'<td class="text-center"><span class="badge badge-light">' + doc.codigo + '</span></td>' +
						'<td class="text-center"><span class="badge badge-light">' + doc.codigoPrevired + '</span></td>' +
						'<td>' + doc.nombre + '</td>' +
						'<td class="text-center">' +
							'<button type="button" class="btn btn-sm btn-outline-danger" onclick="desasignar(' + doc.id + ')" title="Desasignar documento">' +
								'<i class="fe fe-arrow-right"></i>' +
							'</button>' +
						'</td>' +
					'</tr>';
				});
			} else {
				html = '<tr id="noAsignados">' +
					'<td colspan="4" class="text-center py-5 text-muted">' +
						'<i class="fe fe-inbox" style="font-size: 3rem; opacity: 0.3;"></i>' +
						'<p class="mt-3 mb-0">No hay documentos asignados</p>' +
					'</td>' +
				'</tr>';
			}
			$("#escritosAsignados").html(html);
		}

		function renderizarDisponibles(documentos){
			var html = '';
			if(documentos && documentos.length > 0){
				documentos.forEach(function(doc){
					html += '<tr class="fade-in" data-id="' + doc.id + '">' +
						'<td class="text-center"><span class="badge badge-light">' + doc.codigo + '</span></td>' +
						'<td class="text-center"><span class="badge badge-light">' + doc.codigoPrevired + '</span></td>' +
						'<td>' + doc.nombre + '</td>' +
						'<td class="text-center">' +
							'<button type="button" class="btn btn-sm btn-outline-success" onclick="asignar(' + doc.id + ')" title="Asignar documento">' +
								'<i class="fe fe-arrow-left"></i>' +
							'</button>' +
						'</td>' +
					'</tr>';
				});
			} else {
				html = '<tr id="noDisponibles">' +
					'<td colspan="4" class="text-center py-5 text-muted">' +
						'<i class="fe fe-inbox" style="font-size: 3rem; opacity: 0.3;"></i>' +
						'<p class="mt-3 mb-0">No hay documentos disponibles</p>' +
					'</td>' +
				'</tr>';
			}
			$("#escritosDisponibles").html(html);
		}

		function asignar(id){
			var empresa = $("#empresa").val();
			if(!empresa || empresa <= 0){
				ToastifyError("Debe seleccionar una empresa");
				return;
			}

			$.ajax({
				type: "POST",
				url: "php/insert/escrito.php",
				data: { empresa: empresa, id: id },
				dataType: 'json',
				success: function(response){
					if(response.success){
						ToastifySuccess(response.message);
						cargarDocumentos();
					} else {
						ToastifyError(response.message);
						if(response.code == 2){
							cargarDocumentos();
						}
					}
				},
				error: function(){
					ToastifyError("Error de conexión");
				}
			});
		}

		function desasignar(id){
			var empresa = $("#empresa").val();
			if(!empresa || empresa <= 0){
				ToastifyError("Debe seleccionar una empresa");
				return;
			}

			$.ajax({
				type: "POST",
				url: "php/eliminar/escrito.php",
				data: { empresa: empresa, id: id },
				dataType: 'json',
				success: function(response){
					if(response.success){
						ToastifySuccess(response.message);
						cargarDocumentos();
					} else {
						ToastifyError(response.message);
					}
				},
				error: function(){
					ToastifyError("Error de conexión");
				}
			});
		}
	</script>

	<style>
		.bg-primary-gradient {
			background: linear-gradient(135deg, #6259ca 0%, #4a44b1 100%);
		}
		.bg-success-gradient {
			background: linear-gradient(135deg, #28a745 0%, #20863a 100%);
		}
		.bg-warning-gradient {
			background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
		}
		.card {
			border: none;
			box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
			border-radius: 0.5rem;
		}
		.card-header {
			border-radius: 0.5rem 0.5rem 0 0 !important;
		}
		.table th {
			font-weight: 600;
			font-size: 0.85rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.table td {
			vertical-align: middle;
		}
		.table tbody tr:hover {
			background-color: rgba(0, 0, 0, 0.02);
		}
		.badge-light {
			background-color: #f4f6f9;
			color: #333;
			font-weight: 500;
		}
		.btn-outline-success:hover,
		.btn-outline-danger:hover {
			color: #fff;
		}
		.fade-in {
			animation: fadeIn 0.3s ease-in;
		}
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(-5px); }
			to { opacity: 1; transform: translateY(0); }
		}
		.sticky-top {
			position: sticky;
			top: 0;
			z-index: 10;
		}
		#statsSection .card {
			transition: transform 0.2s ease;
		}
		#statsSection .card:hover {
			transform: translateY(-3px);
		}
	</style>



</body>

</html>