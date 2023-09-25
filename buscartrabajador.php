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
<html lang="en">

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
				<ul class="nav">
					<li class="nav-header"><span class="nav-label">Dashboard</span></li>

					<?php

					if (isset($_SESSION['GESTION_PERMISO']) || isset($_SESSION['LECTURA_PERMISO']) || isset($_SESSION['ESCRITURA_PERMISO']) || isset($_SESSION['ACTUALIZACION_PERMISO']) || isset($_SESSION['ELIMINACION_PERMISO'])) {
						if ($_SESSION['GESTION_PERMISO'] == true) {

					?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definicion de Datos</span><i class="angle fe fe-chevron-right"></i></a>
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
										<a class="nav-sub-link" href="jornadas.php">JORNADAS</a>
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
								</ul>
							</li>
							<li class="nav-header"><span class="nav-label">FUNCIONES</span></li>
							<li class="nav-item">
								<a class="nav-link" href="tipodocumento.php"><i class="fe fe-grid sidemenu-icon"></i><span class="sidemenu-label">TIPO DE DOCUMENTOS</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="redactardocumento.php"><i class="fe fe-grid sidemenu-icon"></i><span class="sidemenu-label">REDACTAR DOCUMENTOS</span></a>
							</li>
						<?php
						}

						if ($_SESSION['GESTION_PERMISO'] == true || $_SESSION['ESCRITURA_PERMISO'] == true) {
						?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-message-square sidemenu-icon"></i><span class="sidemenu-label">Empresas</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="empresas.php">Listado de Empresas</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="centrocosto.php">Registro de Centro de Costo</a>
									</li>
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
					}
					?>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-map-pin sidemenu-icon"></i><span class="sidemenu-label">Trabajadores</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="trabajadores.php">Listado de trabajadores</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="registrartrabajador.php">Registro de trabajadores</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="historialtrabajador.php">Ficha de trabajadores</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="documentoficha.php">Registro de documento a Ficha trabajador</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="anotaciones.php">Registro de Anotaciones</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Documentos</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="contratoindividual.php">Generacion de Contrato Individual</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="generarlote.php">Generacion de Contratos Masivos</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="finiquitoindividual.php">Generacion de Finiquito Individual</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="generarlotefiniquito.php">Generacion de Finiquitos Masivos</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="notificacionindividual.php">Generacion de Notificacion Individual</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="generarlotenotificacion.php">Generacion de Notificación Masiva</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="documentospersonalizados.php">Generacion de Documentos Individual</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="generarlotepersonalizado.php">Generacion de Documentos Masivos</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="impresiondocumentos.php">Impresión Documentos</a>
							</li>
						</ul>
					</li>
					<?php

					if (isset($_SESSION['GESTION_PERMISO'])) {
						if ($_SESSION['GESTION_PERMISO'] == true) {

					?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-box sidemenu-icon"></i><span class="sidemenu-label">Gestion de Usuarios</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="usuarios.php">Registrar Usuarios</a>
									</li>

								</ul>
							</li>
					<?php
						}
					}
					?>
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
							<h1 class="main-content-title tx-30">Generar Contrato Individual</h1>
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
										<h6 class="main-content-label mb-1">Seleccione el trabajador</h6>
										<p class="text-mutted card-sub-title"></p>
									</div>
									<div class="row justify-content-center d-none">
										<div class="col-md-6">
											<input type="text" id="rut" name="rut" class="form-control" onkeyup="formatRut(this)" placeholder="Ingrese el Rut" maxlength="12">
										</div>
									</div>
								</div>
								<div class="row justify-content-center d-none">
									<div class="col-md-6 text-center">
										<button onclick="buscartrabajador()" class="btn btn-primary">Buscar <i class="fa fa-search"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>


					<!-- ROW- opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Listado de Trabajadores Activos</h4>
								</div>
								<div class="card-body p-4">
									<div class="">
										<div class="table-responsive">
											<table class="table text-nowrap w-100" id="example1">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">RUT</th>
														<th class="bg-transparent">Nombre</th>
														<th class="bg-transparent">Fecha de Contrato</th>
														<th class="bg-transparent">Sexo</th>
														<th class="bg-transparent text-center">Generar Contrato</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = $c->listartrabajadoresactivos($_SESSION['CURRENT_ENTERPRISE']);

													$lista1 = $c->listartrabajadores($_SESSION['CURRENT_ENTERPRISE']);
													foreach ($lista as $object) {
														echo "<tr class='border-bottom-0'>";
														echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
														echo $object->getRut();
														echo "</td>";
														echo "<td class='text-muted fs-15 font-weight-semibold'>";
														echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2();
														echo "</td>";
														echo "<td class='text-muted fs-15 font-weight-semibold'>";
														//Imprimir Fecha en formato dd-mm-yyyy
														echo date("d-m-Y", strtotime($object->getNacimiento()));
														echo "</td>";
														echo "<td class='text-muted fs-15 font-weight-semibold'>";
														if ($object->getSexo() == 1) {
															echo "Masculino";
														} else {
															echo "Femenino";
														}
														echo "</td>";
														echo "<td class='text-center'>";
														echo "<a class='btn btn-outline-info btn-sm rounded-11' href='contratoindividual.php?code=" . $object->getId() . "' data-toggle='tooltip' data-original-title='Ver Más'>";
														echo "<i class='fa fa-plus'>";
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
						</div>
					</div>
					<!-- ROW-4 END -->
					<!-- ROW- opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card transcation-crypto1" id="transcation-crypto1">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Listado de Trabajadores Inactivos</h4>
								</div>
								<div class="card-body p-4">
									<div class="">
										<div class="table-responsive">
											<table class="table text-nowrap w-100" id="example2">
												<thead class="border-top">
													<tr>
														<th class="bg-transparent">RUT</th>
														<th class="bg-transparent">Nombre</th>
														<th class="bg-transparent">Fecha de Nacimiento</th>
														<th class="bg-transparent">Sexo</th>
														<th class="bg-transparent text-center">Generar Contrato</th>
													</tr>
												</thead>
												<tbody>
													<?php
													foreach ($lista1 as $object) {
														$exite = false;
														foreach ($lista as $object1) {

															if ($object->getId() == $object1->getId()) {
																$exite = true;
															}
														}
														if ($exite == false) {
															echo "<tr class='border-bottom-0'>";
															echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
															echo $object->getRut();
															echo "</td>";
															echo "<td class='text-muted fs-15 font-weight-semibold'>";
															echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2();
															echo "</td>";
															echo "<td class='text-muted fs-15 font-weight-semibold'>";
															//Imprimir fecha en formato dd-mm-aaaa
															echo date("d-m-Y", strtotime($object->getNacimiento()));
															echo "</td>";
															echo "<td class='text-muted fs-15 font-weight-semibold'>";
															if ($object->getSexo() == 1) {
																echo "Masculino";
															} else {
																echo "Femenino";
															}
															echo "</td>";
															echo "<td class='text-center'>";
															echo "<a class='btn btn-outline-info btn-sm rounded-11' href='contratoindividual.php?code=" . $object->getId() . "' data-toggle='tooltip' data-original-title='Generar Contrato'>";
															echo "<i class='fa fa-plus'>";
															echo "</i>";
															echo "</a>";
															echo "</td>";
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

		<!-- Sidebar -->
		<div class="sidebar sidebar-right sidebar-animate">
			<div class="sidebar-icon">
				<a href="#" class="text-right float-right text-dark fs-20" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x"></i></a>
			</div>
			<div class="sidebar-body">
				<h5>Todo</h5>
				<div class="d-flex p-3">
					<label class="ckbox"><input checked type="checkbox"><span>Hangout With friends</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input type="checkbox"><span>Prepare for presentation</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input type="checkbox"><span>Prepare for presentation</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input checked type="checkbox"><span>System Updated</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input type="checkbox"><span>Do something more</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input type="checkbox"><span>System Updated</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top">
					<label class="ckbox"><input type="checkbox"><span>Find an Idea</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<div class="d-flex p-3 border-top mb-0">
					<label class="ckbox"><input type="checkbox"><span>Project review</span></label>
					<span class="ml-auto">
						<i class="fe fe-edit-2 text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
						<i class="fe fe-trash-2 text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
					</span>
				</div>
				<h5>Overview</h5>
				<div class="p-4">
					<div class="main-traffic-detail-item">
						<div>
							<span>Founder &amp; CEO</span> <span>24</span>
						</div>
						<div class="progress">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" class="progress-bar progress-bar-xs wd-20p" role="progressbar"></div>
						</div><!-- progress -->
					</div>
					<div class="main-traffic-detail-item">
						<div>
							<span>UX Designer</span> <span>1</span>
						</div>
						<div class="progress">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="15" class="progress-bar progress-bar-xs bg-secondary wd-15p" role="progressbar"></div>
						</div><!-- progress -->
					</div>
					<div class="main-traffic-detail-item">
						<div>
							<span>Recruitment</span> <span>87</span>
						</div>
						<div class="progress">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" class="progress-bar progress-bar-xs bg-success wd-45p" role="progressbar"></div>
						</div><!-- progress -->
					</div>
					<div class="main-traffic-detail-item">
						<div>
							<span>Software Engineer</span> <span>32</span>
						</div>
						<div class="progress">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar progress-bar-xs bg-info wd-25p" role="progressbar"></div>
						</div><!-- progress -->
					</div>
					<div class="main-traffic-detail-item">
						<div>
							<span>Project Manager</span> <span>32</span>
						</div>
						<div class="progress">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar progress-bar-xs bg-danger wd-25p" role="progressbar"></div>
						</div><!-- progress -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

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
						<form action="" class="needs-validation was-validated">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" placeholder="RUT" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" placeholder="Nombre" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" placeholder="Primer Apellido" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" placeholder="Segundo Apellido" required="" type="text" value="">
									</div>
								</div>


								<div class="col-md-12 mt-3 text-right">
									<button type="reset" class="btn btn-warning btn-md"> <i class="fa fa-arrow-left"></i> Restablecer</button>
									<button type="submit" class="btn btn-primary btn-md"> <i class="fa fa-save"></i> Registrar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

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
													<th class="bg-transparent">Agregar</th>
												</tr>
											</thead>
											<tbody>

												<tr class="">
													<td class="text-muted fs-15 font-weight-semibold">08.</td>
													<td class="text-dark fs-15 font-weight-semibold">Emily Lewis</td>
													<td class="">
														<a class="btn btn-outline-info btn-sm rounded-11 mr-2" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-plus"></i></a>
													</td>
												</tr>
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

	<!-- INTERNAL INDEX js -->
	<script src="assets/js/index.js"></script>

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

	<?php
	if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
		$id = $_SESSION['CURRENT_ENTERPRISE'];
		echo "<script>";
		echo "window.onload = function(){
		listarcomunas();
		listarciudades();
		mostrarEmpresa(" . $id . ");
		}";
		echo "</script>";
	}

	?>

	<script src="JsFunctions/Trabajadores.js"></script>


</body>

</html>