<?php if($settingsc['poz_novi']!="") $pozboja=" style='background:".$settingsc['poz_novi']."'"; else $pozboja="";if($settingsc['limit_novi_proizvodi']<1) $lim="LIMIT 7"; else $lim="LIMIT ".$settingsc['limit_novi_proizvodi'];?>    <div class="brand-area pb-70"<?php echo $pozboja?>>        <div class="container-fluid">            <div class="row">                <div class="col-12">                    <div class="section-title">                        <h3><?php echo $arrwords['karakteristika2']?></h3>                    </div>                </div>                <div class="col-12">                    <div class="tab-content">                        <div class="tab-pane fade show active" id="brand-one">                            <div class="product-gallary-wrapper">                                <div class="product-gallary-active owl-carousel owl-arrow-style sale-nav"><?php $ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide        FROM pro p        INNER JOIN prol pt ON p.id = pt.id_text        WHERE pt.lang='$lang' AND p.akt=1 AND p.novo=1 AND p.prodato=0 AND lager=1 ORDER BY p.pozicija, rand() $lim");//echo mysqli_num_rows ($atz);while($atz1=mysqli_fetch_array($ztz)) {$a1 = mysqli_query($conn, "SELECT brend FROM pro WHERE id=$atz1[id]");$a2=mysqli_fetch_array($a1);$a3 = mysqli_query($conn, "SELECT naziv FROM stavkel WHERE id_page=$a2[brend]");$a4=mysqli_fetch_array($a3); if($atz1['kategorija']>0) { $sta = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide        FROM stavke p        INNER JOIN stavkel pt ON p.id = pt.id_page        WHERE pt.lang='$lang' AND p.id=$atz1[kategorija]");  $sta1=mysqli_fetch_array($sta);  $mlink=$all_links[3];  $plusi=$sta1['ulink']."/"; } else {  $mlink=$all_links[2];  $plusi=""; } ?>                                    <div class="product-item">                                        <div class="product-thumb">										                                            <a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $atz1['ulink']?>-<?php echo $atz1['ide']?>/"  title="<?php echo $atz1['naslov']?>">											<?php if($atz1['slika']!="") { ?>												<img class="pri-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika']?>" title="<?php echo $atz1['titleslike']?>" alt="<?php echo $atz1['altslike']?>">												<?php } else { ?>												<img class="pri-img" src="<?php echo $patH?>/img/no-product-image.png" title="<?php echo $atz1['titleslike']?>" alt="<?php echo $atz1['altslike']?>">											<?php } if($atz1['slika1']!="") { ?>												<img class="sec-img" src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $atz1['slika1']?>" title="<?php echo $atz1['titleslike']?>" alt="<?php echo $atz1['altslike']?>">											<?php } ?>                                            </a>                                            <div class="box-label"><?php if($atz1['novo']==1) { ?>												<div class="label-product label_new">                                                <span>novo</span>                                                </div><?php } ?>                                                <div class="label-product label_sale"><?phpif($atz1['cena']<$atz1['cena1']) {$proc=100*$atz1['cena']/$atz1['cena1'];$procenat=-(100-round($proc))."%";} else$procenat="";?>                                                    <span><?php echo $procenat?></span>                                                </div><?php if($atz1['naslovna']==1) { ?>												<div class="icc">													<span><i class="far fa-thumbs-up"></i></span>												</div><?php } ?>                                            </div>                                            <div class="action-links">                                            <ul>                                            <li><a title="Dodaj u listu želja" href="<?php echo $patH?>/include/ulistu-zelja.php?pro=<?php echo $atz1['ide']?>"><i class="far fa-heart"></i></a></li>                                            <li id="up<?php echo $atz1['ide']?>"><a title="Uporedi proizvode" href="javascript:;" onclick="uporedi('<?php echo $atz1["ide"]?>')"><i class="fal fa-balance-scale"></i></a></li>                                            </ul>                                            </div>                                        </div>                                        <div class="product-caption">											<div class="manufacture-product">												<p><?php echo $a4['naziv']?></p>											</div>                                            <div class="product-name">												<h4><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $plusi?><?php echo $atz1['ulink']?>-<?php echo $atz1['ide']?>/" title="<?php echo $atz1['naslov']?>"><?php echo $atz1['naslov']?></a></h4>                                            </div>                                            <div class="ratings"><?php$ocena=0;if(mb_eregi("-",$atz1['ocena'])) {$oce=explode("-",$atz1['ocena']);$ocena=round($oce[0]/$oce[1]);}$ocena1=5-$ocena;                                    for($r=1; $r<=$ocena; $r++) {                                        echo'<span class="yellow"><i class="fal fa-star"></i></span>';                                        }									for($q=1; $q<=$ocena1; $q++) {									echo'<span class="sivo"><i class="fal fa-star"></i></span>';										}?>                                            </div>                                            <div class="price-box"><?phpif($atz1['uvaluti']==1) {$pcena=$atz1['cena']/$settings['kurs_evra'];$pcena1=$atz1['cena1']/$settings['kurs_evra'];$decim="2";$vta="&euro;";$um="";}else {$pcena=$atz1['cena'];$pcena1=$atz1['cena1'];$decim="0";$vta="RSD";$um=" class='um'";}if($atz1['cena']!=0) {if($atz1['cena1']>0)echo "<span class='regular-price'><span class='special-price'>Cena: ".number_format($pcena,$decim,",",".")."<span".$um."> ".$vta."</span></span></span><span class='old-price'><del>".number_format($pcena1,$decim,",",".")."<span".$um."> ".$vta."</span></del></span>";elseecho "<span class='regular-price'>Cena: ".number_format($pcena,$decim,",",".")." <span".$um."> ".$vta."</span></span>";if($atz1['lager']==1) {$ukorpu="onclick=\"displaySubs($atz1[id],'yes')\"";$ispis="Dodaj u korpu";}else {$ukorpu="";$ispis="Nije dostupno";}}?>                                            </div>											<a class="btn-cart" href="javascript:;" <?php echo $ukorpu?> title="Dodaj u korpu"><?php echo $ispis?></a>                                        </div>                                    </div> <!-- end single item -->	<?php } ?>                                </div>                            </div>                        </div>                    </div>                </div>            </div>        </div>    </div>