<div class="header-top black-bg">
<?php if($modulArr['kategorije-hamburger']==1) include('menu-kategorija-hamburger.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-12">
				<div class="header-top-left">
					<ul>
					<li><?php echo $arrwords['parola']?></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-4 col-12">
				<div class="box box-right">
					<ul>
					<li class="settings">
					<a href="javascript:void(0)" class="ha-toggle"><i class="fal fa-user"></i> <?php echo $arrwords['korisnicki_menu']?><span class="lnr lnr-chevron-down"></span></a>
					<ul class="box-dropdown ha-dropdown">
					<?php
					$me=mysqli_query($conn, "SELECT * FROM menus_list WHERE id_menu=3 ORDER BY position ASC");
					while($me1=mysqli_fetch_assoc($me))
					{
					$pe=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$me1[id] AND lang='$lang'");
					$pe1=mysqli_fetch_assoc($pe);
					$pa=mysqli_query($conn, "SELECT * FROM page WHERE id=$me1[id]");
					$pa1=mysqli_fetch_assoc($pa);
					if(($logovan==1 and $pa1['show_for_users']==1) or ($logovan==1 and ($me1['id']==14 or $me1['id']==11))  or ($logovan=="" and $pa1['show_for_users']==0))
					{
					if(isset($_SESSION['userid'])) {
					$mn=mysqli_query($conn, "SELECT dostava FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
					$mn1=mysqli_fetch_assoc($mn);
					}
					if(mb_eregi(".php",$pe1['ulink'])) $ulinka=$pe1['ulink'];
					else if($me1['id']==58 and $mn1['dostava']==5) $ulinka="podesavanja-prodavca/";
					else if($pe1['ulink']!="") $ulinka=$pe1['ulink']."/";
					else $ulinka="";
					//echo $me1['id']."-->".$mn1['dostava'];
					?>
					<li><a href="<?php echo $patH1?>/<?php echo $ulinka?>" title="<?php echo $pe1['naziv']?>"><i class="<?php echo $pa1['class_for_icon']?>"></i> <?php echo $pe1['naziv']?></a></li>
					<?php
					}
					} 
					?>
					</ul>
					</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div><!-- end header-top black-bg -->

<div class="header-middle">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-lg-3 col-md-4 col-sm-4 col-12">
				<div class="logo">
<?php if($log1['slika']!="") { ?>
				<a href="<?php echo $patH1?>" id="path"><img src="galerija/<?php echo $log1['slika']?>" alt="<?php echo $log1['alt']?>" title="<?php echo $log1['title']?>"></a>
<?php } ?>
				</div>
			</div>
		<div class="col-lg-5 col-md-12 col-12 order-sm-last">
			<div class="header-middle-inner">
				<form method="get" action="#">
				<script>document.querySelector("form").setAttribute("action", "")</script>

				<div class="top-cat hm1">
					<input class="top-cat-field" type="text" name="word" required placeholder="Pretraga" value="<?php echo $word?>">
					<button class="top-search-btn" type="submit" value=""> <span class="fas fa-search"></span></button>

<?php
$rad1=$rad2="";
if(!isset($sarray['pron']) or $sarray['pron']==1)
$rad1="checked";
elseif($sarray['pron']==2)
$rad2="checked";
elseif($sarray['pron']==3)
$rad3="checked";
?>
<input class="d-none" name="pron" type="radio" value='1' <?php echo $rad1?> />
<input class="d-none" name="pron" type="radio" value='2' <?php echo $rad2?> />
				</div>
				</form>
			</div>
		</div>

		<div class="col-lg-4 col-md-8 col-12 col-sm-8 order-lg-last">
			<div class="mini-cart-option">
<ul>
<li class="compare pr-20">
<?php
if(isset($_SESSION['uporedi']) and count($_SESSION['uporedi'])>0)
{
$ima=implode(",",$_SESSION['uporedi']);
$baz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1  AND p.id IN($ima) GROUP BY p.id");
$imabr=mysqli_num_rows($baz);
}
if(isset($imabr)) $imabr1=$imabr; else $imabr1=0;
?>
<a class="ha-toggle" href="<?php echo $patH.'/'.$all_links[11]?>/"><i class="fal fa-balance-scale fa-2x"></i><span class="count3"><?php echo $imabr1?></span></a>
</li>

<li class="wishlist">
<?php
if((isset($_COOKIE['soglasi']) and $_COOKIE['soglasi']!=""))
{
$imp=$_COOKIE['soglasi'];
$lp_niz_r=array_reverse(explode(",",$_COOKIE['soglasi']));
$lz = mysqli_query($conn, "SELECT p.id FROM pro p 
        WHERE p.id IN($imp)");
$lzbr=mysqli_num_rows($lz);
}
if($lzbr==0) $lzbr1="0"; else $lzbr1=$lzbr;
?>
<a class="ha-toggle" href="<?php echo $patH.'/'.$all_links[14]?>/"><span class="lnr lnr-heart"></span><span class="count"><?php echo $lzbr1?></span></a>
</li>

<li class="my-cart">
<div class="header-cart-icon">
<a href="javascript:void(0)" id="small-cart-trigger" class="small-cart-trigger">
<i class="far fa-shopping-cart"></i>
<?php
$ii=0;
if(isset($_SESSION[$sid]))
{
foreach($_SESSION[$sid] as $keyy) {
$ii++;
}
}
if($ii==0) {
$prKor=' style="display:block;"';
$prKor1=' style="display:none;"';
}
else {
$prKor1='';
$prKor=' style="display:none;"';
}
?>
<span class="count2"><?php echo $ii?></span>
</a>
<div class="small-cart deactive-dropdown-menu">
<div class="small-cart-item-wrapper">
<?php
echo "<h4 class='text-center'$prKor>Vaša korpa je prazna!</h4>";
?>
<div id="ukorpu-header">
<?php
if(isset($_SESSION[$sid]))
{
$ukupno=0;
foreach($_SESSION[$sid] as $key => $value)
{
$cena_sum=0;
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
/*if($az1['cena1']>0 and $az1['akcija']==1)
$cenar=$az1['cena1'];
else*/
$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar)*$value;
$zalink=$all_links[3];
?>

<div class="single-item" id="item-korpa<?php echo $az1['id']?>">
<div class="image">
<a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>/">
<?php if($az1['slika']!="") $slik=$patH.GALFOLDER."/thumb/".$az1['slika']; else $slik=$patH."/img/no-product-image.png"; ?>
<img class="img-fluid" src="<?php echo $slik?>" title="<?php echo $az1['naslov']?>" alt="<?php echo $az1['naslov']?>">
</a>
</div>
<div class="content">
<p class="cart-name"><a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>/"><?php echo $az1['naslov']?></a></p>
<?php
/*if($az1['cena1']>0) $kosta=$az1['cena1'];
else*/
$kosta=$az1['cena'];
?>
<p class="cart-quantity"><span class="quantity-mes"><?php echo $value?> x </span> <?php echo $kosta?> = <span><?php echo formatCene($cena_sum,1)?></span></p>
</div>

<a class="remove-icon" href="javascript:;" onclick="displaySubs2(<?php echo $az1['id']?>,'drop');"><i class="fal fa-trash-alt"></i></a>
</div>
<?php
}
}
}
?>
</div>
<div class="cart-calculation-table"<?php echo $prKor1?>>
<table class="table mb-25">
<tbody>
<tr>
<td class="text-left">Ukupno:</td>
<td class="text-right" id="ukupno-header"><?php echo formatCene($ukupno,$idvalute)?></td>
</tr>
</tbody>
</table>
<div class="cart-buttons">
<a class="btn-1 home-btn w-100" href="<?php echo $patH1?>/<?php echo $all_links[18]?>/">Pogledaj korpu</a>
</div>
</div>
</div>
</div>
</div>
</li>
</ul><!-- header-cart-icon -->

			</div>
		</div>
	</div>
</div><!-- container-fluid -->

<div class="social-icons d-none d-xl-block">
<ul>
<?php if($settings['google']!="") {?><li><a href="<?php echo $settings['google']?>" target="_blank"><i class="fas fa-map-marker-alt"></i></a></li><?php }?>
<?php if($settings['facebook']!="") {?><li><a href="<?php echo $settings['facebook']?>" target="_blank"><i class="fab fa-facebook"></i></a></li><?php }?>
<?php if($settings['twitter']!="") {?><li><a href="<?php echo $settings['twitter']?>" target="_blank"><i class="fab fa-twitter"></i></a></li><?php }?>
<?php if($settings['linkedin']!="") {?><li><a href="<?php echo $settings['linkedin']?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php }?>
<?php if($settings['instagram']!="") {?><li><a href="<?php echo $settings['instagram']?>" target="_blank"><i class="fab fa-instagram"></i></a></li><?php }?>
<?php if($settings['youtube']!="") {?><li><a href="<?php echo $settings['youtube']?>" target="_blank"><i class="fab fa-youtube-square"></i></a></li><?php }?>
<?php if($settings['tiktok']!="") {?><li><a href="<?php echo $settings['tiktok']?>" target="_blank"><img class="tiktok" src="<?php echo $patH?>/css/svg/tiktok.svg" title="Pratite nas na Tiktok" alt="Pratite nas na Tiktok"></a></li><?php }?>
</ul>
</div><!-- end social-icons -->
</div><!-- end header-middle -->

<div class="header-top-menu theme-bg mb-30 sticker">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
<?php if($modulArr['kategorije-izdvojeno']==1) {
echo '<div class="top-main-menu">';
include('menu-kategorija-izdvojeni.php');
}
else echo '<div class="top-main-menu2">';
?>
					<div class="main-menu">
						<nav id="mobile-menu">
<?php
$menuArr=array();
$menuArrp=array();
$me = mysqli_query($conn, "SELECT m.*, p.*, pl.*,m.id as ide, m.nivo as nivos, m.id_parent as parent
        FROM menus_list m
        INNER JOIN pagel pl ON m.id = pl.id_page
        INNER JOIN page p ON m.id = p.id
        WHERE p.akt=1 AND m.id_menu=4  AND pl.lang='$lang' GROUP BY p.id ORDER BY -m.position DESC");
$ce=0;
while($me1=mysqli_fetch_assoc($me))
{
$menuArr[$me1['nivos']][]=$me1;
$menuArrp[$me1['parent']][]=$me1['parent'];
}
$benuArr=array();
$benuArrp=array();
$nArrp=array();
$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as ide, p.id_parent as parent
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND (p.id_cat=32) ORDER BY p.position ASC");
   while($me1=mysqli_fetch_array($tz))
     {
$benuArr[$me1['nivo']][]=$me1;
$benuArrp[$me1['parent']][]=$me1;
$nArrp[$me1['ide']]=$me1;
}
?>
<ul>
<li><a href="<?php echo $patH?>" class="pl-0"><i class="fa fa-home fa-2x"></i></a></li>
<?php
if($modulArr['kategorije-u-glavnom-meniju']==1) {
include('menu-kategorija.php');
}
$ce=0;
foreach($benuArr[1] as $ke => $me1)
{
if(is_array($benuArrp[$me1['ide']])){
foreach($benuArrp[$me1['ide']] as $zzzzz => $nnnnn)
{
$dukis=$benuArrp[$nnnnn['ide']] && count($benuArrp[$nnnnn['ide']]);
}
}
if($me1['class_for_icon']!="") $uklas=" class='".$me1['class_for_icon']."'"; else $uklas="";
if($page1['id']==$me1['ide']) $curre=' class="active"'; else $curre="";
?>
<?php
$ce++;
}
$ce=0;
foreach($menuArr[1] as $ke => $me1)
{
if($me1['class_for_icon']!="") $uklas="<i class='".$me1['class_for_icon']."'></i> "; else $uklas="";
if($page1['id']==$me1['ide']) $curre=' class="active"'; else $curre="";

if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0)
$arrdole=" <span class='lnr lnr-chevron-down'></span>"; else $arrdole="";

if(is_array($menuArrp[$me1['ide']])) $prom=count($menuArrp[$me1['ide']]); else $prom=0;
if($prom>0) $ulinka="javascript:void(0)";
else $ulinka=$patH1."/".$me1['ulink']."/";
?>
<li><a href="<?php echo $ulinka?>" title="<?php echo $me1['naziv']?>"><?php echo $uklas.$me1['naziv']?><?php echo $arrdole?></a>
<?php
if($menuArrp[$me1['ide']] && count($menuArrp[$me1['ide']])>0){
?>
<ul class="dropdown">
  <?php
foreach($menuArr[2] as $ce => $ze1)
{
if($me1['ide']==$ze1['parent']) {
if($ze1['ulink']!="") $ulinka1=$ze1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if(preg_match("/.php/",$ze1['ulink']))
$ulinka1=$ze1['ulink'];
if($ze1['class_for_icon']!="") $uklas1="<i class='".$ze1['class_for_icon']." ic2nivo'></i> "; else $uklas1="";
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])==1)
$link2="javascript:void(0)";
else $link2=$patH1."/".$ulinka1;
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])>0)
$arrde=" <span class='lnr lnr-chevron-right'></span>"; else $arrde="";
?>
<li><a href="<?php echo $link2?>" title="<?php echo $ze1['naziv']?>"><?php echo $uklas1.$ze1['naziv']?><?php echo $arrde?></a>
<?php
if($menuArrp[$ze1['ide']] && count($menuArrp[$ze1['ide']])>0){
?>
<ul class="dropdown">
<?php
foreach($menuArr[3] as $de => $te1)
{
if($ze1['ide']==$te1['parent']) {
if($te1['ulink']!="") $ulinka1=$te1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if(preg_match("/.php/",$te1['ulink']))
$ulinka1=$te1['ulink'];
if($te1['class_for_icon']!="") $uklas2="<i class='".$te1['class_for_icon']." ic2nivo'></i> "; else $uklas2="";
?>
<li><a href="<?php echo $patH1?>/<?php echo $ulinka1?>" title="<?php echo $te1['naziv']?>"><?php echo $uklas2.$te1['naziv']?></a></li>
<?php
}
}
?>
</ul>
<?php
}
?>
 </li>
