<?phpif($settingsb['poz_tekstova']!=""){$pzb=explode(",",$settingsb['poz_tekstova']);$pozboja=" style='background:".$pzb[$ff]."'";}else $pozboja="";?><div class="container-fluid"<?php echo $pozboja?>><div class="row mb-20"><?php $ff=0;$delay=-200;$pte = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id        FROM pages_text p        INNER JOIN pages_text_lang pt ON p.id = pt.id_text                WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY p.pozicija ASC");$ptenum=mysqli_num_rows($pte);while($pte1=mysqli_fetch_assoc($pte)){if($pte1['trecina']==1) {$trec="col-lg-4 col-md-4 mt-90 mb-20";$zatrec="<div class='trecinabox' data-aos='fade-up' data-aos-duration='800' data-aos-delay='".$delay."'>";$zatrec1="</div>";}else {$trec="col-12";$zatrec="";$zatrec1="";}?>	<div class="<?php echo $trec?>"><?phpecho $zatrec;if($pte1['full_img_width']==0) $ord1="2" and $ord2="1"; else $ord1="order-lg-1" and $ord2="order-lg-2";if($pte1['slika']!="" or $pte1['pretraga_link']!="") {if($pte1['polapola']==1) {$siri="6"; $nep=""; $pola="6";}else {$siri="7"; $nep=""; $pola="5";}}else $siri="12" and $nep=" d-none";if($pte1['trecina']==1) {$siri="12"; $nep=""; $nep1=" d-none"; $pola="12"; $ord1=""; $ord2="";}?>                                <div class="single-blog-post gallery-type-post">                                    <div class="row align-items-center">                                        <div class="col-lg-<?php echo $pola?> order-1 <?php echo $ord2.$nep?>">                                            <div class="single-blog-post-media mb-sm-20"><?php if($pte1['pretraga_link']!="" and $pte1['mini_slider']==0) {echo '<div class="video embed-responsive embed-responsive-16by9">';echo $pte1['pretraga_link'];echo '</div>';}elseif($pte1['mini_slider']==1) {echo '<div class="blog-thumb-active owl-carousel">';if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]")){?><div class="blog-thumb blog--hover"><img src="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" /></div><?php }$pp = mysqli_query($conn, "SELECT p.*, pt.*        FROM slike p        INNER JOIN slike_lang pt ON p.id = pt.id_slike                WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pte1[id_text] ORDER BY -p.pozicija DESC");while($izg1=mysqli_fetch_assoc($pp)){echo '<div class="blog-thumb">';echo '<img class="img-fluid" src="'.$patH.SUBFOLDER.GALFOLDER.'/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'">';echo '</div>';}echo '</div>';}else {if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]")) {?><div class="pro-large-img"><img src="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" class="img-fluid w-100" /><div class="img-view"><a class="img-popup" href="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" class="w-100"><i class="fa fa-search"></i></a></div></div><?php }}?>                                            </div>                                        </div>                                        <div class="col-lg-<?php echo $siri?> order-2 <?php echo $ord1?>">                                            <div class="single-blog-post-content">											<?php if($page1['h1']!="") echo ""; else echo '<h2 class="post-title">'.$pte1["naslov"].'</h2>'; ?>                                                <?php echo $pte1["opis"]?><?php read_files("idupisa",$pte1['id'],$page1['id'],$patH,$page_path2,0);if($pte1['video']!="") { ?><video id="volume" controls>	<source src="<?php echo $patH1?>/video-fajlovi/<?php echo $pte1['video']?>" /></video><script>document.getElementById("volume").volume = 0.5;</script> <?php }if($pte1['keywords']!="") { ?><button class="theme-button product-cart-button2 mt-20 float-right" onclick="window.location.href='<?php echo $pte1['keywords']?>'"><?php echo $arrwords['pogledaj']?> <i class="fal fa-arrow-alt-right"></i></button><?php } ?>                                            </div>                                        </div>                                    </div>                                </div><?php if($pte1['pretraga_link']!="" and $pte1['mini_slider']==0) { ?><!-- Izlistavanje galerije slika kada ima video zapisa odavde -->							<div class="mbt-100 mt-30<?php echo $nep1?>">								<div class="row"><?php if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]")){?><!-- Ovo je glavna slika kada ima video ubacen --><div class="mt-10 col-12 col-lg-2 col-md-3 col-sm-6"><div class="galerija pro-large-img"><img src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" /><div class="img-view"><a class="img-popup" href="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>"><i class="fa fa-search"></i></a></div></div></div><?php }$pp = mysqli_query($conn, "SELECT p.*, pt.*        FROM slike p        INNER JOIN slike_lang pt ON p.id = pt.id_slike                WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pte1[id_text] ORDER BY -p.pozicija DESC");while($izg1=mysqli_fetch_assoc($pp)){echo '<div class="mt-10 col-12 col-lg-2 col-md-3 col-sm-6 mbt-100">';echo '<div class="galerija pro-large-img"><img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'"><div class="img-view"><a class="img-popup" href="'.$patH.SUBFOLDER.GALFOLDER.'/'.$izg1['slika'].'" title="'.$izg1['title'].'"><i class="fa fa-search"></i></a></div></div></div>';}?>							</div>						</div><!-- Izlistavanje galerije slika kada ima video zapisa dovde --><?php }elseif($pte1['mini_slider']==0) {$pp = mysqli_query($conn, "SELECT p.*, pt.*        FROM slike p        INNER JOIN slike_lang pt ON p.id = pt.id_slike                WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pte1[id_text] ORDER BY -p.pozicija DESC");if(mysqli_num_rows($pp)>0) {?>						<div class="col-12 mt-30<?php echo $nep1?>">							<div class="row"><?php while($izg1=mysqli_fetch_assoc($pp)){echo '<div class="mt-10 col-12 col-lg-2 col-md-3 col-sm-6 mbt-100">';echo '<div class="galerija"><div class="pro-large-img"><img class="img-fluid" src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'"><div class="img-view"><a class="img-popup" href="'.$patH.SUBFOLDER.GALFOLDER.'/'.$izg1['slika'].'" title="'.$izg1['title'].'"><i class="fa fa-search"></i></a>';echo '</div>';echo '</div>';echo '</div>';echo '</div>';}?>							</div>						</div><?php}}echo $zatrec1;?></div><?php $delay=$delay+300; $ff++; } ?></div></div>