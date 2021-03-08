<?php
$prod=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$az1[prodavac]");
$prod1=mysqli_fetch_assoc($prod);
if($prod1['firma']==1) $prodavac=$prod1['nazivfirme']; else $prodavac=$prod1['nickname'];
$ocenaQW=0;
if(mb_eregi("-",$az1['ocena'])) {
$oceQW=explode("-",$az1['ocena']);
$ocenaQW=round($oceQW[0]/$oceQW[1]);
$ocenaQW4=$oce[0]/$oceQW[1];
$ocenaQW5=round($ocenaQW4,1);
$ockoQW=$oceQW[1];
if((substr($ockoQW, -1)*1==1) or (substr($ockoQW, -1)*1>=5 and substr($ockoQW, -1)*1<=9))
$ockosQW=$ockoQW." Ocena";
else
if(substr($ockoQW, -1)*1>1 and substr($ockoQW, -1)*1<5)
$ockosQW=$ockoQW." Ocene";
} else $ockosQW="Bez ocene";

$filtris=explode(",",$az1["filteri"]);
$filt=array();
foreach($filtAll as $kuk => $vuk) {
if(in_array($kuk, $filtris))
$filt[$kuk]=$vuk;
}
$mlista .='
<div class="modal fade" id="quick-view'.$az1["ide"].'">
	<div class="container">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="mb-20">
							<div class="pro-large-img">';
if($az1['slika']!="") $psl=$patH.SUBFOLDER.GALFOLDER."/thumb/".$az1['slika']; else $psl=$patH."/img/no-product-image.png";
$mlista .='                     <img src="'.$psl.'" alt="'.$al.'" title="'.$ti.'">
                            </div>';
if($az1['slika1']!="") {
$mlista .='					<div class="pro-large-img">
                                <img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">
                            </div>';
}
$mlista .='
                            <div class="pro-details-review mb-20 text-center">
                                <ul>
                                    <li>';
for($i=1; $i<6; $i++) {
if($i<=$ocenaQW) $toje=' style="color:#FFCC00;"'; else $toje="";

$mlista .='	                            <span><i class="fa fa-star"'.$toje.'></i></span>';
}
$mlista .='                          </li><li>'.$ockosQW.'</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
						<div class="product-details-inner">
							<div class="pro-details-name mb-10">
								<h3 class="product-details-title mb-15">'.$az1['naslov'].'</h3>
								<h4 class="product-details-title mb-15">'.$az1['marka'].'</h4>
								<h4 class="mt-0 mb-15">Prodavac: '.$prodavac.'</h4>
							</div>
';
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija']==1)
$mlista .='<p class="product-price product-price--big mb-10">Cena: <span class="discounted-price">'.number_format($az1['cena'],2,",",".").'</span>
<span class="main-price discounted">Cena: '.number_format($az1['cena1'],2,",",".").'</span></p>';
}
else
$mlista .= '<p class="product-price product-price--big mb-10">Cena: <span class="discounted-price">'.number_format($az1['cena'],2,",",".").'</span></p>';
$mlista .='							<div class="product-info-block mb-30">
                                        <div class="single-info">
                                            <span class="title">Brend:</span>
                                            <span class="value"><a href="javascript:void()">'.$brend1['naziv'].'</a></span>
                                        </div>
                                        <div class="single-info">
                                            <span class="title">WEB ID:</span>
                                            <span class="value">'.$az1["ide"].'</span>
                                        </div>
										<!--
                                        <div class="single-info">';
if($az1['lager']==1) $lg="Ima na stanju."; else $lg="Trenutno nema na stanju.";
                                            $mlista .='<span class="title">Dostupno:</span>
                                            <span class="value stock-red">'.$lg.'</span>
                                        </div>
										-->';
if($az1['vegan']==1) $mlista .= '<li><span>Cena dostave: <b>BESPLATNA DOSTAVA!</b></span></li>';
elseif($az1['nova_cena_dostave']==0 and $az1['limit_dostave']==0 and $az1['fiksna_dostava']>0) $mlista .= '<li><span>Cena dostave: <b>'.$az1['fiksna_dostava'].' RSD</b></span></li>';
elseif($az1['nova_cena_dostave']==0 and $az1['limit_dostave']>0 and $az1['fiksna_dostava']>0) $mlista .= '<li><span>Cena dostave: <b>'.$az1['fiksna_dostava'].' RSD</b></span></li><li><span>Za narudžbine preko <b>'.$az1['limit_dostave'].' RSD</b> dostava je besplatna!</span></li>';
elseif($az1['nova_cena_dostave']>0 and $az1['limit_dostave']>0 and $az1['fiksna_dostava']>0) $mlista .= '<li><span>Cena dostave: <b>'.$az1['nova_cena_dostave'].' RSD</b></span></li><li><span>Za narudžbine preko <b>'.$az1['limit_dostave'].' RSD</b> dostava je besplatna!</span></li>';
elseif($az1['nova_cena_dostave']>0 and $az1['limit_dostave']==0 and $az1['fiksna_dostava']==0) $mlista .= '<li><span>Cena dostave: <b>'.$az1['nova_cena_dostave'].' RSD</b></span></li>';
elseif($az1['nova_cena_dostave']>0 and $az1['limit_dostave']==0 and $az1['fiksna_dostava']>0) $mlista .= '<li><span>Cena dostave: <b>'.$az1['nova_cena_dostave'].' RSD</b></span></li>';
if(strlen($az1["filteri"])>0){
$mlista .='<strong>Karakterisike proizvoda:</strong><br>';

$iv=0;
foreach($filt as $k => $v){
$parent=$v['id_parent'];
$mlista .=$filtAll[$parent]['naziv'].": ";
$mlista .="<strong>".$v['naziv']."</strong><br>";
$iv++;
}
}
                                    $mlista .='</div>';
                                    $mlista .='<div class="product-short-desc mb-25">
                                        '.$az1["opis"].'
                                    </div>
                                    <div class="quantity mb-20">
									<a href="javascript:;" class="theme-button product-cart-button mb-10" '.$ukorpu.' title="'.@count($hashAA).'"><i class="far fa-shopping-cart"></i> Dodaj u korpu</a>
                                    </div>
                                    <div class="mb-15">
									<ul>
                                        <li id="up'.$az1['ide'].'"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('.$az1['ide'].')"><i class="fal fa-balance-scale"></i> Uporedi proizvod</a></li>
										<li><a title="Dodaj u listu želja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i> Dodaj u listu želja</a></li>
									</ul>
                                    </div>
                                </div>
                                <!--=======  End of product detail content  =======-->
                            </div>
                        </div>
                    </div>
			</div>
		</div>
    </div>
</div>';