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
	$valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
unset($_SESSION['TRABJADOR_CONTRATO']);
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
	<title>Gestor de Documentos | Procesar Trabajadores</title>

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
							<h1 class="main-content-title tx-30">Procesamiento de Liquidaciones</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
								<li class="breadcrumb-item active">Procesamiento</li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->


					<!-- Custom Styles for Dashboard -->
					<style>
						.kpi-card {
							border-radius: 15px;
							padding: 25px;
							color: white;
							position: relative;
							overflow: hidden;
							box-shadow: 0 4px 15px rgba(0,0,0,0.15);
							transition: transform 0.3s ease, box-shadow 0.3s ease;
						}
						.kpi-card:hover {
							transform: translateY(-5px);
							box-shadow: 0 8px 25px rgba(0,0,0,0.2);
						}
						.kpi-card .kpi-icon {
							position: absolute;
							right: 20px;
							top: 50%;
							transform: translateY(-50%);
							font-size: 4rem;
							opacity: 0.2;
						}
						.kpi-card .kpi-number {
							font-size: 2.5rem;
							font-weight: 700;
							margin-bottom: 5px;
						}
						.kpi-card .kpi-title {
							font-size: 0.95rem;
							font-weight: 500;
							text-transform: uppercase;
							letter-spacing: 1px;
							opacity: 0.9;
						}
						.kpi-blue {
							background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
						}
						.kpi-orange {
							background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
						}
						.kpi-green {
							background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
						}
						.dashboard-panel {
							background: #fff;
							border-radius: 15px;
							box-shadow: 0 2px 10px rgba(0,0,0,0.08);
							overflow: hidden;
							height: 100%;
						}
						.panel-header {
							padding: 18px 25px;
							color: white;
							font-weight: 600;
							font-size: 1.1rem;
							display: flex;
							justify-content: space-between;
							align-items: center;
						}
						.panel-header-left {
							background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
						}
						.panel-header-right {
							background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
						}
						.panel-body {
							padding: 20px;
						}
						.panel-footer {
							padding: 20px 25px;
							background: #f8f9fa;
							border-top: 1px solid #eee;
						}
						.clean-table {
							width: 100%;
						}
						.clean-table thead th {
							background: #f8f9fa;
							color: #6c757d;
							font-weight: 600;
							font-size: 0.85rem;
							text-transform: uppercase;
							letter-spacing: 0.5px;
							padding: 12px 15px;
							border-bottom: 2px solid #e9ecef;
						}
						.clean-table tbody tr {
							border-bottom: 1px solid #f1f1f1;
							transition: background 0.2s ease;
						}
						.clean-table tbody tr:hover {
							background: #f8f9fa;
						}
						.clean-table tbody td {
							padding: 12px 15px;
							vertical-align: middle;
							color: #495057;
						}
						.btn-add-circle {
							width: 32px;
							height: 32px;
							border-radius: 50%;
							padding: 0;
							display: inline-flex;
							align-items: center;
							justify-content: center;
							font-size: 14px;
							transition: all 0.3s ease;
						}
						.btn-add-circle:hover {
							transform: scale(1.15);
						}
						.btn-remove-circle {
							width: 32px;
							height: 32px;
							border-radius: 50%;
							padding: 0;
							display: inline-flex;
							align-items: center;
							justify-content: center;
							font-size: 14px;
							background: #dc3545;
							border: none;
							color: white;
							transition: all 0.3s ease;
						}
						.btn-remove-circle:hover {
							background: #c82333;
							transform: scale(1.15);
						}
						.btn-process-main {
							width: 100%;
							padding: 15px;
							font-size: 1.1rem;
							font-weight: 600;
							border-radius: 10px;
							background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
							border: none;
							color: white;
							transition: all 0.3s ease;
							box-shadow: 0 4px 15px rgba(17,153,142,0.3);
						}
						.btn-process-main:hover {
							transform: translateY(-2px);
							box-shadow: 0 6px 20px rgba(17,153,142,0.4);
							color: white;
						}
						.btn-danger-main {
							width: 100%;
							padding: 12px;
							font-size: 0.95rem;
							font-weight: 600;
							border-radius: 10px;
							background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
							border: none;
							color: white;
							transition: all 0.3s ease;
						}
						.btn-danger-main:hover {
							transform: translateY(-2px);
							box-shadow: 0 4px 15px rgba(235,51,73,0.3);
							color: white;
						}
						.filter-compact {
							background: #fff;
							border-radius: 10px;
							padding: 15px 20px;
							box-shadow: 0 2px 8px rgba(0,0,0,0.06);
							margin-bottom: 20px;
						}
						.filter-compact label {
							font-size: 0.8rem;
							font-weight: 600;
							color: #6c757d;
							text-transform: uppercase;
							letter-spacing: 0.5px;
							margin-bottom: 5px;
						}
						.filter-compact .form-control {
							border-radius: 8px;
							border: 1px solid #e0e0e0;
							font-size: 0.9rem;
						}
						.switch-container {
							background: #fff;
							border-radius: 10px;
							padding: 15px;
							margin-bottom: 15px;
							border: 1px solid #e9ecef;
						}
						.custom-switch-lg .custom-switch-indicator {
							width: 50px;
							height: 26px;
						}
						.custom-switch-lg .custom-switch-indicator::before {
							width: 22px;
							height: 22px;
						}
						.custom-switch-lg .custom-switch-input:checked ~ .custom-switch-indicator::before {
							left: 26px;
						}
						.empty-state {
							text-align: center;
							padding: 40px 20px;
							color: #adb5bd;
						}
						.empty-state i {
							font-size: 3rem;
							margin-bottom: 15px;
							opacity: 0.5;
						}
						.badge-count {
							background: rgba(255,255,255,0.2);
							padding: 5px 12px;
							border-radius: 20px;
							font-size: 0.85rem;
						}
					</style>

					<?php
					// Obtener datos para KPIs
					$lista = array();
					if (isset($_SESSION['COST_CENTER'])) {
						$lista = $c->listartrabajadoresactivoscenter($_SESSION['CURRENT_ENTERPRISE'], $_SESSION['COST_CENTER']);
					} else {
						$lista = $c->listartrabajadoresactivos($_SESSION['CURRENT_ENTERPRISE']);
					}
					$totalTrabajadores = count($lista);
					?>

					<!-- KPI Cards Row -->
					<div class="row mb-4">
						<div class="col-lg-4 col-md-4 mb-3">
							<div class="kpi-card kpi-blue">
								<i class="fa fa-users kpi-icon"></i>
								<div class="kpi-number" id="kpi-total"><?php echo $totalTrabajadores; ?></div>
								<div class="kpi-title">Total Trabajadores</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 mb-3">
							<div class="kpi-card kpi-orange">
								<i class="fa fa-clock kpi-icon"></i>
								<div class="kpi-number" id="kpi-pendientes">0</div>
								<div class="kpi-title">Pendientes</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 mb-3">
							<div class="kpi-card kpi-green">
								<i class="fa fa-check-circle kpi-icon"></i>
								<div class="kpi-number" id="kpi-procesados">0</div>
								<div class="kpi-title">Procesados</div>
							</div>
						</div>
					</div>

					<!-- Compact Filters Row -->
					<div class="filter-compact">
						<div class="row align-items-end">
							<div class="col-lg-3 col-md-4 mb-2 mb-lg-0">
								<label for="periodo">Periodo</label>
								<input type="month" name="periodo" id="periodo" class="form-control"
									value="<?php echo date("Y-m"); ?>">
							</div>
							<div class="col-lg-4 col-md-5 mb-2 mb-lg-0">
								<label for="centrocosto">Centro de Costo</label>
								<select name="centrocosto" id="centrocosto" class="form-control select2">
									<?php
									$centrocostos = $c->listarcentrocosto($_SESSION['CURRENT_ENTERPRISE']);
									foreach ($centrocostos as $centrocosto) {
										if (isset($_SESSION['COST_CENTER'])) {
											if ($centrocosto->getId() == $_SESSION['COST_CENTER']) {
												echo "<option value='" . $centrocosto->getId() . "' selected>" . $centrocosto->getNombre() . "</option>";
											} else {
												echo "<option value='" . $centrocosto->getId() . "'>" . $centrocosto->getNombre() . "</option>";
											}
										} else {
											echo "<option value='" . $centrocosto->getId() . "'>" . $centrocosto->getNombre() . "</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-lg-5 col-md-3">
								<button type="button" class="btn btn-primary mr-2" onclick="filtrartrabajadores()">
									<i class="fa fa-filter mr-1"></i> Filtrar
								</button>
								<?php if (isset($_SESSION['COST_CENTER'])) { ?>
									<button type="button" class="btn btn-outline-secondary" onclick="limpiarfiltro()">
										<i class="fa fa-times mr-1"></i> Limpiar
									</button>
								<?php } ?>
							</div>
						</div>
					</div>

					<!-- Main Two-Column Layout -->
					<div class="row">
						<!-- Left Column: Banco de Trabajadores (60%) -->
						<div class="col-xl-7 col-lg-7 col-md-12 mb-4">
							<div class="dashboard-panel">
								<div class="panel-header panel-header-left">
									<span><i class="fa fa-list mr-2"></i>Listado Disponible</span>
									<span class="badge-count"><?php echo $totalTrabajadores; ?> registros</span>
								</div>
								<div class="panel-body">
									<div class="d-flex justify-content-end mb-3">
										<button onclick="allwork()" class="btn btn-success btn-sm">
											<i class="fa fa-plus-circle mr-1"></i> Agregar Todos
										</button>
									</div>
									<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
										<table class="clean-table text-wrap w-100" id="example1">
											<thead>
												<tr>
													<th>RUT</th>
													<th>Nombre Completo</th>
													<th>Centro Costo</th>
													<th class="text-center">Accion</th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach ($lista as $object) {
													echo "<tr>";
													echo "<td class='font-weight-semibold'>";
													echo $object->getRut();
													echo "</td>";
													echo "<td>";
													echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2();
													echo "</td>";
													echo "<td class='text-muted'>";
													echo $object->getDiscapacidad();
													echo "</td>";
													echo "<td class='text-center'>";
													echo "<button class='btn btn-info btn-add-circle' onclick='agregartrabajador(" . $object->getId() . ",\"" . $object->getRut() . "\",\"" . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . "\"," . $object->getNacionalidad() . ")' title='Agregar'>";
													echo "<i class='fa fa-plus'></i>";
													echo "</button>";
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

						<!-- Right Column: Zona de Procesamiento (40%) -->
						<div class="col-xl-5 col-lg-5 col-md-12 mb-4">
							<div class="dashboard-panel">
								<div class="panel-header panel-header-right">
									<span><i class="fa fa-tasks mr-2"></i>Bandeja de Procesamiento</span>
									<span class="badge-count" id="badge-lote">0 seleccionados</span>
								</div>
								<div class="panel-body" style="min-height: 350px;">
									<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
										<table class="clean-table text-nowrap">
											<thead>
												<tr>
													<th>RUT</th>
													<th>Nombre</th>
													<th class="text-center">Quitar</th>
												</tr>
											</thead>
											<tbody id="lotes">
												<!-- Los trabajadores seleccionados aparecen aqui dinamicamente -->
											</tbody>
										</table>
									</div>
									<div class="empty-state" id="empty-lote">
										<i class="fa fa-inbox"></i>
										<p>No hay trabajadores en la bandeja</p>
										<small>Seleccione trabajadores del listado</small>
									</div>
								</div>
								<div class="panel-footer">
									<!-- Switch de Gratificacion -->
									<div class="switch-container">
										<label class="custom-switch custom-switch-lg mb-0">
											<input value="1" type="checkbox" id="gratificacion" name="gratificacion" class="custom-switch-input">
											<span class="custom-switch-indicator"></span>
											<span class="custom-switch-description ml-2" style="font-size: 0.95rem;">
												<strong>Aplica Gratificacion</strong>
											</span>
										</label>
									</div>

									<!-- Botones de Accion -->
									<button onclick="procesartodo()" class="btn btn-process-main mb-3">
										<i class="fa fa-cog mr-2"></i> PROCESAR LIQUIDACIONES
									</button>
									<button onclick="Eliminartodo()" class="btn btn-danger-main">
										<i class="fa fa-trash mr-2"></i> Vaciar Bandeja
									</button>
								</div>
							</div>
						</div>
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

	<!-- Modal de Liquidaciones Procesadas -->
	<div class="modal fade" id="modalLiquidaciones" tabindex="-1" role="dialog" aria-labelledby="modalLiquidacionesLabel" aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-xl" role="document" style="max-width: 95%; margin: 20px auto;">
			<div class="modal-content" style="border-radius: 15px; overflow: hidden;">
				<!-- Header del Modal -->
				<div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 20px 30px;">
					<div>
						<h4 class="modal-title mb-1" id="modalLiquidacionesLabel">
							<i class="fa fa-file-invoice-dollar mr-2"></i>Liquidaciones Procesadas
						</h4>
						<small id="modal-periodo-info" style="opacity: 0.9;"></small>
					</div>
					<div class="d-flex align-items-center" style="gap: 15px;">
						<span class="badge badge-light" id="modal-stats" style="font-size: 0.9rem; padding: 8px 15px;"></span>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1; text-shadow: none;">
							<span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
						</button>
					</div>
				</div>

				<!-- Body del Modal -->
				<div class="modal-body p-0" style="background: #f8f9fa; height: calc(100vh - 200px); display: flex;">
					<!-- Panel Izquierdo: Lista de Trabajadores -->
					<div id="panel-lista-trabajadores" style="width: 320px; background: #fff; border-right: 1px solid #e9ecef; display: flex; flex-direction: column;">
						<!-- Header del Panel -->
						<div style="padding: 15px 20px; background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%); color: white;">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<strong><i class="fa fa-users mr-2"></i>Trabajadores</strong>
								<span class="badge badge-light" id="count-trabajadores">0</span>
							</div>
							<input type="text" id="buscar-trabajador-modal" class="form-control form-control-sm" placeholder="Buscar trabajador..." style="border-radius: 20px; border: none;">
						</div>
						<!-- Lista de Trabajadores -->
						<div id="lista-trabajadores-modal" style="flex: 1; overflow-y: auto;">
							<!-- Se llena dinamicamente -->
						</div>
					</div>

					<!-- Panel Derecho: Detalle de Liquidacion -->
					<div id="panel-detalle-liquidacion" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
						<!-- Header del Detalle -->
						<div id="detalle-header" style="padding: 15px 25px; background: #fff; border-bottom: 1px solid #e9ecef; display: none;">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<h5 class="mb-1" id="detalle-nombre-trabajador" style="color: #2c3e50;"></h5>
									<small class="text-muted" id="detalle-rut-trabajador"></small>
								</div>
								<div class="d-flex" style="gap: 10px;">
									<button class="btn btn-outline-primary btn-sm" onclick="imprimirLiquidacionActual()" title="Imprimir esta liquidacion">
										<i class="fa fa-print mr-1"></i> Imprimir
									</button>
								</div>
							</div>
						</div>

						<!-- Contenido de la Liquidacion -->
						<div id="detalle-contenido" style="flex: 1; overflow-y: auto; padding: 25px;">
							<!-- Estado inicial: Seleccionar trabajador -->
							<div id="estado-inicial" class="text-center" style="padding: 80px 40px;">
								<i class="fa fa-hand-pointer" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
								<h5 style="color: #6c757d;">Seleccione un trabajador</h5>
								<p class="text-muted">Haga clic en un trabajador de la lista para ver su liquidacion</p>
							</div>

							<!-- Contenido de la liquidacion (oculto inicialmente) -->
							<div id="liquidacion-content" style="display: none;">
								<!-- Se llena dinamicamente -->
							</div>
						</div>
					</div>
				</div>

				<!-- Footer del Modal -->
				<div class="modal-footer" style="background: #fff; border-top: 1px solid #e9ecef; padding: 15px 25px;">
					<div class="d-flex justify-content-between w-100">
						<div>
							<span class="text-muted" id="footer-info"></span>
						</div>
						<div class="d-flex" style="gap: 10px;">
							<button type="button" class="btn btn-success" onclick="imprimirTodasLiquidaciones()">
								<i class="fa fa-print mr-1"></i> Imprimir Todas
							</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								<i class="fa fa-times mr-1"></i> Cerrar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Estilos adicionales para el modal -->
	<style>
		/* Lista de trabajadores en el modal */
		.trabajador-item {
			padding: 12px 20px;
			border-bottom: 1px solid #f1f1f1;
			cursor: pointer;
			transition: all 0.2s ease;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		.trabajador-item:hover {
			background: #f8f9fa;
		}
		.trabajador-item.active {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
		}
		.trabajador-item.active .text-muted {
			color: rgba(255,255,255,0.8) !important;
		}
		.trabajador-item .trabajador-info {
			flex: 1;
		}
		.trabajador-item .trabajador-nombre {
			font-weight: 600;
			font-size: 0.9rem;
			margin-bottom: 2px;
		}
		.trabajador-item .trabajador-rut {
			font-size: 0.8rem;
		}
		.trabajador-item .trabajador-liquido {
			font-weight: 700;
			font-size: 0.95rem;
		}
		.trabajador-item.ya-existe {
			background: #fff3cd;
		}
		.trabajador-item.ya-existe .badge-warning-subtle {
			background: #ffc107;
			color: #212529;
			font-size: 0.7rem;
			padding: 2px 6px;
			border-radius: 4px;
		}

		/* Liquidacion detalle */
		.liquidacion-card {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			margin-bottom: 20px;
			overflow: hidden;
		}
		.liquidacion-card-header {
			background: #f8f9fa;
			padding: 12px 20px;
			font-weight: 600;
			color: #495057;
			border-bottom: 1px solid #e9ecef;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.liquidacion-card-body {
			padding: 15px 20px;
		}
		.liquidacion-row {
			display: flex;
			justify-content: space-between;
			padding: 8px 0;
			border-bottom: 1px solid #f1f1f1;
		}
		.liquidacion-row:last-child {
			border-bottom: none;
		}
		.liquidacion-row .codigo {
			color: #495057;
		}
		.liquidacion-row .valor {
			font-weight: 600;
			color: #2c3e50;
		}
		.liquidacion-total {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 15px 20px;
			border-radius: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 15px;
		}
		.liquidacion-total .label {
			font-size: 1rem;
		}
		.liquidacion-total .amount {
			font-size: 1.5rem;
			font-weight: 700;
		}

		/* Info cards en detalle */
		.info-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 15px;
			margin-bottom: 20px;
		}
		.info-item {
			background: #f8f9fa;
			padding: 12px 15px;
			border-radius: 8px;
		}
		.info-item .label {
			font-size: 0.75rem;
			text-transform: uppercase;
			color: #6c757d;
			letter-spacing: 0.5px;
		}
		.info-item .value {
			font-size: 1rem;
			font-weight: 600;
			color: #2c3e50;
		}

		/* Procesando overlay */
		.processing-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0,0,0,0.7);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}
		.processing-overlay .spinner {
			width: 60px;
			height: 60px;
			border: 4px solid rgba(255,255,255,0.3);
			border-top-color: #fff;
			border-radius: 50%;
			animation: spin 1s linear infinite;
		}
		@keyframes spin {
			to { transform: rotate(360deg); }
		}
		.processing-overlay .text {
			color: white;
			margin-top: 20px;
			font-size: 1.1rem;
		}
		.processing-overlay .progress-text {
			color: rgba(255,255,255,0.8);
			margin-top: 10px;
			font-size: 0.9rem;
		}
	</style>

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
			updateDashboardUI();
		});

		// Funcion para actualizar los KPIs y el estado de la bandeja
		function updateDashboardUI() {
			var lotesBody = document.getElementById('lotes');
			var emptyState = document.getElementById('empty-lote');
			var badgeLote = document.getElementById('badge-lote');
			var kpiPendientes = document.getElementById('kpi-pendientes');

			var rowCount = lotesBody ? lotesBody.getElementsByTagName('tr').length : 0;

			// Actualizar badge
			if (badgeLote) {
				badgeLote.textContent = rowCount + ' seleccionados';
			}

			// Actualizar KPI de pendientes
			if (kpiPendientes) {
				kpiPendientes.textContent = rowCount;
			}

			// Mostrar/ocultar estado vacio
			if (emptyState) {
				emptyState.style.display = rowCount > 0 ? 'none' : 'block';
			}
		}

		// Observer para detectar cambios en la tabla de lotes
		var lotesObserver = new MutationObserver(function(mutations) {
			updateDashboardUI();
		});

		// Iniciar observador cuando el DOM este listo
		$(document).ready(function() {
			var lotesBody = document.getElementById('lotes');
			if (lotesBody) {
				lotesObserver.observe(lotesBody, { childList: true, subtree: true });
			}
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