<?php
session_start();
unset($_SESSION['TRABJADOR_CONTRATO']);
require 'php/controller.php';
$c = new Controller();
$nombre = "";
if (isset($_GET['code'])) {
	$id = $_GET['code'];
	$tipo = $c->buscartipodocumento($id);
	if ($tipo != null) {
		$nombre = $tipo->getNombre();
	} else {
		header("Location: tipodocumento.php");
	}
} else {
	header("Location: tipodocumento.php");
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
	<meta name="description" content="Dashpro-  Admin Panel HTML Dashboard Template">
	<meta name="author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="responsive admin template,bootstrap dashboard theme,simple dashboard template,bootstrap admin dashboard,bootstrap 4 template admin,template admin bootstrap 4,template bootstrap 4 admin,quality dashboard template,bootstrap 4 admin template,premium bootstrap template,bootstrap simple dashboard,simple admin panel template,dashboard admin bootstrap 4,html css dashboard template,admin dashboard bootstrap 4,bootstrap 4 admin dashboard,bootstrap dashboard template">

	<!-- Favicon -->
	<link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />
	<link href="assets/css/toastify.min.css" rel="stylesheet" />

	<!-- Title -->
	<title>Gestor Documento | Redactar Documento</title>

	<!-- Bootstrap css-->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<!-- Icons css-->
	<link href="assets/css/icons.css" rel="stylesheet" />

	<!-- Internal Quill css-->
	<link href="assets/plugins/quill/quill.snow.css" rel="stylesheet">
	<link href="assets/plugins/quill/quill.bubble.css" rel="stylesheet">

	<!-- Internal Summernote css-->
	<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.css">

	<!-- Style css-->
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/dark-boxed.css" rel="stylesheet">
	<link href="assets/css/boxed.css" rel="stylesheet">
	<link href="assets/css/skins.css" rel="stylesheet">
	<link href="assets/css/dark-style.css" rel="stylesheet">

	<!-- Internal DataTables css-->
	<link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

	<!-- Color css-->
	<link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/css/colors/color.css">

	<!-- Select2 css -->
	<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

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
									<a class="nav-sub-link" href="trabajadores.php">Trabajadores</a>
								</li>

								<?php
								if ($_SESSION['GESTION_PERMISO'] == true || $_SESSION['ESCRITURA_PERMISO'] == true) {
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
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span
								class="sidemenu-label">Reportes</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="impresiondocumentos.php">Impresión Documentos</a>
							</li>
						</ul>
					</li>
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
						<div class="mt-0">
							<form class="form-inline">
								<div class="search-element">
									<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
									<button class="btn" type="submit">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</form>
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
							<h1 class="main-content-title tx-30">Redactar <h3 class="ml-2"> <?php echo $nombre; ?></h3>
							</h1>
						</div>
					</div>
					<!-- End Page Header -->

					<!-- Row -->
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="mb-3">
										<button class="btn btn-primary" id="btnAgregarCampos" data-target="#modalcampo" data-toggle="modal"><i class="fa fa-plus"></i> Agregar Campos</button>
									</div>
									<div id="summernote"></div>
									<div class="row">
										<div class="col-lg-12 text-right">
											<a href="tipodocumento.php" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Volver</a>
											<button class="btn btn-success" onclick="generarDocumento(<?php echo $id; ?>)"><i class="fa fa-save"></i> Registrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Row -->

					<!-- Row -->
					<div class="row d-none">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Quill Editor</h6>
										<p class="text-muted card-sub-title">Quill is a modern WYSIWYG editor built for compatibility and extensibility. Replacement icons from default svg icons are made from <a href="https://icons8.com/line-awesome">Line Awesome</a></p>
									</div>
									<div class="ql-wrapper">
										<div id="quillEditor">
											<p><strong>Quill</strong> is a free, open source <a href="https://github.com/quilljs/quill/">WYSIWYG editor</a> built for the modern web. With its <a href="https://quilljs.com/docs/modules/">modular architecture</a> and expressive API, it is completely customizable to fit any need.</p><br>
											<p>The icons use here as a replacement to default svg icons are from <a href="https://icons8.com/line-awesome">Line Awesome Icons</a>.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Row -->

					<!-- Row -->
					<div class="row d-none">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Quill Inline-Edit Editor</h6>
										<p class="text-muted card-sub-title">Quill text editor that can inline edit in a page.</p>
									</div>
									<div class="wd-xl-70p ht-350">
										<div class="ql-scrolling-demo" id="scrolling-container">
											<div id="quillInline">
												<h2>Try to select me and edit</h2>
												<p><br></p>
												<p>Pippin looked out from the shelter of <a href="https://www.bootstrapdash.com">Gandalf"s cloak</a>. He wondered if he was awake or still sleeping, still in the swift-moving dream in which he had been wrapped so long since the great ride began. The <a href="http://bootstrapdash.net">dark world</a> was rushing by and the wind sang loudly in his ears. He could see nothing but the wheeling stars, and away to his right vast shadows against the sky where the mountains of the South marched past. Sleepily he tried to reckon the times and stages of their journey, but his memory was drowsy and uncertain.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Row -->
				</div>
			</div>
		</div>
		<!-- End Main Content-->

		<!-- Main Footer-->
		<div class="main-footer text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<span>Copyright © 2021 <a href="#">Dashpro</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span>
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

		<!-- Quill Modal -->
		<div class="modal" id="modalQuill">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header pd-20">
						<h6 class="modal-title">Create New Document</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body pd-0">
						<div class="ql-wrapper ql-wrapper-modal ht-250">
							<div class="flex-1" id="quillEditorModal2">
								<p><strong>Quill</strong> is a free, open source <a href="https://github.com/quilljs/quill/">WYSIWYG editor</a> built for the modern web. With its <a href="https://quilljs.com/docs/modules/">modular architecture</a> and expressive API, it is completely customizable to fit any need.</p><br>
								<p>The icons use here as a replacement to default svg icons are from <a href="https://icons8.com/line-awesome">Line Awesome Icons</a>.</p>
							</div>
						</div>
					</div>
					<div class="modal-footer pd-20">
						<button class="btn ripple btn-main-primary" type="button">Save changes</button> <button class="btn ripple btn-light" type="button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Quill Modal -->

	</div>
	<!-- End Row -->
	<!-- Modal -->
	<div class="modal fade" id="modalcampo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Campos Disponibles</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<!----------------INFORMACION CELEBRACION DE CONTRATO--------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion Celebracion de Contrato</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CATEGORIA_CONTRATO')">CATEGORIA DE CONTRATO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CEL_REGION')">REGION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CEL_COMUNA')">COMUNA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_CELEBRACION')">FECHA CELEBRACION</button></div>

						<!--------------INFORMACION EMPRESA------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la Empresa</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('RUT_EMPRESA')">RUT EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NOMBRE_EMPRESA')">RAZON SOCIAL</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('RUT_REPRESENTANTE_LEGAL')">RUT REPRESENTANTE LEGAL</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('REPRESENTANTE_LEGAL')">REPRESENTANTE LEGAL</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CORREO_EMPRESA')">CORREO EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TELEFONO_EMPRESA')">TELEFONO EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CALLE_EMPRESA')">CALLE EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_EMPRESA')">NUMERO EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('REGION_EMPRESA')">REGION EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COMUNA_EMPRESA')">COMUNA EMPRESA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CODIGO_ACTIVIDAD')">CODIGO ACTIVIDAD</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DEPT_EMPRESA')">DEPARTAMENTO EMPRESA</button></div>

						<!-----------------------INFORMACION DEL TRABAJADOR----------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion Personal del Trabajador</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('RUT_TRABAJADOR')">RUT TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NOMBRE_TRABAJADOR')">NOMBRE TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('APELLIDO_1')">PRIMER APELLIDO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('APELLIDO_2')">SEGUNDO APELLIDO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_NACIMIENTO')">FECHA NACIMIENTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('SEXO')">SEXO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ESTADO_CIVIL')">ESTADO CIVIL</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NACIONALIDAD')">NACIONALIDAD</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CORREO_TRABAJADOR')">CORREO TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TELEFONO_TRABAJADOR')">TELEFONO TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('REGION_TRABAJADOR')">REGION TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COMUNA_TRABAJADOR')">COMUNA TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CALLE_TRABAJADOR')">CALLE TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_CASA_TRABAJADOR')">NUMERO CASA TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DEPARTAMENTO_TRABAJADOR')">DEPARTAMENTO TRABAJADOR</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DISCAPACIDAD')">DISCAPACIDAD</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('PENSION_INVALIDEZ')">PENSION INVALIDEZ</button></div>

						<!---------------------------------NATURALEZA DE LOS SERVICIOS----------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la naturaleza de los servicios</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CENTRO_DE_COSTO')">CENTRO DE COSTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CARGO')">CARGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DESCRIPCION_CARGO')">DESCRIPCION CARGO</button></div>

						<!--------------------------------DIRECCION ESPECIFICA (LUGAR DE TRABAJO UNICO)------------------------------------>
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la direccion especifica (lugar de trabajo unico)</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('REGION_ESPECIFICA')">REGION ESPECIFICA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COMUNA_ESPECIFICA')">COMUNA ESPECIFICA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CALLE_ESPECIFICA')">CALLE ESPECIFICA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_CASA_ESPECIFICA')">NUMERO ESPECIFICO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DEPARTAMENTO_ESPECIFICO')">DEPARTAMENTO ESPECIFICO</button></div>

						<!---------------------------------ZONA GEOGRAFICA DE PRESTACION DE SERVICIO DEL TRABAJADOR----------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la zona geografica de prestacion de servicio del trabajador</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ZONA_PRESTACION')">ZONA PRESTACION</button></div>

						<!-----------------------------------SERVICIOS EN REGIMEN SUBCONTRATACION---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los servicios en regimen subcontratacion</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('RUT_EMPRESA_SUBCONTRATADA')">RUT EMPRESA SUBCONTRATADA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NOMBRE_EMPRESA_SUBCONTRATADA')">NOMBRE EMPRESA SUBCONTRATADA</button></div>

						<!------------------------------------SERVICIO TRANSITORIOS---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los servicios transitorios</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('RUT_EMPRESA_TRANSITORIA')">RUT EMPRESA TRANSITORIA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NOMBRE_EMPRESA_TRANSITORIA')">NOMBRE EMPRESA TRANSITORIA</button></div>

						<!-------------------------------------REMUNERACIONES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de las remuneraciones</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('SUELDO_BASE')">TIPO SUELDO BASE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('SUELDO_MONTO')">SUELDO MONTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('SUELDO_MONTO_LETRAS')">MONTO SUELDO EN LETRAS</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ZONA_EXTREMA')">ZONA EXTREMA</button></div>

						<!-------------------------------------HABERES IMPONIBLES---------------------------------------->
						<!-------------------------------------HABERES IMPONIBLES TRIBUTABLES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los haberes imponibles tributables</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_TRIBUTABLE')">HABER IMPONIBLE TRIBUTABLE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_TRIBUTABLE_MONTO')">HABER IMPONIBLE TRIBUTABLE MONTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_TRIBUTABLE_PERIODO')">HABER IMPONIBLE TRIBUTABLE PERIODO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_NO_TRIBUTABLE_DETALLE')">HABER IMPONIBLE NO TRIBUTABLE DETALLE</button></div>

						<!-------------------------------------HABERES IMPONIBLES NO TRIBUTABLES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los haberes imponibles no tributables</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_NO_TRIBUTABLE')">HABER IMPONIBLE NO TRIBUTABLE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_NO_TRIBUTABLE_MONTO')">HABER IMPONIBLE NO TRIBUTABLE MONTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_NO_TRIBUTABLE_PERIODO')">HABER IMPONIBLE NO TRIBUTABLE PERIODO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_IMPO_NO_TRIBUTABLE_DETALLE')">HABER IMPONIBLE NO TRIBUTABLE DETALLE</button></div>

						<!-------------------------------------HABERES NO IMPONIBLES TRIBUTABLES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los haberes no imponibles tributables</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_TRIBUTABLE')">HABER NO IMPONIBLE TRIBUTABLE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_TRIBUTABLE_MONTO')">HABER NO IMPONIBLE TRIBUTABLE MONTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_TRIBUTABLE_PERIODO')">HABER NO IMPONIBLE TRIBUTABLE PERIODO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_TRIBUTABLE_DETALLE')">HABER NO IMPONIBLE TRIBUTABLE DETALLE</button></div>

						<!-------------------------------------HABERES NO IMPONIBLES NO TRIBUTABLES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de los haberes no imponibles no tributables</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_NO_TRIBUTABLE')">HABER NO IMPONIBLE NO TRIBUTABLE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_NO_TRIBUTABLE_MONTO')">HABER NO IMPONIBLE NO TRIBUTABLE MONTO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_NO_TRIBUTABLE_PERIODO')">HABER NO IMPONIBLE NO TRIBUTABLE PERIODO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HABER_NO_IMPO_NO_TRIBUTABLE_DETALLE')">HABER NO IMPONIBLE NO TRIBUTABLE DETALLE</button></div>

						<!-------------------------------------GRATIFICACIONES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de las gratificaciones</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('GRATIFICACION_FORMA_PAGO')">FORMA DE PAGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('PERIODO_GRATIFICACION')">PERIODO DE PAGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DETALLE_REMUNERACION_GRATIFICACION')">DETALLE DE REMUNERACION</button></div>

						<!-------------------------------------PERIODO Y FORMA DE PAGO---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion del periodo y forma de pago</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('PERIODO_PAGO')">PERIODO DE PAGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_PAGO')">FECHA DE PAGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FORMA_PAGO')">FORMA DE PAGO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('BANCO')">BANCO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TIPO_CUENTA')">TIPO DE CUENTA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_CUENTA')">NUMERO DE CUENTA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ANTICIPO')">ANTICIPO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('AFP')">AFP</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('SALUD')">SALUD</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('OTROS_PACTOS')">OTROS PACTOS</button></div>

						<!-------------------------------------JORNADA DE TRABAJO Y OTRAS ESTIPULACIONES---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la jornada de trabajo y otras estipulaciones</h6>
						</div>
						<!-------------------------------------JORNADA EXCEPCIONAL---------------------------------------->
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('JORNADA_EXCEPCIONAL')">JORNADA EXCEPCIONAL</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_RESOLUCION')">NUMERO DE RESOLUCION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_RESOLUCION')">FECHA DE RESOLUCION</button></div>


						<!-------------------------------------INFORMACION JORNADA---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Informacion de la jornada</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TIPO_JORNADA')">TIPO DE JORNADA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DURACION_JORNADA_HORAS')">DURACION DE JORNADA DIARIA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DURACION_JORNADA_MENSUAL')">DURACION DE JORNADA MENSUALES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('HORARIOS_TURNOS')">HORARIOS Y TURNOS</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COLACION_MINUTOS')">COLACION EN MINUTOS</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ROTACION')">ROTACION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COLACION_IMPUTABLES_MINUTOS')">COLACION IMPUTABLES EN MINUTOS</button></div>

						<!-------------------------------------DISTRIBUCION DE JORNADA---------------------------------------->
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Distribucion de JORNADA</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DISTRIBUCION_JORNADA')">DISTRIBUCION DE JORNADA</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TIPO_CONTRATO')">TIPO DE CONTRATO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('INICIO_CONTRATO')">INICIO DE CONTRATO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TERMINO_CONTRATO')">TERMINO DE CONTRATO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('ESTIPULACIONES')">ESTIPULACIONES</button></div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Vacaciones</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('NUMERO_COMPROBANTE')">NUMERO COMPROBANTE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('PERIODO_VACACIONES')">PERIODO VACACIONES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('INICIO_PERIODO_VACACIONES')">INICIO PERIODO VACACIONES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TERMINO_PERIODO_VACACIONES')">TERMINO PERIODO VACACIONES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_INICIO_VACACIONES')">FECHA INICIO VACACIONES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_TERMINO_VACACIONES')">FECHA TERMINO VACACIONES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('TOTAL_DIAS_VACACIONES')">DIAS TOTALES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DIAS_VACACIONES')">DIAS HABILES TOMADOS</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DIAS_HABILES_RESTANTES')">DIAS HABILES RESTANTES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_COMPROBANTE')">FECHA COMPROBANTE</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('OBSERVACIONES_VACACIONES')">OBSERVACIONES VACACIONES</button></div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Finiquito</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_FINIQUITO')">FECHA FINIQUITO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CAUSAL_FINIQUITO')">CAUSAL FINIQUITO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DETALLE_FINIQUITO')">DETALLE FINIQUITO</button></div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">Notificación</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_NOTIFICACION')">FECHA NOTIFICACION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CAUSAL_DE_DERECHO')">CAUSAL DE DERECHO</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('CAUSAL_DE_HECHOS')">CAUSAL DE HECHOS</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('COTIZACIONES_PREVISIONALES')">COTIZACIONES PREVISIONALES</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FORMA_DE_COMUNICACION')">FORMA DE COMUNICACION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DOCUMENTACION_DE_ACREDITACION')">DOCUMENTACION DE ACREDITACION</button></div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('DISPOSICION_Y_PAGO')">DISPOSICIÓN Y PAGO DE FINIQUITO</button></div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<h6 class="main-content-label mb-1 text-center">OTROS DOCUMENTOS</h6>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mt-3 mb-3"><button class="btn btn-success btn-block" data-dismiss="modal" onclick="agregarcampo('FECHA_GENERACION')">FECHA GENERACIÓN</button></div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

		<!-- Internal Quill js-->
		<script src="assets/plugins/quill/quill.min.js"></script>

		<!-- Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- Internal Summernote js-->
		<script src="assets/plugins/summernote/summernote-bs4.js"></script>

		<!-- Internal Form-editor js-->
		<script src="assets/js/form-editor.js"></script>

		<!-- Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- Sidemenu js -->
		<script src="assets/plugins/sidemenu/sidemenu.js"></script>

		<script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
		<script src="assets/js/table-data.js"></script>
		<script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>

		<!-- Sidebar js -->
		<script src="assets/plugins/sidebar/sidebar.js"></script>

		<!-- Select2 js-->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

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
		<script src="JsFunctions/EditDocumento.js"></script>
		<script>
			window.onload = function() {
				cargarDocumento(<?php echo $id; ?>);
			}
		</script>
</body>

</html>