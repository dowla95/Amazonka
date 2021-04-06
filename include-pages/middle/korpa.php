    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH1?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Korpa</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container-fluid">
<div class="section-title">
  <h3>Narudžbenica</h3>
</div>
 <?php 



if(!isset($_SESSION[$sid]) and !isset($_POST['naruci_log']))
$msgr="Vaša korpa je prazna!";
if($msgr!="")
echo "<div class='info_box$green'><div>$msgr</div></div><br /><br />";?>
</div>
<?php 
//echo korpaZaMejliPrikaz(4);
function korpaZaMejliPrikaz($tipa) {
global $sarray;
global $conn;
	  $korpa = '
	    <br><table cellpadding="1" cellspacing="1" width="100%" style="background:#ccc;">
		  <tr>
		    <th width="65%" align="left" style="background:#eee; padding:3px 5px 3px 5px">Proizvod</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Cena</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Količina</th>
		    <th width="15%" style="background:#eee; padding:3px 5px 3px 5px">Ukupna cena</th>
		  </tr>
	  ';
$ukupno_sve = 0;
$TrckID=$sarray["TrackID"];
//$TrckID="ABizNet-56";
$ri=@mysqli_query($conn, "SELECT * FROM privremena_pro WHERE trackid=".safe($TrckID)."");
while($v=mysqli_fetch_array($ri))
{
        $moneta = 'rsd';
		$ukupno_sve = $ukupno_sve + (roundCene($v['cena'],0) * $v['kolicina']);
    $plus = '<br /> + <br />';
		$korpa .= '
		  <tr>
		    <td width="65%" align="left" style="background:#fff; padding:3px 5px 3px 5px">'.$v['naziv'].'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format(roundCene($v['cena'],0), 2, ',', '.').'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.$v['kolicina'].'</td>
		    <td width="15%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format((roundCene($v['cena'],0) * $v['kolicina']), 2, ',', '.').' '.$moneta.'</td>
		  </tr>
		';
      }
$korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Ukupno za naplatu</td>
	        <td width="15%" align="center"  style="background:#cccccc; padding:3px 5px 3px 5px">';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
    $korpa .= '<span style="color:#CC0000;"><b><i style="font-size:11px;">'.formatCene($ukupno_sve,1);
   $korpa .="</i><br>cena sa promo kodom: ".formatCene($ukupno_sve,1,$_SESSION['promo-kod']['vrednost_koda']);
    $korpa .='</b></span>';
} else {
 $korpa .= '<span style="color:#CC0000;"><b>'.formatCene($ukupno_sve,1);
    $korpa .='</b></span>';
}
    $korpa .= '</td>
          </tr>';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
  $porez=number_format(($ukupno_sve-$_SESSION['promo-kod']['vrednost_koda']-(($ukupno_sve-$_SESSION['promo-kod']['vrednost_koda'])/1.2)), 2, ',', '.');
  else
  $porez=number_format(($ukupno_sve-($ukupno_sve/1.2)), 2, ',', '.');
    $korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Porez obračunat u cenu placanja</td>
	        <td width="15%" align="center"  style="background:#ffffff; padding:3px 5px 3px 5px">
    '.$porez.' rsd
          </td>
          </tr>';
        $korpa .='</table>';
        $payID=preg_replace('#[^0-9]#i', '', $sarray["PaymentID"]);
if($payID!="")
{
$pri=@mysqli_query($conn, "SELECT * FROM privremena WHERE payamentid=".safe($payID)."");
$pri1=mysqli_fetch_array($pri);
}
$korpa .="<br />
<table style='width:100%;background:#ccc;' cellspacing='1' cellpadding='1'>";
$korpa .="<tr>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Detalji transakcije</b></th>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci kupca</b></th>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci firme</b></th></tr>";
$korpa .="<tr>";
$postdate=$sarray['postdate'];$datum_transakcije=substr(strip_tags($postdate), -2)."-".substr(strip_tags($postdate), 0, 2)."-".date("Y").".";
$PosD=explode(" ",$postdate);
  $PostD1=$PosD[0];
