    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
						<nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $patH1?>">Naslovna</a></li>
<?php
$idkat=$ztz1['ide'];
$podkat=$nArrp[$idkat]['parent'];
$parentkat=$nArrp[$podkat]['parent'];

if(isset($bap1['naziv']) and $bap1['naziv']!=''){
?>
<li class="breadcrumb-item"><?php echo $bap1['naziv']?></li>
<?php
}

if ($nArrp[$parentkat]['naziv']!="") {
echo "						<li class='breadcrumb-item'>";
echo "						<a href='$patH1/$all_links[3]/".$nArrp[$parentkat]['ulink']."/'>".$nArrp[$parentkat]['naziv']."</a>";
echo "						</li>";
}
if ($nArrp[$podkat]['naziv']!="") {
if(isset($nArrp[$parentkat]['ulink']))
$imosti=$nArrp[$parentkat]['ulink']."/"; else $imosti="";
echo "						<li class='breadcrumb-item'>";
echo "						<a href='$patH1/$all_links[3]/".$imosti.$nArrp[$podkat]['ulink']."/'>".$nArrp[$podkat]['naziv']."</a>";
echo "						</li>";
}
if($ztz1['naziv']!="") {
?>
                            <li class="breadcrumb-item"><?php echo $ztz1['naziv']?></li>
<?php } ?>
                        </ul>
						</nav>
                    </div>
				</div>
			</div>
        </div>
    </div>

<?php
if($modulArr['sponzorisano']==1 and isset($ztz1['ide'])) {
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN kat_pro k ON p.id=k.pro
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 AND izdvoj_u_kategoriji=1 AND mesto_prikaza=1 AND p.prodato=0 AND lager=1 AND k.kat=$ztz1[ide] AND sponzorisano_do >= CURDATE() GROUP BY p.id ORDER BY p.pozicija ASC, p.id DESC LIMIT 4");
if(mysqli_num_rows($az)>0) {
include("include-pages/ajax-load/oprema-lista-sponzorisano.php");
echo $mlistas;
}
}
?>

<div class="main-wrapper pt-35">
<div class="container-fluid">
<div class="row">
<div class="col-lg-3">
	<div class="shop-sidebar-inner mb-30">
		<div class="single-sidebar mb-45">
<?php
/*$iovos="";
if($base_arr_r[1]=="proizvodi" and $base_arr_r[0]!="")
 {
 $ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  p.akt=1 AND  ulink=".safe($base_arr_r[0])." AND p.id_cat=32");
   $ztz1=mysqli_fetch_array($ztz);
$iovos =" AND kategorija=".$ztz1['ide'];
 }
*/

 /*$akcijska=mysqli_query($conn, "SELECT MIN(cena1) as akcmin, MAX(cena1) as akcmax FROM pro WHERE akt=1 AND tip=5 AND cena1>0");
 $akcijska1=@mysqli_fetch_assoc($akcijska);
 $minak=$akcijska1['akcmin'];
 $maxak=$akcijska1['akcmax'];*/
/* $mi=mysqli_query($conn, "SELECT MIN(cena) as micena, MAX(cena) as macena FROM pro WHERE akt=1 AND tip=5");
 $mi1=mysqli_fetch_assoc($mi);*/
//$mic=$mi1['micena'];
//$mac=$mi1['macena'];
/*if($minak>0) $mic=$minak; else $mic=$mi1['micena'];
if($maxak>0) $mac=$maxak; else $mac=$mi1['macena'];*/
/*$mic=$mi1['micena'];
$mac=$mi1['macena'];*/
?>

<script>
function loads() {
path=$("#path").attr("href");
 sev=$(".sev").val();
var gethash=window.location.hash;
 if(gethash!="")
 {
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/oprema-load.php?va=<?php echo $idvalute?>&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){ 
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]);
$("#collapseTree").html(datas[2]);
}
});
}
}
loads();
</script>

<div class="sidebar-inner-title mb-25">
<h3>Opseg cena</h3>
             <div class="price-range"><!--price-range-->
				<div class="sidebar-price">
					<div class="well text-center">
                <input class="text-center" data-min="<?php echo $mic?>" data-max="<?php echo $mac?>" type="text" id="amount" name="range" readonly style="border:0;color:#222;font-weight:600;">
				<div id="slider-range" style="width:90%;margin:0 auto;"></div>
					</div>
				</div>
			 </div><!--/price-range-->
</div>
</div>

<h3><?php echo $arrwords['paket3']?></h3>
<div id="load-filter">
<?php
include("include-pages/ajax-load/levo-filter.php");

echo $fblista;
echo $mblista;
echo $molista;
echo $flista;
?>
</div>
		<div class="single-sidebar mb-40">
<?php
if($modulArr['sponzorisano-levo']==1 and isset($ztz1['ide'])) {
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN kat_pro k ON p.id=k.pro
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 AND izdvoj_u_kategoriji=1 AND mesto_prikaza=0 AND p.prodato=0 AND k.kat=$ztz1[ide] AND sponzorisano_do >= CURDATE() GROUP BY p.id ORDER BY p.pozicija ASC, p.id DESC LIMIT 4");
if(mysqli_num_rows($az)>0) {
include("include-pages/ajax-load/oprema-lista-sponzorisano-levo.php");
echo $mlistaslevo;
}
}
?>
		</div>
	</div>
</div>

<div class="col-lg-9 order-first order-lg-last">
	<div class="product-shop-main-wrapper mb-50">
        <?php
        if($ztz1['ide'])
        echo "<h1 class='title text-center'>".$ztz1['naziv']."</h1>";
        else
        echo "<h1 class='title text-center'>".$page1['h2']."</h1>";
$sort_arr=array("Prvo najnoviji", "Prvo najstariji","Naziv (A-Z)","Naziv (Z-A)","Cena (Rastuće)","Cena (Opadajuće)");
echo '
                    <div class="shop-top-bar mb-30">
                        <div class="row">
                            <div class="col-md-5">
                                    <div class="top-bar-left">
                                        <div class="product-view-mode no">
                                            <a href="#" data-target="column_3"><span>3-col</span></a>
                                            <a class="active" href="#" data-target="grid"><span>4-col</span></a>
                                            <a href="#" data-target="list"><span>list</span></a>
                                        </div>
                                    </div>
                            </div>
						<div class="col-md-7">
							<div class="top-bar-right">
                                <div class="per-page">
								<!--
                                    <p>Prikaži: </p>
                                    <select class="nice-select" name="sortby">
                                    <option value="trending">10</option>
                                    <option value="sales">20</option>
                                    <option value="sales">30</option>
                                     </select>
									 <p> proizvoda</p>
								-->
                                </div>
								<div class="product-short">
									<p>Sortiranje : </p>
									<select class="sev" rel="oprema-load.php">
';
foreach($sort_arr as $k => $v) {
if(isset($_GET['sev']) and $_GET['sev']==$k) $sele=" selected"; else $sele="";
echo "<option value='$k'$sele>$v</option>";
}
echo '                    			</select>
								</div>
							</div>
						</div>
					</div>
				</div>
';
?>
<div class="features_items" id="load-lista"><!--features_items-->
<?php
include("include-pages/ajax-load/oprema-lista.php");
echo $mlista;
?>
</div><!--features_items-->
<?php if(strlen($ztz1['keywords'])>10) echo "<p>".$ztz1['keywords']."</p>"; ?>
<!--
<?php if(strlen($page1['podnaslov'])>10) echo "<p>".$page1['podnaslov']."</p>"; ?>
-->
</div> <!-- / product-shop-main-wrapper mb-50 -->
</div>
</div>
</div>
</div>