<?php
}
}
?>
</ul>
<?php
}

?>
 </li>
<?php
$ce++;
}
?>
</ul>
						</nav>
					</div>

					<div class="header-call-action">
						<p>
<?php if($settings['tel-sin']!="" or $settings['tel-header']!="") { ?>
						<strong><a href="tel:<?php echo $settings['tel-sin']?>"><span class="lnr lnr-phone"></span> <?php echo $settings['tel-header']?> <i class="fal fa-hand-pointer"></i></a></strong>
<?php } ?>
						<a data-toggle="collapse" href="#detpret" tabindex="0" role="button" aria-expanded="false" aria-controls="detpret" class="no"> <i class="far fa-ellipsis-h-alt pl-10"></i> <span class="fas fa-search"></span></a></p>
					</div>
				</div><!-- end top-main-menu -->
			</div><!-- end col-lg-12 -->

			<div class="col-12 d-block d-lg-none"><div class="mobile-menu"></div></div>

		</div><!-- end row -->



		<div class="pb-5 collapse" id="detpret">
			<div class="card card-body">
				<div class="top-cat">
					<div class="search-form">
					<strong>Pretraga u kategoriji:</strong><br>
					<form action="" method="">
					<select>
					<option value="0">SVE</option>
					<?php
					$benuArr=array();
					$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as ide, p.id_parent as parent
							FROM stavke p
							INNER JOIN stavkel pt ON p.id = pt.id_page
							WHERE pt.lang='$lang' AND (p.id_cat=32) ORDER BY p.position ASC");
					   while($me1=mysqli_fetch_array($tz))
						 {
					$benuArr[$me1['nivo']][]=$me1;
					}
					foreach($benuArr[1] as $ke => $me1) {
					?>
					<option value="<?php echo $me1['id']?>"><?php echo $me1['naziv']?></option>
					<?php } ?>
					</select>
					</form>
					</div><!-- end search-form -->
				</div>
			</div>
		</div>
	</div><!-- end container-fluid -->
</div><!-- header-top-menu theme-bg sticker -->