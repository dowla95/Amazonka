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
<h1 style='font-size:16px;color:red;'>Upis novog emaila</h1>
<?php 
if(isset($_POST['reg_sub']))
{
$uh=mysqli_num_rows(mysqli_query($conn, "SELECT email FROM subscribers WHERE email='$_POST[email]'"));
if($uh>0)
$msgr="Email vec postoji u bazi!";
else
{
mysqli_query($conn, "INSERT INTO subscribers SET email='$_POST[email]', akt=1, time='".time()."'");
$msgr="Novi email <b>$_POST[email]</b> je upisan";
}
}
if($msgr!="")
echo "<div class='infob'><div class='info_box'><div>$msgr</div></div></div>";

?>    	

						<form action="" method="post">
                     
                        <div class="col-sm-4" style="padding-left:0px;">
							<input type="email" name='email' placeholder="Email adresa*" required>
                        </div>
                         
                        <div class="col-sm-4">
<input type="hidden" name="reg_sub" value='1' />                                          
							<button type="submit" class="btn btn-default">Sačuvaj</button>
						</div>
                        </form>
					</div><!--/sign up form-->

			</div>
		</div>
	</section><!--/form-->
  </body>
  </html>