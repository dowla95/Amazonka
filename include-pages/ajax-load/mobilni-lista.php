<?php 
if(isset($_COOKIE['valuta']))
$idvalute=""; else
$idvalute=1;
$valke=$_GET['va']?$_GET['va']:$idvalute;
$mlista="";
$inner_plus1=$inner_plus2=""; 

if(!mb_eregi('brend',$_POST['hashe']) and !mb_eregi('filt1',$_POST['hashe']) and !mb_eregi('filt2',$_POST['hashe']) and !mb_eregi('filt3',$_POST['hashe'])) {
$inner_plus1=" AND p.izdvojeni=1";
}

if($hashA && count($hashA)==0) 
$inner_plus1=" AND p.izdvojeni=1";
if($hashA['filt1']!="")
{
$na=explode("-",$hashA['filt1']);
if(in_array(1,$na) and in_array(2,$na))
$inner_plus1 .=" AND (p.akcija=1 OR  p.novo=1)";
else
{
if(in_array(1,$na))
$inner_plus1 .=" AND p.akcija=1";
if(in_array(2,$na))
$inner_plus1 .=" AND p.novo=1";
}
}
if($hashA['brend']!="")
{
$inner_plus1 .=" AND brend IN(".str_replace("-",",",$hashA['brend']).")";
}
if($hashA['price']!="")
{
$ecena=explode("-",$hashA['price']);
$cena1=$ecena[0]*1;
$cena2=$ecena[1]*1;
if($valke>0)
{
$cena1=($cena1/EVRO);
$cena2=($cena2/EVRO);
}
$inner_plus1 .=" AND cena BETWEEN $cena1 AND $cena2";
}
unset($hashA['brend']);
unset($hashA['p']);
unset($hashA['price']);
unset($hashA['filt1']);
if(isset($hashA) and count($hashA)>0)
{
$s=1;
foreach($hashA as $key => $value)
{ 
$suh=explode("-",$value);
$inner_plus .="INNER JOIN pro_filt pf$s ON p.id = pf$s.id_pro AND  pf$s.id_filt IN (".implode(",",$suh).")";
$s++; 
}
}

if(!isset($hashAP['p'])) $ipe=0; else $ipe=$hashAP['p'];  
$ByPage1=12;
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus       
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 $inner_plus1 GROUP BY time DESC"));
$cce=ceil($br_upisa/$ByPage1);
if($ipe>0) $ipes=$ipe; else $ipes=1;
$str = ($ipes-1)*$ByPage1;

$sort_arr=array("Najnoviji", "Najstariji","Naziv (A-Z)","Naziv (Z-A)","Cena (Rastuće)","Cena (Opadajuće)");

if($ztz1['slika']!="") echo "
                    <div class='shop-banner mb-30'>
                        <img class='img-fluid w-100' src='".$patH.SUBFOLDER.GALFOLDER."/".$ztz1['slika']."' alt='".$al."' title='".$ti."'>
                    </div>
"; else echo "";

$mlista .='
                    <div class="shop-header mb-30">
                        <div class="shop-header__left">
                            <div class="grid-icons mr-20">
                                <button data-target="grid three-column" data-tippy="3" data-tippy-inertia="true" data-tippy-animation="fade" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme = "sharpborder" class="active three-column"></button>
                                <button data-target="grid four-column" data-tippy="4" data-tippy-inertia="true" data-tippy-animation="fade" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme = "sharpborder"  class="four-column d-none d-lg-block"></button>
                                <button data-target="list" data-tippy="List" data-tippy-inertia="true" data-tippy-animation="fade" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme = "sharpborder"  class="list-view"></button>
                            </div>
<!--
                            <div class="shop-header__left__message">
                                Showing 1 to 9 of 15 (2 Pages)
                            </div>
-->
                        </div>

                        <div class="shop-header__right">
