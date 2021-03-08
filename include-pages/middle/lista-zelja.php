    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Lista želja</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="home-module-three hm-1 fix pb-40 pt-20">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-20">
                            <h3>Vaša <span>lista želja</span></h3>
                        </div>
                    </div>
                </div>

<div id="load-lista">						
						
						<div class="product-double-row-slider-wrapper">
                            <div class="module-four-wrapper custom-seven-column">
<!-- pocetak petlje -->
<?php 

$slik=mysqli_query($conn, "SELECT sl.slika, lk.keywords
        FROM page sl
        INNER JOIN pagel lk ON sl.id = lk.id_page
        WHERE sl.id=14 AND sl.akt=1");
$slik1=mysqli_fetch_assoc($slik);
if($slik1['slika']!="") {
if($slik1['keywords']!="") $linksl="<a href='".$slik1['keywords']."'>" and $nolinksl="</a>"; else $linksl="" and $nolinksl="";
echo '
                        <div class="col col-2 mb-30">
                            <div class="product-item">
                                <div class="product-thumb">
								'.$linksl.'
                                    <img src="'.$patH1.'/'.GALFOLDER.'/thumb/'.$slik1["slika"].' " alt="">
								'.$nolinksl.'
                                </div>
                            </div>
                        </div>
';
}

if(isset($_COOKIE['valuta']))
$idvalute=""; else $idvalute=1;
$mlista="";
if((isset($_COOKIE['soglasi']) and $_COOKIE['soglasi']!=""))
{
$impar=$_COOKIE['soglasi'];
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1  AND p.id IN($impar) GROUP BY p.id"); 
while($az1=mysqli_fetch_array($az))
{
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$az1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
if($az1['lager']==1)
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
else
$ukorpu="onclick=\"alert('Ovaj proizvod trenutno nemamo na lageru, molimo da proverite mogućnost naručivanja ili se opredelite za drugi')\"";
if ($az1['altslike']!="") $alt=$az1['altslike']; else $alt=$az1['naslov'];
if ($az1['titleslike']!="") $tit=$az1['titleslike']; else $tit=$az1['naslov'];
?>
                                <div class="col mb-30">
                                    <div class="product-item">
                                        <div class="product-thumb">
                                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/" title="<?php echo $az1['naslov']?>">
<img class="pri-img" src="<?php echo $patH.SUBFOLDER.GALFOLDER?>/thumb/<?php echo $az1['slika']?>" alt="<?php echo $alt?>" title="<?php echo $tit?>">
<?php if($az1['slika1']!="") { ?>
<img class="sec-img" src="<?php echo $patH.SUBFOLDER.GALFOLDER?>/thumb/<?php echo $az1['slika1']?>" alt="<?php echo $alt?>" title="<?php echo $tit?>">
<?php 
}
$naslovna=$najporodavaniji=$akcija=$novo=$lagers="";
//if($az1['novo']==1) $novo="<i class='fa am-novo novo'></i>"; else $novo="";
//if($az1['vegan']==1) $vegan="<i class='fa am-vegan3 vegan'></i>"; else $vegan="";
//if($az1['akcija']==1 and $az1['cena1']>0) $akcija="<i class='fa am-akcija akcija'></i>"; else $akcija="";
//if($az1['naslovna']==1) $naslovna="<i class='far fa-thumbs-up favorit'></i>"; else $naslovna="";
//if($az1['izdvojeni']==1) echo $najporodavaniji="<i class='fa am-best-seller najprodavaniji'></i>"; else $najporodavaniji="";
//if($az1['lager']==0) $lagers="<i class='fa am-out-of-stock lager'></i>" and $naslovna=$najporodavaniji=$akcija=$novo=""; else $lagers="";
//echo $novo.$najporodavaniji.$akcija.$naslovna.$lagers.$vegan;
if($az1['lager']==1) {
$ukorpu="onclick=\"displaySubs($az1[id],'yes')\"";
$ispis="Dodaj u korpu";
}
else {
$ukorpu="";
$ispis="Nije dostupno";
}
?>
                                            </a>
											<div class="box-label">
<?php if($az1['novo']==1) { ?>
												<div class="label-product label_new">
													<span>NOVO</span>
												</div>
<?php
}
if($az1['cena1']>0 and $az1['akcija_obicna']==1) {
$proc=100*$az1['cena']/$az1['cena1'];
$procenat=-(100-round($proc))."%";
echo '<div class="label-product label_sale"><span>'.$procenat.'</span></div>';
}
?>
											</div>

                                            <div class="action-links">
                                                <ul>
<li><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/" title="<?php echo $az1['naslov']?>"><i class="fal fa-eye"></i></a></li>
<li id="up<?php echo $az1['ide']?>"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('<?php echo $az1["ide"]?>')"><i class="fal fa-balance-scale"></i></a></li>
<li><a href="<?php echo $patH?>/include/ulistu-zelja-del.php?pro=<?php echo $az1['ide']?>" title="Izbaci iz liste"><i class="fa am-slomljeno-srce"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="product-caption">
											<div class="product-name mb-5">
                                            <p class="product-title"><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $az1['ulink']?>-<?php echo $az1['id']?>/" title="<?php echo $az1['naslov']?>"><?php echo $az1['naslov']?></a></p>
											</div>
										<div class="price-box">
<?php 
if($az1['cena']!=0) {
if($az1['cena1']>0 and $az1['akcija_obicna']==1)
echo "<span class='regular-price'>Cena: <span class='special-price'>".number_format($az1['cena'],0,",",".")."</span></span>
<span class='old-price'><del>".number_format($az1['cena1'],0,",",".")."</del></span>";
else
echo "<span class='regular-price'>Cena: ".number_format($az1['cena'],0,",",".")."</span>";
}
?>
										</div>
										<a class="btn-cart b3" href="javascript:;" <?php echo $ukorpu?> title="Dodaj u korpu"><?php echo $ispis?></a>
                                        </div>
                                    </div>
                                </div>
<?php 
}
}
?>
<!-- kraj petlje -->
							</div>
                            </div>
                        </div>
            </div>
        </div>