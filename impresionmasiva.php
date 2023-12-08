<?php
require 'php/controller.php';
$c = new Controller();
?>
<?php
session_start();
unset($_SESSION['TRABJADOR_CONTRATO']);
$_SESSION['TRABJADOR_ID'] = 0;
unset($_SESSION['TRABAJADOR_ID']);
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
} else {
	header("Location: index.php");
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
	<title>Gestor de Documentos | Impresión Masiva</title>

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
					<img src="assets/img/brand/dark-logo.png" class="header-brand-img desktop-logo theme-logo"
						alt="logo">
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
						<a href="index.php"><img src="assets/img/brand/dark-logo.png" class="mobile-logo"
								alt="logo"></a>
						<a href="index.php"><img src="assets/img/brand/logo.png" class="mobile-logo-dark"
								alt="logo"></a>
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
							<i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
									viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path
										d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
								</svg></i>
							<i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
									viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path
										d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
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
									?>
								</h6>
							</div>
							<a class="dropdown-item" href="close.php">
								<i class="fe fe-power"></i> Cerrar Sesíon
							</a>
						</div>
					</div>
					<button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
						aria-expanded="false" aria-label="Toggle navigation">
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
							<a class="nav-link icon full-screen-link fullscreen-button" href=""><i
									class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
										viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none" />
										<path
											d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
									</svg></i>
								<i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
										viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none" />
										<path
											d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
									</svg></i>
							</a>
						</div>
						<div class="dropdown main-profile-menu">
							<a class="d-flex" href="#">
								<span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
							</a>
							<div class="dropdown-menu">
								<div class="header-navheading">
									<h6 class="main-notification-title">
										<?php echo $_SESSION['USER_NAME']; ?>
									</h6>
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
							<h1 class="main-content-title tx-30">Impresión Documentos</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>

					<!-- Row -->
					<div class="row d-none">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Basic Style Accordion</h6>
										<p class="text-muted card-sub-title">The default collapse behavior to create an
											accordion.</p>
									</div>
									<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
										<div class="card">
											<div class="card-header" id="headingOne" role="tab">
												<a aria-controls="collapseOne" aria-expanded="true"
													data-toggle="collapse" href="#collapseOne">Making a Beautiful CSS3
													Button Set</a>
											</div>
											<div aria-labelledby="headingOne" class="collapse show"
												data-parent="#accordion" id="collapseOne" role="tabpanel">
												<div class="card-body">
													A concisely coded CSS3 button set increases usability across the
													board, gives you a ton of options, and keeps all the code involved
													to an absolute minimum. Anim pariatur cliche reprehEnderit, enim
													eiusmod high life accusamus terry richardson ad squid. 3 wolf moon
													officia aute, non cupidatat skateboard dolor brunch.
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingTwo" role="tab">
												<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed"
													data-toggle="collapse" href="#collapseTwo">Horizontal Navigation
													Menu Fold Animation</a>
											</div>
											<div aria-labelledby="headingTwo" class="collapse" data-parent="#accordion"
												id="collapseTwo" role="tabpanel">
												<div class="card-body">
													Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus
													terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
													skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
													Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
													single-origin coffee nulla assumEnda shoreditch et. Nihil anim
													keffiyeh helvetica, craft beer labore.
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingThree" role="tab">
												<a aria-controls="collapseThree" aria-expanded="false" class="collapsed"
													data-toggle="collapse" href="#collapseThree">Creating CSS3 Button
													with Rounded Corners</a>
											</div>
											<div aria-labelledby="headingThree" class="collapse"
												data-parent="#accordion" id="collapseThree" role="tabpanel">
												<div class="card-body">
													Anim pariatur cliche reprehEnderit, enim eiusmod high life accusamus
													terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
													skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
													Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
													single-origin coffee nulla assumEnda shoreditch et. Nihil anim
													keffiyeh helvetica, craft beer labore.
												</div>
											</div><!-- collapse -->
										</div>
									</div><!-- accordion -->
								</div>
							</div>
						</div>
					</div>
					<!-- End Row -->
					<!-- ROW- opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card" id="tab">
								<div class="card-body">
									<div class="text-wrap">
										<div class="example">
											<div class="border">
												<div class="bg-light-1 nav-bg">
													<nav class="nav nav-tabs">
														<a class="nav-link active" data-toggle="tab"
															href="#tabCont1">Contratos</a>
														<a class="nav-link" data-toggle="tab"
															href="#tabCont2">Finiquitos</a>
														<a class="nav-link" data-toggle="tab"
															href="#tabCont3">Notificaciones</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont4">Otros
															Documentos</a>
													</nav>
												</div>
												<div class="card-body tab-content">
													<div class="tab-pane active show" id="tabCont1">
														<!-- Row -->
														<div class="row">
															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div aria-multiselectable="true"
																			class="accordion">
																			<?php
																			$lista = $c->listarlotescontrato($_SESSION['CURRENT_ENTERPRISE']);
																			foreach ($lista as $object) {
																				$lista1 = $c->listarlotestext2($object->getId());
																				if (count($lista1) > 0) {
																					$lotenobre = $object->getNombre_lote();
																					//Borrar el resto del texto despues del _
																					$pos = strpos($lotenobre, "_");
																					if ($pos === false) {
																					} else {
																						$lotenobre = substr($lotenobre, 0, $pos);
																					}

																					?>
																					<div class="card accordion-item">
																						<div class="card-header accordion-header"
																							id="headingOne-1" role="tab">
																							<a aria-controls="collapseOne"
																								aria-expanded="true"
																								data-toggle="collapse"
																								href="#collapse-<?php echo $object->getId() ?>"
																								class="accordion-toggle bg-primary text-white collapsed"
																								data-parent="#accordion"><i
																									class="fe fe-arrow-right mr-2"></i>
																								<?php echo $lotenobre; ?>
																							</a>
																						</div>
																						<div aria-labelledby="headingOne-1"
																							class="collapse"
																							data-parent="#accordion"
																							id="collapse-<?php echo $object->getId() ?>"
																							role="tabpanel">
																							<div class="card-body">
																								<div class="row mb-4">
																									<div
																										class="col-md-12 text-right mt-2">
																										<a target="_blank"
																											href="php/report/impresioncontratos.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-print"></i>
																											Imprimir Todo</a>
																										<a target="_blank"
																											href="php/report/inscipcionfaenaall.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-file-excel"></i>
																											Inscripcion Faena</a>
																										<button
																											onclick="eliminartodoccontrato(<?php echo $object->getId(); ?>)"
																											class="btn btn-danger"><i
																												class="fa fa-trash-alt"></i>
																											Eliminar
																											Lote</button>
																									</div>
																								</div>
																								<div class="table-responsive">
																									<table
																										class="table w-100 text-nowrap table-lote">
																										<thead
																											class="border-top">
																											<tr>
																												<th
																													class="bg-transparent">
																													Contrato
																												</th>
																												<th
																													class="bg-transparent">
																													Trabajador
																												</th>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-plus"></i>
																													Agregar
																												</th>
																												<td class='text-center'>Inscripcion Faena</td>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-print"></i>
																													Imprimir
																												</th>
																											</tr>
																										</thead>
																										<tbody>
																											<?php
																											foreach ($lista1 as $object1) {
																												echo "<tr class='border-bottom-0'>";
																												echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
																												echo $object1->getContrato();
																												echo "</td>";
																												echo "<td class='text-muted fs-15 font-weight-semibold'>";
																												echo $object1->getTrabajador();
																												echo "</td>";
																												echo "<td class='text-center'>";
																												echo "<a class='btn btn-outline-info btn-sm rounded-11' onclick='addcart(1," . $object1->getFecha_fin() . ",\"" . $object1->getContrato() . "\",\"" . $object1->getTrabajador() . "\",\"" . $object1->getFecha_inicio() . "\")' data-toggle='tooltip' data-original-title='Agregar'>";
																												echo "<i class='fa fa-plus'>";
																												echo "</i>";
																												echo "</a>";
																												echo "</td>";
																												echo "<td class='text-center'><a class='btn btn-outline-success btn-sm rounded-11' target='_blank' href='php/report/inscripcionfaena.php?id=" . $object1->getFecha_fin() . "'><i class='fa fa-file-excel'></i></a></td>";

																												echo "<td class='text-center'>";
																												echo "<a class='btn btn-outline-success btn-sm rounded-11' href='uploads/Contratos/" . $object1->getFecha_inicio() . "' target='_blank' data-toggle='tooltip' data-original-title='Imprimir'>";
																												echo "<i class='fa fa-print'>";
																												echo "</i>";
																												echo "</a>";
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
																					<?php
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>

														</div>
														<!-- End Row -->
													</div>
													<div class="tab-pane" id="tabCont2">
														<!-- Row -->
														<div class="row">
															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div aria-multiselectable="true"
																			class="accordion">
																			<?php
																			$lista = $c->listarlotescontrato($_SESSION['CURRENT_ENTERPRISE']);
																			foreach ($lista as $object) {
																				$lista1 = $c->listarlotestext1($object->getId());
																				if (count($lista1) > 0) {
																					$lotenobre = $object->getNombre_lote();
																					//Borrar el resto del texto despues del _
																					$pos = strpos($lotenobre, "_");
																					if ($pos === false) {
																					} else {
																						$lotenobre = substr($lotenobre, 0, $pos);
																					}
																					?>
																					<div class="card accordion-item">
																						<div class="card-header accordion-header"
																							id="headingOne-1" role="tab">
																							<a aria-controls="collapseOne"
																								aria-expanded="true"
																								data-toggle="collapse"
																								href="#collapse-<?php echo ($object->getId() + 1) ?>"
																								class="accordion-toggle bg-primary text-white collapsed"
																								data-parent="#accordion"><i
																									class="fe fe-arrow-right mr-2"></i>
																								<?php echo $lotenobre; ?>
																							</a>
																						</div>
																						<div aria-labelledby="headingOne-1"
																							class="collapse"
																							data-parent="#accordion"
																							id="collapse-<?php echo ($object->getId() + 1) ?>"
																							role="tabpanel">
																							<div class="card-body">
																								<div class="row">
																									<div
																										class="col-md-12 text-right mb-2">
																										<a target="_blank"
																											href="php/report/impresionfiniquitos.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-print"></i>
																											Imprimir Todo</a>
																										<button
																											onclick="eliminartodofiniquito(<?php echo $object->getId(); ?>)"
																											class="btn btn-danger"><i
																												class="fa fa-trash-alt"></i>
																											Eliminar
																											Lote</button>
																									</div>
																								</div>
																								<div class="table-responsive">
																									<table
																										class="table w-100 text-nowrap table-lote">
																										<thead
																											class="border-top">
																											<tr>
																												<th
																													class="bg-transparent">
																													Contrato
																												</th>
																												<th
																													class="bg-transparent">
																													Fecha
																													Termino</th>
																												<th
																													class="bg-transparent">
																													Trabajador
																												</th>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-print"></i>
																													Agregar
																												</th>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-print"></i>
																													Imprimir
																												</th>
																											</tr>
																										</thead>
																										<tbody>
																											<?php
																											foreach ($lista1 as $object1) {
																												echo "<tr class='border-bottom-0'>";
																												echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
																												$fecha = $object1->getFecha_inicio();
																												//Convertir fecha en formato dd-mm-YYYY
																												$fecha = date("d-m-Y", strtotime($fecha));
																												$fechatermino = $object1->getFecha_fin();
																												//Convertir fecha en formato dd-mm-YYYY
																												$fechatermino = date("d-m-Y", strtotime($fechatermino));

																												echo $object1->getContrato() . " - " . $fecha;
																												echo "</td>";
																												echo "<td class='text-muted fs-15 font-weight-semibold'>";
																												echo $fechatermino;
																												echo "</td>";
																												echo "<td class='text-muted fs-15 font-weight-semibold'>";
																												echo $object1->getTrabajador();
																												echo "</td>";
																												echo "<td class='text-center'>";
																												echo "<a class='btn btn-outline-success btn-sm rounded-11' onclick='addcart1(2," . $object1->getNombre_lote() . ",\"" . $object1->getContrato() . "\",\"" . $object1->getFecha_fin() . "\",\"" . $object1->getTrabajador() . "\",\"" . $object1->getFecha_inicio() . "\")' data-toggle='tooltip' data-original-title='Agregar'>";
																												echo "<i class='fa fa-print'>";
																												echo "</i>";
																												echo "</a>";
																												echo "</td>";
																												echo "<td class='text-center'>";
																												echo "<a class='btn btn-outline-success btn-sm rounded-11' href='php/pdf/finiquito.php?id=" . $object1->getNombre_lote() . "' target='_blank' data-toggle='tooltip' data-original-title='Imprimir'>";
																												echo "<i class='fa fa-print'>";
																												echo "</i>";
																												echo "</a>";
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
																					<?php
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>

														</div>
														<!-- End Row -->
													</div>
													<div class="tab-pane" id="tabCont3">
														<!-- Row -->
														<!-- Row -->
														<div class="row">
															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div aria-multiselectable="true"
																			class="accordion">
																			<?php
																			$lista = $c->listarlotescontrato($_SESSION['CURRENT_ENTERPRISE']);
																			foreach ($lista as $object) {
																				$lista1 = $c->listarlotestext4($object->getId());
																				if (count($lista1) > 0) {
																					$lotenobre = $object->getNombre_lote();
																					//Borrar el resto del texto despues del _
																					$pos = strpos($lotenobre, "_");
																					if ($pos === false) {
																					} else {
																						$lotenobre = substr($lotenobre, 0, $pos);
																					}
																					?>
																					<div class="card accordion-item">
																						<div class="card-header accordion-header"
																							id="headingOne-1" role="tab">
																							<a aria-controls="collapseOne"
																								aria-expanded="true"
																								data-toggle="collapse"
																								href="#collapse-<?php echo ($object->getId() + 1) ?>"
																								class="accordion-toggle bg-primary text-white collapsed"
																								data-parent="#accordion"><i
																									class="fe fe-arrow-right mr-2"></i>
																								<?php echo $lotenobre; ?>
																							</a>
																						</div>
																						<div aria-labelledby="headingOne-1"
																							class="collapse"
																							data-parent="#accordion"
																							id="collapse-<?php echo ($object->getId() + 1) ?>"
																							role="tabpanel">
																							<div class="card-body">
																								<div class="row">
																									<div
																										class="col-md-12 text-right mb-2">
																										<a target="_blank"
																											href="php/report/impresionnotificaciones.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-print"></i>
																											Imprimir Todo</a>
																										<a target="_blank"
																											href="php/report/impresionnotificacionescsv.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-file-excel-o"></i>
																											Imprimir Todo
																											XLS</a>
																										<a target="_blank"
																											href="php/report/retiropreviredall.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-file-excel-o"></i>
																											Retiro Previred</a>
																										<button
																											onclick="eliminartodonotificacion(<?php echo $object->getId(); ?>)"
																											class="btn btn-danger"><i
																												class="fa fa-trash-alt"></i>
																											Eliminar
																											Lote</button>
																									</div>
																								</div>
																								<div class="table-responsive">
																									<table
																										class="table w-100 text-nowrap table-lote">
																										<thead
																											class="border-top">
																											<tr>
																												<th
																													class="bg-transparent">
																													Trabajador
																												</th>
																												<th
																													class="bg-transparent">
																													Fecha
																													Notificacion
																												</th>
																												<th
																													class="bg-transparent">
																													Comunicacion
																												</th>
																												<th
																													class="bg-transparent text-center">
																													PDF</th>
																												<th
																													class="bg-transparent text-center">
																													XLS</th>
																												<th
																													class="bg-transparent text-center">
																													Retiro Previred</th>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-print"></i>
																													Agregar
																												</th>
																												<th
																													class="bg-transparent text-center">
																													<i
																														class="fa fa-print"></i>
																													Eliminar
																												</th>
																											</tr>
																										</thead>
																										<tbody>
																											<?php
																											foreach ($lista1 as $notificacion) {
																												echo "<tr>";
																												echo "<td>" . $notificacion->getRegistro() . "</td>";
																												echo "<td>" . $notificacion->getFechanotificacion() . "</td>";
																												echo "<td>" . $notificacion->getComunicacion() . "</td>";
																												echo "<td class='text-center'><a href='php/pdf/notificacion.php?id=" . $notificacion->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-print'></i></a></td>";
																												echo "<td class='text-center'><a href='php/pdf/notificacioncsv.php?id=" . $notificacion->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-excel-o'></i></a></td>";
																												echo "<td class='text-center'><a href='php/report/retiroprevired.php?id=" . $notificacion->getId() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-file-excel-o'></i></a></td>";
																												echo "<td class='text-center'><a class='btn btn-outline-info btn-sm rounded-11' onclick='addcart2(3," . $notificacion->getId() . ",\"" . $notificacion->getRegistro() . "\",\"" . $notificacion->getFechanotificacion() . "\",\"" . $notificacion->getCausal() . "\",\"" . $notificacion->getComunicacion() . "\")' data-toggle='tooltip' data-original-title='Agregar'><i class='fa fa-plus'></i></a></td>";
																												echo "<td class='text-center'><button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminarnotificacion(" . $notificacion->getId() . ")'><i class='fa fa-trash'></i></button></td>";
																												echo "</tr>";

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
																</div>
															</div>

														</div>
														<!-- End Row -->
														<!-- End Row -->
													</div>
													<div class="tab-pane" id="tabCont4">
														<div class="row">

															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div aria-multiselectable="true"
																			class="accordion">
																			<?php
																			$lista = $c->listarlotescontrato($_SESSION['CURRENT_ENTERPRISE']);
																			foreach ($lista as $object) {
																				$lista1 = $c->listarlotestext5($object->getId());
																				if (count($lista1) > 0) {
																					$lotenobre = $object->getNombre_lote();
																					//Borrar el resto del texto despues del _
																					$pos = strpos($lotenobre, "_");
																					if ($pos === false) {
																					} else {
																						$lotenobre = substr($lotenobre, 0, $pos);
																					}

																					?>
																					<div class="card accordion-item">
																						<div class="card-header accordion-header"
																							id="headingOne-1" role="tab">
																							<a aria-controls="collapseOne"
																								aria-expanded="true"
																								data-toggle="collapse"
																								href="#collapse-<?php echo $object->getId() ?>"
																								class="accordion-toggle bg-primary text-white collapsed"
																								data-parent="#accordion"><i
																									class="fe fe-arrow-right mr-2"></i>
																								<?php echo $lotenobre; ?>
																							</a>
																						</div>
																						<div aria-labelledby="headingOne-1"
																							class="collapse"
																							data-parent="#accordion"
																							id="collapse-<?php echo $object->getId() ?>"
																							role="tabpanel">
																							<div class="card-body">
																								<div class="row mb-4">
																									<div
																										class="col-md-12 text-right mt-2">
																										<a target="_blank"
																											href="php/report/impresiondocumentos.php?id=<?php echo $object->getId(); ?>"
																											class="btn btn-success"><i
																												class="fa fa-print"></i>
																											Imprimir Todo</a>
																										<button
																											onclick="eliminartododocumento(<?php echo $object->getId(); ?>)"
																											class="btn btn-danger"><i
																												class="fa fa-trash-alt"></i>
																											Eliminar
																											Lote</button>
																									</div>
																								</div>
																								<div class="table-responsive">
																									<table
																										class="table w-100 text-nowrap table-lote">
																										<thead>
																											<tr>
																												<td>RUT</td>
																												<td>Trabajador
																												</td>
																												<td>Fecha de
																													Generación
																												</td>
																												<td>Tipo de
																													Documento
																												</td>
																												<td>Documento
																												</td>
																												<td
																													class='text-center'>
																													Agregar</td>
																												<td
																													class='text-center'>
																													Eliminar
																												</td>
																											</tr>
																										</thead>
																										<tbody>
																											<?php
																											foreach ($lista1 as $object1) {
																												echo "<tr class='border-bottom-0'>";
																												echo "<td>" . $object1->getEmpresa() . "</td>";
																												echo "<td>" . $object1->getTrabajador() . "</td>";
																												echo "<td>" . $object1->getFechageneracion() . "</td>";
																												echo "<td>" . $object1->getTipodocumento() . "</td>";
																												echo "<td><a href='uploads/documentos/" . $object1->getDocumento() . "' target='_blank' class='btn btn-outline-success btn-sm rounded-11'><i class='fa fa-print'></i></a></td>";
																												echo "<td class='text-center'>";
																												echo "<a class='btn btn-outline-info btn-sm rounded-11' onclick='addcart3(4," . $object1->getId() . ",\"" . $object1->getEmpresa() . "\",\"" . $object1->getTrabajador() . "\",\"" . $object1->getFechageneracion() . "\",\"" . $object1->getTipodocumento() . "\",\"" . $object1->getDocumento() . "\")' data-toggle='tooltip' data-original-title='Agregar'>";
																												echo "<i class='fa fa-plus'>";
																												echo "</i>";
																												echo "</a>";
																												echo "</td>";
																												echo "<td class='text-center'>";
																												echo "<button class='btn btn-outline-danger btn-sm rounded-11' onclick='eliminardocumento(" . $object1->getId() . ")'><i class='fa fa-trash'></i></button>";
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
																					<?php
																				}
																			}
																			?>
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
					<!-- ROW-4 END -->

					<div class="row objetos mt-2">

					</div>


					<div class="row objetos1 mt-2">

					</div>

					<div class="row objetos2 mt-2">

					</div>

					<div class="row objetos3 mt-2">

					</div>

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

	<!-- Back-to-top -->
	<a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
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
	<script src="JsFunctions/Trabajadores.js"></script>
	<script src="JsFunctions/masiva.js"></script>

	<script>
		$(document).ready(function () {
			mostrarEmpresa();
			$(".table-lote").DataTable({
				"responsive": true,
				"autoWidth": false,
				"language": {
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"zeroRecords": "No se encontraron resultados en su busqueda",
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
				"lengthMenu": [5, 10, 20, 50, 100],
				"iDisplayLength": 5,
			});
		});
	</script>

	<script>
		function mas(id) {
			$.ajax({
				type: "POST",
				url: "php/cargar/mas.php",
				data: {
					id: id
				},
				success: function (data) {
					window.location.href = "menuinfo.php";
				}
			});
		}
	</script>
</body>

</html>