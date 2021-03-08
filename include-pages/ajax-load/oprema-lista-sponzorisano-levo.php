<?php
$mlistaslevo="";
$mlistaslevo.='
            <div class="">
                <h3>'.$arrwords['sponzorisano1'].'</h3>
            </div>
';
while($az1=mysqli_fetch_array($az))
{

//$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$az1[brend] AND lang='$lang'");
//$brend1=mysqli_fetch_assoc($brend);
if($az1['lager']==1) {
$ukorpu="onclick=\"displaySubs($az1[id],'yes', this)\"";
$ispis="Dodaj u korpu";
}
else {
$ukorpu="";
$ispis="Nije dostupno";
}
if ($az1['altslike']!="") $al=$az1['altslike']; else $al=$az1['naslov'];
if ($az1['titleslike']!="") $ti=$az1['titleslike']; else $ti=$az1['naslov'];

$mlistaslevo .='
                    <div class="product-module-caption">
						<div class="">
                            <a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">
';
if($az1['slika']!="") { $mlistaslevo .='
                                <img class="img-fluid w-100" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika'].'" alt="'.$al.'" title="'.$ti.'">
'; } else { $mlistaslevo .='	<img class="img-fluid w-100" src="'.$patH.'/img/no-product-image.png" alt="'.$al.'" title="'.$ti.'">
'; } $mlistaslevo .='
							</a>
						</div>
						<div class="product-module-name">
							<h4><a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a></h4>
						</div>
						<div class="price-box-module">
';
if($az1['uvaluti']==1) {
$pcena=$az1['cena']/$settings['kurs_evra'];
$pcena1=$az1['cena1']/$settings['kurs_evra'];
$decim="2";
$vta="&euro;";
$um="";
}
else {
$pcena=$az1['cena'];
$pcena1=$az1['cena1'];
$decim="0";
$vta="RSD";
$um=" class='um'";
}
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija_obicna']==1)
$mlistaslevo .='
<span class="regular-price">Cena: <span class="special-price">'.number_format($pcena,$decim,",",".").' '.$vta.'</span></span>
<span class="old-price"><del>'.number_format($pcena1,$decim,",",".").' </del>'.$vta.'</span>
';
else
$mlistaslevo .='
<span class="regular-price">Cena: '.number_format($pcena,$decim,",",".").' <span'.$um.'>'.$vta.'</span></span>
';
}
$mlistaslevo .='				<br><span><a class="btn-2 home-btn" href="javascript:;"'.$ukorpu.' rel="'.$patH1.'/'.$all_links[18].'/">KUPI ODMAH</a></span>
							</div>
						</div>
						<hr>
';
}
?>