$y=substr($PostD1,0,4);
$m=substr($PostD1,4,2);
$d=substr($PostD1,6,2);
$datum_transakcije="$d-$m-$y $PosD[1]";
$korpa .='<td style="background:white;" valign="top"><table style="width:100%;">
   ';
$korpa .='
    <tr>
      <td width="40%">Način plaćanja</td>
      <td>Platna kartica</td>
    </tr>
	<!--
	<tr>
      <td width="40%">Način isporuke</td>
      <td>'.$pri1["nacin_kupovine"].'</td>
    </tr>
	-->
     <tr>
      <td>Datum transakcije</td>';
    if($pri1["transactionid"]!="")
    $korpa .='<td>'.$datum_transakcije.'</td>';
    else
    $korpa .='<td></td>';
    $korpa .='</tr>
    <tr>
      <td>Iznos</td>
      <td>';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
$korpa .=format_ceneS($ukupno_sve,0,$_SESSION['promo-kod']['vrednost_koda']);
else
$korpa .=format_ceneS($ukupno_sve,0);
$korpa .=' rsd</td>
    </tr> <tr>
      <td width="40%">Broj narudzbine</td>
      <td>'.strip_tags($pri1["trackid"]).'</td>
    </tr>
    <tr>
    <tr>
      <td>Autorizacioni kod</td>
      <td>'.strip_tags($pri1['auth']).'</td>
    </tr>
<tr>
    <td>Status transakcije</td>
      <td>'.strip_tags($pri1["resultcode"]).'</td>
    </tr>
    <tr>
      <td>Kod statusa transakcije</td>
      <td>'.strip_tags($pri1['ProcReturnCode']).'</td>
    </tr>
      <td>Broj transakcije</td>
      <td>'.strip_tags($pri1["transactionid"]).'</td>
    </tr>
    <tr>
      <td>Statusni kod 3D transakcije</td>
      <td>'.strip_tags($pri1["status"]).'</td>
    </tr>
    ';
$korpa .='
  </table></td>';
  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">
    <tr>
      <td width="40%">Ime i prezime</td>
      <td>'.$pri1['ime'].'</td>
    </tr>
    <tr>
      <!--<td>Grad, pošt. broj</td>-->
      <td colspan="2">'.$pri1["grad"].'</td>
    </tr>
    <tr>
      <td>Adresa</td>
    <td>'.$pri1['adresa'].'</td>
    </tr>
    <tr>
      <td>Telefon</td>
      <td>'.$pri1['telefon'].'</td>
    </tr>
    <tr>
      <td>Email</td>
     <td>'.$pri1['mejl'].'</td>
    </tr>
  </table></td>';
  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">
    <tr>
      <td width="40%">Naziv firme</td>
      <td>Amazonka doo Beograd</td>
    </tr>
    <tr>
      <td>Adresa</td>
      <td>Beograd-Zvezdara, Golubačka 1</td>
    </tr>
      <tr>
      <td>PIB:<br>105170964</td>
    </tr>
    <tr>
      <td>Telefon:<br>011/20-80-555</td>
    </tr>
    <tr>
      <td>E-mail:<br>office@amazonka.rs</td>
    </tr>
    <tr>
      <td>Web:<br><a href="https://www.amazonka.rs">www.amazonka.rs</a></td>
    </tr>
  </table></td>';$korpa .="</tr>";
    $korpa .="</table>";
	  return $korpa;
	}
