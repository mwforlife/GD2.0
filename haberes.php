
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

if(isset($_SESSION['GESTION_PERMISO'])){
	if($_SESSION['GESTION_PERMISO']==false){
		if(!isset($_SESSION['CURRENT_ENTERPRISE'])){
			header("Location: index.php");
		}
	}
}else{
	if(!isset($_SESSION['CURRENT_ENTERPRISE'])){
		header("Location: index.php");
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
					<h5 class="empresaname m-0">
								<h5>
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
							<h1 class="main-content-title tx-30">Haberes y Descuentos</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card orverflow-hidden">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Registro de habres y Descuentos</h6>
										<p class="text-mutted card-sub-title"></p>
									</div>
									<form id="RegisForm" name="RegisForm" class="needs-validation was-validated">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Codigo</label>
													<input class="form-control" id="codigo" name="codigo" placeholder="Ingrese el Codigo" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Descripcion</label>
													<input class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la Descripción" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Tipo</label>
													<select name="tipo" id="tipo" class="form-control select2">
														<option value="1">Haber</option>
														<option value="2">Descuento</option>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Imponible</label>
													<select name="imponible" id="imponible" class="form-control select2">
														<option value="1">Si</option>
														<option value="2">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Tributable</label>
													<select name="tributable" id="tributable" class="form-control select2">
														<option value="1">Si</option>
														<option value="2">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Gratificación</label>
													<select name="gratificacion" id="gratificacion" class="form-control select2">
														<option value="1">Si</option>
														<option value="2">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Reservado</label>
													<select name="reservado" id="reservado" class="form-control select2">
														<option value="1">Si</option>
														<option value="2">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label>Codigo LRE</label>
													<select name="lre" id="lre" class="form-control select2">
														<?php
															$codigos = $c->listarcodigoslre();
															foreach($codigos as $codigo)
															{
																echo "<option value='".$codigo->getId()."'>";
																echo $codigo->getDescripcion();
																if(strlen($codigo->getArticulo())>0){
																	echo " (".$codigo->getArticulo().") ";
																}
																echo " (Cód. ".$codigo->getCodigo()." ) ";
																echo "</option>";
															}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label for="">¿Aplica Formula?</label><br/>
													<input type="radio" name="aplicaformula" id="aplicaformula" value="2" checked onclick="formul(2)"> <span>No</span>
													<input type="radio" name="aplicaformula" id="aplicaformula" value="1" onclick="formul(1)"> <span>Si</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label for="">Formula</label>
													<input class="form-control" readonly id="formula" name="formula" placeholder="Ingrese la Formula" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label for="">Agrupación</label>
													<select name="agrupacion" id="agrupacion" class="form-control select2">
														<option value="1">Valor</option>
														<option value="2">Horas</option>
														<option value="2">Dias</option>
													</select>
												</div>
											</div>
											
											<?php
											if(isset($_SESSION['GESTION_PERMISO'])){
												if($_SESSION['GESTION_PERMISO']==true){
											?>
											<div class="col-lg-6">
												<div class="form-group has-success mg-b-0">
													<label for="">Categoria</label>
													<select name="categoria" id="categoria" class="form-control select2">
														<option value="1">Master</option>
														<option value="2">Empresa</option>
													</select>
												</div>
											</div>
											<?php
												}else{
													echo "<input type='hidden' name='categoria' id='categoria' value='2'>";
												}
											}else{
												echo "<input type='hidden' name='categoria' id='categoria' value='2'>";
											}
											?>

											<div class="col-md-12 mt-3 text-right">
												<button type="reset" href="#" class="btn btn-warning btn-md"> <i class="fa fa-refresh"></i> Restablecer</button>
												<button type="submit" href="#" class="btn btn-primary btn-md"> <i class="fa fa-save"></i> Registrar</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">
										Variables Formula
									</h4>
									<div class="row">
										<div class="col-md-12">
											<button class='btn btn-outline-primary' onclick='addformula("{SUELDO_BASE}")'>Sueldo Base</button>
											<button class='btn btn-outline-primary' onclick='addformula("{DIAS_TRABAJADOS}")'>Dias Trabajados</button>
											<button class='btn btn-outline-primary' onclick='addformula("{HORAS_TRABAJADAS}")'>Horas Trabajadas</button>
											<button class='btn btn-outline-primary' onclick='addformula("{VALOR_AGREGADO}")'>Valor Agregado</button>	
											<button class='btn btn-outline-primary' onclick='addformula("{TOTAL_IMPONIBLE}")'>Total Imponible</button>
											<button class='btn btn-outline-primary' onclick='addformula("{TOTAL_NO_IMPONIBLE}")'>Total No Imponible</button>
											<button class='btn btn-outline-primary' onclick='addformula("{TOTAL_TRIBUTABLE}")'>Total Tributable</button>
											<button class='btn btn-outline-primary' onclick='addformula("{TOTAL_HABERES}")'>Total Haberes</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ROW-4 opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Listado Haberes y Descuentos</h4>
								</div>
								<div class="card-body">
									<div class="">
										<div class="table-responsive">
											<table class="table w-100 text-nowrap" id="example1">
												<thead class="border-top text-center">
													<tr>
														<th class="bg-transparent">Codigo</th>
														<th class="bg-transparent">Descripción</th>
														<th class="bg-transparent">Tipo</th>
														<th class="bg-transparent">Imponible</th>
														<th class="bg-transparent">Tributable</th>
														<th class="bg-transparent">Gratificación</th>
														<th class="bg-transparent">Reservado</th>
														<th class="bg-transparent">Codigo LRE</th>
														<th class="bg-transparent">Aplica Formula</th>
														<th class="bg-transparent">Formula</th>
														<th class="bg-transparent">Acciones</th>
													</tr>
												</thead>
												<tbody class="text-center">
													<?php
													$haberes = array();
													if(isset($_SESSION['CURRENT_ENTERPRISE'])){
														$haberes = $c->listarhaberesydescuentosempresa($_SESSION['CURRENT_ENTERPRISE']);
													}else{
														$haberes = $c->listarhaberesydescuentos();
													}
													foreach($haberes as $haber){
														echo "<tr>";
														echo "<td>".$haber->getCodigo()."</td>";
														echo "<td>".$haber->getDescripcion()."</td>";
														if($haber->getTipo()==1){
															echo "<td>Haber</td>";
														}else{
															echo "<td>Descuento</td>";
														}
														if($haber->getImponible()==1){
															echo "<td>Si</td>";
														}else{
															echo "<td>No</td>";
														}
														if($haber->getTributable()==1){
															echo "<td>Si</td>";
														}else{
															echo "<td>No</td>";
														}
														if($haber->getGratificacion()==1){
															echo "<td>Si</td>";
														}else{
															echo "<td>No</td>";
														}
														if($haber->getReservado()==1){
															echo "<td>Si</td>";
														}else{
															echo "<td>No</td>";
														}
														echo "<td>".$haber->getLre()."</td>";
														if($haber->getAplicaformula()==1){
															echo "<td>Si</td>";
															echo "<td>".$haber->getFormula()."</td>";
														}else{
															echo "<td>No</td>";
															echo "<td>No Aplica</td>";
														}
														echo "<td>";
														if($haber->getTipohaber()==1){
															if(isset($_SESSION['GESTION_PERMISO'])){
																if($_SESSION['GESTION_PERMISO']==true){
																	echo "<a href='#' class='btn btn-primary btn-sm' onclick='editarhaber(".$haber->getId().")'><i class='fa fa-edit'></i></a>";
																	echo "<a href='#' class='btn btn-danger btn-sm' onclick='eliminarhaber(".$haber->getId().")'><i class='fa fa-trash'></i></a>";
																}else{
																	echo "-";
																}
															}else{
																echo "-";
															}
														}else{
														echo "<a href='#' class='btn btn-primary btn-sm' onclick='editarhaber(".$haber->getId().")'><i class='fa fa-edit'></i></a>";
														echo "<a href='#' class='btn btn-danger btn-sm' onclick='eliminarhaber(".$haber->getId().")'><i class='fa fa-trash'></i></a>";
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
	<script src="JsFunctions/haberes.js"></script>
	<script src="JsFunctions/main.js"></script>

	<script>
		$(document).ready(function () {
			mostrarEmpresa();
		});
	</script>



</body>

</html>