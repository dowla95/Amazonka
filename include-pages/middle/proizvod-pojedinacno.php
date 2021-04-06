    <div class="breadcrumb-area mb-30">
        <div class="container-fluid">
            <div class="row">
<?php
$prod=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$dztz1[prodavac]");
$prod1=mysqli_fetch_assoc($prod);
if($prod1['firma']==1) $prodavac=$prod1['nazivfirme']; else $prodavac=$prod1['nickname'];
 
$sin=array();
$vi=mysqli_query($conn, "SELECT * FROM kat_pro WHERE pro=".$dztz1['ide']);
while($vi1=mysqli_fetch_assoc($vi)){
$sin[]=$vi1['kat'];
}
$idkat=$sin[0];
$podkat=$nArrp[$idkat]['parent'];
$parentkat=$nArrp[$podkat]['parent'];
?>
                <div class="col-lg-12">
                    <div class="breadcrumb-wrap">
					<nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $patH1?>">Naslovna</a></li>
                            
<?php
if ($nArrp[$parentkat]['naziv']!="") {
echo "						<li class='breadcrumb-item'>";
echo "						<a href='$patH1/$all_links[3]/".$nArrp[$parentkat]['ulink']."/'>".$nArrp[$parentkat]['naziv']."</a>";
echo "						</li>";
}

if ($nArrp[$podkat]['naziv']!="") {
echo "						<li class='breadcrumb-item'>";
echo "						<a href='$patH1/$all_links[3]/".$nArrp[$parentkat]['ulink']."/".$nArrp[$podkat]['ulink']."/'>".$nArrp[$podkat]['naziv']."</a>";
echo "						</li>";
}
?>
							<li class="breadcrumb-item">
<?php 
echo "						<a href='$patH1/$all_links[3]/".$nArrp[$parentkat]['ulink']."/".$nArrp[$podkat]['ulink']."/".$nArrp[$idkat]['ulink']."/'>".$nArrp[$idkat]['naziv']."</a>";
?>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $dztz1['naslov']?></li>
                        </ul>
					</nav>
                    </div>
				</div>
			</div>
        </div>
    </div>

    <div class="product-details-main-wrapper pb-50">
        <div class="container-fluid">
            <div class="row">
				<div class="col-12">
					<h1 class="product-details-title mb-15"><?php echo $dztz1['naslov']?></h1>
				</div>
			</div>
			<div class="row">
                <div class="col-lg-5">
				<div class="product-large-slider mb-20">
					<div class="pro-large-img">
<?php if($dztz1['slika']=="") {$src=$patH."/img/no-product-image.png"; $dnone=" d-none";} else $src=$patH.GALFOLDER."/".$dztz1['slika'] and $dnone=""; ?>
						<img src="<?php echo $src?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
						    <div class="img-view<?php echo $dnone?>">
                                <a class="img-popup" href="<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $dztz1['slika']?>" title="<?php echo $dztz1['naslov']?>"><i class="fa fa-search"></i></a>
                            </div>
					</div>
<?php if($dztz1['slika1']!="") { ?>
					<div class="pro-large-img">
						<img src="<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $dztz1['slika1']?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
						    <div class="img-view<?php echo $dnone?>">
                                <a class="img-popup" href="<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $dztz1['slika1']?>" title="<?php echo $dztz1['naslov']?>"><i class="fa fa-search"></i></a>
                            </div>
					</div>
<?php } ?>
<?php 
$sli = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike
        WHERE pt.lang='$lang' AND  p.tip=5 AND  p.akt='Y' AND p.idupisa=".$dztz1['ide']." ORDER BY -p.pozicija DESC");
while($sli1=mysqli_fetch_assoc($sli)) { ?>
					<div class="pro-large-img">
						<img src="<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $sli1['slika']?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
							<div class="img-view">
                                <a class="img-popup" href="<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $sli1['slika']?>" title="<?php echo $dztz1['naslov']?>"><i class="fa fa-search"></i></a>
                            </div>
					</div>
<?php } ?>
				</div>

                    <div class="pro-nav pb-30<?php echo $dnone?>">
<div class="pro-nav-thumb">
<img src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $dztz1['slika']?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
</div>
<?php if($dztz1['slika1']!="") { ?>
<div class="pro-nav-thumb">
<img class="img-fluid" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $dztz1['slika1']?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
</div>
<?php } ?>
<?php 
$sli = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike
        WHERE pt.lang='$lang' AND  p.tip=5 AND  p.akt='Y' AND p.idupisa=".$dztz1['ide']." ORDER BY -p.pozicija DESC");
while($sli1=mysqli_fetch_assoc($sli)) {
?>
						<div class="pro-nav-thumb">
							<img src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $sli1['slika']?>" title="<?php echo $dztz1['naslov']?>" alt="<?php echo $dztz1['naslov']?>">
						</div>
<?php } ?>
					</div>

