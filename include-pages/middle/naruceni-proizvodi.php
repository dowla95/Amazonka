<?php
$fif=mysqli_query($conn, "SELECT * FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
INNER JOIN poruceno po ON po.id_pro=p.id
INNER JOIN porudzbine pd ON pd.id=po.id_porudzbine
WHERE p.tip=5 AND p.akt=1 AND p.prodavac=$_SESSION[userid] AND p.prodato=0 ORDER BY pd.vreme DESC");
?>

<div class="container-fluid">
	<form action="#" class="w-100">
		<div class="row text-center">
			<div class="col-md-1"><h4>Slika</h4></div>
			<div class="col-md-7"><h4>Proizvod</h4></div>
			<div class="col-md-3"><h4>Status</h4></div>
			<div class="col-md-1"><h4>Snimi</h4></div>
		</div>
		<hr>
<?php while($fif1=mysqli_fetch_assoc($fif)) {
$kupac=mysqli_fetch_assoc(mysqli_query($conn, "SELECT nickname FROM users_data WHERE user_id=$fif1[kupac]"));
if($fif1['nacin_placanja']==1) $np="Pouzećem/gotovinski";
elseif($fif1['nacin_placanja']==2) $np="Uplata na račun";
else $np="Karticom online";
$val="RSD";
$cena=number_format($fif1['cena'],0,",",".");
$svega=number_format($fif1['kolicina']*$fif1['cena'],0,",",".");
$vreme="dana ".date("d.m.Y.", $fif1['vreme'])." u ".date("H:i", $fif1['vreme']);

if($fif1['prodato']==1) {
$proda=" class='prodato'";
$alink="";
$nealink="";
}
else {
$proda="";
$alink="<a href='".$patH."/proizvodi/".$fif1['ulink']."-".$fif1['id']."/'>";
$nealink="</a>";
}
?>
		<div class="row">
			<div class="col-md-1 text-center">
 <?php if($fif1['slika']!=""){ ?>
 <?php echo $alink?>
 <img src="<?php echo $patH.GALFOLDER?>/thumb/<?php echo $fif1['slika']?>" class="img-fluid" />
 <?php echo $nealink?>
 <?php }
 else echo $alink."<img src='".$patH."/img/no-product-image.png' width='100' />".$nealink;
 ?>
			</div>
			<div class="col-md-7">
				<p>
				<b>Kupac:</b> <?php echo $kupac['nickname'].", ".$vreme?>, naručio je <?php echo $alink.$fif1['naslov'].$nealink?><br>
				<b>Iznos:</b> <?php echo $fif1['kolicina']." x ".$cena?> = <?php echo $svega." ".$val?><br>
				<b>Način plaćanja:</b> <?php echo $np?>
				<?php if($fif1['poruka']!="" )echo "<br><b>Poruka: </b>".$fif1['poruka']; else echo "";?>
				</p>
			</div>
			<div class="col-md-3 text-center">
				<select name="status" class="w-100">
					<option value="0">PORUČENA</option>
					<option value="1">SPREMNA ZA PREUZIMANJE</option>
					<option value="2">URUČENA</option>
					<option value="3">OTKAZANA</option>
				</select>
			</div>
			<div class="col-md-1 text-center">
				<button type="submit" class="theme-button product-cart-button2"> Snimi </button>
			</div>
		</div>
		<hr>

<?php } ?>
	</form>
</div>