if(isset($_SESSION[$sid]) and count($_SESSION[$sid])>0)
{
if(isset($sarray['PaymentID']))
{
?>


<div class="container">
<!-- Order content -->
<div class="col-xs-12 col-md-12 content">
<?php $payID=$sarray["PaymentID"];
if($payID!="")
$payID=preg_replace('#[^0-9]#i', '', $payID);
if ($sarray["resultcode"]=="Approved")
{
?>
<div style='background:#e0fce3;padding:10px;margin-bottom:10px;'>
<h1 class="zeleni-naslov" style="color:#75f252;font-size:18px;">Hvala. Vaša narudžbina je uspešno izvršena! <br /><span style='font-size:15px;color:#444;'>Vaša porudžbina će biti realizovana u najkraćem mogućem roku.</span></h1>
<p class="veci-blok">Ako imate bilo kakvih pitanja slobodno nas pozovite na <b class="crvena">011/20-80-555</b></p>
<p class="veci-blok">Ono što takođe treba da znate:</p>
<ul class="stavke">
<li>Ukoliko ste napravili porudžbinu tokom vikenda (subota ili nedelja), ista će biti realizovana u ponedeljak.<br />
</li>
<li>Isporuke vršimo na bilo koju adresu u Srbiji, Bosni i Hercegovini i Crnoj Gori.</li>
</ul>
</div>
<?php 
echo korpaZaMejliPrikaz(2);
?>
 </div>
 </div> <!-- container narudzbina -->
<?php 
if(isset($_SESSION[$sid]))  unset($_SESSION[$sid]);}
elseif (($sarray["resultcode"]=="Declined" or $sarray["resultcode"]=="Error") and $sarray["auth"]=="")
{
?>
	<center style='background:#ffeded;padding:10px;margin-bottom:10px;'>
		<font size="3" color="red">
Plaćanje nije uspešno, Vaš račun nije zadužen. Najčešći uzrok je pogrešno
unet broj kartice, datum isteka ili sigurnosni kod. <br />Pokušajte ponovo. U slučaju uzastopnih greški pozovite svoju banku.
		</font>
	<p><a href="<?php echo $patH1?>/korpa/" class="crvena">&laquo; Idite na stranicu KORPE gde vršite izbor načina plaćanja i da ponovo pokušate plaćanje</a></p>
   </center>
<?php 
echo korpaZaMejliPrikaz(2);
 }   else
{
?>
	<center style='background:#f1f1f1;padding:10px 0px;margin-bottom:10px;border:1px solid #CCCCCC;'>
		<font size="5" color="red">
		  Došlo je do greške u pokušaju plaćanja, pokušajte ponovo!
		</font>
	<p><a href="<?php echo $patH1?>/korpa/" class="crvena">&laquo; Idite na stranicu KORPE gde vršite izbor načina plaćanja i da ponovo pokušate plaćanje</a></p>
   </center>
<?php 
echo korpaZaMejliPrikaz(2);
 }
} else {
	
if($load_nestpay_form==1 and isset($_POST['nacin']) and $_POST['nacin']==4)
{
	
?>
 <center>
  <?php echo '<h1 class="zeleni-naslov" style="text-align:center">Molimo vas da sačekate! <img src="'.$domen.'/loader.gif" alt="loader" /></h1>';?>
    <form method="post" name="nestpay" action="https://bib.eway2pay.com/fim/est3Dgate">
		<input type="submit" value="Nastavi sa plaćanjem karticom &raquo;" class="green-btn" />
		<input type="hidden" name="clientid" value="<?php echo $orgClientId ?>">
        <input type="hidden" name="amount" value="<?php echo $orgAmount ?>">
        <input type="hidden" name="oid" value="<?php echo $orgOid ?>">
        <input type="hidden" name="okUrl" value="<?php echo $orgOkUrl ?>">
        <input type="hidden" name="failUrl" value="<?php echo $orgFailUrl ?>">
        <input type="hidden" name="trantype" value="<?php echo $orgTransactionType ?>">
		<input type="hidden" name="currency" value="<?php echo $orgCurrency ?>">
        <input type="hidden" name="rnd" value="<?php echo $orgRnd ?>">
        <input type="hidden" name="hash" value="<?php echo $hash ?>">
        <input type="hidden" name="storetype" value="3d_pay_hosting">
        <input type="hidden" name="hashAlgorithm" value="ver2">
        <input type="hidden" name="lang" value="sr">
        <input type="hidden" name="shopurl" value="<?php echo $patH?>/korpa/" />
        <input type="hidden" name="encoding" value="utf-8">
	</form>
    </center>
    <script type="text/javascript">
 	document.nestpay.submit();
	</script>
<?php 
}
else {
?>
    <div class="shopping-cart-wrapper pb-70">
        <div class="container-fluid">
            <div class="row">
			<div class="table-responsive">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
	<table class="table table-bordered">
		<thead class="sukupno">
			<tr>
				<th>Slika</td>
				<th>Proizvod</td>
				<th>Cena</td>
				<th>Količina</td>
				<th>Svega</td>
				<th>Izbaci</td>
			</tr>
		</thead>
    <?php
if(isset($_SESSION[$sid]) and count($_SESSION[$sid])>0) { ?>
<script type="text/javascript">
    function autoRefreshPage()
    {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 1200000);
</script>
<?php }
     ?>
		<tbody id="ikorpa">
<?php

if(isset($_SESSION[$sid]))
{

$prodArr=array();
$ponisti_iznos_dostave=0;
foreach($_SESSION[$sid] as $key => $value)
{

if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);

$prodArr[$az1['prodavac']][]=roundCene($az1['cena'],1)*$value;
}
}

$ukupno=0;
$kolko=0;
foreach($_SESSION[$sid] as $key => $value)
{
$cena_sum=0;
$sum=0;
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);

$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$cena_sum_idost =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar)*$value;
$sum =$value;
$zalink=$all_links[3];
$bz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.kupindo='$az1[kupindo]' AND $az1[nijansa]>0 AND NOT p.id=$az1[ide] ORDER BY -p.pozicija DESC, pt.naslov");
if(mysqli_num_rows($bz)==0) $bezo=" class='d-none myBtn'"; else $bezo=" class='myBtn'";
?>
						<tr id="row<?php echo $az1['id']?>">
							<td class="pro-thumbnail">
<?php if($az1['slika']!="") { ?>
<a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/">
<img src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $az1['slika']?>" title="<?php echo $az1['titleslike']?>" alt="<?php echo $az1['altslike']?>">
<?php
}
else { ?>
<a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/">
<img src="<?php echo $patH1?>/img/no-product-image.png" title="<?php echo $az1['titleslike']?>" alt="<?php echo $az1['altslike']?>">	
<?php } ?>
</a>
							</td>
							<td class="pro-title">
								<h4><a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/"><?php echo $az1['naslov']?></a></h4>
								<p>Web ID: <?php echo $az1['ide']?></p>
							</td>
							<td class="pro-price">
							<span class="notxt">Cena po jedinici: </span>
							<?php if($az1['cena1']>0) { ?>
								<p><?php echo format_ceneS($az1['cena'],2) ?></p>
							<?php } else { ?>
							<p><?php echo format_ceneS($az1['cena'],2) ?></p>
							<?php } ?>
							</td>
                            <td class="pro-quantity">
                                <div class="quantity">
                                <input type="button" class="minus" value="-"  onclick="displaySubs1(<?php echo $az1['id']?>,'minus');">
                                <input size="2" class="brr" title="Kolicina" value="<?php echo $value?>" min="1" step="1" id="val<?php echo $az1['id']?>">
                                <input type="button" class="plus" value="+"  onclick="displaySubs1(<?php echo $az1['id']?>,'yes');">
                                </div>
                            </td>

							<td class="pro-subtotal">
								<p class="cart_total_price" id="cen<?php echo $az1['ide']?>"><span class="notxt">SVEGA: </span><?php echo format_ceneS($cena_sum,2)?></p>
							</td>
							<td class="pro-remove">
							<span class="notxt">Izbaci iz korpe </span>
								<a class="cart_quantity_delete" href="javascript:;" onclick="displaySubs2(<?php echo $az1['id']?>,'drop');"><i class="fa fa-times"></i></a>
								<hr class="razd notxt">
							</td>
						</tr>
<?php 
}
$kolko++;
}
}
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0){
$bezpdv=($ukupno-$_SESSION['promo-kod']['vrednost_koda'])/(1+$settings['pdv']/100);
$pdv=$ukupno-$_SESSION['promo-kod']['vrednost_koda']-$bezpdv;
} else {
$bezpdv=$ukupno/(1+$settings['pdv']/100);
$pdv=$ukupno-$bezpdv;
}
?>
<tr class="sukupno">
<td><h4>UKUPNO:</h4></td>
<td>

