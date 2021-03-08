<?php 
session_start();
include("../Connections/conn_admin.php");
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html dir="ltr" lang="en-US" class="ie6"> <![endif]-->
<!--[if IE 7]>    <html dir="ltr" lang="en-US" class="ie7"> <![endif]-->
<!--[if IE 8]>    <html dir="ltr" lang="en-US" class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html dir="ltr" lang="en-US"> <!--<![endif]-->

<!-- BEGIN head -->
<head>

	<!--Meta Tags-->
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
  
<?php 
echo $canon_meta;
?>

	<!--Stylesheets-->
	<link rel="stylesheet" href="<?php echo $patH1?>/css/superfish.css" type="text/css"  media="all"  />
 
	<link rel="stylesheet" href="<?php echo $patH1?>/css/prettyPhoto.css" type="text/css" media="all" />
	<link type="text/css" href="<?php echo $patH1?>/css/jqueryui/jquery.ui.datepicker.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo $patH1?>/style.css" type="text/css"  media="all"  />
	<link rel="stylesheet" href="<?php echo $patH1?>/css/colours/cream-red.css" type="text/css"  media="all"  />
	<link href='http://fonts.googleapis.com/css?family=Cardo:400,400italic,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo $patH?>/colorbox/colorbox1.css" />
	<!--Favicon-->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
     

 
 
 
	<!--JavaScript-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js'></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/jquery.ui.datepicker.js"></script>
	<script type='text/javascript' src='<?php echo $patH1?>/js/jquery.prettyPhoto.js'></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/slides.min.jquery.js"></script>
	<script type="text/javascript" src="<?php echo $patH1?>/js/scripts.js"></script>

<script type='text/javascript'  src="<?php echo $patH?>/colorbox/jquery.colorbox.js"></script>    	
 <script type="text/javascript">
$(document).ready(function() { 
    parent.$.fn.colorbox.resize({
        innerWidth: $(document).width(),
        innerHeight: $(document).height()
    });
}); 
</script>   
   
  </head>
  <body style='background:#f1f1f1;'>
  	<!-- BEGIN .background-wrapper -->
	<div class="background-wrapper">
		
		<!-- BEGIN .content-wrapper -->
		<div class="content-wrapper">
		
			<!-- BEGIN .content-body -->
			<div class="content-body">
				
<?php 
  $ip=getenv(REMOTE_ADDR);
     

$tip= preg_replace('#[^0-9]#i', '', $_GET['tip']);
$id_upisa= preg_replace('#[^0-9]#i', '', $_GET['id_upisa']);
$id_parent = preg_replace('#[^0-9]#i', '', $_GET['id_parent']);
if($_POST[upisi_komentar])

{
$Text=$_POST["tekst"];

$Text=strip_tags($Text);

$email=$_POST["email"];

$ime=strip_tags($_POST["ime"]);

$Text=strip_tags($Text);

$mesto=$_POST[mesto];
$tip=$_POST[tip];
$id_parent=$_POST[id_parent]?$_POST[id_parent]:0;
$id_upisa=$_POST[id_upisa];
$datum=time();

if (!empty($email) and !mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $email)) 
$msgr="Email adresa nije validna!";
elseif ($ime=="" || $Text=="" || $email=="")
$msgr="Niste ispunili sva obavezna polja!";

else
{

if(!mysqli_query($conn, "INSERT INTO comments SET naslov=".safe(strip_tags($ime)).", email=".safe(strip_tags($email)).", opis=".safe(strip_tags($Text)).", ip='$ip', datum='".time()."', akt='Y', id_parent='$id_parent', id_pro='$id_upisa', tip='$tip'")) echo mysqli_error();
$msgr_ok="Vaš komentar je upisan!";
 $zadnji=mysqli_insert_id($conn);
 ?>
<script>
/*$(document).ready(function(){
//parent.$.fn.colorbox.close();
var referrer = window.parent.location.href;
spl=referrer.split("#");

window.parent.location=spl[0]+"#coment<?php echo $zadnji?>";
window.parent.location.reload(true);
});*/
</script>
<?php 
}

} 


 

?>    
<br /><br />
      	<div class="page-content blog-list-wrapper"> 

<?php 

  
if($msgr!="")
{
?>
<div class="msg fail" name="komentar"><p><a name="komentar"><?php echo $msgr?></a></p></div>
<?php 
}
if($msgr_ok!="")
{
?>
<div class="msg success"><p><a name="komentar"><?php echo $msgr_ok?></a></p></div>
<?php 
}
?>
         		<!-- BEGIN #respond -->
								<div id="respond" class="clearfix"  style='padding:10px;'>
									<h3 id="reply-title">Odgovor na komentar</h3>

										<form action="#komentar" id="commentform" method="post">

											<div class="field-row">
												<label for="contact_name">Ime <span>(obavezno)</span></label>
											   	<input type="text" name="ime" id="contact_name" class="text_input" value="<?php echo $_POST[ime]?>" />
											</div>

											<div class="field-row">
												<label for="email">Email <span>(obavezno)</span></label>
												<input type="text" name="email" value="<?php echo $_POST[email]?>" id="email" class="text_input"  />		
											</div>

											<!--<div class="field-row">
												<label for="site_url">Website URL</label>
												<input type="text" name="site_url" id="site_url" class="text_input" value="" />		
											</div>-->

											<div class="field-row">
												<label for="message_text">Komentar <span>(obavezno)</span></label>
												<textarea name="tekst" id="message_text" class="text_input" cols="60" rows="9"><?php echo $_POST[tekst]?></textarea>
											</div>
<input type="hidden" name="tip" value="<?php echo $tip?>" />
<input type="hidden" name="id_upisa" value="<?php echo $id_upisa?>" />
<input type="hidden" name="id_parent" value="<?php echo $id_parent?>" />
											<input class="button2" type="submit" value="Upišite komentar" id="submit" name="upisi_komentar">

										</form>
<br /><br />
									<!-- END #respond -->
									</div>
</div>                  
</div>
</div>
</div>
</body>
</html>