<?php 
$nArr=array();
$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  p.nivo=1 AND p.id_cat=30 ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
$nArr[$tz1['ide']]=$tz1;
}
$ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 AND p.kupindo='$dztz1[kupindo]' AND p.kupindo!='' AND nijansa>0 AND NOT p.id=$dztz1[ide]");
while($az1=mysqli_fetch_array($ztz))
{
$mz1=$nArr[$az1['nijansa']];
?>
<div class="col-petina mt-20 text-center nijans d-none">
    <div class="single-slider-product grid-view-product">
        <div class="single-slider-product__image" style="line-height:unset;">
            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $az1['ulink']?>/" title="<?php echo $az1['naslov']?>">
            <img class="img-fluid" src="<?php echo $patH.SUBFOLDER.GALFOLDER.'/thumb/'.$mz1['slika']?>" alt="<?php echo $al?>" title="<?php echo $ti?>"><p><?php echo $mz1['naziv']?></p></a>
        </div>
	</div>
</div>
<?php } ?>

<?php if($dztz1['video']!="") {
if(substr($dztz1['video'], -3)=="mp4") $vtip="video/mp4";
elseif(substr($dztz1['video'], -3)=="ogg") $vtip="video/ogg";
else $vtip="video/webm";
?>
	<video width="100%" id="volume" controls preload>
    <source src="<?php echo $patH1?>/video-fajlovi/<?php echo $dztz1['video']?>" type="<?php echo $vtip?>" />
	</video>
<script>
document.getElementById("volume").volume = 0.4;
</script>
<?php } ?>


<?php
if($dztz1['keywords']!="") {
echo '<div class="video embed-responsive embed-responsive-16by9 mb-3">';
if(preg_match("/\byoutube\b/i",$dztz1['keywords'])) {
$vide=str_replace("watch?v=", "embed/", $dztz1['keywords']);
$video=str_replace("&", "?", $vide);
echo '<iframe src='.$video.' allowfullscreen="allowfullscreen"></iframe>';
}
else echo "<h3>Nešto nije u redu. Proverite da li ste uneli dobar link videa.</h3>";
echo '</div>';
}
?>


                 </div>


                <div class="col-lg-7">
                    <!--=======  product details content  =======-->
                    <div class="product-details-inner">
						<div class="product-details-contentt">
<?php
if($dztz1['marka']!="") echo "<div class='pro-details-name mb-10'><h3>".$dztz1['marka']."</h3></div>"; else echo "";
$ocena=0;
if(mb_eregi("-",$dztz1['ocena'])) {
$oce=explode("-",$dztz1['ocena']);
$ocena=round($oce[0]/$oce[1]);
$ocena4=$oce[0]/$oce[1];
$ocena5=round($ocena4,1);
$ocko=$oce[1];
if((substr($ocko, -1)*1==1) or (substr($ocko, -1)*1>=5 and substr($ocko, -1)*1<=9))
$ockos=$ocko." Ocena";
else
if(substr($ocko, -1)*1>1 and substr($ocko, -1)*1<5)
$ockos=$ocko." Ocene";
} else $ockos="Bez ocene";
?>
					<div class="row">
						<div class="col-12 col-sm-6">
                            <div class="pro-details-review mb-20">
                                <ul>
                                    <li>
                                    <?php
for($i=1; $i<6; $i++) {
if($i<=$ocena) $toje=' style="color:#FFCC00;"'; else $toje="";
                                    ?>
                                        <span><i class="fa fa-star"<?php echo $toje?>></i></span>
                                    <?php } ?>
                                    </li>

                                    <li><a href="javascript:void(0)"><?php echo $ockos?></a></li>
                                </ul>
                            </div>
							<div class="price-box mb-5">
<?php
if($dztz1['uvaluti']==1) {
$pcena=$dztz1['cena']/$settings['kurs_evra'];
$pcena1=$dztz1['cena1']/$settings['kurs_evra'];
$decim="2";
$vta="&euro;";
$um="";
}
else {
$pcena=$dztz1['cena'];
$pcena1=$dztz1['cena1'];
$decim="0";
$vta="RSD";
$um=" class='um'";
}
if($dztz1['cena']!=0) {
if($dztz1['cena1']>0 and $dztz1['akcija_obicna']==1)
echo "Cena: <span class='regular-price'><span class='special-price'>".number_format($pcena,$decim,",",".")." <span".$um.">".$vta."</span></span></span>
&nbsp;&nbsp;<span class='old-price'><del>".number_format($pcena1,$decim,",",".")." <span".$um.">".$vta."</span></del></span>";
else
echo "Cena: <span class='regular-price'><span class='special-price'>".number_format($pcena,$decim,",",".")." <span".$um.">".$vta."</span></span></span>";
}
?>
							</div>
                            <div class="pro-details-list">
                                <ul>
<?php if($brend1['naziv']!="") { ?>
                                    <li><span>Brand: </span><a href="#"><?php echo $brend1['naziv']?></a></li>
<?php }
if($dztz1['novo']==1) $nov="NOVO"; else $nov="KORIŠĆENO";
?>
                                    <li><span>Stanje: </span><b><?php echo $nov?></b></li>
									<li><span>WEB ID: </span><?php echo $dztz1['id']?></li>