<!--
                            <div class="single-select-block d-inline-block mr-50 mr-lg-10 mr-md-10 mr-sm-10">
                                <span class="select-title">Show:</span>
                                <select>
                                    <option value="1">10</option>
                                    <option value="2">20</option>
                                    <option value="3">30</option>
                                    <option value="4">40</option>
                                </select>
                            </div>
-->
                            <div class="single-select-block d-inline-block">
                                <span class="select-title">Sortiranje:</span>
                                <select class="sev" rel="oprema-load.php">
';
foreach($sort_arr as $k => $v) {
if(isset($_GET['sev']) and $_GET['sev']==$k) $sele=" selected"; else $sele="";
$mlista .="<option value='$k'$sele>$v</option>";
}
$mlista .='                    </select>
                            </div>
                        </div>
                    </div>
';


if(isset($_GET['sev']) and $_GET['sev']==1)
$orderby="p.id ASC";
else
if(isset($_GET['sev']) and $_GET['sev']==2)
$orderby="pt.naslov ASC";
else
if(isset($_GET['sev']) and $_GET['sev']==3)
$orderby="pt.naslov DESC";
else
if(isset($_GET['sev']) and $_GET['sev']==4)
$orderby="p.cena ASC";
else
if(isset($_GET['sev']) and $_GET['sev']==5)
$orderby="p.cena DESC";
else
$orderby="p.id DESC";
$mlista .="</select></div></div>";
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus       
        WHERE pt.lang='$lang' AND p.akt=1 AND p.tip=5 $inner_plus1 GROUP BY p.id ORDER BY  $orderby  LIMIT $str,$ByPage1");

$mlista .='<div class="row shop-product-wrap grid three-column mb-10">';

while($az1=mysqli_fetch_array($az))
{
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$az1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
if($az1['lager']==1)
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
if ($az1['altslike']!="") $al=$az1['altslike']; else $al=$az1['naslov'];
if ($az1['titleslike']!="") $ti=$az1['titleslike']; else $ti=$az1['naslov'];

$mlista .='				<div class="col-12 col-lg-4 col-md-6 col-sm-6 mb-20">
                            <div class="single-slider-product grid-view-product">
                                <div class="single-slider-product__image">
                                    <a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">
                                        <img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika'].'" alt="'.$al.'" title="'.$ti.'">
';
if($az1['slika1']!="") $mlista .='<img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">';
$naslovna=$najporodavaniji=$akcija=$novo=$lagers="";
if($az1['novo']==1) $novo="<i class='fa am-novo novo'></i>"; else $novo="";
if($az1['akcija']==1 and $az1['cena1']>0) $akcija="<i class='fa am-procenat akcija'></i>"; else $akcija="";
if($az1['naslovna']==1) $naslovna="<i class='far fa-thumbs-up favorit'></i>"; else $naslovna="";
if($az1['izdvojeni']==1) $najporodavaniji="<i class='fa am-best-seller najprodavaniji'></i>"; else $najporodavaniji="";
if($az1['lager']==0) $lagers="<i class='fa am-out-of-stock lager'></i>" and $naslovna=$najporodavaniji=$akcija=$novo=""; else $lagers="";
$mlista .='
									'.$naslovna.$najporodavaniji.$akcija.$novo.$lagers.'
									</a>
                                    <div class="hover-icons">
                                        <ul>
                                            <li><a title="Detalji proizvoda" href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'"><i class="fal fa-eye"></i></a></li>
                                            <li><a title="Dodaj u listu želja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i></a></li>
                                            <li id="up'.$az1["ide"].'"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('.$az1["ide"].')"><i class="fal fa-balance-scale"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="single-slider-product__content">
                                    <p class="product-title">
									<a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a>
									</p>
';
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija']==1)
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena1'],2,",",".").'</span><br>
<span class="main-price discounted">Cena: '.number_format($az1['cena'],2,",",".").'</span></p>';
else
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena'],2,",",".").'</span></p>';
}
$mlista .='
                                    <span class="cart-icon"><a href="javascript:;"'.$ukorpu.' title="'.@count($hashAA).'"><i class="far fa-shopping-cart"></i></a></span>
									
                                </div>
                            </div>
                            
                            <!--=======  End of grid view product  =======-->

                            <!--=======  List view product  =======-->
                            
                            <div class="single-slider-product single-slider-product--list-view list-view-product">
                                <div class="single-slider-product__image single-slider-product--list-view__image">
                                    <a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">
                                        <img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika'].'" alt="'.$al.'" title="'.$ti.'">
