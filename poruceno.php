<?php 
session_start();
include("Connections/conn.php");
include(SUBFOLDERS."include/Izvrsenja.php");
if(isset($_GET['id']) and isset($_SESSION['userid']) and $_SESSION['userid']>0)
{
$mn=mysqli_query($conn, "SELECT * FROM porudzbine WHERE id=$_GET[id] and user_id=".$_SESSION['userid']);
$mn1=mysqli_fetch_assoc($mn);
?>
<!DOCTYPE html>

<html lang="sr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titles?></title>        
<meta name="description" content="<?php echo $descripts?>" />
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
</head><!--/head-->

<body>
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
					<div class="login-form col-sm-12"><!--sign up form-->
 <?php 
 $zasend='	
<table class="table table-condensed">
						<tr><td colspan="2"><b>Nova porudžbina!</b> Detalji porudzbine</td></tr>
			<tr><td>Broj porudzbine: </td><td align="left">'.$mn1['id'].'</td></tr>
 	<tr><td>Datum porudzbine: </td><td align="left">'.date("d.m.Y H:s", $mn1['vreme']).'</td></tr>
							<tr><td>Ime i prezime: </td><td align="left">'.$mn1['ime'].'</td></tr>
	<tr><td>Adresa (ulica i broj): </td><td align="left">'.$mn1['adresa'].'</td></tr>
<tr><td>Grad: </td><td align="left">'.$mn1['grad'].'</td></tr>
      <tr><td>Email adresa: </td><td align="left">'.$mn1['email'].'</td></tr>
							<tr><td>Telefon: </td><td align="left">'.$mn1['telefon'].'</td></tr>
			<tr><td colspan="2">Poruka:<br />'.$mn1['poruka'].' </td></tr>				
					</table>
          <br />

<table class="table table-condensed">
					<thead>
          <tr><td colspan="6"><b>Poručeni proizvodi</b></td></tr>
						<tr class="cart_menu">
							<td class="image" align="left">Slika</td>
							<td class="description" align="left">Proizvod</td>
							<td class="price">Cena</td>
							<td class="quantity">Količina</td>
							<td class="total">Svega</td>
						</tr>
					</thead>
					<tbody>';
$sn=mysqli_query($conn, "SELECT * FROM poruceno WHERE id_porudzbine=$mn1[id]");
while($sn1=mysqli_fetch_assoc($sn))
{     
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang'  AND p.id=$sn1[id_pro]");
 $az1=mysqli_fetch_assoc($az);       
 $cenka=$sn1['cena'];
if($mn1['nacin_placanja']==4)
$cena_sum =roundCene($cenka,0)*$sn1['kolicina'];
else
$cena_sum =roundCene($cenka,1)*$sn1['kolicina'];
$ukupno +=$cenka*$value;
$sum =$value;
if($az1['tip']==4) $zalink=$all_links[2];
elseif ($az1['tip']==5) $zalink=$all_links[3];
else $zalink=$all_links[48];
 						$zasend .='<tr>
							<td class="cart_product">
								<a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/" target="_blank">
<img src="'.$patH1.GALFOLDER.'/thumb/'.$az1['slika'].'" title="'.$az1['titleslike'].'">
</a>
							</td>
							<td class="cart_description">
								<h4><a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/"  target="_blank">'.$az1['naslov'].'</a></h4>
								<p>Web ID: '.$az1['id'].'</p>
							</td>
							<td class="cart_price" align="center">
								<p>';
                if($mn1['nacin_placanja']==4)
                $zasend .=format_ceneS2($sn1['cena'],0);
                else
                $zasend .=formatCene(roundCene($sn1['cena'],1),1);
                $zasend .='</p>
							</td>
                            <td class="product-quantity">
                                <div class="quantity buttons_added">
                                <input size="2" class="input-text qty text" title="Kolicina" value="'.$sn1['kolicina'].'" readonly min="1" step="1">
                                </div>
                                            </td>
							<td class="cart_total" align="center">
								<p class="cart_total_price">'.formatCene($cena_sum,1).'</p>
							</td>
						</tr>';
} 
if($mn1['nacin_placanja']==1) $inacin='Plaćanje gotovinski/pouzećem';
else
if($mn1['nacin_placanja']==2) $inacin='Uplata na račun';
else
if($mn1['nacin_placanja']==5) $inacin='Kredit';
else
if($mn1['nacin_placanja']==3) $inacin='Na rate uz -50% popusta na mesečnu pretplatu.';
  $zasend .='                      
  <tr>
                        	<td colspan="2">
                            <h4>Način plaćanja:</h4>
                            </td>
                            <td colspan="3">
                            <p class="ukupno" style="font-size:14px;margin-top:10px;">'.$inacin.'</p>
                            </td>
                        </tr>
                       <tr>
                        	<td colspan="2">
                            <h4>UKUPAN IZNOS:</h4>
                            </td>
                            <td colspan="3">
                        <p class="ukupno">';
          if($mn1['iznos_sa_kodom']>0 and $mn1['iznos']>$mn1['iznos_sa_kodom'])
       $zasend .="<span style='font-size:11px;'>".formatCene($mn1['iznos'],1)."</span><br>cena sa promo kodom:<br>".formatCene($mn1['iznos_sa_kodom'],1);
   else  $zasend .=formatCene($mn1['iznos'],1);
                        $zasend .='</p>
                            </td>
                        </tr>
					</tbody>
				</table>';
        echo  $zasend;
 ?>
              </div>
              </div>
              </div>
              </section>          
<?php } ?>                        
</body></html>