<!--
<?php if($dztz1['lager']==0) echo '<li><span>'.$arrwords2['lager_nema'].'</span></li>'; else echo '<li><span>'.$arrwords2['lager_ima'].'</span></li>';?>
-->
<?php
echo '<li><span>Cena dostave: <b>BESPLATNA DOSTAVA!</b></span></li>';
//if($dztz1['vegan']==1) echo '<li><span>Cena dostave: <b>BESPLATNA DOSTAVA!</b></span></li>';
//elseif($dztz1['nova_cena_dostave']==0 and $dztz1['limit_dostave']==0 and $dztz1['fiksna_dostava']>0) echo '<li><span>Cena dostave: <b>'.$dztz1['fiksna_dostava'].' RSD</b></span></li>';
//elseif($dztz1['nova_cena_dostave']==0 and $dztz1['limit_dostave']>0 and $dztz1['fiksna_dostava']>0) echo '<li><span>Cena dostave: <b>'.$dztz1['fiksna_dostava'].' RSD</b></span></li><li><span>Za narudžbine preko <b>'.$dztz1['limit_dostave'].' RSD</b> dostava je besplatna!</span></li>';
//elseif($dztz1['nova_cena_dostave']>0 and $dztz1['limit_dostave']>0 and $dztz1['fiksna_dostava']>0) echo '<li><span>Cena dostave: <b>'.$dztz1['nova_cena_dostave'].' RSD</b></span></li><li><span>Za narudžbine preko <b>'.$dztz1['limit_dostave'].' RSD</b> dostava je besplatna!</span></li>';
//elseif($dztz1['nova_cena_dostave']>0 and $dztz1['limit_dostave']==0 and $dztz1['fiksna_dostava']==0) echo '<li><span>Cena dostave: <b>'.$dztz1['nova_cena_dostave'].' RSD</b></span></li>';
//elseif($dztz1['nova_cena_dostave']>0 and $dztz1['limit_dostave']==0 and $dztz1['fiksna_dostava']>0) echo '<li><span>Cena dostave: <b>'.$dztz1['nova_cena_dostave'].' RSD</b></span></li>';



if(strlen($dztz1['link'])>5) { ?>
                                    <li><span>EAN KOD: </span><?php echo $dztz1['link']?></li>
<?php } ?>
                                </ul>
								
								<div class="rating">
								  <span><strong>Ocenite proizvod:</strong></span><br>
                  <?php

for($i=5; $i>0; $i--) {
//if($i==$ocena) $toje="checked"; else
$toje="";
                  ?>
								  <input type="radio" class="starme" id="star<?php echo $i?>" name="rating" <?php echo $toje?> value="<?php echo $i?>-<?php echo $dztz1['ide']?>" /><label for="star<?php echo $i?>" title="<?php echo $i?>"><?php echo $i?> stars</label>
							<?php } ?>
								</div>
								<div class="clearfix"></div>
								
								
                            </div>

<?php if($dztz1['lager']==0) {
if(isset($_SESSION['userid'])) {
?>
                        <div class="product-detail-sort-des mb-20">
<h5><?php echo $arrwords['obavesti_kad_stigne']?></h5>
<form method="post" action="" id="obavesti">
<?php 
echo '<input type="hidden" name="obavestime" value="'.$us1['email'].'">';
//else echo '<input class="form-control mb-10" type="email" name="obavestime" placeholder="Unesite email za obaveštenje" required>'; ?>
<input type="hidden" name="naziv" value="<?php echo $dztz1['naslov']?>">
<input type="hidden" name="link" value="<?php echo curPageURL()?>">
<input type="hidden" name="pro" value="<?php echo $dztz1['id']?>">
<button class="theme-button mb-10" id="obavestiEmail" > <?php echo $arrwords['obavesti_me']?> </button>
</form>
							<div class="clearfix"></div>
                        </div>
<?php } } else { ?>
                            <div class="pro-quantity-box mb-30">
								<button type="submit" class="btn-cart lg-btn" onclick="displaySubs(<?php echo $dztz1['id']?>,'yes');"><i class="far fa-shopping-cart"></i> Dodaj u korpu</button>
							</div>
<?php }  ?>

							<div class="useful-links mb-20">
								<ul>
<?php if(isset($lz_niz) and in_array($dztz1['id'],$lz_niz)) { ?>
									<li class="wishlist-button mr-20"><a href="<?php echo $patH?>/include/ulistu-zelja-del.php?pro=<?php echo $dztz1['id']?>"><i class="far fa-heart"></i> Izbaci iz liste</a></li>
<?php } else { ?>
									<li class="wishlist-button mr-20"><a href="<?php echo $patH?>/include/ulistu-zelja.php?pro=<?php echo $dztz1['id']?>"><i class="far fa-heart"></i> U listu želja</a></li>
<?php }
if($_SESSION['uporedi'][$dztz1["id"]]==$dztz1["id"]) { ?>
									<li class="compare-button mr-20"><a href="<?php echo $patH1?>/<?php echo $all_links[11]?>/" title="Uporedi proizvode"><i class="fal fa-balance-scale"></i> Uporedi</a></li>
<?php } else {  ?>
									<li class="compare-button mr-20" id="up<?php echo $dztz1["id"]?>"><a href="javascript:;" onclick="uporedi(<?php echo $dztz1["id"]?>)"  title="Uporedi proizvode"><i class="fal fa-balance-scale"></i> Uporedi</a></li>
<?php } ?>
									<li class="wishlist-button"><a href="javascript:;" onclick="print('<?php echo $patH?>/print_pro_op.php?id=<?php echo $dztz1['id']?>')"><i class="far fa-print"></i> Štampaj</a></li>
								</ul>
							</div>
						</div>
								
						<div class="col-12 col-sm-6">
						<h4 class="mt-0 mb-15">Prodavac: <?php echo $prodavac?></h4>
						<?php if($slbrend1['slika']!="") echo '
						<img class="img-fluid mb-20" src="'.$patH1.'/galerija/thumb/'.$slbrend1["slika"].'" alt="'.$brend1['naziv'].'" title="'.$brend1['naziv'].'">'; else echo "";
