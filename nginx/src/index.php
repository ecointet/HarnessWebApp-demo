<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

session_start();
require("tools.php");
require_once "mobile-detect/Mobile_Detect.php";

$detect = new Mobile_Detect;
if (!$detect->isMobile()) $device = "Computer";
else if ($detect->isiPhone()) $device = "iPhone";
else if ($detect->isSamsung()) $device = "Samsung";
else if ($detect->isAndroidOS()) $device = "Android";

$_SESSION["device"] = $device;

//CONTEXT
if (!empty($_GET['id']))
	{
		
		$data = readApi($store, $_GET['id']);
		if ($data)
			{
				$_SESSION['buyer'] = $data["name"];
				$_SESSION['logo'] = $data["logo"];
				$_SESSION['background'] = $data["background"];
				//echo "DEBUG:";
				//echo "result[".$data["name"]."]";
				//print_r($data);
			}
	}
//
//echo "DEBUG";
//echo print_r($customerstore->findall());
//DEFAULT
if (!isset($_SESSION["logo"]) || empty($_SESSION["logo"])) $_SESSION["logo"] = "/img/harness-logo.png";
if (!isset($_SESSION["background"]) || empty($_SESSION["background"])) $_SESSION["background"] = "http://avante.biz/wp-content/uploads/Background-Pics-HD/Background-Pics-HD-001.jpg";
if (!isset($_SESSION['buyer']))
{
    $_SESSION['buyer'] = readable_random_string();
}
?>
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<meta http-equiv="Cache-control" content="no-cache, must-revalidate">
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="codepixer">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>WebApp - <?php echo $_SESSION['buyer']?></title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 


<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="/login/css/main.css">
<!--===============================================================================================-->



			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/nice-select.css">					
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">
			<link rel="stylesheet" href="css/main.css">

		</head>
		<body>
		<script>

function loadvaccin(){
	setInterval(function(){
      $('#vaccin').load('result.php');
 },2000);
}


function DoAction(v_action, v_value)
{
	console.log("Updating customer to :"+v_value);
	$.ajax({
		type: "GET",
		url: '/tools.php',
		data: {action: v_action, value: v_value},
		success: function(data){
			console.log(data);
		}
	});
			
}

		window.count_wallet=0;
		function Checkout(v_metric, v_value)
			{
				v_value = window.count_wallet;
				
				if (v_value <= 0)
				{
					$("div.shoppingcart" ).html("<p>EMPTY!</p>");
					return;
				}

				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				console.log("Try to send ["+v_metric+"] and ["+v_value+"]");
				$.ajax({
					type: "GET",
					url: '/api-signalfx.php',
					data: {metric: v_metric, value: v_value},
					success: function(data){
						if (data == "-1")
							$("div.shoppingcart" ).html("<p>ERROR</p>");
						else
						{
						console.log(data);
						window.count_wallet = 0;
						$("div.shoppingcart" ).html("<p>DONE!</p>");
						}
					}
				});
						
			}


			function AddToCart(v_metric, v_value)
			{
				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				console.log("Try to send ["+v_metric+"] and ["+v_value+"]");
				$.ajax({
					type: "GET",
					url: '/api-signalfx.php',
					data: {metric: v_metric, value: v_value},
					success: function(data){
						//if (data == "-1")
						//	$("div.shoppingcart" ).html("<p>ERROR</p>");
						//else
						//{
						console.log(data);
						window.count_wallet = parseInt(window.count_wallet) + parseInt(v_value);
						$("div.shoppingcart" ).html("<p>"+window.count_wallet+"</p>");
						//}
					}
				});
						
			}

			function Simulation()
			{
				var v_size = 60;
				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				alert("Simulation started for "+v_size+" seconds! Please watch the SignalFx Dashboard...");
				//console.log("Simulation starting...");
				$.ajax({
					type: "GET",
					url: '/simulation.php',
					data: {size: v_size},
					success: function(data){
						console.log(data);
						//alert("Simulation Finised!");
						$("div.shoppingcart" ).html("<p>DONE</p>");
					}
				});
						
			}

			

		


			
		</script>
		<style type="text/css">
