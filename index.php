<?php
session_start();
if (isset($_SESSION['is_login'])) {
	header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>Sistem Informasi Monitoring PKL</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Dasho Bootstrap admin template made using Bootstrap 5 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 5, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Dasho, Dasho bootstrap admin template">
	<meta name="author" content="Phoenixcoded" />

	<!-- Favicon icon -->
	<link rel="icon" href="assets/images/favicon.svg" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
	<!-- animation css -->
	<link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
	<!-- vendor css -->
	<link rel="stylesheet" href="assets/css/style.css">

</head>

<!-- [ signin-img-slider2 ] start -->

<body class="auth-prod-slider">
	<div class="blur-bg-images"></div>
	<div class="auth-wrapper">
		<div class="auth-content container">
			<div class="card">
				<div class="row align-items-center">
					<div class="col-md-6">
						<div class="card-body">
							<img src="assets/images/logo-dark.svg" alt="" class="img-fluid mb-4">
							<h4 class="mb-3 f-w-400">Silahkan Login Disini!</h4>
							<form id="form-login">
								<div class="form-group mb-4">
									<label class="form-label">Email / Username</label>
									<input type="text" class="form-control" name="email_username" placeholder="masukkan email ..." autocomplete="off" autofocus>
								</div>
								<div class="form-group mb-4">
									<label class="form-label">Password</label>
									<input type="password" class="form-control" name="password" placeholder="masukkan password ...">
								</div>
								<button class="btn btn-primary col-lg-12 mb-4">Login</button>
							</form>
						</div>
					</div>
					<div class="col-md-6 d-none d-md-block">
						<div id="carouselExampleCaptions" class="carousel slide auth-slider" data-bs-ride="carousel">

							<ol class="carousel-indicators">
								<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
								<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
								<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
								<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"></li>
							</ol>
							<div class="carousel-inner">
								<div class="carousel-item active">
									<div class="auth-prod-slidebg bg-1"></div>
									<div class="carousel-caption d-none d-md-block">
										<img src="assets/images/product/prod-1.jpg" alt="product images" class="img-fluid mb-5">
										<h5>First slide label</h5>
										<p class="mb-5">Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
									</div>
								</div>
								<div class="carousel-item">
									<div class="auth-prod-slidebg bg-2"></div>
									<div class="carousel-caption d-none d-md-block">
										<img src="assets/images/product/prod-2.jpg" alt="product images" class="img-fluid mb-5">
										<h5>Second slide label</h5>
										<p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
									</div>
								</div>
								<div class="carousel-item">
									<div class="auth-prod-slidebg bg-3"></div>
									<div class="carousel-caption d-none d-md-block">
										<img src="assets/images/product/prod-1.jpg" alt="product images" class="img-fluid mb-5">
										<h5>Third slide label</h5>
										<p class="mb-5">Praesent commodo cursus magna, vel scelerisque nisl consectetur.
										</p>
									</div>
								</div>
								<div class="carousel-item">
									<div class="auth-prod-slidebg bg-4"></div>
									<div class="carousel-caption d-none d-md-block">
										<img src="assets/images/product/prod-2.jpg" alt="product images" class="img-fluid mb-5">
										<h5>Forth slide label</h5>
										<p class="mb-5">Praesent commodo cursus magna, vel scelerisque nisl consectetur.
										</p>
									</div>
								</div>
							</div>
							<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></a>
							<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ signin-img-slider2 ] end -->

	<!-- Required Js -->
	<script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script>
		$(document).ready(function() {
			$('#form-login').submit(function(e) {
				e.preventDefault();
				let data = $(this).serialize();
				data = data + '&action=login';
				$.ajax({
					type: 'POST',
					url: 'classes/Login.php',
					data: data,
					success: function(response) {
						if (response == 'success') {
							swal({
								title: "Sukses!",
								text: "Login Berhasil",
								icon: "success",
								buttons: false,
								dangerMode: false,
								showConfirmButton: false,
								showCancelButton: false,
								showCloseButton: false,
								timer: 2000
							}).then(() => {
								window.location.href = 'dashboard.php';
							});
						} else {
							swal({
								title: "Gagal!",
								text: "Login Gagal",
								icon: "error",
								buttons: false,
								dangerMode: false,
								showConfirmButton: false,
								showCancelButton: false,
								showCloseButton: false,
								timer: 2000
							}).then(() => {
								window.location.href = 'index.php';
							});
						}
					}
				});
			});
		});
	</script>
</body>

</html>