/*$proF=mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        LEFT JOIN pro_filt f ON f.id_filt=p.id
        WHERE p.akt=1 AND f.id_pro=".$dztz1["id"]." GROUP BY p.id");
        if(!$proF) echo mysqli_error($conn);

while($proFi=mysqli_fetch_assoc($proF)){
echo $proFi['naziv']."<br>";
}*/
$filtri=explode(",",$dztz1["filteri"]);
$filt=array();
$filtAll=array();
$ff=mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang'");
//echo mysqli_num_rows($ff);
while($ff1=mysqli_fetch_assoc($ff)){
if(in_array($ff1['id_page'], $filtri))
$filt[$ff1['id_page']]=$ff1;
$filtAll[$ff1['id_page']]=$ff1;
}
if (isset($dztz1["filteri"])) {
?>
									<div class="mb-20">
										<p class="karakteristike">Karakterisike proizvoda:</p>
              <?php
$iv=0;
foreach($filt as $k => $v){
$parent=$v['id_parent'];
echo $filtAll[$parent]['naziv'].": ";
echo "<strong>".$v['naziv']."</strong><br>";
$iv++;
}
              ?>
									</div>
<?php } ?>
								</div>
							</div>

                        <div class="product-info-block mb-30">
<?php
$zaq = mysqli_query($conn, "SELECT naziv FROM stavkel
	WHERE id_page='$dztz1[nijansa]' AND $dztz1[nijansa]>0");
if(mysqli_num_rows($zaq)>0) {
$zaq1=mysqli_fetch_array($zaq);	
echo '<div class="single-info">
	<span class="title">Nijansa: </span>
	<span class="value">'.$zaq1['naziv'].'</span>
</div>
';
}
else echo "";
?>
                        </div>


<!-- JSON-LD ознаке које је генерисао Помоћник за означавање структурираних података. -->
<?php 
$ops=strip_tags($dztz1['opis']);
$ops1=str_replace("\"","",$ops);
$ops2=strip_tags(mb_substr($ops1,0,160));
?>
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Product",
  "name" : "<?php echo $dztz1['naslov']?>",
  "image" : "<?php echo $patH?>/galerija/thumb/<?php echo $dztz1['slika']?>",
  "description" : "<?php echo $ops2 ?>",
  "brand" : {
    "@type" : "Brand",
    "name" : "<?php echo $brend1['naziv']?>",
	"logo" : "<?php echo $patH?>/galerija/<?php echo $slbrend1['slika']?>"
  },
  "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "<?php echo $ocena5?>",
      "ratingCount": "<?php echo $ocko?>"
    },
  "offers" : {
    "@type" : "Offer",
	"url": "<?php echo $patH?>/<?php echo $all_links[3]?>/<?php echo $dztz1['ulink']?>/",
	"priceCurrency": "RSD",
    "price" : "<?php echo $dztz1['cena']?>",
	"priceValidUntil": "2022-11-01",
	"availability": "https://schema.org/InStock"
  }
}
</script>
<ul class="nav mt-20 display-4 d-none">
<?php 
$naslovna=$najporodavaniji=$akcija=$novo=$lagers=$vegan="";
if($dztz1['vegan']==1) $vegan="<li class='ljub'><i class='fa am-vegan3'></i></li>";
if($dztz1['novo']==1) $novo="<li class='ljub'><i class='fa am-novo'></i></li>";
if($dztz1['akcija']==1 and $dztz1['cena1']>0)
$akcija="<li class='ljub'><i class='fa am-procenat'></i></li>";
if($dztz1['naslovna']==1)
$naslovna="<li class='ljub'><i class='far fa-thumbs-up'></i></li>";
if($dztz1['izdvojeni']==1)
$najporodavaniji="<li class='ljub'><i class='fa am-best-seller'></i></li>";
if($dztz1['lager']==0)
$lagers="<li class='ljub'><i class='fa am-out-of-stock'></i></li>";
echo $novo.$najporodavaniji.$akcija.$naslovna.$lagers.$vegan;
?>
</ul>
</div>
</div>

			</div><!-- /row -->
		</div><!-- /container-fluid -->
	</div>
</div>



<div class="product-details-reviews pb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-info mt-half">
                    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                             <a class="nav-link active" id="nav_desctiption" data-toggle="pill" href="#tab_description" role="tab" aria-controls="tab_description" aria-selected="true">Opis</a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link" id="nav_specifikacija" data-toggle="pill" href="#tab_specifikacija" role="tab" aria-controls="tab_specifikacija" aria-selected="false">Karaktristike</a>
                        </li>
