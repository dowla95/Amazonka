<?php
$fif=mysqli_query($conn, "SELECT *, p.id as id FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id 
WHERE p.tip=5 AND p.akt=1 AND prodavac=$_SESSION[userid] GROUP BY p.id ORDER BY time DESC");
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			<form action="#">
				<div class="table-responsive">
					<table class="table table-bordered">
							<thead class="text-center">
								<tr>
									<td>Slika</td>
									<td>Proizvod</td>
									<td>Objavljen</td>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>Cena</td>
									<td>Akcije</td>
								</tr>
							</thead>
						<tbody>
<?php while($fif1=mysqli_fetch_assoc($fif)) {
if($fif1['uvaluti']==0) {
$val="RSD";
$cena=number_format($fif1['cena'],0,",",".");
}
else {
$val="&euro;";
$cena=number_format($fif1['cena']/$settings['kurs_evra'],2,",",".");
}
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
							<tr<?php echo $proda?> id="row<?php echo $fif1['id']?>">
								<td class="text-center">
 <?php if($fif1['slika']!=""){ ?>
 <?php echo $alink?>
 <img src="<?php echo $patH.GALFOLDER?>/thumb/<?php echo $fif1['slika']?>" width='100' />
 <?php echo $nealink?>
 <?php }
 else echo $alink."<img src='".$patH."/img/no-product-image.png' width='100' />".$nealink;
 ?>
								<td>
									<h3><?php echo $alink.$fif1['naslov'].$nealink?></h3>
									<p><?php echo $fif1['marka']?></p>
								</td>
								<td class="text-center">
									<p><?php echo date('d.m.Y. H:m:s', $fif1['time'])?></p>
								</td>
								<td>

								</td>
								<td class="text-right">
									<p><?php echo $cena." ".$val?></p>
								</td>
								<td class="text-center">
								<ul>
<?php if($fif1['prodato']==0) {?>
									<li class="d-inline-block mr-10"><a href="<?php echo $patH?>/<?php echo $all_links[63]?>/?edit=<?php echo $fif1['id']?>"><i class="far fa-pencil-alt"></i></a></li>
<?php } ?>
									<li class="d-inline-block"><a href="javascript:;" class="delete_pro" rel="<?php echo $fif1['id']?>"><i class="far fa-trash-alt"></i></a></li>
								</ul>
								</td>
							</tr>
<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>