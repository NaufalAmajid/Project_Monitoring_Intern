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
							<h4 class="mb-3 f-w-400">Login into your account</h4>
							<div class="form-group mb-2">
								<label class="form-label">Enter Email</label>
								<input type="email" class="form-control" placeholder="name@sitename.com">
							</div>
							<div class="form-group mb-3">
								<label class="form-label">Enter Password</label>
								<input type="password" class="form-control" placeholder="Allow only max 14 character">
							</div>
							<div class="saprator"><span>OR</span></div>
							<button class="btn btn-facebook mb-2 me-2"><i class="fab fa-facebook-f"></i>facebook</button>
							<button class="btn btn-googleplus mb-2 me-2"><i class="fab fa-google-plus-g"></i>Google</button>
							<button class="btn btn-twitter mb-2 me-2"><i class="fab fa-twitter"></i>Twitter</button>
							<div class="form-group text-start mt-2">
								<div class="checkbox checkbox-primary d-inline">
									<input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
									<label for="checkbox-fill-a1" class="cr">Save credentials</label>
								</div>
							</div>
							<button class="btn btn-primary mb-4" onclick="Login()">Login</button>
							<p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p>
							<p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p>
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


	<div class="footer-fab">
		<div class="b-bg">
			<i class="fas fa-question"></i>
		</div>
		<div class="fab-hover">
			<ul class="list-unstyled">
				<li><a href="../doc/index-bc-package.html" target="_blank" data-text="UI Kit" class="btn btn-icon btn-rounded btn-info m-0"><i class="feather icon-layers"></i></a></li>
				<li><a href="../doc/index.html" target="_blank" data-text="Document" class="btn btn-icon btn-rounded btn-primary m-0"><i class="feather icon feather icon-book"></i></a></li>
			</ul>
		</div>
	</div>


</body>

</html>