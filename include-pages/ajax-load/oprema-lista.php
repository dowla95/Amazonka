<?php 
if(!isset($_POST['uris'])){
$brendd=array();
$brend=mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang'");
while($brends=mysqli_fetch_assoc($brend)){
$brendd[$brends['id_page']]=$brends;
}
}

$mlista .='<div class="row"><div class="col-12 mb-10">';
if(isset($hashA['brend'])){
$filtArr=explode("-",$hashA['brend']);
$filtArrNew=array();
foreach($filtArr as $k => $v)
$filtArrNew[$v]=$brendd[$v]['naziv'];

foreach($filtArrNew as $k => $v){
$mlista .="<label class='zafilt'><input type='checkbox' class='cho' value='".hashlink($k,$hashA,1,"brend")."' rel='sis'><b class='crveno'>X</b> $v</label>";
}
}
if(isset($hashA['filter'])){

$filtArr=explode("-",$hashA['filter']);

$filtArrNew=array();
foreach($filtArr as $k => $v) {
$parent_id=$brendd[$v]['id_parent'];
$filtArrNew[$v]=$brendd[$parent_id]['naziv']." &raquo; ".$brendd[$v]['naziv'];
}
foreach($filtArrNew as $k => $v){

$mlista .="<label class='zafilt'><input type='checkbox' class='cho' value='".hashlink($k,$hashA,1,"filter")."' rel='sis'><b class='crveno'>X</b> $v</label>";
}
}
if(isset($hashA['filt1'])){
$filtArr=explode("-",$hashA['filt1']);
foreach($filtArr as $k => $v) {
$filt_naziv=$arrwords['karakteristika'.$v];
$mlista .="<label class='zafilt'><input type='checkbox' class='cho' value='".hashlink($v,$hashA,1,"filt1")."' rel='sis'><b class='crveno'>X</b> $filt_naziv</label>";
}
}
$mlista .='</div></div>';
unset($hashA['brend']);
unset($hashA['p']);
unset($hashA['price']);
unset($hashA['filt1']); 
/*if(isset($hashA) and count($hashA)>0)
{
$s=1;
foreach($hashA as $key => $value)
{ 
$suh=explode("-",$value);
$inner_plus .="INNER JOIN pro_filt pf$s ON p.id = pf$s.id_pro AND  pf$s.id_filt IN (".implode(",",$suh).")";
$s++; 
}
}*/
if(!isset($hashAP['p'])) $ipe=0; else $ipe=$hashAP['p'];  
$ByPage1=12;
/*if(strlen($katSvi)>0)
$inner_plus1 .="AND p.id IN ($katSvi)";
elseif($ztz1['ide']>0)
$inner_plus1 .="AND p.id<1";*/

/*$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 $inner_plus1 GROUP BY p.id ORDER BY naslov ASC"));*/


//$mlista .="A: ".$ztz1['ide']."---B: ".$inner_plus1."---C: ".$inner_plus."---D: ".count($hashA);
if($br_upisa==0)
 $mlista .="<h2 class='text-center'>Trenutno nemamo nijedan proizvod po ovom kriterijumu</h2>";
$cce=ceil($br_upisa/$ByPage1);
if($ipe>0) $ipes=$ipe; else $ipes=1;
$str = ($ipes-1)*$ByPage1;
if(isset($_GET['sev']) and $_GET['sev']==1)
$orderby="p.id ASC,";
else
if(isset($_GET['sev']) and $_GET['sev']==2)
$orderby="pt.naslov ASC,";
else
if(isset($_GET['sev']) and $_GET['sev']==3)
$orderby="pt.naslov DESC,";
else
if(isset($_GET['sev']) and $_GET['sev']==4)
$orderby="p.cena ASC,";
else
if(isset($_GET['sev']) and $_GET['sev']==5)
$orderby="p.cena DESC,";
else
$orderby="";
//$mlista .="</select></div></div>";
/*$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide$iFilter1
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 $inner_plus1 $iFilter GROUP BY p.id HAVING count(pf.id_filt)=".count($filtNiz)." ORDER BY $orderby p.pozicija ASC, p.id  DESC LIMIT $str,$ByPage1");*/

