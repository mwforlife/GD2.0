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
$plan =0;
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
	$plan = $c->buscarplanempresa($_SESSION['CURRENT_ENTERPRISE']);
} else {
	header("Location: trabajadores.php");
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
	<title>Gestor de Documentos | Ficha Trabajador</title>

	<!-- Bootstrap css-->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<!-- Icons css-->
	<link href="assets/css/icons.css" rel="stylesheet" />
	<link href="assets/css/toastify.min.css" rel="stylesheet" />
	<!-- Internal Daterangepicker css-->
	<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- InternalFileupload css-->
	<link href="assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />

	<!-- InternalFancy uploader css-->
	<link href="assets/plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />

	<!-- Internal TelephoneInput css-->
	<link rel="stylesheet" href="assets/plugins/telephoneinput/telephoneinput.css">

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
	<style>
		.swal2-container .swal2-center .swal2-backdrop-show{
			z-index: 999999999999;
			position: absolute;
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
		<div class="main-content side-content pt-0">

			<div class="container-fluid">
				<div class="inner-body">

					<!-- Page Header -->
					<div class="page-header">
						<div class="page-header-1">
							<h1 class="main-content-title tx-30">Informacion Trabajador</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->


					<!-- Row -->
					<div class="row d-none">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Basic Style Accordion</h6>
										<p class="text-muted card-sub-title">The default collapse behavior to create an accordion.</p>
									</div>
									<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
										<div class="card">
											<div class="card-header" id="headingOne" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapseOne">Making a Beautiful CSS3 Button Set</a>
											</div>
											<div aria-labelledby="headingOne" class="collapse show" data-parent="#accordion" id="collapseOne" role="tabpanel">
												<div class="card-body">
													A concisely coded CSS3 button set increases usability across the board, gives you a ton of options, and keeps all the code involved to an absolute minimum. Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingTwo" role="tab">
												<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseTwo">Horizontal Navigation Menu Fold Animation</a>
											</div>
											<div aria-labelledby="headingTwo" class="collapse" data-parent="#accordion" id="collapseTwo" role="tabpanel">
												<div class="card-body">
													Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumEnda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore.
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingThree" role="tab">
												<a aria-controls="collapseThree" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseThree">Creating CSS3 Button with Rounded Corners</a>
											</div>
											<div aria-labelledby="headingThree" class="collapse" data-parent="#accordion" id="collapseThree" role="tabpanel">
												<div class="card-body">
													Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumEnda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore.
												</div>
											</div><!-- collapse -->
										</div>
									</div><!-- accordion -->
								</div>
							</div>
						</div>
					</div>
					<!-- End Row -->
					<!-- Row -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<div aria-multiselectable="true" class="accordion" id="accordion1" role="tablist">
										<div class="card">
											<div class="card-header" id="headingOne-1" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-1" class="accordion-toggle bg-primary text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Informacion Personal</a>
											</div>
											<div aria-labelledby="headingOne-1" class="collapse" data-parent="#accordion" id="collapse-1" role="tabpanel">
												<div class="card-body">
													<div class="row text-dark">
														<div class="col-md-12">
															<h6 class="main-content-label mb-1">Datos Personales</h6>
															<p class="text-mutted card-sub-title">.</p>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">
																<label for="">RUT:</label>
																<p class="form-control text-dark text-dark" placeholder="RUT" maxlength="12" onkeyup="formatRut(this)" id="TrabajadorRut" name="TrabajadorRut" required="" type="text" value=""> <?php echo $trabajador->getRut(); ?></p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">
																<label for="">DNI:</label>
																<p class="form-control text-dark text-dark" placeholder="DNI" id="TrabajadorDNI" name="TrabajadorDNI" type="text" value="">. <?php echo $trabajador->getDni(); ?>.</p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">
																<label for="">Nombre:</label>
																<p class="form-control text-dark" placeholder="Nombre" id="TrabajadorNombre" name="TrabajadorNombre" required="" type="text" value=""><?php echo $trabajador->getNombre(); ?>.</p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">

																<label for="">Primer Apellido:</label>
																<p class="form-control text-dark" placeholder="Primer Apellido" id="TrabajadorApellido1" name="TrabajadorApellido1" required="" type="text" value=""><?php echo $trabajador->getApellido1(); ?>.</p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">
																<label for="">Segundo Apellido:</label>
																<p class="form-control text-dark" placeholder="Segundo Apellido" id="TrabajadorApellido2" name="TrabajadorApellido2" type="text" value=""><?php echo $trabajador->getApellido2(); ?>.</p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group has-success ">
																<label for="">Fecha de Nacimiento:</label>
																<p class="form-control text-dark" placeholder="Fecha de Nacimiento" id="TrabajadorNacimiento" name="TrabajadorNacimiento" required="" type="date" value=""><?php echo date("d-m-Y", strtotime($trabajador->getNacimiento())); ?>.</p>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group select2-lg">
																<label for="">Sexo:</label>
																<?php
																if ($trabajador->getSexo() == 1) {
																	echo "<p class='form-control text-dark'>Masculino.</p>";
																} else {
																	echo "<p class='form-control text-dark'>Femenino.</p>";
																}
																?>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group select2-lg">
																<label for="">Estado Civil:</label>
																<?php
																$lista = $c->listarestadocivil();
																if (count($lista) > 0) {
																	foreach ($lista as $l) {
																		if ($l->getId() == $trabajador->getCivil()) {
																			echo "<p class='form-control text-dark'>" . $l->getNombre() . ".</p>";
																			break;
																		}
																	}
																} else {
																	echo "<p value=''>No hay datos.</p>";
																}
																?>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group select2-lg">
																<label for="">Nacionalidad:</label>
																<?php
																$lista = $c->listarnacionalidad();
																if (count($lista) > 0) {
																	foreach ($lista as $l) {
																		if ($l->getId() == $trabajador->getNacionalidad()) {
																			echo "<p class='form-control text-dark'>" . $l->getNombre() . ".</p>";
																			break;
																		}
																	}
																} else {
																	echo "<p value=''>No hay datos.</p>";
																}
																?>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group select2-lg">
																<label for="">Persona con Discapacidad:</label>
																<?php
																if ($trabajador->getDiscapacidad() == 1) {
																	echo "<p class='form-control text-dark'>Si.</p>";
																} else {
																	echo "<p class='form-control text-dark'>No.</p>";
																}

																?>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="form-group select2-lg">
																<label for="">Persona con Pensión:</label>
																<?php
																if ($trabajador->getPension() == 1) {
																	echo "<p class='form-control text-dark'>Si.</p>";
																} else {
																	echo "<p class='form-control text-dark'>No.</p>";
																}

																?>
															</div>
														</div>

														<div class="col-md-12 mt-3 text-right">
															<a href="EditarTrabajador.php" type="submit" class="btn btn-primary btn-md"> <i class="fa fa-refresh"></i> Actualizar Información Personal</a>
														</div>

													</div>
													<hr />

													<div class="row">
														<div class="col-md-12">
															<h6 class="main-content-label mb-1">Datos de domicilio</h6>
															<p class="text-mutted card-sub-title"></p>
														</div>
														<div class="col-lg-12 table-responsive">
															<table class="table w-100 table-hover table-bordered">
																<thead>
																	<tr>
																		<th class="wd-15p">Fecha de Registro</th>
																		<th class="wd-15p">Calle</th>
																		<th class="wd-15p">Villa / Población</th>
																		<th class="wd-15p">Numero</th>
																		<th class="wd-15p">Departamento</th>
																		<th class="wd-15p">Region</th>
																		<th class="wd-15p">Comuna</th>
																		<th class="wd-15p">Ciudad</th>
																		<th class="wd-15p">Acción</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$region = $c->listarregiones();
																	$lista = $c->listardomicilio($id);
																	foreach ($lista as $domi) {
																		echo "<tr>";
																		echo "<td>" . $domi->getRegistro() . "</td>";
																		echo "<td>" . $domi->getCalle() . "</td>";
																		echo "<td>" . $domi->getVilla() . "</td>";
																		echo "<td>" . $domi->getNumero() . "</td>";
																		echo "<td>" . $domi->getDepartamento() . "</td>";
																		foreach ($region as $reg) {
																			if ($reg->getId() == $domi->getRegion()) {
																				echo "<td>" . $reg->getNombre() . "</td>";
																			}
																		}
																		$comuna = $c->listarcomunas($domi->getRegion());
																		foreach ($comuna as $com) {
																			if ($com->getId() == $domi->getComuna()) {
																				echo "<td>" . $com->getNombre() . "</td>";
																			}
																		}
																		$ciudad = $c->listarciudades($domi->getComuna());
																		foreach ($ciudad as $ciu) {
																			if ($ciu->getId() == $domi->getCiudad()) {
																				echo "<td>" . $ciu->getNombre() . "</td>";
																			}
																		}
																		echo "<td class='d-flex'> 
																				<a class='btn btn-outline-warning btn-sm rounded-11' href='actualizardomicilio.php?code=" . $domi->getId() . "'><i class='fa fa-pen'></i></a>
																				<a class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminardomicilio(" . $domi->getId() . ")'><i class='fa fa-trash'></i></a>
																				</td>";
																		echo "</tr>";
																	}
																	?>
																</tbody>
															</table>
														</div>
														<div class="col-md-12 mt-3 text-right">
															<a href="EditarDomicilio.php" type="submit" class="btn btn-primary btn-md"> <i class="fa fa-plus"></i> Agregar</a>
														</div>

													</div>

													<hr />
													<div class="row">
														<div class="col-md-12">
															<h6 class="main-content-label mb-1">Datos de Contacto</h6>
															<p class="text-mutted card-sub-title"></p>
														</div>
														<div class="col-lg-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" >
																<thead>
																	<tr>
																		<td>Fecha de Registro</td>
																		<td>Telefono</td>
																		<td>Correo Electronico</td>
																		<td>Acción</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$lista = $c->listarcontacto($id);
																	foreach ($lista as $cont) {
																		echo "<tr>";
																		echo "<td>" . $cont->getRegistro() . "</td>";
																		echo "<td>" . $cont->getTelefono() . "</td>";
																		echo "<td>" . $cont->getCorreo() . "</td>";
																		echo "<td class='d-flex'> 
																			<a class='btn btn-outline-warning btn-sm rounded-11' href='actualizarcontacto.php?code=" . $cont->getId() . "'><i class='fa fa-pen'></i></a>
																			<a class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarcontacto(" . $cont->getId() . ")'><i class='fa fa-trash'></i></a>
																			</td>";
																		echo "</tr>";
																	}
																	?>
																</tbody>

															</table>
														</div>
														<div class="col-md-12 mt-3 text-right">
															<a href="Contacto.php" type="submit" class="btn btn-primary btn-md"> <i class="fa fa-plus"></i> Agregar</a>
														</div>

													</div>
													<hr />

												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingOne-2" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-2" class="accordion-toggle bg-secondary text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Informacion Previsional</a>
											</div>
											<div aria-labelledby="headingOne-2" class="collapse" data-parent="#accordion" id="collapse-2" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="infoprevisional.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar Información </a>
														</div>
													</div>

													<div class="row m-3">
														<div class="col-md-12 table-responsive">
															<h4>Información Previsional</h4>
															<table class="table w-100 table-hover table-bordered" id="example1">
																<thead>
																	<tr>
																		<td>Periodo</td>
																		<td>AFP</td>
																		<td>Jubilado</td>
																		<td>S. Cesantia</td>
																		<td>S. Accidentes</td>
																		<td>Inicio Cesantia</td>
																		<td>Salud</td>
																		<td>Moneda Plan</td>
																		<td>Monto</td>
																		<td>Moneda GES</td>
																		<td>Monto</td>
																		<td>Obs</td>
																		<td>Doc. AFP</td>
																		<td>Doc. Salud</td>
																		<td>Doc. Jubilacion</td>
																		<td>Acción</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	if (isset($_SESSION['TRABAJADOR_ID'])) {
																		$id = $_SESSION['TRABAJADOR_ID'];
																		$prevision = $c->listarprevision($id);
																		if (count($prevision) > 0) {
																			foreach ($prevision as $p) {
																				echo "<tr>";
																				echo "<td>" . $p->getPeriodo() . "</td>";
																				echo "<td>" . $p->getAfp() . "</td>";
																				echo "<td>" . $p->getJubilado() . "</td>";
																				echo "<td>" . $p->getCesantia() . "</td>";
																				echo "<td>" . $p->getSeguro() . "</td>";
																				echo "<td>" . date("d-m-Y", strtotime($p->getPeriodocesantia())) . "</td>";					
																				echo "<td>" . $p->getIsapre() . "</td>";
																				if ($p->getMonedapacto() == 1) {
																					echo "<td>Pesos</td>";
																				} else if ($p->getMonedapacto() == 2) {
																					echo "<td>UF</td>";
																				} else {
																					echo  "<td>7%</td>";
																				}
																				echo "<td>" . $p->getMonto() . "</td>";
																				if ($p->getTipoges() == 1) {
																					echo "<td>Pesos</td>";
																				} else if ($p->getTipoges() == 2) {
																					echo "<td>UF</td>";
																				} else {
																					echo  "<td>No Aplica</td>";
																				}
																				echo "<td>" . $p->getGes() . "</td>";
																				echo "<td>" . $p->getComentario() . "</td>";
																				if ($p->getDocumentoafp() == "") {
																					echo "<td></td>";
																				} else {
																					echo "<td><a class='btn btn-outline-success btn-sm rounded-11' href='uploads/" . $p->getDocumentoafp() . "' target='_blank'><i class='fa fa-file'></i></td>";
																				}
																				if ($p->getDocumentosalud() == null) {
																					echo "<td></td>";
																				} else {
																					echo "<td><a class='btn btn-outline-success btn-sm rounded-11' href='uploads/" . $p->getDocumentosalud() . "' target='_blank'><i class='fa fa-file'></i></td>";
																				}

																				if ($p->getDocumentojubilacion() == null) {
																					echo "<td>No Aplica</td>";
																				} else {
																					echo "<td><a class='btn btn-outline-success btn-sm rounded-11' href='uploads/" . $p->getDocumentojubilacion() . "' target='_blank'><i class='fa fa-file'></i></td>";
																				}
																				echo "<td class='d-flex'> 
																				<a class='btn btn-outline-warning btn-sm rounded-11' href='infoprevisional.php?code=" . $p->getId() . "'><i class='fa fa-pen'></i></a>
																				<a class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarprevision(" . $p->getId() . ")'><i class='fa fa-trash'></i></a>
																				</td>";
																				echo "</tr>";
																			}
																		}
																	}
																	?>
																</tbody>

															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-vac" class="accordion-toggle bg-success text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Información bancaria</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-vac" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="cuentabancaria.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Registrar Cuenta </a>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example2">
																<thead>
																	<tr>
																		<td>Banco</td>
																		<td>Tipo de Cuenta</td>
																		<td>Numero de Cuenta</td>
																		<td>Acción</td>
																	</tr>
																</thead>
																<tbody class="tablecontratos">
																	<?php
																	$lista = $c->listarcuentasbancariastexto($_SESSION['TRABAJADOR_ID']);
																	if (count($lista) > 0) {
																		foreach ($lista as $p) {
																			echo "<tr>";
																			echo "<td>" . $p->getBanco() . "</td>";
																			echo "<td>" . $p->getTipo() . "</td>";
																			echo "<td>" . $p->getNumero() . "</td>";
																			echo "<td class='d-flex'> 
																			<a class='btn btn-outline-warning btn-sm rounded-11' href='cuentabancariaedit.php?code=" . $p->getId() . "'><i class='fa fa-pen'></i></a>
																			<a class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarcuentabancaria(" . $p->getId() . ")'><i class='fa fa-trash'></i></a>
																			</td>";
																			echo "</tr>";
																		}
																	}
																	?>

																</tbody>

															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										<?php

										if (isset($_SESSION['GESTION_PERMISO']) || $plan==2) {
											if ($_SESSION['GESTION_PERMISO'] == true || $plan==2) {

										?>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-6" class="accordion-toggle bg-dark text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Cargas Familiar / Beneficios Sociales</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-6" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="cargafamiliar.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar Carga </a>
														</div>
													</div>

													<div class="row m-3">
														<div class="col-md-12 table-responsive">
															<h4>Información Carga Familiar</h4>
															<table class="table w-100 table-hover table-bordered" id="example3">
																<thead>
																	<tr>
																		<td>Rut</td>
																		<td>Nombre</td>
																		<td>P. Apellido</td>
																		<td>S. Apellido</td>
																		<td>F. Nacimiento</td>
																		<td>Estado Civil</td>
																		<td>F. Reconocimiento</td>
																		<td>F. Pago</td>
																		<td>Vigencia</td>
																		<td>T. Causante</td>
																		<td>Sexo</td>
																		<td>T. Carga</td>
																		<td>F. Registro</td>
																		<td>Obs</td>
																		<td>Doc</td>
																		<td>Accion</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$cargas = $c->listarcargas($_SESSION['TRABAJADOR_ID']);
																	if (count($cargas) > 0) {
																		foreach ($cargas as $carga) {
																			echo "<tr>";
																			echo "<td>" . $carga->getRut() . "</td>";
																			echo "<td>" . $carga->getNombre() . "</td>";
																			echo "<td>" . $carga->getApellido1() . "</td>";
																			echo "<td>" . $carga->getApellido2() . "</td>";
																			echo "<td>" . $carga->getFechaNacimiento() . "</td>";
																			echo "<td>" . $carga->getEstadoCivil() . "</td>";
																			echo "<td>" . $carga->getFechaReconocimiento() . "</td>";
																			echo "<td>" . $carga->getFechaPago() . "</td>";
																			if ($carga->getVigencia() == "0000-00-00") {
																				echo "<td></td>";
																			} else {
																				echo "<td>" . $carga->getVigencia() . "</td>";
																			}
																			echo "<td>" . $carga->getTipoCausante() . "</td>";
																			echo "<td>" . $carga->getSexo() . "</td>";
																			echo "<td>" . $carga->getTipoCarga() . "</td>";
																			echo "<td>" . $carga->getFechaRegistro() . "</td>";
																			echo "<td>" . $carga->getComentario() . "</td>";
																			if (strlen($carga->getDocumento()) > 0) {
																				echo "<td><a href='uploads/" . $carga->getDocumento() . "' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
																			} else {
																				echo "<td></td>";
																			}
																			echo "<td class='d-flex'> 
																				<a class='btn btn-outline-warning btn-sm rounded-11' href='actualizarcarga.php?code=" . $carga->getId() . "'><i class='fa fa-pen'></i></a>
																				<a class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarcarga(" . $carga->getId() . ")'><i class='fa fa-trash'></i></a>
																				</td>";
																			echo "</tr>";
																		}
																	}
																	?>
																</tbody>

															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
											}
										}
										?>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-3" class="accordion-toggle bg-warning text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Contratos</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-3" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right mb-4">
															<a class="btn btn-success" href="contratoindividual.php?code=<?php echo $id;?>"> <i class="fa fa-edit"></i> Nuevo Contrato</a>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example4">
																<thead>
																	<tr>
																		<td>F. Inicio</td>
																		<td>F. Termino</td>
																		<td>T. Contrato</td>
																		<td>Estado</td>
																		<td>Doc</td>
																		<td>Anexos</td>
																		<td>Eliminar</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$contratos = $c->listarcontratos($_SESSION['TRABAJADOR_ID']);
																	if (count($contratos) > 0) {
																		foreach ($contratos as $contrato) {
																			echo "<tr>";
																			echo "<td>" . date("d-m-Y", strtotime($contrato->getFechaInicio())) . "</td>";
																			if (strlen($contrato->getFechaTermino()) == 0) {
																				echo "<td> Sin Fecha de termino </td>";
																			} else {
																				echo "<td>" . date("d-m-Y", strtotime($contrato->getFechaTermino())) . "</td>";
																			}
																			echo "<td>" . $contrato->getTipoContrato() . "</td>";
																			if ($contrato->getEstado() == 1) {
																				echo "<td>Activo</td>";
																			} else {
																				echo "<td>Finiquitado</td>";
																			}
																			echo "<td><a class='btn btn-outline-warning btn-sm rounded-11' target='_blank' href='uploads/Contratos/" . $contrato->getDocumento() . "'><i class='fa fa-file'></i></a></td>";
																			
																			echo "<td><a onclick='buscaranexo(".$contrato->getId().")' class='btn btn-outline-info btn-sm rounded-11'><i class='fa fa-file'></i></a></td>";
																			
																			if ($contrato->getEstado() == 1) {
																				echo "<td><button class='btn btn-danger btn-sm rounded-11' onclick='eliminarcontrato(" . $contrato->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																			} else {
																				echo "<td class='text-center'>-</td>";
																			}
																			echo "</tr>";
																		}
																	}
																	?>
																</tbody>

															</table>

														</div>
													</div>

												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-4" class="accordion-toggle bg-success text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Finiquitos</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-4" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="finiquitoindividual.php?code=<?php echo $id;?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Nuevo Finiquito </a>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example5">
																<thead>
																	<tr>
																		<td>Fecha Inicio</td>
																		<td>Fecha Termino</td>
																		<td>Fecha Finiquito</td>
																		<td>Causal Termino de Contrato</td>
																		<td>Detalle</td>
																		<td>Ver Documento</td>
																		<td>Eliminar</td>
																	</tr>
																</thead>
																<tbody class="tablecontratos">
																	<?php
																	$finiquitos = $c->listarfiniquitotext($id);
																	if (count($finiquitos) > 0) {
																		foreach ($finiquitos as $finiquito) {
																			echo "<tr>";
																			//Convertir fecha en formato dd-mm-YYYY
																			$fecha_inicio = date("d-m-Y", strtotime($finiquito->getFechaInicio()));
																			$fecha_termino = date("d-m-Y", strtotime($finiquito->getFechaTermino()));
																			$fecha_finiquito = date("d-m-Y", strtotime($finiquito->getFechafiniquito()));
																			echo "<td>" . $fecha_inicio . "</td>";
																			echo "<td>" . $fecha_termino . "</td>";
																			echo "<td>" . $fecha_finiquito . "</td>";
																			echo "<td>" . $finiquito->getCausal() . "</td>";
																			echo "<td><button class='btn btn-outline-warning btn-sm rounded-11' data-toggle='modal' data-target='#modal-detalle-finiquito' onclick='detallefiniquito(" . $finiquito->getId() . ")'><i class='fa fa-eye'></i></button></td>";
																			echo "<td><a href='php/pdf/finiquito.php?id=" . $finiquito->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-pdf-o'></i></a></td>";
																			echo "<td><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarfiniquito(" . $finiquito->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																			echo "</tr>";
																		}
																	}
																	?>

																</tbody>

															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-not" class="accordion-toggle bg-danger text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Notificación de Despido</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-not" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="notificacionindividual.php?code=<?php echo $id;?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Nueva Notificación </a>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example6">
																<thead>
																	<tr>
																		<td>Fecha Notificación</td>
																		<td>Causal de Hechos</td>
																		<td>Comunicacion</td>
																		<td>PDF</td>
																		<td>CSV</td>
																		<td>Eliminar</td>
																	</tr>
																</thead>
																<tbody class="tablenotificacion">
																	<?php
																	$notifi = $c->listarnotificacionestext($_SESSION['TRABAJADOR_ID']);
																	if ($notifi != null) {
																		foreach ($notifi as $notificacion) {
																			echo "<tr>";
																			echo "<td>" . $notificacion->getFechanotificacion() . "</td>";
																			echo "<td>" . $notificacion->getCausal() . "</td>";
																			echo "<td>" . $notificacion->getComunicacion() . "</td>";
																			echo "<td><a href='php/pdf/notificacion.php?id=" . $notificacion->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-pdf-o'></i></a></td>";
																			echo "<td><a href='php/pdf/notificacioncsv.php?id=" . $notificacion->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-excel-o'></i></a></td>";
																			echo "<td><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarnotificacion(" . $notificacion->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																			echo "</tr>";
																		}
																	}
																	?>
																</tbody>

															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										
										<?php

										if (isset($_SESSION['GESTION_PERMISO']) || $plan==2) {
											if ($_SESSION['GESTION_PERMISO'] == true || $plan==2) {

										?>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-5" class="accordion-toggle bg-info text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Vacaciones</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-5" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12">
															<form id="formvacaprogresivas">
																<div class="row">
																	<?php
																	$id = $_SESSION['TRABAJADOR_ID'];
																	$fecafec = $c->buscarfechaafectovacaciones($id); ?>
																	<div class="col-md-12">
																		<label for="">¿Esta afecto a vacaciones proporcionales?</label>
																		<input type="radio" value="1" name="afecto" id="afecto1" onclick="vista(1,<?php echo $id; ?>)" <?php if ($fecafec != false) {
																																											echo "checked";
																																										} ?>><span>Si</span>
																		<input type="radio" value="2" name="afecto" id="afecto2" onclick="vista(2,<?php echo $id; ?>)" <?php if ($fecafec == false) {
																																											echo "checked";
																																										} ?>><span>No</span>
																	</div>
																	<div class="col-md-12 afectosi <?php if ($fecafec == false) {
																										echo " d-none";
																									} ?>">
																		<div class="row">
																			<div class="col-md-6 ">
																				<label for="">Fecha de inicio de vacaciones progresivas.</label>
																				<?php
																				$id = $_SESSION['TRABAJADOR_ID'];
																				//Imprimir Id
																				echo "<input type='hidden' name='idtrabajador' id='idtrabajador' value='" . $id . "'>";
																				if ($fecafec != false) {
																					echo "<input type='date' name='vacacionesprogresivas' id='vacacionesprogresivas' class='form-control' value='" . $fecafec . "'>";
																				} else {
																				?>
																					<input type="date" name="vacacionesprogresivas" id="vacacionesprogresivas" class="form-control">
																				<?php
																				}
																				?>
																			</div>
																			<div class="col-md-6  justif-content-start align-items-end d-flex">
																				<?php
																				if ($fecafec != false) {
																					echo "<button type='submit' class='btn btn-success'><i class='fa fa-save'></i></button>";
																				} else {
																				?>
																					<button type="submit" id="btnregfec" class="btn btn-success"><i class="fa fa-save"></i></button>
																				<?php
																				}
																				?>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															</td>
															<div class="col-md-12 text-right">
																<a href="vacaciones.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar Vacaciones</a>
															</div>

															<div class="col-md-12 table-responsive">
																<table class="table w-100 table-hover table-bordered" id="example7">
																	<thead>
																		<tr>
																			<td>Periodo</td>
																			<td>F. Inicio</td>
																			<td>F. Termino</td>
																			<td>Can. Dias Tomados</td>
																			<td>Obs</td>
																			<td>Comp No Firmado</td>
																			<td>Comp Firmado</td>
																			<td>Eliminar</td>
																			<td>Cargar Comp. Firmado</td>
																			<td>Fecha de registro</td>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$id = $_SESSION['TRABAJADOR_ID'];
																		$lista = $c->listarvacaciones($id);
																		foreach ($lista as $key) {
																			$periodoinicio = $key->getPeriodoinicio();
																			$periodotermino = $key->getPeriodotermino();
																			$dias = $key->getDiashabiles();
																			$diasprogresivas = $key->getDiasprogesivas();
																			$fechainicio = $key->getFechainicio();
																			$fechatermino = $key->getFechatermino();
																			$observacion = $key->getObservacion();
																			$comprobante = $key->getComprobantefirmado();
																			$registro = $key->getRegistro();


																			echo "<tr>";
																			echo "<td>" . $periodoinicio . " - " . $periodotermino . "</td>";
																			//Fechas en formato dd-mm-aaaa
																			echo "<td>" . date("d-m-Y", strtotime($fechainicio)) . "</td>";
																			echo "<td>" . date("d-m-Y", strtotime($fechatermino)) . "</td>";
																			echo "<td>" . ($dias + $diasprogresivas) . "</td>";
																			echo "<td>" . $key->getObservacion() . "</td>";
																			echo "<td><a class='btn btn-outline-success rounded-11 btn-sm mr-2' href='php/report/comprobantevacaciones.php?code=" . $key->getId() . "' target='_blank'><i class='fa fa-file'></i></a></td>";
																			if ($comprobante == "") {
																				echo "<td></td>";
																			} else {
																				echo "<td><a class='btn btn-outline-success rounded-11 btn-sm mr-2' href='uploads/Comprobantes/" . $comprobante . "' target='_blank'><i class='fa fa-file'></i></a></td>";
																			}

																			echo "<td>";
																			echo "<a class='btn btn-outline-danger rounded-11 btn-sm mr-2' onclick='eliminarvacaciones(" . $key->getId() . ")' class='btn btn-primary'><i class='fa fa-trash'></i></a>";
																			echo "</td>";
																			echo "<td>";
																			echo "<a class='btn btn-outline-success rounded-11 btn-sm mr-2' data-toggle='modal' data-target='#modalcargarcomprobante' onclick='cargarcomprobante(" . $key->getId() . ")' class='btn btn-primary'><i class='fa fa-upload'></i></a>";
																			echo "</td>";
																			//Sacar Fecha y hora en formato humano
																			echo "<td>" . date("d-m-Y H:i:s", strtotime($registro)) . "</td>";

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
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-7" class="accordion-toggle bg-purple text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Licencias Medicas</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-7" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<a href="licenciamedica.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar Licencia Medica</a>
														</div>

														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example8">
																<thead>
																	<tr>
																		<td>Folio</td>
																		<td>Tipo Licencia</td>
																		<td>F. Inicio</td>
																		<td>F. Termino</td>
																		<td>Total Días</td>
																		<td>Rut Entidad Pagadora</td>
																		<td>Institución Pagadora</td>
																		<td>Obs</td>
																		<td>Doc. Licencia</td>
																		<td>Comp. Tramite</td>
																		<td>Accion</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$id = $_SESSION['TRABAJADOR_ID'];
																	$lista = $c->listarlicencias($id);
																	foreach ($lista as $key) {
																		//Cambiar formato de fecha a dd/mm/aaaa
																		$fecha_inicio = $key->getFechainicio();
																		$fecha_termino = $key->getFechafin();
																		$fecha_inicio = date("d-m-Y", strtotime($fecha_inicio));
																		$fecha_termino = date("d-m-Y", strtotime($fecha_termino));
																		$institucion = $key->getPagadora();
																		$comentario = $key->getComentario();
																		$documentolicencia = $key->getDocumentolicencia();
																		$comprobantetramite = $key->getComprobantetramite();
																		$id = $key->getId();
																		echo "<tr>";
																		echo "<td>" . $key->getFolio() . "</td>";
																		echo "<td>" . $key->getTipolicencia() . "</td>";
																		echo "<td>" . $fecha_inicio . "</td>";
																		echo "<td>" . $fecha_termino . "</td>";
																		//Calculo de dias
																		$datetime1 = new DateTime($fecha_inicio);
																		$datetime2 = new DateTime($fecha_termino);
																		$interval = $datetime1->diff($datetime2);
																		$dias = $interval->format('%a');
																		echo "<td>" . $dias . "</td>";
																		echo "<td>" . $key->getRegistro() . "</td>";
																		echo "<td>" . $institucion . "</td>";
																		echo "<td>" . $comentario . "</td>";
																		echo "<td><a class='btn btn-outline-success rounded-11 btn-sm mr-2' href='uploads/" . $documentolicencia . "' target='_blank'><i class='fa fa-file'></i></a></td>";
																		echo "<td><a class='btn btn-outline-success rounded-11 btn-sm mr-2' href='uploads/" . $comprobantetramite . "' target='_blank'><i class='fa fa-file'></i></a></td>";
																		echo "<td>";
																		echo "<a class='btn btn-outline-warning rounded-11 btn-sm mr-2' href='licenciamedicaedit.php?code=" . $id . "' class='btn btn-primary'><i class='fa fa-pen'></i></a>";
																		echo "<a class='btn btn-outline-danger rounded-11 btn-sm mr-2' onclick='eliminarlicencia(" . $id . ")' class='btn btn-primary'><i class='fa fa-trash'></i></a>";
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
										<?php
											}
										}
										?>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-doc" class="accordion-toggle bg-danger text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Otros Documentos</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-doc" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right">
															<?php
															$estado = $c->estadocontrato($_SESSION['TRABAJADOR_ID']);
															if ($estado == true) {
															?>
																<a href="documentospersonalizados.php?code=<?php echo $id;?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Nuevo Documento </a>
															<?php
															}
															?>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example9">
																<thead>
																	<tr>
																		<td>Fecha de Generación</td>
																		<td>Tipo de Documento</td>
																		<td>Documento</td>
																		<td>Eliminar</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$notifi = $c->listardocumentostext($_SESSION['TRABAJADOR_ID']);
																	if ($notifi != null) {
																		foreach ($notifi as $notificacion) {
																			echo "<tr>";
																			echo "<td>" . $notificacion->getFechageneracion() . "</td>";
																			echo "<td>" . $notificacion->getTipodocumento() . "</td>";
																			echo "<td><a href='uploads/documentos/" . $notificacion->getDocumento() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-pdf-o'></i></a></td>";
																			echo "<td><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminardocumento(" . $notificacion->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																			echo "</tr>";
																		}
																	}
																	?>
																</tbody>
															</table>

														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
										if (isset($_SESSION['GESTION_PERMISO']) || $plan==2) {
											if ($_SESSION['GESTION_PERMISO'] == true || $plan==2) {
										?>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-an" class="accordion-toggle bg-warning text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Anotaciones</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-an" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right mb-4"><?php
																								$estado = $c->estadocontrato($_SESSION['TRABAJADOR_ID']);
																								if ($estado == true) {
																								?>
																<a href="anotaciones.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Nueva Anotacion </a>
															<?php
																								}
															?>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 table-responsive">
															<table class="table w-100 table-hover table-bordered" id="example10">
																<thead>
																	<tr>
																		<td>Tipo Anotacion</td>
																		<td>Ver</td>
																		<td>Eliminar</td>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$anotaciones = $c->listarporanotacion($_SESSION['TRABAJADOR_ID']);
																	if (count($anotaciones) > 0) {
																		foreach ($anotaciones as $anotacion) {
																			echo "<tr>";
																			echo "<td>" . $anotacion->getTipoanotacion() . "</td>";
																			echo "<td><button class='btn btn-outline-primary btn-sm rounded-11' data-toggle='modal' data-target='#modalanotacion' onclick='mostraranotacion(" . $anotacion->getId() . ")'><i class='fa fa-eye'></i></button></td>";
																			echo "<td><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminaranotacion(" . $anotacion->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																			echo "</tr>";
																		}
																	}
																	?>
																</tbody>

															</table>

														</div>
													</div>

												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingOne-3" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapse-docsub" class="accordion-toggle bg-info text-white collapsed" data-parent="#accordion"><i class="fe fe-arrow-right mr-2"></i>Documentos Subidos</a>
											</div>
											<div aria-labelledby="headingOne-3" class="collapse" data-parent="#accordion" id="collapse-docsub" role="tabpanel">
												<div class="card-body">
													<div class="row">
														<div class="col-md-12 text-right mb-4">
															<a href="documentoficha.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Subir Documento </a>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 table-responsive">
														<table class="table w-100 table-hover table-bordered" id="example11">
															<thead>
																<tr>
																	<td>Titulo</td>
																	<td>Tipo</td>
																	<td>Observacion</td>
																	<td>Documento</td>
																	<td>Registro</td>
																	<td>Eliminar</td>
																</tr>
															</thead>
															<tbody>
																<?php
																$anotaciones = $c->listardocumentossubidos($_SESSION['TRABAJADOR_ID']);
																if (count($anotaciones) > 0) {
																	foreach ($anotaciones as $anotacion) {
																		echo "<tr>";
																		echo "<td>" . $anotacion->getTitulo() . "</td>";
																		echo "<td>" . $anotacion->getTipo() . "</td>";
																		echo "<td>" . $anotacion->getComentario() . "</td>";
																		echo "<td><a href='uploads/documentosubido/" . $anotacion->getDocumento() . "' target='_blank' class='btn btn-outline-primary btn-sm rounded-11'><i class='fa fa-eye'></i></a></td>";
																		$fecha = date_create($anotacion->getFecha());
																		echo "<td>" . date_format($fecha, 'd-m-Y') . "</td>";
																		echo "<td><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminardocumentosubido(" . $anotacion->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																		echo "</tr>";
																	}
																}
																?>
															</tbody>

														</table>

													</div>
												</div>

											</div>
										</div>
										<?php
											}
										}
										?>
									</div>
								</div>


								<!-- accordion -->
							</div>
						</div>
					</div>
				</div>
				<!-- End Row -->

				<div class="row">
					<div class="col-md-12">
						<a href="trabajadores.php" class="btn btn-danger"><i class="fa fa-arrow-left"> Volver</i></a>
					</div>

				</div>


			</div>
		</div>
	</div>
	<!-- End Main Content-->

	<!-- Main Footer-->
	<div class=" main-footer text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<span>Copyright © 2022 - KaiserTech Todos los derechos reservados.</span>
				</div>
			</div>
		</div>
	</div>
	<!--End Footer-->

	<!-------------------------modalcargarcomprobante-------------------------------------------->
	<!-- Modal -->
	<div class="modal fade" id="modalcargarcomprobante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Cargar Comprobante Firmado</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formcargarcomp">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<p>Comprobante Firmado</p>
										<input type="file" name="documentocom" id="documentocom" class="dropify" data-height="200" required />
										<input type="hidden" name="idvacaciones" id="idvacaciones" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-arrow-left"></i> Volver</button>
						<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal TipoContrato-->
	<div class="modal fade" id="modal-detalle-finiquito" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Detalle Finiquito</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-4 detallefin">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Sidebar -->
	<div class="sidebar sidebar-right sidebar-animate">
		<div class="sidebar-icon">
			<a href="#" class="text-right float-right text-dark fs-20" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x"></i></a>
		</div>
	</div>
	<!-- End Sidebar -->

	</div>
	<!-- End Page -->

	<!-- Modal Anotacion-->
	<div class="modal fade" id="modalanotacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Anotación</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-0 pt-1">
							<div class="row">
								<div class="col-md-12" id="anot">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Anotacion-->
	<div class="modal fade" id="modalanexos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Anexos de Contrato</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card" id="transcation-crypto-1">
						<div class="card-body p-0 pt-1">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover w-100">
										<thead>
											<tr>
												<td>Fecha Generacion</td>
												<td>Sueldo Base</td>
												<td>Estado</td>
												<td>Documento</td>
												<td>Eliminar</td>
											</tr>
										</thead>
										<tbody id="anexos">
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
	<script src="assets/js/select2.js"></script>

	<!-- Internal TelephoneInput js-->
	<script src="assets/plugins/telephoneinput/telephoneinput.js"></script>
	<script src="assets/plugins/telephoneinput/inttelephoneinput.js"></script>
	<!-- Internal Data Table js -->
	<script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
	<script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
	<script src="assets/js/table-data.js"></script>


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

	<script>
		$(document).ready(function(){
			mostrarEmpresa();
		});
	</script>
</body>

</html>