<?php if($modulArr['komentari-proizvod']==1) {
if(!isset($_SESSION['userids'])) $aktis=" AND akt=1"; else $aktis="";
$kom=mysqli_query($conn, "SELECT * FROM komentari WHERE id_pro=".$dztz1['ide']." AND tip=0 AND id_parent=0 $aktis ORDER BY date ASC");
$brk=mysqli_num_rows($kom);
if($brk==0) {
$pref="";
$cbr="Za sada nema ni pitanja ni komentara.";
}
else {
$cbr="KOMENTAR";
$pref=$brk;
}
if($brk>1) $nast="A"; else $nast="";
?>
                        <li class="nav-item">
                            <a class="nav-link" id="nav_review" data-toggle="pill" href="#tab_review" role="tab" aria-controls="tab_review" aria-selected="false">Pitanja/Komentari (<?php echo $brk?>)</a>
                        </li>
<?php } ?>
                    </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_description" role="tabpanel" aria-labelledby="nav_desctiption">
							<?php echo $dztz1['opis']?>
                            </div>
                            <div class="tab-pane fade show d-none" id="tab_specifikacija" role="tabpanel" aria-labelledby="nav_specifikacija">
                            </div>
<?php if($modulArr['komentari-proizvod']==1) { ?>
                            <div class="tab-pane fade" id="tab_review" role="tabpanel" aria-labelledby="nav_review">
                                <div class="product-review">
                                    <div class="customer-review">
                    <div class="comment-section mb-md-30 mb-sm-30">
                        <h3 class="comment-counter"><?=$pref." ".$cbr.$nast?></h3>
                        <div class="comment-container mb-30">
 <?php
while($kom1=mysqli_fetch_assoc($kom)) {
$tim = strtotime($kom1['date']);
?>

<div id="kom<?php echo $kom1['id']?>">
<?php
if(isset($_SESSION['userids'])) { //admin akcije
if($kom1['akt']==1) $komse="checked"; else $komse="";
$odgovri='<span class="reply-btn"><a href="javascript:;" onclick="formOdg('.$kom1['id'].')" title="Odgovori na komentar"><i class="far fa-reply-all"></i></a></span>';
?>
<div class="single-comment admin-odobrenje">
<div class="check-box d-inline-block ml-0 ml-md-2">
<input id="odobrikom<?php echo $kom1['id']?>" class="check-box" type='checkbox' <?php echo $komse?> value='<?php echo $kom1['id']?>' onclick="akti(<?php echo $kom1['id']?>, 'akomentar')" />
<label for="odobrikom<?php echo $kom1['id']?>"><?php echo $langa['messag'][56]?></label>
</div>

<a href='javascript:;' onclick="delm(<?php echo $kom1['id']?>,'del_kom','<?php echo $langa['messag'][562]?>', 0)">
<i class="far fa-trash-alt"></i> <?php echo $langa['messag'][561]?></a>
<a style="margin-left:10%" name="reviews" href='javascript:;'  rel="<?php echo $kom1['id']?>" class='izmform'><i class="far fa-retweet-alt"></i> Izmeni komentar</a>

</div>
<?php } ?>


<div class="single-comment mb-15">
<?php echo $odgovri?>
<div class="image">
<i class="fal fa-comment-smile fa-3x"></i>
</div>
<div class="content">
<h3 class="user"><?php echo $kom1['ime']?> <span class="comment-time"><?php echo date("H:i", $tim)?> <?php echo date("d.m.Y", $tim)?></span></h3>
<p class="comment-text" id="com<?php echo $kom1['id']?>"><?php echo $kom1['komentar']?></p>

<div id="fom<?php echo $kom1['id']?>"></div>

<?php
$skom=mysqli_query($conn, "SELECT * FROM komentari WHERE id_parent=$kom1[id] AND tip=0 $aktis ORDER BY date ASC");
if(mysqli_num_rows($skom)>0) {
while($skom1=mysqli_fetch_assoc($skom)) {
$tim = strtotime($skom1['date']);
if(isset($_SESSION['userids']))
{
if($skom1['akt']==1) $skomse="checked"; else $skomse="";
?>
<div id="kom<?php echo $kom1['id']?>">
<div class="single-comment admin-odobrenje skom<?php echo $skom1['id']?>">

<div class="check-box d-inline-block ml-0 ml-md-2">
<input id="odobrikom<?php echo $skom1['id']?>" class="check-box" type='checkbox' <?php echo $skomse?> value='<?php echo $skom1['id']?>' onclick="akti(<?php echo $skom1['id']?>, 'akomentar')" />
<label for="odobrikom<?php echo $skom1['id']?>"><?php echo $langa['messag'][56]?></label>
</div>

<a href='javascript:;' onclick="delm(<?php echo $skom1['id']?>,'del_kom','<?php echo $langa['messag'][562]?>', <?php echo $kom1['id']?>)">
<i class="far fa-trash-alt"></i> <?php echo $langa['messag'][561]?></a>
<a style="margin-left:10%" name="reviews" href='javascript:;' rel="<?php echo $skom1['id']?>" class='izmform'><i class="far fa-retweet-alt"></i> Izmeni komentar</a>
</div>

<?php } ?>
<div class="single-comment skom<?php echo $skom1['id']?> mb-20 pt-15 d-block">
<p class="comment-text"><i class="fal fa-comment-smile fa-2x"></i> <span class="comment-time"><?php echo date("H:i", $tim)?> <?php echo date("d.m.Y", $tim)?></span> <strong><?php echo $skom1['ime']?></strong> kaže:</p>
<p class="comment-text" id="com<?php echo $skom1['id']?>"><?php echo $skom1['komentar']?></p>
</div>

<?php
if(!isset($_SESSION['userids'])) echo ""; else echo "</div>";
}
}
?>
</div>
</div>
</div> <!-- / div id -->
<?php
} // kraj while petlje listanja komentaara
if(!isset($_SESSION['userids'])) echo "</div></div>"; else echo ""; // Ovako je za NE admina
?>
                        
                                    </div> <!-- end of customer-review -->
<div id="reviews" class="mb-30 row">
<div class="col-sm-12">
<h3>Postavite pitanje ili napišite svoj komentar</h3>

<div class="comment-form">
<form action="<?php echo curPageURL()?>#reviews"  method="post" class="comment-form">
<input type="hidden" name="idpro" value="<?php echo $dztz1['ide']?>">
<div class="row">

<div class="col-lg-6">
    <div class="form-group">
<label>Ime ili nadimak <span class="required">*</span></label>
<input type="text" name='ime' placeholder="Vaše ime" value="<?php echo $_POST['ime']?$_POST['ime']:$uzk1['ime']?>" required>
	</div>
</div>

<div class="col-lg-6">
    <div class="form-group">
<label>Email <span class="required">*</span></label>
<input type="email" name='email' value="<?php echo $_POST['email']?$_POST['email']:$uzk1['email']?>" placeholder="Vaša email adresa (neće biti objabvljena)" required>
	</div>
</div>

<input type="hidden" name="send_komentar" value="1">

<div class="col-lg-12">
<div class="form-group">
<label>Pitanje ili komentar <span class="required">*</span></label>
<textarea name="poruka" required><?php echo $_POST['poruka']?$_POST['poruka']:""?></textarea>
</div>
</div>

</div>

<div class="row">
<div class="col-lg-12">

<div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_html']?>"></div>

<button type="submit" class="fl-btn float-right">
<?php
 echo "Pošalji";
?>
</button>
</div>
</div>

</form>
</div>

<div id="komForma" style="display:none;">
<form action="<?php echo curPageURL()?>#reviews"  method="post" class="comment-form">
<div class="row">
<div class="col-lg-6">
    <div class="form-group">
<label>Ime ili nadimak <span class="required">*</span></label>
<input type="text" name='ime' placeholder="Vaše ime" value="" required>
	</div>
</div>
<div class="col-lg-6">
    <div class="form-group">
<label>Email <span class="required">*</span></label>
<input type="email" name='email' value="" placeholder="Vaša email adresa" required>
	</div>
</div>
<input type="hidden" name="id_parent" id="id_parent" value="0">
<input type="hidden" name="send_komentar" value="1">
<input type="hidden" name="idpro" value="<?php echo $dztz1['id']?>">
<div class="col-lg-12">
<div class="form-group">
<label>Komentar <span class="required">*</span></label>
<textarea name="poruka" required></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<button type="submit" class="fl-btn float-right"><?php echo "Pošalji";?></button>
</div>
</div>
</form>
</div>

</div>
</div>
                                </div> <!-- end of product-review -->
                            </div>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> 


<?php
if(isset($_SESSION['userids'])) echo "</div></div>"; else echo "";
if($modulArr['mozda-ce-vas-zanimati']==1) { ?>
<!--=======  Start MOZDA CE VAS ZANIMATI...  =======-->
<div class="container-fluid">
    <div class="home-module-four">
            <div class="section-title">
                <h3><?php echo $arrwords['mozda_vas_zanima']?></h3>
            </div>
                    <!--=======  product single row slider wrapper  =======-->
            <div class="pro-module-four-active owl-carousel owl-arrow-style">
<?php 
if($settingsb['limit_upotpunite']<1) $lim=4; else $lim=$settingsb['limit_upotpunite'];
$josa=0;
/*$atz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN pro_slicni ps ON p.id = ps.id_pro1 AND ps.id_pro=$dztz1[id]
        WHERE pt.lang='$lang' AND p.akt=1");
$utza=mysqli_num_rows($atz);
$ppa=ceil($utza/$lim);
if($utza<$lim)
$josa=$lim-$utza;
if($utza==0) $ppa=1;
$st=$y*$lim;

$ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN pro_slicni ps ON p.id = ps.id_pro1 AND ps.id_pro=$dztz1[id]
        WHERE pt.lang='$lang' AND p.akt=1  ORDER BY RAND() LIMIT $st,4");*/
//echo mysqli_num_rows ($atz);

$kizArr=array();

 $aa = mysqli_query($conn, "SELECT kat  FROM kat_pro WHERE pro=$dztz1[id]");
  while($aa1=mysqli_fetch_array($aa)){
$kizArr[]=$aa1['kat'];
  }

$ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
INNER JOIN kat_pro kp ON p.id=kp.pro
        WHERE pt.lang='$lang' AND p.akt=1 AND kp.kat IN (".implode(",",$kizArr).") ORDER BY RAND() LIMIT $lim");

while($atz1=mysqli_fetch_array($ztz))
 {
 if($atz1['kategorija']>0)
 {
 $sta = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND p.id=$atz1[kategorija]");
  $sta1=mysqli_fetch_array($sta);
  $mlink=$all_links[3];
  $plusi=$sta1['ulink']."/";
 } else
 {
  $mlink=$all_links[3];
  $plusi="";
 }
 ?>
                            <!--=======  single slider product  =======-->
                <div class="product-module-four-item">
                    <div class="product-module-caption">
                        <div class="product-module-name">
                            <h4><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>"><?php echo $atz1['naslov']?></a></h4>
                        </div>
                        <div class="ratings">
<?php
$ocena=0;
if(mb_eregi("-",$atz1['ocena'])) {
$oce=explode("-",$atz1['ocena']);
$ocena=round($oce[0]/$oce[1]);
}
$ocena1=5-$ocena;
                                    for($r=1; $r<=$ocena; $r++) {
                                        echo'<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									echo'<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
?>
                        </div>
                        <div class="price-box-module">
<?php 
if($atz1['cena']!=0) {
if($atz1['cena1']>0 and $atz1['akcija_obicna']==1)
echo "<span class='regular-price'><span class='special-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span></span>
<span class='old-price'><del>".number_format($atz1['cena1'],0,",",".")."</del></span>";
else
echo "<span class='regular-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span>";
if($atz1['lager']==1)
$ukorpu="onclick=\"displaySubs($atz1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
}
?>
<br>
<span><a class="btn-2 home-btn" href="<?php echo $patH1?>/<?php echo $all_links[18]?>/" <?php echo $ukorpu?>>KUPI ODMAH</a></span>
                        </div>
                    </div>
                    <div class="product-module-thumb">
                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>">
							<?php if($atz1['slika']!="") { ?>
								<img class="pri-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika']?>" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
							<?php } else { ?>
							<img class="pri-img" src="<?php echo $patH?>/img/no-product-image.png" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
						<?php } ?>		
                        </a>
                    </div>
                </div>
<?php 
}
if($josa>0)
{
$rtz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 ORDER BY rand() LIMIT $josa");
while($atz1=mysqli_fetch_array($rtz))
 {
 if($atz1['kategorija']>0)
 {
 $sta = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND p.id=$atz1[kategorija]");
  $sta1=mysqli_fetch_array($sta);
  $mlink=$all_links[3];
  $plusi=$sta1['ulink']."/";
 }else
 {
  $mlink=$all_links[3];
  $plusi="";
 }
?>
                <div class="product-module-four-item">
                    <div class="product-module-caption">
                        <div class="product-module-name">
                            <h4><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>"><?php echo $atz1['naslov']?></a></h4>
                        </div>
                        <div class="ratings">
<?php
$ocena=0;
if(mb_eregi("-",$atz1['ocena'])) {
$oce=explode("-",$atz1['ocena']);
$ocena=round($oce[0]/$oce[1]);
}
$ocena1=5-$ocena;
                                    for($r=1; $r<=$ocena; $r++) {
                                        echo'<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									echo'<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
?>
                        </div>
                        <div class="price-box-module">
<?php 
if($atz1['cena']!=0) {
if($atz1['cena1']>0 and $atz1['akcija_obicna']==1)
echo "<span class='regular-price'><span class='special-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span></span>
<span class='old-price'><del>".number_format($atz1['cena1'],0,",",".")."</del></span>";
else
echo "<span class='regular-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span>";
if($atz1['lager']==1)
$ukorpu="onclick=\"displaySubs($atz1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
}
?>
<br>
<span><a class="btn-2 home-btn" href="<?php echo $patH1?>/<?php echo $all_links[18]?>/" <?php echo $ukorpu?>>KUPI ODMAH</a></span>
                        </div>
                    </div>
                    <div class="product-module-thumb">
                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>">
							<?php if($atz1['slika']!="") { ?>
								<img class="pri-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika']?>" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
							<?php } else { ?>
							<img class="pri-img" src="<?php echo $patH?>/img/no-product-image.png" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
						<?php } ?>		
                        </a>
                    </div>
                </div> <!-- end single item -->
<?php } } ?>
            </div>
                   <!--=======  End of product single row slider wrapper  =======-->
    </div>
</div>
<!--=======  End MOZDA CE VAS ZANIMATI...  =======-->
<?php } ?>



<?php if($modulArr['kupili-su']==1) { ?>
<!--=======  Start KUPILI SU...  =======-->
<div class="container-fluid">
    <div class="home-module-four">
            <div class="section-title">
                <h3><?php echo $arrwords['kupci_kupili']?></h3>
            </div>
                    <!--=======  product single row slider wrapper  =======-->
            <div class="pro-module-four-active owl-carousel owl-arrow-style">
<?php 
if($settingsb['limit_kupili_su']<1) $lim=4; else $lim=$settingsb['limit_kupili_su'];
$atz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN pro_kupili ps ON p.id = ps.id_pro1 AND ps.id_pro=$dztz1[id]
        WHERE pt.lang='$lang' AND p.akt=1");

$utza=mysqli_num_rows($atz);
$ppa=ceil($utza/$lim);
if($utza<$lim)
$josa=$lim-$utza;
if($utza==0) $ppa=1;
$st=$y*$lim;
?>
<?php 
$ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        INNER JOIN pro_kupili ps ON p.id = ps.id_pro1 AND ps.id_pro=$dztz1[id]
        WHERE pt.lang='$lang' AND p.akt=1  ORDER BY RAND() LIMIT $st,4");
//echo mysqli_num_rows ($atz);
while($atz1=mysqli_fetch_array($ztz))
 {
 if($atz1['kategorija']>0)
 {
 $sta = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND p.id=$atz1[kategorija]");
  $sta1=mysqli_fetch_array($sta);
  $mlink=$all_links[3];
  $plusi=$sta1['ulink']."/";
 } else
 {
  $mlink=$all_links[3];
  $plusi="";
 }
 ?>
                            <!--=======  single slider product  =======-->
                <div class="product-module-four-item">
                    <div class="product-module-caption">
                        <div class="product-module-name">
                            <h4><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $plusi?><?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>"><?php echo $atz1['naslov']?></a></h4>
                        </div>
                        <div class="ratings">
<?php
$ocena=0;
if(mb_eregi("-",$atz1['ocena'])) {
$oce=explode("-",$atz1['ocena']);
$ocena=round($oce[0]/$oce[1]);
}
$ocena1=5-$ocena;
                                    for($r=1; $r<=$ocena; $r++) {
                                        echo'<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									echo'<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
?>
                        </div>
                        <div class="price-box-module">
<?php 
if($atz1['cena']!=0) {
if($atz1['cena1']>0 and $atz1['akcija_obicna']==1)
echo "<span class='regular-price'><span class='special-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span></span>
<span class='old-price'><del>".number_format($atz1['cena1'],0,",",".")."</del></span>";
else
echo "<span class='regular-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span>";
if($atz1['lager']==1)
$ukorpu="onclick=\"displaySubs($atz1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
}
?>
<br>
<span><a class="btn-2 home-btn" href="<?php echo $patH1?>/<?php echo $all_links[18]?>/" <?php echo $ukorpu?>>KUPI ODMAH</a></span>
                        </div>
                    </div>
                    <div class="product-module-thumb">
                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>">
							<?php if($atz1['slika']!="") { ?>
								<img class="pri-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika']?>" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
							<?php } else { ?>
							<img class="pri-img" src="<?php echo $patH?>/img/no-product-image.png" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
						<?php } ?>		
                        </a>
                    </div>
                </div>
<?php 
}
if($josa>0)
{
$rtz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 ORDER BY rand() LIMIT $josa");
while($atz1=mysqli_fetch_array($rtz))
 {
 if($atz1['kategorija']>0)
 {
 $sta = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND p.id=$atz1[kategorija]");
  $sta1=mysqli_fetch_array($sta);
  $mlink=$all_links[3];
  $plusi=$sta1['ulink']."/";
 }else
 {
  $mlink=$all_links[3];
  $plusi="";
 }
?>
                <div class="product-module-four-item">
                    <div class="product-module-caption">
                        <div class="product-module-name">
                            <h4><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $plusi?><?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>"><?php echo $atz1['naslov']?></a></h4>
                        </div>
                        <div class="ratings">
<?php
$ocena=0;
if(mb_eregi("-",$atz1['ocena'])) {
$oce=explode("-",$atz1['ocena']);
$ocena=round($oce[0]/$oce[1]);
}
$ocena1=5-$ocena;
                                    for($r=1; $r<=$ocena; $r++) {
                                        echo'<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									echo'<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
?>
                        </div>
                        <div class="price-box-module">
<?php 
if($atz1['cena']!=0) {
if($atz1['cena1']>0 and $atz1['akcija_obicna']==1)
echo "<span class='regular-price'><span class='special-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span></span>
<span class='old-price'><del>".number_format($atz1['cena1'],0,",",".")."</del></span>";
else
echo "<span class='regular-price'>Cena: ".number_format($atz1['cena'],0,",",".")."</span>";
if($atz1['lager']==1)
$ukorpu="onclick=\"displaySubs($atz1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
}
?>
<br>
<span><a class="btn-2 home-btn" href="<?php echo $patH1?>/<?php echo $all_links[18]?>/" <?php echo $ukorpu?>>KUPI ODMAH</a></span>
                        </div>
                    </div>
                    <div class="product-module-thumb">
                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['id']?>/" title="<?php echo $atz1['naslov']?>">
							<?php if($atz1['slika']!="") { ?>
								<img class="pri-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika']?>" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
							<?php } else { ?>
							<img class="pri-img" src="<?php echo $patH?>/img/no-product-image.png" title="<?php echo $atz1['naslov']?>" alt="<?php echo $atz1['naslov']?>">
						<?php } ?>		
                        </a>
                    </div>
                </div> <!-- end single item -->
<?php } } ?>
            </div>
                   <!--=======  End of product single row slider wrapper  =======-->
    </div>
</div>
<!--=======  EndKUPILI SU...  =======-->
<?php } ?>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">(function() {var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js?publisherid=100005648085505074745";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);})();</script>