';
if($az1['slika1']!="") $mlista .='<img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">';
$mlista .='</a>
								'.$naslovna.$najporodavaniji.$akcija.$novo.$lagers.'
                                </div>

                                <div class="single-slider-product__content  single-slider-product--list-view__content">
                                    <div class="single-slider-product--list-view__content__details">
                                        <h2 class="product-title"><a href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'">'.$az1['naslov'].'</a></h2>
										<p>'.$az1['marka'].'</p>
                                        <p class="short-desc">'.substr(strip_tags($az1['opis']),0,200).'...</p>
                                    </div>
';
if($az1['lager']==0) $lager="Nema na lageru."; else $lager="DA";
$mlista .='
                                    <div class="single-slider-product--list-view__content__actions">
                                        <div class="availability mb-10">
                                            <span class="availability-title">Dostupno: </span>
                                            <span class="availability-value">'.$lager.'</span>
                                        </div>
';


if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija']==1)
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena1'],2,",",".").'</span><br>
<span class="main-price discounted">Cena: '.number_format($az1['cena'],2,",",".").'</span></p>';
else
$mlista .='<p class="product-price">Cena: <span class="discounted-price">'.number_format($az1['cena'],2,",",".").'</span></p>';
}



$mlista .='
                                        <a href="javascript:;" class="theme-button list-cart-button mb-10" '.$ukorpu.' title="'.@count($hashAA).'"><i class="far fa-shopping-cart"></i> U korpu</a>
                                        <div class="hover-icons">
                                            <ul>
                                                <li><a title="Detalji proizvoda" href="'.$patH1.'/'.$all_links[3].'/'.$az1['ulink'].'/" title="'.$az1['naslov'].'"><i class="fal fa-eye"></i></a></li>
                                                <li><a title="Dodaj u listu želja" href="'.$patH.'/include/ulistu-zelja.php?pro='.$az1['ide'].'"><i class="far fa-heart"></i></a></li>
												<li id="up'.$az1["ide"].'"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('.$az1["ide"].')"><i class="fal fa-balance-scale"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
';
}
$mlista .='</div>';
?>



<?php 
if($br_upisa>$ByPage1)
{ $ii=$i+1;


$mlista .='
                    <div class="pagination-section mb-md-30 mb-sm-30">
                        <ul class="pagination">
';
if($ipe>1) {
$ss=$ipe-1;
$mlista .='<li><a href="'.$patH1.'/'.$all_links[3].'/#'.hashlink($ss,$hashAP,$ii,"p").'" class="ch" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">&laquo;</a></li>';
}
for($s=0; $s<$cce; $s++)
{
$ss=$s+1;
if($ipe==$ss or ($ipe==0 and $ss==1)) 
$active="class='active'"; else $active='';

$mlista .='<li '.$active.'><a href="'.$patH1.'/'.$all_links[3].'/#'.hashlink($ss,$hashAP,$ii,"p").'" class="ch" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">'.$ss.'</a></li>';

}							
if($ipe<$cce)
{
if(empty($ipe)) $ipe=1;
$ss=$ipe+1;

$mlista .='<li><a href="'.$patH1.'/'.$all_links[3].'/#'.hashlink($ss,$hashAP,$ii,"p").'" class="ch" rel="#'.hashlink($ss,$hashAP,$ii,"p").'">&raquo;</a></li>';
}
}
$mlista .='
                        </ul>

                        <div class="pagination-text">
                            Prikazano 1 to 9 of 15 (2 Pages)
                        </div>
                    </div>
';















           