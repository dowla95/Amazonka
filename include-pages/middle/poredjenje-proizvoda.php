    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Poređenje proizvoda</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="comparison-wrapper pb-50">
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <main id="primary" class="site-main">
                <div class="comparison">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="section-title">
                                <h3>Uporedi proizvode</h3>
                            </div>
						<div class="table-responsive text-center">
							<table class="table table-bordered compare-style">
                                <thead>
                                    <tr>
										<td><strong>Slika</strong></td>
										<td><strong>Proizvod</strong></td>
										<td><strong>Brend</strong></td>
										<td><strong>Cena</strong></td>
										<td><strong>Dodaj/Izbaci</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
						

<?php 
if(isset($_COOKIE['valuta']))
$idvalute=""; else
$idvalute=1;
if(isset($sarray['ukloni']) and $sarray['ukloni']>0)
{
$ukloni=$sarray['ukloni'];
unset($_SESSION["uporedi"][$ukloni]);
}
if(isset($_SESSION['uporedi']) and count($_SESSION['uporedi'])>0)
{
$ni="";
$imp=implode(",",$_SESSION['uporedi']);
$lp_niz_r=array_reverse($_SESSION['uporedi']); 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1  AND p.id IN($imp) GROUP BY p.id ORDER BY FIELD ('p.id',".implode(",",$lp_niz_r).")");
while($az1=mysqli_fetch_array($az))
{
$zalink=$all_links[3];
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$az1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
if($az1['lager']==1)
$ukorpu="onclick=\"displaySubs(".$az1['id'].",'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na stanju, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
?>
<tr>
<td>
<a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/" title="<?php echo $az1['naslov']?>">
<?php 
echo '<img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika'].'" alt="'.$az1['altslike'].'" title="'.$az1['titleslike'].'"  class="img-thumbnail">';                                
?>
</a>
</td>
<td>
<h5><a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/" title="<?php echo $az1['naslov']?>"><?php echo $az1['naslov']?></a></h5>
<?php echo substr(strip_tags($az1['opis']),0,300);?>...
</td>
<td>
<?php echo $brend1['naziv']?>
</td>
<td>
<?php 
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija']==1)
echo "<span class='regular-price'><span class='special-price'>".number_format($az1['cena'],2,",",".")."</span></span>
<span class='old-price'><del>".number_format($az1['cena1'],2,",",".")."</del></span>";
else
echo "<span class='regular-price'>".number_format($az1['cena'],2,",",".")."</span>";
}
if($az1['lager']==1)
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
?>
</td>
<td>
	<ul>
		<li class="d-inline-block"><a href="<?php echo $patH1?>/<?php echo $all_links[11]?>/?ukloni=<?php echo $az1['id']?>"><i class="far fa-trash-alt fa-2x"></i></a></li>
		<li class="d-inline-block"><a href="javascript:;" <?php echo $ukorpu?> title="<?php echo @count($hashAA)?>"><i class="far fa-shopping-cart fa-2x"></i></a></li>
	</ul>
</td>



<?php 
} 
}
else $ni="<h3>Trenutno niste izabrali nijedan proizvod za poredjenje</h3>";
?>
</tr>
</tbody>
</table>
</div>
						</div>
					</div>
				</div> 
			</main>
<?php echo $ni?>		
		</div>
	</div>
</div>
</div>