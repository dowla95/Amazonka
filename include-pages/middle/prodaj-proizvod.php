<?php //include("tiny_mce.php"); ?><div class='container-fluid'><h2>Upis proizvoda</h1><?php$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");$mn1=mysqli_fetch_assoc($mn);if($msr!="")echo "<div class='infos1'><div>$msr</div></div>"; $pozicija=$_POST["pozicija"]; $cenna=$_POST["cena"];?><link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"><form method="post" action="" id="addPro" enctype="multipart/form-data"><?php if($mn1['dostava']==0) { ?><input type="hidden" name="limdo" value="0"><input type="hidden" name="fido" value="0"><input type="hidden" name="bedo" value="1"><?php	}else { ?><input type="hidden" name="limdo" value="<?php echo $mn1['limit_dostave']?>"><input type="hidden" name="fido" value="<?php echo $mn1['fiksna_dostava']?>"><input type="hidden" name="bedo" value="0"><?php } ?><input type="hidden" name="addpro" value="1"><input type="hidden" name="prodavac" value="<?php echo $_SESSION['userid']?>"><input type="hidden" name="idpro" value="0"><input type="hidden" name="kat1" value="0"><input type="hidden" name="kat2" value="0"><input type="hidden" name="kat3" value="0"><input type="hidden" name="brendovi" value="0"><div class="row"><div class="col-12 zabrend"><!--<b>Brend</b><br>--><?phpif(isset($oldbrend)) {?><select name="brendovi" class="form-control w-100 mb-20"><option value="">Izaberite proizvođača</option><?php$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide        FROM stavke p        INNER JOIN stavkel pt ON p.id = pt.id_page        WHERE /*pt.lang='$firstlang' AND  */p.nivo=1 AND  p.akt=1 AND p.id_cat=27 ORDER BY -p.position DESC");   while($tz1=mysqli_fetch_array($tz))     {if(isset($_POST['brendovi']) and $tz1['ide']==$_POST['brendovi'])$che="selected"; else $che="";echo "<option value='$tz1[ide]' $che>$tz1[naziv]</option>";}?></select><?php} else {?><div class="dropdown">  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    IZABERITE BREND  </button>  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">  <input class="form-control mb-10 findkat" rel="zabrend" type="text" name="" value="" placeholder="Krenite sa kucanjem brenda..."><ul class="brcol">  <?php  $i=1;$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide        FROM stavke p        INNER JOIN stavkel pt ON p.id = pt.id_page        WHERE /*pt.lang='$firstlang' AND  */p.nivo=1 AND  p.akt=1 AND p.id_cat=27 ORDER BY -p.position DESC");   while($me1=mysqli_fetch_array($tz))     {?><li><a class="dropdown-item brendi ka<?php echo $i?>" href="javascript:;" data="<?php echo $me1['nivo']?>" title="<?php echo replace1($me1['naziv'])?>" rel="<?php echo $me1['ide']?>"><span><?php echo $me1['naziv']?></span></a></li><?php $i++; } ?></ul>  </div></div><?php}?></div><div class="col-12 mb-10"><?php echo $settings['nema_brenda']?></div></div><div class="row"><div class="col-12 mb-10"><div class="dropdown">  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    IZABERI GLAVNU KATEGORIJU  </button>  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:90%;">  <input class="form-control mb-10 findkat" type="text" name="" value="" placeholder="Krenite sa kucanjem kategorije...">  <?php	$benuArr=array();					$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as ide, p.id_parent as parent							FROM stavke p							INNER JOIN stavkel pt ON p.id = pt.id_page							WHERE pt.lang='$lang' AND p.nivo=1 AND (p.id_cat=32) ORDER BY p.position ASC");               $i=1;					   while($me1=mysqli_fetch_array($tz))						 {					?>    <div class="prikat"><a class="dropdown-item kati ka<?php echo $i?>" href="javascript:;" data="<?php echo $me1['nivo']?>" title="<?php echo replace1($me1['naziv'])?>" rel="<?php echo $me1['ide']?>"><span><?php echo $me1['naziv']?></span></a></div><?php $i++; } ?>  </div></div><div id="kat2"></div><div id="kat3" class="mb-10"></div><?php echo $settings['nema_kategorije']?></div></div><?php$naslov=$ulink=$opis1=$opis=$title=$keywords=$description=$esno1=$esno2=$esno3=$esno4=$pozicija=$altslike=$titleslike="";$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC"); while($la1=mysqli_fetch_array($la)) { $jez=$la1['jezik']; $naslov=$_POST["naslov$jez"]; $marka=$_POST["marka$jez"]; $opis=$_POST["opis$jez"]; $keywords=$_POST["keywords$jez"]; ?><div class="row"><div class="col-lg-6">Naziv proizvoda: <span style='color:red;'>*</span><br /><input type="text" name='naslov<?php echo $jez?>' value="<?php echo $naslov?>" class="form-control" required /></div><div class="col-12"><label>Opis</label><textarea class="form-control" id="summernote"  name="opis<?php echo $jez?>"><?php echo $opis?></textarea></div><div class="col-12"><label>YouTube ili Vimeo video</label><br /><input type="text" name='keywords<?php echo $jez?>' value='<?php echo $keywords?>' class='form-control w-100'  /></div><?php } ?></div><div class="row"><div class="col-12"><div class="row mt-10"><div class="col-md-2 col-sm-4 col-6"><b>Cena <span style='color:red;'>*</span></b><br /><input class="form-control" type="number" name='cena' value="<?php echo $cena?>"  min="0" required /></div><div class="col-md-2 col-sm-4 col-6"><b>Cena u:</b><br /><input type="radio" value="0" name="uvaluti" checked> RSD<input class="ml-20" type="radio" value="1" name="uvaluti"> &euro;</div><div class="col-md-3 col-sm-4 col-12"><b>Stanje <span style='color:red;'>*</span></b><br /><input type="radio" value="0" name="novoli" required> <label>Novo</label><input class="ml-10" type="radio" value="1" name="novoli" required> <label>Korišćeno</label></div><div class="col-md-3 col-sm-12 col-12"><label for="dostava"><b>Cena dostave samo za ovaj proizvod:</b></label><br /><div class="check-box d-inline-block ml-0 ml-md-2 mt-10"><input class="checkbox" type="checkbox" name="checkbox" id="checkbox" value="checkbox" /><label for="checkbox">Izmeni cenu dostave</label><br /><input class="form-control mt-10" id="dosta" name="dostava" type="number" value="<?php echo $dostava?>" min="0"/></div></div><script>$('form').on('focus', 'input[type=number]', function (e) {  $(this).on('wheel.disableScroll', function (e) {    e.preventDefault()  })})$('form').on('blur', 'input[type=number]', function (e) {  $(this).off('wheel.disableScroll')})$(function () {    $('input[id="dosta"]').hide();    //show it when the checkbox is clicked    $('input[name="checkbox"]').on('click', function () {        if ($(this).prop('checked')) {            $('input[id="dosta"]').fadeIn();        } else {            $('input[id="dosta"]').hide();        }    });});</script><div class="col-md-2 col-sm-12 col-6"><label>Šifra/EAN KOD</label><br /><input type="text" name='link' class='form-control' value="<?php echo $link?>" /></div></div></div></div><div class="row"><div class="col-md-12 mt-20"><label class="infile">    <input type="file" name="proimages[]" multiple id="proimages" class="d-none"/>    <i class="fal fa-images"></i> DODAJ SLIKE</label><div class="spinner-border" role="status" style="display:none;position:relative;top:5px;">  <span class="sr-only">Loading...</span></div></div></div><div class="row"><div class="col-md-12 mt-20"><div id="sortable" class="d-flex flex-center flex-wrap"></div></div></div><div class="row mt-20 mb-20"><div class="col-12 accordion"><div class="card-header fildeo p-2" style="display:none;"><b>Filter stavke</b> (U Vašem je interesu da popunite donje karakteriistike proizvoda!)</div><div id="filter" class="card-body in" style="display:none;"></div></div></div><div class='alert text-right' role="alert"></div><div class="spinner-border" id="spinner" role="status" style="display:none;position:relative;top:5px;">  <span class="sr-only">Loading...</span></div> <input type='submit' name='save_pro' class="theme-button float-right" value='<?php echo $arrwords['postavi_proizvod']?>'></form></div><script src="<?php echo $patH?>/js/bootstrap.min.js"></script>