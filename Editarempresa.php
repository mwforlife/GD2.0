<?php
require 'php/controller.php';
$c = new Controller();
?>
<?php
session_start();
unset($_SESSION['TRABJADOR_CONTRATO']);
$rut = "";
$nombre = "";
$direccion = "";
$region = 0;
$telefono = "";
$correo = "";
$giro = "";
$comuna = 0;
$ciudad = 0;
$caja = 0;
$mutual = 0;
$cotb = 0;
$cotls = 0;
$cotad = 0;
$plan = 0;

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
?>
<?php
$id = 0;
if (isset($_GET['code'])) {
	$id = $_GET['code'];
	$empresa = $c->buscarEmpresa1($id);
	if ($empresa != null) {
		$rut = $empresa->getRut();
		$nombre = $empresa->getRazonSocial();
		$nombre = $empresa->getRazonSocial();
		$calle = $empresa->getCalle();
		$numero = $empresa->getNumero();
		$departamento = $empresa->getDepartamento();
		$region = $empresa->getRegion();
		$telefono = $empresa->getTelefono();
		$correo = $empresa->getEmail();
		$giro = $empresa->getGiro();
		$comuna = $empresa->getComuna();
		$ciudad = $empresa->getCiudad();
		$caja = $empresa->getCajasCompensacion();
		$mutual = $empresa->getMutuales();
		$cotb = $empresa->getCotizacionBasica();
		$cotls = $empresa->getCotizacionLeySanna();
		$cotad = $empresa->getCotizacionAdicional();
		$plan = $c->buscarplanempresa($id);

		$EMPRESA_ID = $id;
	} else {
		header('Location: empresas.php');
	}
} else {
	header('Location: empresas.php');
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
		<!-- Main Content-->
		<div class="main-content side-content pt-0">
			<?php
			$empresa = $c->buscarEmpresa1($id);
			$rut = $empresa->getRut();
			$nombre = $empresa->getRazonSocial();
			$nombre = $empresa->getRazonSocial();
			$calle = $empresa->getCalle();
			$villa = $empresa->getVilla();
			$numero = $empresa->getNumero();
			$departamento = $empresa->getDepartamento();
			$region = $empresa->getRegion();
			$telefono = $empresa->getTelefono();
			$correo = $empresa->getEmail();
			$giro = $empresa->getGiro();
			$comuna = $empresa->getComuna();
			$ciudad = $empresa->getCiudad();
			$caja = $empresa->getCajasCompensacion();
			$mutual = $empresa->getMutuales();
			$cotb = $empresa->getCotizacionBasica();
			$cotls = $empresa->getCotizacionLeySanna();
			$cotad = $empresa->getCotizacionAdicional();
			?>

			<div class="container-fluid">
				<div class="inner-body">
					<!-- Page Header -->
					<div class="page-header">
						<div class="page-header-1">
							<h1 class="main-content-title tx-30">Empresas</h1>
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
										<h6 class="main-content-label mb-1">Editar de Empresa</h6>
										<p class="text-mutted card-sub-title"></p>
									</div>
									<form name="EnterpriseEditForm" id="EnterpriseEditForm" class="">
										<input name="EMPRESAID" required=""type="hidden" value="<?php echo $id; ?>">
										<div class="row">
											<div class="col-md-12">
												<label for="">Seleccionar Plan</label>
												<select name="plan" id="plan" class="form-control">
													<?php
													$planes = $c->listarplanes();
													if (count($planes) > 0) {
														foreach ($planes as $planempresa) {
															if ($planempresa->getId() == $plan) {
																echo "<option value='" . $planempresa->getId() . "' selected>" . $planempresa->getNombre() . "</option>";
															} else {
																echo "<option value='" . $planempresa->getId() . "'>" . $planempresa->getNombre() . "</option>";
															}
														}
													} else {
														echo "<option value='0' >No hay planes registrados</option>";
													}
													?>
												</select>
												<hr>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Rut Empresa</label>
													<input class="form-control" id="EnterpriseRut" name="EnterpriseRut" placeholder="RUT" maxlength="12" onkeyup="formatRut(this)" required="" type="text" value="<?php echo $rut; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Razón Social</label>
													<input class="form-control" id="EnterpriseNombre" name="EnterpriseNombre" placeholder="Razón Social" required="" type="text" value="<?php echo $nombre; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>CALLE</label>
													<input class="form-control" id="Enterprisecalle" name="Enterprisecalle" placeholder="Calle" required="" type="text" value="<?php echo $calle; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Villa / Poblacion</label>
													<input class="form-control" id="Enterprisevilla" name="Enterprisevilla" placeholder="Villa / Población" required="" type="text" value="<?php echo $villa; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>NUMERO</label>
													<input class="form-control" id="Enterprisenumero" name="Enterprisenumero" placeholder="Numero" required="" type="text" value="<?php echo $numero; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Departamento (Opcional)</label>
													<input class="form-control" id="Enterprisedept" name="Enterprisedept" placeholder="Departamento" type="text" value="<?php echo $departamento; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group select2-lg">
													<label>Región</label>
													<select name="EnterpriseRegion" id="EnterpriseRegion" onchange="listarcomunas(), listarciudades()" class="form-control regiones">
														<?php
														$lista = $c->listarregiones();
														if (count($lista) > 0) {
															foreach ($lista as $ciudad) {
																if ($ciudad->getId() == $region) {
																	echo "<option value='" . $ciudad->getId() . "' selected>" . $ciudad->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $ciudad->getId() . "'>" . $ciudad->getNombre() . "</option>";
																}
															}
														} else {
															echo "<option value='0' >No hay regiones registradas</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group select2-lg">
													<label>Comuna</label>
													<select name="EnterpriseComuna" id="EnterpriseComuna" class="form-control comunas">
														<?php
														$lista = $c->listarcomunas($region);
														if (count($lista) > 0) {
															foreach ($lista as $comuna) {
																if ($comuna->getId() == $empresa->getComuna()) {
																	echo "<option value='" . $comuna->getId() . "' selected>" . $comuna->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $comuna->getId() . "'>" . $comuna->getNombre() . "</option>";
																}
															}
														} else {
															echo "<option value='0' >No hay comunas registradas</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group select2-lg">
													<label>Ciudad</label>
													<select name="EnterpriseCiudad" id="EnterpriseCiudad" class="form-control ciudades">
														<?php
														$lista = $c->listarciudades($region);
														if (count($lista) > 0) {
															foreach ($lista as $comuna) {
																if ($comuna->getId() == $empresa->getComuna()) {
																	echo "<option value='" . $comuna->getId() . "' selected>" . $comuna->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $comuna->getId() . "'>" . $comuna->getNombre() . "</option>";
																}
															}
														} else {
															echo "<option value='0' >No hay Ciudades registradas</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Telefono</label>
													<input name="EnterpriseTelefono" id="EnterpriseTelefono" class="form-control" placeholder="Telefono" required="" type="text" value="<?php echo $telefono; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Correo Electronico</label>
													<input name="EnterpriseCorreo" id="EnterpriseCorreo" class="form-control" placeholder="Correo Electronico" required="" type="text" value="<?php echo $correo; ?>">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group has-success ">
													<label>Giro Comercial</label>
													<input name="EnterpriseGire" id="EnterpriseGiro" class="form-control" placeholder="Giro Comercial" required="" type="text" value="<?php echo $giro; ?>">
												</div>
											</div>
										</div>
										<hr>
										<div>
											<h6 class="main-content-label mb-1">Caja de Compensación</h6>
											<p class="text-mutted card-sub-title"></p>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group select2-lg">
													<label>Caja Compensación</label>
													<select name="EnterpriseCaja" id="EnterpriseCaja" class="form-control ">
														<?php
														$lista = $c->listarCajasCompensacion();
														if (count($lista) > 0) {
															foreach ($lista as $caja) {
																if ($caja->getId() == $empresa->getCajasCompensacion()) {
																	echo "<option value='" . $caja->getId() . "' selected>" . $caja->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $caja->getId() . "'>" . $caja->getNombre() . "</option>";
																}
															}
														} else {
															echo "<option value='0' >No hay cajas de compensacion registradas</option>";
														}
														?>
													</select>
												</div>
											</div>
										</div>


										<hr>
										<div>
											<h6 class="main-content-label mb-1">Mutual de Seguridad</h6>
											<p class="text-mutted card-sub-title"></p>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group select2-lg">
													<label>Mutuales de Seguridad</label>
													<select name="EnterpriseMutual" id="EnterpriseMutual" class="form-control ">
														<?php
														$lista = $c->listarMutuales();
														if (count($lista) > 0) {
															foreach ($lista as $mutual) {
																if ($mutual->getId() == $empresa->getMutuales()) {
																	echo "<option value='" . $mutual->getId() . "' selected>" . $mutual->getNombre() . "</option>";
																} else {
																	echo "<option value='" . $mutual->getId() . "'>" . $mutual->getNombre() . "</option>";
																}
															}
														} else {
															echo "<option value='0' >No hay mutuales registradas</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6 col-md-6">
												<div class="form-group has-success ">
													<label for="">Cotización basica (%)</label>
													<input class="form-control" name="EnterpriseCotizacionB" id="EnterpriseCotizacionB" placeholder="0" readonly required="" type="number" value="<?php echo $cotb; ?>">
												</div>
											</div>
											<div class="col-lg-6 col-md-6">
												<div class="form-group has-success ">
													<label for="">Cotización Ley Sanna (%)</label>
													<input class="form-control" name="EnterpriseCotizacionL" id="EnterpriseCotizacionL" placeholder="0" readonly required="" type="number" value="<?php echo $cotls; ?>">
												</div>
											</div>
											<div class="col-lg-6 col-md-12">
												<div class="form-group has-success ">
													<label for="">Cotización Adicional (%)</label>
													<input min="0" value="<?php echo $cotad; ?>" class="form-control" name="EnterpriseCotizacionC" id="EnterpriseCotizacionC" step="0.01" placeholder="Ingresar tasa" required="" type="number" value="">
												</div>
											</div>

										</div>

										<div class="col-md-12 mt-3 text-right">
											<button type="submit" class="btn btn-primary btn-md"> <i class="fa fa-refresh"></i> Actualizar</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>


					<!-- Representante Legal -->
					<div class="row adi">
						<div class="col-lg-12">
							<div class="card orverflow-hidden">
								<div class="card-body">
									<div class="w-100">
										<h6 class="main-content-label mb-1">Representante Legal</h6>
									</div>
									<div class="table-responsive">
										<table class="table w-100 text-nowrap">
											<thead class="border-top">
												<tr>
													<th class="bg-transparent">Rut</th>
													<th class="bg-transparent">Nombre</th>
													<th class="bg-transparent">Apellidos</th>
													<th class="bg-transparent">Eliminar</th>
												</tr>
											</thead>
											<tbody id="tablerepre">

											</tbody>
										</table>
									</div>
									<div>
										<button class="btn btn-primary" data-toggle="modal" data-target="#representantelegalmodal" type="button">Agregar Representante</button>

									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Codigo De actividad-->
					<div class="row adi">
						<div class="col-lg-12">
							<div class="card orverflow-hidden">
								<div class="card-body">
									<div>
										<h6 class="main-content-label mb-1">Codigo de actividad economica</h6>

									</div>
									<div class="table-responsive">
										<table class="table w-100 text-nowrap">
											<thead class="border-top">
												<tr>
													<th class="bg-transparent">Codigo SII</th>
													<th class="bg-transparent">Actividad</th>
													<th class="bg-transparent">Eliminar</th>
												</tr>
											</thead>
											<tbody id="tabledata">


											</tbody>
										</table>
									</div>
									<div>
										<button class="btn btn-primary" data-toggle="modal" data-target="#codigoactividadmodal" type="button">Agregar Codigo Actividad</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-----Guardar Cambios------->
					<div class="row adi">
						<div class="col-md-12 text-right">
							<a href="empresas.php" class="btn btn-danger btn-md"> <i class="fa fa-arrow-left"></i> Volver</a>
							<button class="btn btn-primary" onclick="guardar()"> <i class="fa fa-save"></i> Guardar</button>
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
						<form id="RepresentanteForm" name="RepresentanteForm" class="needs-validation was-validated">
							<div class="row">
								<input name="EMPRESAID" id="EMPRESAID1" required=""type="hidden" value="<?php echo $id; ?>">
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" id="RepresentanteRut" maxlength="12" onkeyup="formatRut(this)" name="RepresentanteRut" placeholder="RUT" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" id="RepresentanteNombre" name="RepresentanteNombre" placeholder="Nombre" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" id="RepresentanteApellido1" name="RepresentanteApellido1" placeholder="Primer Apellido" required="" type="text" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-success ">
										<input class="form-control" id="RepresentanteApellido2" name="RepresentanteApellido2" placeholder="Segundo Apellido" type="text" value="">
									</div>
								</div>


								<div class="col-md-12 mt-3 text-right">
									<button type="reset" class="btn btn-warning btn-md"> <i class="fa fa-refresh"></i> Restablecer</button>
									<button type="submit" class="btn btn-primary btn-md"> <i class="fa fa-save"></i> Registrar</button>
								</div>
							</div>
						</form>
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
										<table class="table w-100 text-nowrap" id="example1">
											<thead class="border-top">
												<tr>
													<th class="bg-transparent">Codigo SII</th>
													<th class="bg-transparent">Actividad</th>
													<th class="bg-transparent">Agregar</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$lista = $c->ListarCodigoActividad();
												foreach ($lista as $key) {
													echo "<tr class=''>";
													echo "<td class='text-muted fs-15 font-weight-semibold'>" . $key->getCodigoSii() . "</td>";
													echo "<td class='text-dark fs-15 font-weight-semibold'>" . $key->getNombre() . "</td>";
													echo "<td class=''>";
													echo "<a class='btn btn-outline-success btn-sm rounded-11 mr-2' data-toggle='tooltip' onclick='CodigoActividad1(" . $key->getId() . ", ".$id.")' data-original-title='Agregar'><i class='fa fa-plus'></i></a>";
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
	<script src="JsFunctions/validation.js"></script>
	<script src="JsFunctions/Alert/toastify.js"></script>
	<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
	<script src="JsFunctions/Alert/alert.js"></script>
	<script src="JsFunctions/Comunas.js"></script>
	<script src="JsFunctions/precargado.js"></script>
	<script src="JsFunctions/Empresa.js"></script>
	<script>
		window.onload = function() {
			ListarRepresentantes();
			ListarCodigoActividad();
		}
	</script>



</body>

</html>