</td>
<td colspan="2">
<?php
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$del1="<del>";
$del2="</del>";
}
else {
$del1="";
$del2="";
}
if(formatCene($ukupno,1) == formatCene($ukupno,1, $_SESSION['promo-kod']['vrednost_koda'])) $nono=" d-none"; else $nono="";
?>
<p class="ukupno<?php echo $nono?>"><?php echo $del1.format_ceneS($ukupno,2).$del2?></p>
</td>
<td colspan="2">
<p class="ukupno-promo ukupno"><?php echo format_ceneS($ukupno,2, $_SESSION['promo-kod']['vrednost_koda'])?></p>
</td>
</tr>
					</tbody>
				</table>
			</div>
			</div>
        </div>
     </div>
</div>
<form action="" id="glavna-forma" method="post" class="mb-20 w-100 sukupno" <?php echo $hider?>>
<div class="container-fluid">
<div class="row">
<!--
<div class="col-lg-3 col-md-6 mb-sm-20">
<h5>Izaberite način isporuke:</h5>
<?php
$isp=$isp1="";
if(isset($_SESSION['izf']['isporuka']) and $_SESSION['izf']['isporuka']==1)
$isp="checked";
if(isset($_SESSION['izf']['isporuka']) and $_SESSION['izf']['isporuka']==2)
$isp1="checked";
if(isset($_POST['isporuka']) and (int) filter_var($_POST['isporuka'], FILTER_SANITIZE_NUMBER_INT)==1) $isp="checked";
if(isset($_POST['isporuka']) and (int) filter_var($_POST['isporuka'], FILTER_SANITIZE_NUMBER_INT)==2) $isp1="checked";
?>
<i class="fas fa-home mb-10" style="margin-right:3px;"></i> <input type='radio' <?php echo $isp?> name='isporuka' value='Na navedenu adresu1' required> Na navedenu adresu<br>
<i class="fas fa-user" style="margin-right:8px;"></i> <input type='radio' <?php echo $isp1?> name='isporuka' value='Lično u poslovnici2'> Lično preuzimanje<br>
</div>
-->
<div class="col-lg-3 col-md-12 mb-sm-20 mb-md-20">
<h5>Izaberite način plaćanja:</h5>
<?php 
$nac=$nac1=$nac2=$nac4="";
if(isset($_SESSION['izf']['nacin']) and $_SESSION['izf']['nacin']==1)
$nac="checked";
if(isset($_SESSION['izf']['nacin']) and $_SESSION['izf']['nacin']==2)
$nac1="checked";
if(isset($_SESSION['izf']['nacin']) and $_SESSION['izf']['nacin']==3)
$nac2="checked";
if(isset($_SESSION['izf']['nacin']) and $_SESSION['izf']['nacin']==4)
$nac3="checked";
if(isset($_SESSION['izf']['nacin']) and $_SESSION['izf']['nacin']==5)
$nac4="checked";
if(isset($_POST['nacin']) and $_POST['nacin']==1) $nac="checked";
if(isset($_POST['nacin']) and $_POST['nacin']==2) $nac1="checked";
if(isset($_POST['nacin']) and $_POST['nacin']==3) $nac2="checked";
if(isset($_POST['nacin']) and $_POST['nacin']==4) $nac3="checked";
if(isset($_POST['nacin']) and $_POST['nacin']==5) $nac4="checked";
?>
<i class="fas fa-truck mb-10"></i> <input type='radio' <?php echo $nac?> name='nacin' value='1' required> Pouzećem/gotovinski<br>
<i class="far fa-university" style="margin-right:5px;"></i> <input type='radio' <?php echo $nac1?> name='nacin' value='2'> Uplata na račun<br>
<i class="far fa-credit-card" style="margin-right:3px;margin-top:8px"></i> <input type='radio' <?php echo $nac3?> name='nacin' value='4'> Karticom online<br>
<i class="far fa-wallet" style="margin-right:5px;margin-top:8px"></i> <input type='radio' <?php echo $nac4?> name='nacin' value='5'> Kreditom<br>
</div>
<?php
$placeholdertext="Unesite, ako je potrebno sve što smatrate da je važno za ovu Vašu narudžbu.";
$poruka="";
if(isset($_SESSION['izf']['poruka'])) $poruka=$_SESSION['izf']['poruka'];
if(isset($_POST['poruka'])) $poruka=$_POST['poruka'];
?>
<div class="col-lg-9 col-md-12">
<h5>Poruka uz Vašu narudžbu:</h5>
<textarea name="poruka" rows="2" placeholder="<?php echo $placeholdertext?>"><?php echo $poruka?></textarea>
</div>
</div>
<div id="promo-info" style='width:100%;color:red;'><?php echo $odgKredita; ?></div>