.shoppingcart {
    background-image: url("img/bag.png");
    background-repeat: no-repeat, no-repeat;
	background-color: transparent;
	width:80px;
	height:80px;
	background-size: 80px;
	color:white;
	display:none;
}
.shoppingcart p{
   
	vertical-align: baseline;
    text-align: center;
    padding-top: 40px;
    font-size: 30px;

}
.banner-area {
    /* BACKGROUND */
    background: url(<? echo $_SESSION["background"]; ?>) center;
    background-size: cover;
}
</style>
			  <header id="header" id="home">
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="/"><img src="<? echo $_SESSION["logo"]; ?>" alt="" title="" height="50px"/></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="#home">Home</a></li>
				          <li><a href="#service">share with people</a></li>
						  <li><a href="#login">Login</a></li>
				          <li class="menu-has-children"><a href="">DEBUG</a>
				            <ul>
				              <li>Token: <b><?php echo $_ENV["TOKEN"]; ?></b></li>
							  <li>Realm: <b><?php echo $_ENV["REALM"]; ?></b></li>
				              <li>Hostname: <b><?php echo $_ENV["HOST"]; ?></b></li>
							  <li>"Buy-Metric=<b><?php echo $_ENV["BUYMETRIC"]; ?></b>"</li>
							  <li>"?company=<b><?php echo $_GET["company"]; ?></b>"</li>
				            </ul>
				          </li>
						  <li class="menu-has-children"><a href="">CONFIG</a>
				            <ul>
				              <li>Customer: <form><input type="text" id="customer" value="<?php echo $_SESSION['buyer']; ?>"></form></li>
							  <li>Logo: <form><input type="text" id="customer-logo" value="<?php echo $_SESSION['logo']; ?>"></form></li>
							  <li>Background: <form><input type="text" id="background" value="<?php echo $_SESSION['background']; ?>"></form></li>
				            </ul>
				          </li>
				        </ul>
				      </nav><!-- #nav-menu-container -->		    		
			    	</div>
			    </div>
			  </header><!-- #header -->


			<!-- start banner Area -->
			<section class="banner-area" id="home">	
				<div class="container">
					<div class="row fullscreen d-flex align-items-center justify-content-center">
						<div class="banner-content col-lg-10">
							<div style="margin:0 auto; margin-bottom:10px" id="SV Fintechn Corp.shoppingcart" name="shoppingcart" class="shoppingcart"><p>0</p></div>
							<h5 class="text-white text-uppercase"></h5>
							<h1>
												
							</h1>
							<div id="vaccin" name="vaccin" align="center"><a href="#login"><div align="center"><img src="img/captain-america.png" width="200px" /></div></a></div>
						</div>											
					</div>
				</div>
			</section>
			<!-- End banner Area -->	

					

			<!-- Start service Area -->
			<section class="service-area section-gap" id="service">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8 pb-40 header-text">
							<h1>
							<?php 
							$url = $_SERVER['HTTP_HOST']."/?id=".$_SESSION['buyer'];
							//echo $url
							?></h1>
							<p>
								<div style="align:center;font-size:15px">Get the App!</div>
								<?php echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$url.'"%2F&choe=UTF-8" width="100%">'; ?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-user"></span>Expert Technicians</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-license"></span>Professional Service</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-phone"></span>Great Support</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-rocket"></span>Technical Skills</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>				
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-diamond"></span>Highly Recomended</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-bubble"></span>Positive Reviews</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>									
							</div>
						</div>						
					</div>
				</div>	
			</section>
			<!-- End service Area -->

				<!-- Start Jenkins Area -->
			<section class="service-area section-gap" id="login">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8 pb-40 header-text">
						<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-70">
						Please Sign-in
					</span>
					<span class="login100-form-avatar">
						<img src="/login/images/avatar-01.jpg" alt="AVATAR">
					</span>

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
						<input class="input100" type="text" name="username">
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
						<input class="input100" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<ul class="login-more p-t-190">
						<li class="m-b-8">
							<span class="txt1">
								Forgot
							</span>

							<a href="#" class="txt2">
								Username / Password?
							</a>
						</li>

						<li>
							<span class="txt1">
								Don’t have an account?
							</span>

							<a href="#" class="txt2">
								Sign up
							</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
						</div>
					</div>
					
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-rocket"></span>Technical Skills</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>				
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-diamond"></span>Highly Recomended</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-bubble"></span>Positive Reviews</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>									
							</div>
						</div>						
					</div>
				</div>	
			</section>
			<!-- End service Area -->	

			<!-- Start ERROR Area -->
			<section class="service-area section-gap" id="error">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8 pb-40 header-text">
							<h1>
							Authentification - Login Module is down.
							</h1>
							<p>
								<div style="align:center;font-size:15px">Unable to authentificate.</div>
						
							</p>
						</div>
					</div>
										
					</div>
				</div>	
			</section>
			<!-- End service Area -->

			
			<!-- start footer Area -->		
			<footer class="footer-area section-gap">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Us</h6>
								<p>
									Powered by <a href="https://twitter.com/ecointet">Etienne Cointet</a> for Harness.io - 2021.
								</p>
								<p class="footer-text">
									<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								</p>								
							</div>
						</div>
						<div class="col-lg-5  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>Stay update with our latest</p>
								<div class="" id="mc_embed_signup">
									<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">
										<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
			                            	<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
			                            	<div style="position: absolute; left: -5000px;">
												<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
											</div>

										<div class="info"></div>
									</form>
								</div>
							</div>
						</div>						
						<div class="col-lg-2 col-md-6 col-sm-6 social-widget">
							<div class="single-footer-widget">
								<h6>Follow Us</h6>
								<p>Let us be social</p>
								<div class="footer-social d-flex align-items-center">xs
									<a href="https://twitter.com/signalfx"><i class="fa fa-twitter"></i></a>
									<a href="https://www.signalfx.com/"><i class="fa fa-dribbble"></i></a>
									<a href="#"><i class="fa fa-behance"></i></a>
								</div>
							</div>
						</div>							
					</div>
				</div>
			</footer>	
			<!-- End footer Area -->	

			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>		
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>	
			<script src="js/owl.carousel.min.js"></script>			
			<script src="js/jquery.sticky.js"></script>
			<script src="js/jquery.nice-select.min.js"></script>			
			<script src="js/parallax.min.js"></script>	
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>	

			<script>
//Customerchange
$( "#customer" ).change(function() {
	console.log($( "#customer" ).val());
	DoAction("update-customer", $( "#customer" ).val());
			});
//End

//Logochange
$( "#customer-logo" ).change(function() {
	console.log($( "#customer-logo" ).val());
	DoAction("update-logo", $( "#customer-logo" ).val());
			});
//End

//Backgroundchange
$( "#background" ).change(function() {
	console.log($( "#background" ).val());
	DoAction("update-background", $( "#background" ).val());
			});
//End

function GetName()
{
var person = prompt("What's your name?", "<?php echo $_SESSION["buyer"]; ?>");

if (person == null || person == "") {
  console.log("user is the default one");
} else {
	//console.log("user updated:"+person);
	DoAction("update-customer", person);
		}
}

loadvaccin(); // This will run on page load


//GetName();
			</script>
		</body>
	</html>



