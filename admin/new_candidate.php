<?php 
include("header-top-add-user.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titles?></title>        
<meta name="description" content="<?php echo $descripts?>" />
	<meta name="keywords" content="" />
    <meta name="author" content="">
    
    <base href="<?php echo $patH?>/">
    <link href="<?php echo $patH?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $patH?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $patH?>/css/prettyPhoto.css" rel="stylesheet">
 
    <link href="<?php echo $patH?>/css/animate.css" rel="stylesheet">
	<link href="<?php echo $patH?>/css/main.css" rel="stylesheet">
	<link href="<?php echo $patH?>/css/responsive.css" rel="stylesheet">
<script src="<?php echo $patH?>/js/jquery.js"></script>
<script src="<?php echo $patH?>/js/js.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo $patH?>/images/icon/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<body>
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
 
					<div class="login-form col-sm-12"><!--sign up form-->
<h1 style='font-size:16px;color:red;'>Upis novog korisnika</h1>
<?php 

if($msgr!="")
echo "<div class='infob'><div class='info_box'><div>$msgr</div></div></div>";

?>    	

						<form action="" method="post">
                        <div class="col-sm-4">
							<input type="text" name='ime' placeholder="Ime i prezime ili naziv firme*" required>
                        </div>
                        <div class="col-sm-4">
							<input type="email" name='email' placeholder="Email adresa*" required>
                        </div>
                        <div class="col-sm-4">
							<input type="text" name="pib" placeholder="Za firmu unesite PIB"/>
                        </div>
                        <div class="col-sm-4">
							<input type="password" placeholder="Lozinka*"  name="password" required>
                        </div>
                        <div class="col-sm-4">
							<input type="password" placeholder="Ponovite lozinku*"  name="password1" required>
                        </div>
                        <div class="col-sm-4">
							<input type="text" placeholder="Telefon*" name="telefon" required>
                        </div>
                        <div class="col-sm-4">
							<input type="text" placeholder="Poštanski broj*" name="pbroj" required>
                        </div>
                        <div class="col-sm-4">
							<input type="text" placeholder="Grad - Mesto*" name="grad" required>
                        </div>
                        <div class="col-sm-4">
							<input type="text" placeholder="Ulica i broj*" name="ulica_broj" required>
                        </div>
                        <div class="col-sm-4">
                        
                        </div>
                        <div class="col-sm-4">
                        <span><input type="checkbox" name="vesti" value="1" class="checkbox" checked>Želim da dobijam vesti sa sajta</span>
                        </div>
                        <div class="col-sm-4">
<input type="hidden" name="reg_cand" value='1' />                                          
							<button type="submit" class="btn btn-default">Registracija</button>
						</div>
                        </form>
					</div><!--/sign up form-->

			</div>
		</div>
	</section><!--/form-->
  </body>
  </html>