<?php
if($modulArr['promo-kodovi']==1) {
if(isset($_SESSION['promo-kod']) and $_SESSION['promo-kod']!=""){
$isable="disabled";
$ralis=' &nbsp;<a class="btn btn-secondary cart-pg" href="javascript:;" id="zanemari-kod" style="margin-left:10px;">Zanemari KOD</a>';
} else {
$isable="";
$ralis='<a class="btn btn-secondary cart-pg" id="upotrebi-kod" href="#" style="margin-left:10px;">Upotrebi KOD</a>';
}
?>

<!--	<div class="shopping-cart-wrapper pb-20 mt-20">
		<div class="row">
			<div class="col-12">
			
			
			
	<div class="card-header collapsed" data-toggle="collapse" data-parent="#prok" href="#prok">
		<b>Imate PROMO KOD?</b>
	</div>
			
	<div class="cart-accordion-wrapper mt-full">

		<div class="card">
		<div id="prok" class="card-body collapse">
                <div class="input-group">
                    <label class="col-12 col-sm-12 col-md-3" for="input-coupon">Unos promo KOD-a</label>
					<div class="col-12 col-sm-12 col-md-9">
						<div class="input-group">
							<input class="form-control" type="text" name="promo-kod" maxlength="6" id="promo-kod" <?php // echo $isable?> value="<?php // echo $_SESSION['promo-kod']?$_SESSION['promo-kod']['kod']:"";?>" placeholder="Unesite promo KOD"> <?php // echo $ralis?>
							<div id="promo-info" style='width:100%;color:red;'></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

			</div>
		</div>
	</div> -->
<?php } ?>
</div>
</div>

