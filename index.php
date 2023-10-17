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
	<style>
		.select2-selection {
			width: 100% !important;
		}
	</style>


</head>

<body class="main-body leftmenu">

	<!-- Loader -->
	<div id="global-loader">
		<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
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
				<ul class="nav">
					<li class="nav-header"><span class="nav-label">Dashboard</span></li>

					<?php

					if (isset($_SESSION['GESTION_PERMISO']) || isset($_SESSION['LECTURA_PERMISO']) || isset($_SESSION['ESCRITURA_PERMISO']) || isset($_SESSION['ACTUALIZACION_PERMISO']) || isset($_SESSION['ELIMINACION_PERMISO'])) {
						if ($_SESSION['GESTION_PERMISO'] == true) {

					?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definiciones</span><i class="angle fe fe-chevron-right"></i></a>
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
								</ul>
							</li>
						<?php
						}
						?>
						<li class="nav-header"><span class="nav-label">FUNCIONES</span></li>


						<li class="nav-item">
							<a class="nav-link with-sub" href="#"><i class="fe fe-message-square sidemenu-icon"></i><span class="sidemenu-label">Maestros</span><i class="angle fe fe-chevron-right"></i></a>
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
							<a class="nav-link with-sub" href="#"><i class="fe fe-droplet sidemenu-icon"></i><span class="sidemenu-label">Auditoria</span><i class="angle fe fe-chevron-right"></i></a>
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
						<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Documentos</span><i class="angle fe fe-chevron-right"></i></a>
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
						<a class="nav-link with-sub" href="#"><i class="fe fe-dollar-sign sidemenu-icon"></i><span class="sidemenu-label">Remuneraciones</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="habmaster.php">Haberes y Descuentos</a>
							</li>
						</ul>
					</li>
					<!--------------------------------------------------------------->
					<!--------------------Carga de documentos------------------>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-upload sidemenu-icon"></i><span class="sidemenu-label">Carga de Documentos</span><i class="angle fe fe-chevron-right"></i></a>
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
						<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Reportes</span><i class="angle fe fe-chevron-right"></i></a>
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
						</ul>
					</li>
					<!--------------------------------------------------------------->

				</ul>
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
						<div class="w-100" style="position: relative; z-index: 999999;">
							<select name="currententerprise" id="currententerprise" class="form-control select2" onchange="seleccionarEmpresa(this.value)">
								<?php
								if (isset($_SESSION['GESTION_PERMISO'])) {
									if ($_SESSION['GESTION_PERMISO'] == true) {
										$lista = $c->listarEmpresas();
										if (count($lista) > 0) {
											echo "<option value='0' >Seleccione Empresa</option>";
											foreach ($lista as $empresa) {
												if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
													$id = $_SESSION['CURRENT_ENTERPRISE'];
													if ($id == $empresa->getId()) {
														echo "<option value='" . $empresa->getId() . "' selected>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
													} else {
														echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
													}
												} else {
													echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
												}
											}
										} else {
											echo "<option value='0' >No hay empresas registradas</option>";
										}
									} else {
										$lista = $c->buscarEmpresausuario($_SESSION['USER_ID']);
										if (count($lista) > 0) {
											echo "<option value='0' >Seleccione Empresa</option>";
											foreach ($lista as $empresa) {
												if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
													$id = $_SESSION['CURRENT_ENTERPRISE'];
													if ($id == $empresa->getId()) {
														echo "<option value='" . $empresa->getId() . "' selected>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
													} else {
														echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
													}
												} else {
													echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
												}
											}
										} else {
											echo "<option value='0' >No hay empresas registradas</option>";
										}
									}
								} else {
									$lista = $c->buscarEmpresausuario($_SESSION['USER_ID']);
									if (count($lista) > 0) {
										echo "<option value='0' >Seleccione Empresa</option>";
										foreach ($lista as $empresa) {
											if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
												$id = $_SESSION['CURRENT_ENTERPRISE'];
												if ($id == $empresa->getId()) {
													echo "<option value='" . $empresa->getId() . "' selected>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
												} else {
													echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
												}
											} else {
												echo "<option value='" . $empresa->getId() . "'>" . $empresa->getRazonSocial() . " - " . $empresa->getRut() . "</option>";
											}
										}
									} else {
										echo "<option value='0' disabled >No hay empresas registradas</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="main-header-right">
					<div class="dropdown d-md-flex header-settings">
						<a href="#">
							<i class="header-icons"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z" />
								</svg></i>
						</a>
					</div>
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
									<?php echo $_SESSION['USER_NAME'] ?>
								</h6>
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
									<h6 class="main-notification-title">
										<?php echo $_SESSION['USER_NAME'] ?>
									</h6>
								</div>
								<a class="dropdown-item" href="close.php">
									<i class="fe fe-power"></i> Cerrar Sesión
								</a>
							</div>
						</div>
						<div class="dropdown  header-settings">
							<a href="#" class="nav-link icon" title="Seleccionar Empresa" class="nav-link icon" data-toggle="modal" data-target="#modalempresa">
								<i class="header-icons"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none" />
										<path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z" />
									</svg></i>
							</a>
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
							<h1 class="main-content-title tx-30">Home</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->
					<!-- ROW-3 -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
							<div class="row">
								<div class="col-xl-3 col-md-6 col-lg-6">
									<div class="card">
										<div class="card-body p-4">
											<div class="d-flex no-block align-items-center">
												<div class="text-left">
													<p class="mb-1 text-dark fs-20 font-weight-medium">Contratos
														Generados</p>
													<h6 class="mb-1 text-success fs-18 font-weight-semibold">
														<?php
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																echo "General";
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	echo "Empresa actual";
																}
															}
														} else {
														}
														?>
													</h6>
													<p class="mb-1 text-muted fs-16 font-weight-semibold">
														<?php
														$valor = 0;
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																$valor = $c->cantidadcontratosgenerados();
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																	if ($empresa > 0) {
																		$valor = $c->cantidadcontratosgeneradosempresa($empresa);
																	}
																}
															}
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$valor = $c->cantidadcontratosgeneradosempresa($empresa);
																}
															}
														}
														echo $valor;
														?>
													</p>
												</div>
												<div class="ml-auto">
													<span class="bg-primary icon-service-2 text-white ">
														<i class="mdi mdi-calculator"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6 col-lg-6">
									<div class="card">
										<div class="card-body p-4">
											<div class="d-flex no-block align-items-center">
												<div class="text-left">
													<p class="mb-1 text-dark fs-20 font-weight-medium">Finiquitos
														Generados</p>
													<h6 class="mb-1 text-success fs-18 font-weight-semibold">
														<?php
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																echo "General";
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	echo "Empresa actual";
																}
															}
														} else {
														}
														?>
													</h6>
													<p class="mb-1 text-muted fs-16 font-weight-semibold">
														<?php
														$valor = 0;
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																$valor = $c->cantidadfiniquitosgenerados();
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																	if ($empresa > 0) {
																		$valor = $c->cantidadfiniquitosgeneradosempresa($empresa);
																	}
																}
															}
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$valor = $c->cantidadfiniquitosgeneradosempresa($empresa);
																}
															}
														}
														echo $valor;
														?>
													</p>
												</div>
												<div class="ml-auto">
													<span class="bg-secondary icon-service-2 text-white ">
														<i class="mdi mdi-poll"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6 col-lg-6">
									<div class="card ">
										<div class="card-body p-4">
											<div class="d-flex no-block align-items-center">
												<div class="text-left">
													<p class="mb-1 text-dark fs-20 font-weight-medium">Trabajadores Con
														licencia</p>
													<h6 class="mb-1 text-success fs-18 font-weight-semibold">
														<?php
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																echo "General";
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	echo "Empresa actual";
																}
															}
														} else {
														}
														?>
													</h6>
													<p class="mb-1 text-muted fs-16 font-weight-semibold">
														<?php
														$valor = 0;
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																$valor = $c->cantidadtrabajadoresconlicenciamedica();
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																	if ($empresa > 0) {
																		$valor = $c->cantidadtrabajadoresconlicenciamedicaempresa($empresa);
																	}
																}
															}
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$valor = $c->cantidadtrabajadoresconlicenciamedicaempresa($empresa);
																}
															}
														}
														echo $valor;
														?>
													</p>
												</div>
												<div class="ml-auto">
													<span class="bg-purple icon-service-2 text-white ">
														<i class="mdi mdi-trending-up"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6 col-lg-6">
									<div class="card">
										<div class="card-body p-4">
											<div class="d-flex no-block align-items-center">
												<div class="text-left">
													<p class="mb-1 text-dark fs-20 font-weight-medium">Trabajadores Con
														vacaciones</p>
													<h6 class="mb-1 text-success fs-18 font-weight-semibold">
														<?php
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																echo "General";
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	echo "Empresa actual";
																}
															}
														} else {
														}
														?>
													</h6>
													<p class="mb-1 text-muted fs-16 font-weight-semibold">
														<?php
														$valor = 0;
														if (isset($_SESSION['GESTION_PERMISO'])) {
															if ($_SESSION['GESTION_PERMISO'] == true) {
																$valor = $c->cantidadtrabajadoresconvacaciones();
															} else {
																if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																	if ($empresa > 0) {
																		$valor = $c->cantidadtrabajadoresconvacacionesempresa($empresa);
																	}
																}
															}
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$valor = $c->cantidadtrabajadoresconvacacionesempresa($empresa);
																}
															}
														}
														echo $valor;
														?>
													</p>
												</div>
												<div class="ml-auto">
													<span class="bg-success icon-service-2 text-white">
														<b class="fs-30 my-auto py-auto">1</b>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ROW-3 END -->
					<div class="row">
						<div class="col-xl-6 col-lg-12 col-md-12">
							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Contratos Proximos a Vencer</h4>
								</div>
								<div class="card-body p-4">
									<div class="">
										<div class="table-responsive">
											<table class="table w-100 table-data text-nowrap w-100">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">Trabajador</th>
														<th class="bg-transparent">Empresa</th>
														<th class="bg-transparent">Fecha de Inicio</th>
														<th class="bg-transparent">Fecha Termino</th>
														<th class="bg-transparent">Estado</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = null;
													if (isset($_SESSION['GESTION_PERMISO'])) {
														if ($_SESSION['GESTION_PERMISO'] == true) {
															$lista = $c->listarcontratosquevenceranenlosproximos90dias();
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$lista = $c->listarcontratosquevenceranenlosproximos90diasempresa($empresa);
																}
															}
														}
													}
													if ($lista != null) {
														foreach ($lista as $object) {
															echo "<tr>";
															echo "<td>" . $object->getTrabajador() . "</td>";
															echo "<td>" . $object->getEmpresa() . "</td>";
															$fechainicio = $object->getFechaInicio();
															$fechatermino = $object->getFechaTermino();
															//Convertir la fecha de inicio a formato d/m/Y
															$fechainicio = date("d/m/Y", strtotime($fechainicio));
															//Convertir la fecha de termino a formato d/m/Y
															$fechatermino = date("d/m/Y", strtotime($fechatermino));
															echo "<td>" . $fechainicio . "</td>";
															echo "<td>" . $fechatermino . "</td>";
															if ($object->getFechaTermino() == date("Y-m-d")) {
																echo "<td><span class='btn btn-primary btn-md wd-100'>Vence Hoy</span></td>";
															} else {
																//Sacar la diferencia entre la fecha de termino y la fecha actual
																$fechatermino = new DateTime($object->getFechaTermino());
																$fechaactual = new DateTime(date("Y-m-d"));
																$diferencia = $fechaactual->diff($fechatermino);
																$dias = $diferencia->days;
																if ($dias >= 1 && $dias <= 10) {
																	echo "<td><button class='btn btn-danger btn-md '>Vence en " . $dias . " dias</button></td>";
																} else if ($dias >= 11 && $dias <= 30) {
																	echo "<td><button class='btn btn-warning btn-md '>Vence en " . $dias . " dias</button></td>";
																} else if ($dias > 30) {
																	echo "<td><button class='btn btn-success btn-md '>Vence en " . $dias . " dias</button></td>";
																}
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
							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Cargas Familiares Proximos a Vencer
									</h4>
								</div>
								<div class="card-body p-3">
									<div class="">
										<div class="table-responsive">
											<table class="table w-100 table-data text-nowrap" id="example1">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">Trabajador</th>
														<th class="bg-transparent">Empresa</th>
														<th class="bg-transparent">Carga</th>
														<th class="bg-transparent">Vigencia</th>
														<th class="bg-transparent">Estado</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = null;
													if (isset($_SESSION['GESTION_PERMISO'])) {
														if ($_SESSION['GESTION_PERMISO'] == true) {
															$lista = $c->listarcargasporvenceren90dias();
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$lista = $c->listarcargasporvenceren90diasempresa($empresa);
																}
															}
														}
													}
													if ($lista != null) {
														foreach ($lista as $object) {
															echo "<tr>";
															echo "<td>" . $object->getTrabajador() . "</td>";
															echo "<td>" . $object->getComentario() . "</td>";
															echo "<td>" . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . "</td>";
															$fechatermino = $object->getVigencia();
															//Convertir la fecha de inicio a formato d/m/Y
															//Convertir la fecha de termino a formato d/m/Y
															$fechatermino = date("d/m/Y", strtotime($fechatermino));
															echo "<td>" . $fechatermino . "</td>";
															if ($object->getVigencia() == date("Y-m-d")) {
																echo "<td><span class='badge badge-danger'>Vence Hoy</span></td>";
															} else {
																//Sacar la diferencia entre la fecha de termino y la fecha actual
																$fechatermino = new DateTime($object->getVigencia());
																$fechaactual = new DateTime(date("Y-m-d"));
																$diferencia = $fechaactual->diff($fechatermino);
																$dias = $diferencia->days;
																if ($dias >= 1 && $dias <= 10) {
																	echo "<td><button class='btn btn-danger btn-md '>Vence en " . $dias . " dias</button></td>";
																} else if ($dias >= 11 && $dias <= 30) {
																	echo "<td><button class='btn btn-warning btn-md '>Vence en " . $dias . " dias</button></td>";
																} else if ($dias > 30) {
																	echo "<td><button class='btn btn-success btn-md '>Vence en " . $dias . " dias</button></td>";
																}
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
						<div class="col-sm-12 col-md-12 col-xl-6">
							<div class="card" id="transcation-crypto1-1">
								<div class="card-header bd-b-0">
									<div class="d-flex">
										<h4 class="card-title font-weight-semibold mb-0">Acumulación de Vacaciones
											Superiores a 30 dias</h4>
									</div>
								</div>
								<div class="card-body p-3">
									<div class="">
										<div class="table-responsive">
											<table class="table w-100 table-data text-nowrap w-100">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">Trabajador</th>
														<th class="bg-transparent">Empresa</th>
														<th class="bg-transparent">Cantidad de Días</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = null;
													if (isset($_SESSION['GESTION_PERMISO'])) {
														if ($_SESSION['GESTION_PERMISO'] == true) {
															$lista = $c->acumulaciondevacaciones();
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$lista = $c->acumulaciondevacacionesempresa($empresa);
																}
															}
														}
													}
													if ($lista != null) {
														foreach ($lista as $object) {
															$cantidad = $c->cantidadvacaciones($object->getId());
															echo "<tr>";
															echo "<td>" . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . "</td>";
															echo "<td>" . $object->getEmpresa() . "</td>";
															if ($cantidad > 1 && $cantidad <= 16) {
																echo "<td><button class='btn btn-success btn-md '> " . $cantidad . " dias</button></td>";
															} else if ($cantidad > 16 && $cantidad <= 30) {
																echo "<td><button class='btn btn-warning btn-md '> " . $cantidad . " dias</button></td>";
															} else {
																echo "<td><button class='btn btn-danger btn-md '> " . $cantidad . " dias</button></td>";
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


							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Licencias Medicas de los ultimos 90
										Dias</h4>
								</div>
								<div class="card-body p-4">
									<div class="">
										<div class="table-responsive">
											<table class="table table-data text-nowrap w-100">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">Trabajador</th>
														<th class="bg-transparent">Empresa</th>
														<th class="bg-transparent">Fecha de Inicio</th>
														<th class="bg-transparent">Fecha Termino</th>
														<th class="bg-transparent">Tipo de Licencia</th>
														<th class="bg-transparent">Estado</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = null;
													if (isset($_SESSION['GESTION_PERMISO'])) {
														if ($_SESSION['GESTION_PERMISO'] == true) {
															$lista = $c->licenciamedicasdelosultimos90dias();
														} else {
															if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
																$empresa = $_SESSION['CURRENT_ENTERPRISE'];
																if ($empresa > 0) {
																	$lista = $c->licenciamedicasdelosultimos90diasempresa($empresa);
																}
															}
														}
													}
													if ($lista != null) {
														foreach ($lista as $object) {
															echo "<tr>";
															echo "<td>" . $object->getTrabajador() . "</td>";
															echo "<td>" . $object->getRegistro() . "</td>";
															$fechainicio = $object->getFechainicio();
															//Convertir fecha a formato dia/mes/año
															$fechainicio = date("d-m-Y", strtotime($fechainicio));
															echo "<td>" . $fechainicio . "</td>";
															$fechafin = $object->getFechafin();
															//Convertir fecha a formato dia/mes/año
															$fechafin = date("d-m-Y", strtotime($fechafin));
															echo "<td>" . $fechafin . "</td>";
															echo "<td>" . $object->getTipolicencia() . "</td>";
															$fechatermino = new DateTime($object->getFechafin());
															$fechaactual = new DateTime(date("Y-m-d"));
															$diferencia = $fechaactual->diff($fechatermino);
															$dias = $diferencia->days;

															if ($object->getFechafin() < date("Y-m-d")) {
																echo "<td><button class='btn btn-danger btn-md '>Vencida</button></td>";
															} else if ($object->getFechafin() > date("Y-m-d")) {
																echo "<td><button class='btn btn-success btn-md '>Vence en " . $dias . " dias</button></td>";
															} else if ($object->getFechafin() == date("Y-m-d")) {
																echo "<td><span class='badge badge-warning'>Vence Hoy</span></td>";
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

		<!-- Modal Detalle Empresa-->
		<div class="modal fade" id="modalempresa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl ">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Seleccionar Empresa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table w-100 table-striped table-bordered text-nowrap w-100" id="table-empresa">
										<thead class="text-center">
											<tr>
												<th class="wd-15p">RUT</th>
												<th class="wd-15p">Razón Social</th>
												<th class="wd-15p">Seleccionar</th>
											</tr>
										</thead>
										<tbody class="text-center">
											<?php
											if (isset($_SESSION['GESTION_PERMISO'])) {
												if ($_SESSION['GESTION_PERMISO'] == true) {
													$lista = $c->listarEmpresas();
													if (count($lista) > 0) {
														foreach ($lista as $empresa) {
															echo "<tr>";
															echo "<td>" . $empresa->getRut() . "</td>";
															echo "<td>" . $empresa->getRazonSocial() . "</td>";
															echo "<td><button type='button' class='btn btn-primary btn-sm' data-dismiss='modal' onclick='seleccionarEmpresa(" . $empresa->getId() . ")'><i class='fa fa-check'></i></button></td>";
															echo "</tr>";
														}
													} else {
														echo "<tr>";
														echo "<td colspan='3'>No hay empresas registradas</td>";
														echo "</tr>";
													}
												} else {
													$lista = $c->buscarEmpresausuario($_SESSION['USER_ID']);
													if (count($lista) > 0) {
														foreach ($lista as $empresa) {
															echo "<tr>";
															echo "<td>" . $empresa->getRut() . "</td>";
															echo "<td>" . $empresa->getRazonSocial() . "</td>";
															echo "<td><button type='button' class='btn btn-primary btn-sm' data-dismiss='modal' onclick='seleccionarEmpresa(" . $empresa->getId() . ")'><i class='fa fa-check'></i></button></td>";
															echo "</tr>";
														}
													} else {
														echo "<tr>";
														echo "<td colspan='3'>No hay empresas registradas</td>";
														echo "</tr>";
													}
												}
											} else {
												$lista = $c->buscarEmpresausuario($_SESSION['USER_ID']);
												if (count($lista) > 0) {
													foreach ($lista as $empresa) {
														echo "<tr>";
														echo "<td>" . $empresa->getRut() . "</td>";
														echo "<td>" . $empresa->getRazonSocial() . "</td>";
														echo "<td><button type='button' class='btn btn-primary btn-sm' data-dismiss='modal' onclick='seleccionarEmpresa(" . $empresa->getId() . ")'><i class='fa fa-check'></i></button></td>";
														echo "</tr>";
													}
												} else {
													echo "<tr>";
													echo "<td colspan='3'>No hay empresas registradas</td>";
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
			</div>
		</div>
		<!-- End Modal Empresa -->

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
	<script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
	<script>
		$("#table-empresa").DataTable({
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "No se encontraron registros",
				"info": "Mostrando página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtrado de _MAX_ registros totales)",
				"search": "Buscar:",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});

		$(".table-data").DataTable({
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "No se encontraron registros",
				"info": "Mostrando página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtrado de _MAX_ registros totales)",
				"search": "Buscar:",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});

		$(".data-table").DataTable({
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "No se encontraron registros",
				"info": "Mostrando página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtrado de _MAX_ registros totales)",
				"search": "Buscar:",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});
	</script>


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

	<script>
		$(document).ready(function() {
			mostrarEmpresa();
		});
	</script>
</body>

</html>