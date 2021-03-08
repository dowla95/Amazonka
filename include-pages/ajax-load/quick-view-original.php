<?php 
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
                        <div class="product-large-slider mb-20">
							<div class="pro-large-img">';
if($az1['slika']!="") $psl=$patH.SUBFOLDER.GALFOLDER."/thumb/".$az1['slika']; else $psl=$patH."/img/no-product-image.png";
$mlista .='                     <img src="'.$psl.'" alt="'.$al.'" title="'.$ti.'">
                            </div>';
if($az1['slika1']!="") {
$mlista .='					<div class="pro-large-img">
                                <img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">
                            </div>';
}
$sli = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike
        WHERE pt.lang='$lang' AND  p.tip=5 AND  p.akt='Y' AND p.idupisa=$az1[id] ORDER BY -p.pozicija DESC");
while($sli1=mysqli_fetch_assoc($sli)) {
$mlista .='
							<div class="pro-large-img">
								<img src="'.$patH.GALFOLDER.'/thumb/'.$sli1['slika'].'" title="'.$sli1['title'].'" alt="'.$sli1['alt'].'">
							</div>';
}
$mlista .='
                        </div>
                        <div class="pro-nav">
							<div class="pro-nav-thumb">';
if($az1['slika']!="") $psl=$patH.SUBFOLDER.GALFOLDER."/thumb/".$az1['slika']; else $psl=$patH."/img/no-product-image.png";
$mlista .='                   <img src="'.$psl.'" alt="'.$al.'" title="'.$ti.'">
                            </div>';
 if($az1['slika1']!="") {
$mlista .='					<div class="pro-nav-thumb">
                                <img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$az1['slika1'].'" alt="'.$al.'" title="'.$ti.'">
                             </div>';
}
$sli = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike
        WHERE pt.lang='$lang' AND  p.tip=5 AND  p.akt='Y' AND p.idupisa=$az1[id] ORDER BY -p.pozicija DESC");
while($sli1=mysqli_fetch_assoc($sli)) {
$mlista .='					<div class="pro-nav-thumb">
								<img src="'.$patH.GALFOLDER.'/thumb/'.$sli1['slika'].'" title="'.$sli1['title'].'" alt="'.$sli1['alt'].'">
							</div>';
}
$mlista .='				</div>
                    </div>
                    <div class="col-lg-7">
						<div class="product-details-inner">
							<div class="pro-details-name mb-10">
								<h3 class="product-details-title mb-15">'.$az1['naslov'].'</h3>
								<h4 class="product-details-title mb-15">'.$az1['marka'].'</h4>
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
                                            <span class="value"><a href="#">'.$brend1['naziv'].'</a></span>
                                        </div>
                                        <div class="single-info">
                                            <span class="title">WEB ID:</span>
                                            <span class="value">'.$az1["ide"].'</span>
                                        </div>
                                        <div class="single-info">';
if($az1['lager']==1) $lg="Ima na stanju."; else $lg="Trenutno nema na stanju.";
                                            $mlista .='<span class="title">Dostupno:</span>
                                            <span class="value stock-red">'.$lg.'</span>
                                        </div>
                                    </div>
                                    <div class="product-short-desc mb-25">
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