<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<?php if(isset($_SESSION['userid'])) { ?>
<div style="text-align:right;"><input type="hidden" name="naruci_log" value="1" />
<label><input type='checkbox' name='opsti_uslovi' value='1' required> Slažem i prihvatam <a href="<?php echo $patH?>/opsti-uslovi-kupovine/" target="_blank" title="Opsti uslovi kupovine"> opšte uslove kupovine</a> (*)</label>
</div>
<button type="submit" id="narucis" class="btn-1 home-btn float-right"><i class="far fa-check"></i> Naruči</button>
<?php
}
else if($modulArr['bez-registracije']==1) { ?>
<h5>Poruka uz Vašu narudžbu:</h5>
<?php
$poruka="";
if(isset($_SESSION['izf']['poruka'])) $poruka=$_SESSION['izf']['poruka'];
if(isset($_POST['poruka'])) $poruka=$_POST['poruka'];
?>
<textarea name="poruka" rows="2" placeholder="<?php echo $placeholdertext?>"><?php echo $poruka?></textarea>
</div>
</div>


<div class="row">

<div class="col-12">
<h5>Naručivanje bez registracije</h5>
<p>Ukoliko želite da naručite bez registracije, popunite sledeće podatke.</p>
</div>
<div class="col-md-6 col-lg-4 col-12">
<ul class="user_info">
<?php
if(isset($_POST['ime'])) $ime=$_POST['ime'];
else
if(isset($_SESSION['izf']['ime'])) $ime=$_SESSION['izf']['ime']; else $ime="";
?>
<li><input type="text" name="ime" value="<?php echo $ime?>" required placeholder="Ime i prezime*"></li>
<?php
if(isset($_POST['posta'])) $posta=$_POST['posta'];
else
if(isset($_SESSION['izf']['posta'])) $posta=$_SESSION['izf']['posta']; else $posta="";
?>
<li><input type="text" name="posta" value="<?php echo $posta?>" required placeholder="Poštanski broj*"></li>
<?php
if(isset($_POST['grad'])) $grad=$_POST['grad'];
else
if(isset($_SESSION['izf']['grad'])) $grad=$_SESSION['izf']['grad']; else $grad="";
?>
<li><input type="text" name="grad" value="<?php echo $grad?>" required placeholder="Grad - mesto*"></li>
<?php
if(isset($_POST['pib'])) $pib=$_POST['pib'];
else
if(isset($_SESSION['izf']['pib'])) $pib=$_SESSION['izf']['pib']; else $pib="";
?>
<li><input type="text" name="pib" value="<?php echo $pib?>" placeholder="Samo za firme - unesite PIB"></li>
</ul>
</div>

<div class="col-md-6 col-lg-4 col-12">
<ul class="user_info">
<?php
if(isset($_POST['adresa'])) $adresa=$_POST['adresa'];
else
if(isset($_SESSION['izf']['adresa'])) $adresa=$_SESSION['izf']['adresa']; else $adresa="";
?>
<li><input type="text" name="adresa" value="<?php echo $adresa?>" required placeholder="Ulica i broj*"></li>
<?php
if(isset($_POST['telefon'])) $telefon=$_POST['telefon'];
else
if(isset($_SESSION['izf']['telefon'])) $telefon=$_SESSION['izf']['telefon']; else $telefon="";
?>
<li><input type="text" name="telefon" value="<?php echo $telefon?>" required placeholder="Telefon*"></li>
<?php
if(isset($_POST['email'])) $email=$_POST['email'];
else
if(isset($_SESSION['izf']['email'])) $email=$_SESSION['izf']['email']; else $email="";
?>
<li><input type="email" name="email" value="<?php echo $email?>" required placeholder="Email adresa*"></li>
</ul>
</div>

<div class="col-md-6 col-lg-4 col-12">
<input type="hidden" name="naruci_log" value="2" />
<span class='obavezno'>*</span> Čekirajte da niste robot: <br />
<div class="g-recaptcha" data-sitekey="6LeJCvUUAAAAAA5QO54GG2VZzWGdU6M_X0DClJii"></div><br />
<label><input type='checkbox' name='opsti_uslovi' value='1' required> Slažem i prihvatam <a href="<?php echo $patH?>/opsti-uslovi-kupovine/" target="_blank" title="Opsti uslovi kupovine"> opšte uslove kupovine</a> (*)</label><br>
<br />
<button type="submit" id="narucis" class="btn-1 home-btn float-right"><i class="far fa-check"></i> Naruči</button>
</div>

</div>

<?php
}
else echo "<h3 class='text-center'>Da bi ste zavržili kupovinu, morate biti registrovani i logovani!</h3>";
?>

</div>
</div>
</div>
</form>
 <?php } } } ?>
 <div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p id="umodal"></p>
  </div>
</div>
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 100; /* Sit on top */
  padding-top: 30px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 90%;
}
/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
<!-- Trigger/Open The Modal -->
 <script>
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var btn = $(".myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
$( document ).on( "click touchstart tap", ".myBtn", function(e) {
modal.style.display = "block";
  zamodal=$(this).next(".zamodal").html();
  $("#umodal").html(zamodal);
});
// When the user clicks the button, open the modal
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>