$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 AND p.prodato=0 AND p.lager=1 $koniPlus $inner_plus1 $ibrendis GROUP BY p.id    ORDER BY $orderby p.pozicija ASC, p.id  DESC LIMIT $str,$ByPage1");
$mlista .='<div class="shop-product-wrap grid row">';
while($az1=mysqli_fetch_array($az))
{
$brend1=$brendd[$az1['brend']];

if($az1['lager']==1) {
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
$ispis="Dodaj u korpu";
}
else {
$ukorpu="";
$ispis="Nije dostupno";
}
if ($az1['altslike']!="") $al=$az1['altslike']; else $al=$az1['naslov'];
if ($az1['titleslike']!="") $ti=$az1['titleslike']; else $ti=$az1['naslov'];

$mlista .='				<div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="product-item mb-30">
                                <div class="product-thumb">
                                    <a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'-'.$az1['ide'].'/" title="'.$az1['naslov'].'">
';
if($az1['slika']!="") $psrc=$patH.SUBFOLDER.GALFOLDER."/thumb/".$az1['slika']; else $psrc=$patH."/img/no-product-image.png";
$mlista .='
                                        <img class="pri-img w-100" src="'.$psrc.'" alt="'.$al.'" title="'.$ti.'">
';
if($az1['slika1']!="")
$mlista .='<img class="sec-img w-100" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">
';
else $mlista .="";
$mlista .='									</a>
';
$vegan="";
if($az1['vegan']==1) $vegan="<i class='dostava fa bn-dostava1 fa-3x'></i>"; else $vegan="";
//if($az1['naslovna']==1) $naslovna="<i class='far fa-thumbs-up favorit'></i>"; else $naslovna="";
//if($az1['izdvojeni']==1) $najporodavaniji="<i class='fa am-best-seller najprodavaniji'></i>"; else $najporodavaniji="";
$mlista .='
'.$vegan.'
                                        <div class="box-label">
';
if($az1['novo']==1) $novopolovno="<span>".$arrwords['nekorisceno']."</span>" and $klnovo=""; else $novopolovno="<span>".$arrwords['polovno']."</span>" and $klnovo=" kori";
$mlista .='
                                            <div class="label-product label_new'.$klnovo.'">
                                              '.$novopolovno.'
                                            </div>
											<div class="label-product label_sale">
';
if($az1['cena']<$az1['cena1'] and $az1['akcija_obicna']==1) {
$proc=100*$az1['cena']/$az1['cena1'];
$procenat=-(100-round($proc))."%";
} else
$procenat="";
$mlista .='
											<span>'.$procenat.'</span>
											</div>';
if($az1['naslovna']==1) { $mlista .='
												<div class="icc">
													<span><i class="far fa-thumbs-up"></i></span>
												</div>';
} else $mlista .='';
$mlista .='                            <div class="action-links">
                                        <ul>
											<li><a title="Brzi pregled" data-toggle = "modal" data-target="#quick-view'.$az1["ide"].'" href="javascript:;"><i class="fal fa-eye"></i></a></li>
                                            <li><a title="Dodaj u listu želja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i></a></li>
                                            <li id="up'.$az1["ide"].'"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('.$az1["ide"].')"><i class="fal fa-balance-scale"></i></a></li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="product-caption">
';
if($brend1['naziv']!="") $mlista .='
								<div class="manufacture-product">
                                    <p>'.$brend1['naziv'].'</p>
                                </div>
';
else $mlista .='';
$mlista .='

                                    <div class="product-name">
<a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'-'.$az1['ide'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a>
									</div>
                                    <div class="ratings">';
$ocena=0;
if(mb_eregi("-",$az1['ocena'])) {
$oce=explode("-",$az1['ocena']);
$ocena=round($oce[0]/$oce[1]);
}
$ocena1=5-$ocena;
                                    for($r=1; $r<=$ocena; $r++) {
                                        $mlista .='<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									$mlista .='<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
                                    $mlista .='</div>
									<div class="price-box">
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
$mlista .='
<span class="regular-price">Cena: <span class="special-price">'.number_format($pcena,$decim,",",".").' '.$vta.'</span></span>
<span class="old-price"><del>'.number_format($pcena1,$decim,",",".").' </del>'.$vta.'</span>
';
else
$mlista .='
<span class="regular-price">Cena: '.number_format($pcena,$decim,",",".").' <span'.$um.'>'.$vta.'</span></span>
';
}
$mlista .='
									</div>
									<span class="btn-cart"><a href="javascript:;" '.$ukorpu.' title="Dodaj u korpu">'.$ispis.'</a></span>
                                </div>
                            </div>
                            
                            <!--=======  End of grid view product  =======-->

                            <!--=======  List view product  =======-->
                            
                            <div class="sinrato-list-item mb-30">
                                <div class="sinrato-thumb">
                                    <a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'-'.$az1['ide'].'/" title="'.$az1['naslov'].'">
';
if($az1['slika']!="") $psrc=$patH.SUBFOLDER.GALFOLDER."/thumb/".$az1['slika'] and $priimg=" pri-img"; else $psrc=$patH."/img/no-product-image.png" and $priimg="";
$mlista .='
                                        <img class="w-100  img-fluid'.$priimg.'" src="'.$psrc.'" alt="'.$al.'" title="'.$ti.'">
';
if($az1['slika1']!="")
$mlista .='<img class="sec-img w-100 img-fluid" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">
';
else $mlista .="";
$mlista .='									</a>
                                        <div class="box-label">
';
if($az1['novo']==1) $novopolovno="<span>".$arrwords['nekorisceno']."</span>" and $klnovo=""; else $novopolovno="<span>".$arrwords['polovno']."</span>" and $klnovo=" kori";
$mlista .='
                                            <div class="label-product label_new'.$klnovo.'">
                                                '.$novopolovno.'
                                            </div>
';
if($az1['cena1']>0 and $az1['akcija_obicna']==1) {
$proc=100*$az1['cena']/$az1['cena1'];
$procenat=-(100-round($proc))."%";
} else
$procenat="";
$mlista .='
                                            <div class="label-product label_sale">
                                                <span>'.$procenat.'</span>
                                            </div>
                                        </div>
								'.$naslovna.$najporodavaniji.$lagers.'
                                </div>

                                <div class="sinrato-list-item-content">
';
if($brend1['naziv']!="") $mlista .='
								<div class="manufacture-product">
                                    <span>'.$brend1['naziv'].'</span>
                                </div>
';
else $mlista .='';
$mlista .='
									<div class="sinrato-product-name">
										<h4 class="product-title"><a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'-'.$az1['ide'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a></h4>
										<p>'.$az1['marka'].'</p>
									</div>
                                    <div class="ratings mb-15">';
									for($r=1; $r<=$ocena; $r++) {
                                        $mlista .='<span class="yellow"><i class="fal fa-star"></i></span>';
                                        }
									for($q=1; $q<=$ocena1; $q++) {
									$mlista .='<span class="sivo"><i class="fal fa-star"></i></span>';	
									}
                                    $mlista .='</div>
									<div class="sinrato-product-des">
										<p class="short-desc">'.substr(sanitize_from_word(strip_tags($az1['opis'])),0,200).'...</p>
									</div>
								</div>

                                    <div class="sinrato-box-action">
                                        <div class="price-box">
';
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija_obicna']==1)
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena1'],2,",",".").'</span><br>
<span class="main-price discounted">Cena: '.number_format($az1['cena'],2,",",".").'</span></p>';
else
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena'],2,",",".").'</span></p>';
}

$mlista .='								</div>
										<span class="btn-cart"><a href="javascript:;" '.$ukorpu.' title="Dodaj u korpu">'.$ispis.'</a></span>
                                        <div class="action-links sinrat-list-icon">
											<a title="Brzi pregled" data-toggle = "modal" data-target="#quick-view'.$az1["ide"].'" href="javascript:;"><i class="fal fa-eye"></i></a>
                                            <a title="Dodaj u listu želja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i></a>
											<span id="up'.$az1["ide"].'"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('.$az1["ide"].')"><i class="fal fa-balance-scale"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
';
include ('quick-view.php');
}
$mlista .='</div>';
?>

<?php 
if($br_upisa>$ByPage1)
{ $ii=$i+1;
if(isset($_POST['uris'])) {
$koren=explode("#",$_POST['uris']);
$zapagin=$koren[0];
} else $zapagin=curPageURL();
$do=$str+$ByPage1;
if($do>$br_upisa) $do=$br_upisa;
$mlista .=' <div class="paginatoin-area style-2 pt-35">
				<div class="row">
					<div class="col-sm-6">
						<div class="pagination-area">
                            Prikazano '.($str + 1).' do '.($do).' od ukupno '.$br_upisa.' proizvoda (strana '.$ipes.'/'.$cce.')
						</div>
					</div>
					<div class="col-sm-6">
						<ul class="pagination-box pagination-style-2">';

if($ipe>1) {
            $ss=$ipe-1;
							$mlista .='<li><a href="'.$zapagin.'#'.hashlink($ss,$hashAP,$ii,"p").'" class="cho" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">&laquo;</a></li>';
              }
            for($s=0; $s<$cce; $s++)
            {              $ss=$s+1;
      if($ipe==$ss or ($ipe==0 and $ss==1)) 
      $active="class='active'"; else $active='';
							$mlista .='<li '.$active.'><a href="'.$zapagin.'#'.hashlink($ss,$hashAP,$ii,"p").'" class="cho" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">'.$ss.'</a></li>';
						}							
if($ipe<$cce) {
            if(empty($ipe)) $ipe=1;
            $ss=$ipe+1;
							$mlista .='<li><a href="'.$zapagin.'/#'.hashlink($ss,$hashAP,$ii,"p").'" class="cho" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">&raquo;</a></li>';
              }
$mlista .='				</ul>
					</div>
				</div>
            </div>';
}
?>     