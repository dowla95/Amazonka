<?php
if(isset($_POST['upodkat']) and $_POST['upodkat']>0 and $_POST['kateg']>0) {
	$tza = mysqli_num_rows(mysqli_query($conn,"SELECT id
							FROM stavke WHERE id_parent=".$_POST['kateg'].""));
              if($tza>0) {
?>
<br><div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    IZABERI PODKATEGORIJU
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:90%;">
  <input class="form-control mb-10 findkat" type="text" name="" value="" placeholder="Krenite sa kucanjem kategorije...">
  <?php
	$benuArr=array();
					$tz = mysqli_query($conn,"SELECT p.*, pt.*, p.id as ide, p.id_parent as parent
							FROM stavke p
							INNER JOIN stavkel pt ON p.id = pt.id_page
							WHERE pt.lang='$lang' AND (p.id_cat=32) AND p.id_parent=".$_POST['kateg']." GROUP BY p.id ORDER BY p.position ASC");
           $i=1;
					   while($me1=mysqli_fetch_array($tz))
						 {
					?>

    <div style="width:30%;float:left;"><a class="dropdown-item kati ka<?php echo $i?>" href="javascript:;" title="<?php echo replace1($me1['naziv'])?>" data="<?php echo $me1['nivo']?>" rel="<?php echo $me1['ide']?>"><span><?php echo $me1['naziv']?></span></a></div>
<?php $i++; } ?>
  </div>
</div>
<?php
}
}

if(isset($sarray['va'])) 
{ 
if($sarray['va']==2) 
{ 
setcookie("valuta", "", time()-60*60*24*30, "/"); 
$sirt=preg_replace("/(^|\?)va=2*/","",curPageURL()); 
} 
elseif($sarray['va']==1) 
{ 
setcookie("valuta", 2, time()+60*60*24*30, "/"); 
$sirt=preg_replace("/(^|\?)va=1*/","",curPageURL()); 
} if(isset($sarray['pron']) and $sarray['pron']>0)
header("location: ". $patH1."/?word=".strip_tags($sarray['word'])."&pron=".strip_tags($sarray['pron'])."");
else
header("location: ". $sirt); 
}
if(isset($_COOKIE['valuta']))  
{ 
$idvalute=""; 
$valut="€"; 
} 
else  
{ 
$idvalute=1; 
$valut="RSD"; 
} 
if(isset($_SESSION['userid']) and $_SESSION['userid']>0) 
{ 
$us=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id='$_SESSION[userid]'"); 
$us1=mysqli_fetch_assoc($us);
}
/* provera postojanja emaila ili nicka */
if(isset($_POST['check_vr']) and $_POST['check_vr']!=''){
$kolona=strip_tags($_POST['kolona']);
$vred=strip_tags(trim($_POST['check_vr']));
if(isset($_SESSION['userid'])) $iskljuci=" AND user_id!=".$_SESSION['userid']; else $iskljuci="";
$mm=mysqli_num_rows(mysqli_query($conn, "SELECT $kolona FROM users_data WHERE $kolona=".safe($vred)."$iskljuci"));
if($mm>0 and $kolona=='email')
$msgr='Email već postoji u bazi!';
elseif($mm>0)
$msgr='Nick već postoji u bazi!';
else
$msgr='';
$ende=0;
}
/******** dodavanje avatara kod registracije korisnika *************/
if((isset($_POST['reg_cand']) or isset($_POST['change_cand'])) and isset($_FILES['avatar']['tmp_name']) and $_FILES['avatar']['tmp_name']!="")
{
$folder='temp/'.session_id();
if(!is_dir($page_path2.SUBFOLDER."/".$folder)) {
mkdir($page_path2.SUBFOLDER."/".$folder, 0777, true);
mkdir($page_path2.SUBFOLDER."/".$folder."/thumb", 0777, true);
}
$iimesl=explode('.', $_FILES['avatar']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);
$formati=array("jpg","jpeg","gif","png");
if(!in_array($ext, $formati)) {
$msgr='Slika nije odgovarajuceg formata';
$ende=0;
} else {
$slika =UploadSlika($_FILES['avatar']['name'],$_FILES['avatar']['tmp_name'],$_FILES['avatar']['type'],"$page_path2/$folder/",1,1);

$msgr="<input type='hidden' value='$slika' name='avatarce' class='avatarce'>";
$ende=1;
}
//exit();
} else
/*************** registracija korisnika ***********/
if(isset($_POST['reg_cand']))
{
$ende=0;
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])."");
$fx1=mysqli_fetch_assoc($fax);
if(mb_eregi('-',$_POST['nickname'])) {
$prim=str_replace("----","-",$_POST['nickname']);
$prim=str_replace("---","-",$prim);
$prim=str_replace("--","-",$prim);

$pr=explode("-",$prim);
if($pr[0]=='')
array_shift($pr);
$brib=count($pr);
if($pr[$brib]=='')
array_pop($pr);
$nick= implode("-",$pr);
} else $nick=$_POST['nickname'];


$nax=mysqli_query($conn, "SELECT * FROM users_data WHERE nickname=".safe($nick)."");
$nx1=mysqli_fetch_assoc($nax);

if($nick=="" or $_POST['ime']=="" or $_POST['email']=="" or $_POST['password']=="" or $_POST['password1']=="" or $_POST['telefon']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="" or ($_POST['firma-lice']=='firma' and ($_POST['nazivfirme']=='' or $_POST['pib']=='')))
$msgr=$arrwords['niste_ispunili'];
else 
if($_POST["uslovi"]!=1) 
{
$msgr=$arrwords2['uslovi_cekiranje1']; 
} 
else 
if($_POST["password"]!=$_POST["password1"]) 
{ 
$msgr=$arrwords2['sifre_nejednake']; 
} 
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
{ 
$msgr=$arrwords['email_novalid']; 
} 
else 
if($fx1['user_id']>0) 
{ 
$msgr=$arrwords['email_postoji']; 
} 
else 
if($nx1['user_id']>0)
{
$msgr=$arrwords['nick_postoji'];
}
else
{ 
if(isset($_POST['avatarce']) and $_POST['avatarce']!='')
$iavatar=", avatar='".$_POST['avatarce']."'"; else $iavatar="";

if($_POST['firma-lice']=='firma') $firma=1; else $firma=0;

if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0; 
//$br1=md5(md5(strip_tags($_POST['password']).time())); 
$password_crypted = tep_encrypt_password(strip_tags($_POST['password'])); 
$date_birth=$post_niz['year']."-".$post_niz['month']."-".$post_niz['day']; 
$randi=gen_rand(); 

if(isset($_POST['nazivfirme']) and strlen($_POST['nazivfirme'])>2)
$nazivfirme=", nazivfirme=".safe($_POST['nazivfirme']);
else
$nazivfirme=", nazivfirme=NULL";

if(isset($_POST['pib']) and strlen($_POST['pib'])>2)
$pib=", pib=".safe($_POST['pib']);
else
$pib=", pib=NULL";

$ime=$_POST['ime'];
if(!mysqli_query($conn, "INSERT INTO users_data SET  provizija=$settings[provizija], firma=$firma, tr=".safe($_POST['racun']).", ime=".safe($ime).$nazivfirme.", email=".safe($_POST['email']).", nickname=".safe($nick).$pib.", password=".safe($password_crypted).", telefon=".safe($_POST['telefon'])."$iavatar, grad=".safe($_POST['grad']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti', randkod='$randi'")) echo mysqli_error();
$zid=mysqli_insert_id($conn);


if(isset($_POST['avatarce']) and $_POST['avatarce']!='') {
if(!is_dir($page_path2.'/avatars/'.$zid)) {
mkdir($page_path2.'/avatars/'.$zid, 0777, true);
mkdir($page_path2.'/avatars/'.$zid.'/thumb', 0777, true);
}
if(is_file($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'])) {
@rename($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'], $page_path2.'/avatars/'.$zid."/".$_POST['avatarce']);
@rename($page_path2.'/temp/'.session_id()."/thumb/".$_POST['avatarce'], $page_path2.'/avatars/'.$zid."/thumb/".$_POST['avatarce']);
}
}

if($ivesti==1) 
@mysqli_query($conn, "INSERT INTO subscribers SET email=".safe($_POST['email']).", akt=1, time='".time()."'"); 
$msgr=$arrwords2['registracija_uspesna']; 
$ende=1; 
$green="_green";
$subject=$arrwords2['subject_mail']." - ".date("Y-m-d"); 
$from_name=$domen;  
$for_admin="<br><b>Podaci novo registrovanog korisnika:</b> <br>"; 
$for_admin .=" 
Ime: $_POST[ime]<br> 
Email: $_POST[email]<br> 
Grad: $_POST[grad]<br> 
"; 
$texte=html2plain($for_admin,10000000);
$linka="<a href='".$patH1."/".$all_links[10]."/?activate=".$randi."'>".$patH1."/".$all_links[10]."/?activate=".$randi."</a>"; 
$akti_tekst=sprintf($arrwords2['reg_send_tekst'], $_POST['ime'], $domen, $linka, $patH1, $domen); 
$akti_tekst1=strip_html_tags($akti_tekst); 
//echo $akti_tekst;  
send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"], $subject, $from_name, $akti_tekst, $akti_tekst1);  send_email("mail", $settings["email_zaemail"], $settings["from_email"], $settings["from_email"], "New user - $_POST[ime]", $from_name, $for_admin, $texte); 
} 
} 
else
if(isset($_POST['change_cand']) and $_SESSION['userid']>0)
{
if($_POST['email']!="")
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])." AND NOT user_id=$_SESSION[userid]");
$fx1=mysqli_fetch_assoc($fax);
}

if($_POST['ime']=="" or $_POST['email']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="" or $_POST['telefon']=="" or ($_POST['firma-lice']=='firma' and ($_POST['nazivfirme']=='' or $_POST['pib']=='')))
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{
$ende=0;
$msgr=$arrwords2['sifre_nejednake'];
}
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false)
{
$ende=0;
$msgr=$arrwords['email_novalid'];
}
else
if($fx1['user_id']>0)
{
$ende=0;
$msgr=$arrwords['email_postoji'];
}
else
{
$password_crypted = tep_encrypt_password(strip_tags($_POST['passwordR']));
if($_POST["passwordR"]!="" and $_POST["passwordR1"]!="")
$novi_pass=", password=".safe($password_crypted);
else
$novi_pass="";

if(isset($_POST['avatarce']) and $_POST['avatarce']!='' and !isset($_POST['avatar_del'])) {
if(!is_dir($page_path2.'/avatars/'.$_SESSION['userid'])) {
mkdir($page_path2.'/avatars/'.$_SESSION['userid'], 0777, true);
mkdir($page_path2.'/avatars/'.$_SESSION['userid'].'/thumb', 0777, true);
}
if(is_file($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'])) {
@rename($page_path2.'/temp/'.session_id()."/".$_POST['avatarce'], $page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatarce']);
@rename($page_path2.'/temp/'.session_id()."/thumb/".$_POST['avatarce'], $page_path2.'/avatars/'.$_SESSION['userid']."/thumb/".$_POST['avatarce']);
}
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatar_curent']);
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/thumb/".$_POST['avatar_curent']);
$avatar=", avatar='".$_POST['avatarce']."'";
}
else if(isset($_POST['avatar_del'])) {
@unlink($page_path2.'/avatars/'.$_SESSION['userid']."/".$_POST['avatar_curent']);
$avatar=", avatar=NULL";
} else $avatar="";
if($_POST['firma-lice']=='firma' and isset($_POST['nazivfirme']) and $_POST['nazivfirme']!='')
$zafirmu=", nazivfirme=".safe($_POST['nazivfirme']).", pib=".safe($_POST['pib']);
else
$zafirmu=", nazivfirme=NULL, pib=NULL";
if($_POST['firma-lice']=='firma') $firma=1; else $firma=0;
//$br1=md5(md5(strip_tags($_POST['password']).time()));
if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0;
if(!mysqli_query($conn, "UPDATE users_data SET firma=$firma, ime=".safe($_POST['ime']).", tr=".safe($_POST['racun']).", email=".safe($_POST['email'])."$avatar$zafirmu, telefon=".safe($_POST['telefon']).", grad=".safe($_POST['grad']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti'$novi_pass WHERE user_id=$_SESSION[userid]")) echo mysqli_error();
//$nus=mysqli_num_rows(mysqli_query($conn, "UPDATE subscribers WHERE email=".safe($_POST['email'])."")); //ovako je bilo
$nus=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])." AND vesti=1")); // a ovo sam dodao jer je prijavljivalo gresku,prijavljuje gresku i na izvornom sajtu xxxxxxxx
$mus=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe($_POST['email'])." AND akt=0"));
if($nus==1 and $ivesti==1)
mysqli_query($conn, "INSERT INTO subscribers SET email=".safe($_POST['email']).", akt=1, time='".time()."'");
elseif($nus==0)
mysqli_query($conn, "DELETE FROM subscribers WHERE email=".safe($_POST['email'])."");

$msgr=$arrwords2['uspesna_izmena'];
$ende=1;
}
}


/*********** Unos/Izmena podataka prodavca za prodaju ********/

if(isset($_POST['pprodavca']) and $_SESSION['userid']>0)
{
if($_POST['racun']=="") $msgr="Niste uneli tekući račun!";
else if($_POST['dostava']=="5") $msgr="Niste odabrali cenu dostave!";
elseif ($_POST['dostava']=="1" and $_POST['limit']=="") $msgr="Odabrali ste besplatnu dostavu preko limita, ali niste uneli limit!";
elseif ($_POST['limit']!="" and $_POST['fiksna']=="") $msgr="Odabrali ste besplatnu dostavu preko limita, ali niste uneli cenu dostave ispod limita!";
elseif ($_POST['dostava']=="2" and $_POST['fiksna']=="") $msgr="Niste uneli fiksnu cenu dostave!";

else
{
if($_POST['limit']>0) $limitp=$_POST['limit']; else $limitp=0;
if($_POST['fiksna']>0) $fiksnap=$_POST['fiksna']; else $fiksnap=0;

if($_POST['dostava']=="1") $dostava="dostava=1" and $limit="limit_dostave=".$limitp and $fiksna="fiksna_dostava=".$fiksnap;
elseif($_POST['dostava']=="2") $dostava="dostava=2" and $limit="limit_dostave=".$limitp and $fiksna="fiksna_dostava=".$fiksnap;
else $dostava="dostava=0" and $limit="limit_dostave=0" and $fiksna="fiksna_dostava=0";

if(!mysqli_query($conn, "UPDATE users_data SET tr=".safe($_POST['racun']).", $dostava, $limit, $fiksna WHERE user_id=$_SESSION[userid]")) echo mysqli_error();
$msgr=$arrwords2['uspesna_izmena'];
}
}

/************************ KORISNIKOV UPIS PROIZVODA *****************************/

/*********** dodavanje slika proizvoda (prva ide u tabelu pro) ********/
if((isset($_POST['addpro'])  or isset($_POST['changepro'])) and isset($_FILES['proimages']['tmp_name'][0]) and $_FILES['proimages']['tmp_name'][0]!="" and isset($_SESSION['userid']))
{
$msgr="";
$folder='temp/'.$_SESSION['userid'].'/'.session_id();
if(!is_dir($page_path2.SUBFOLDER."/".$folder)) {
mkdir($page_path2.SUBFOLDER."/".$folder, 0777, true);
mkdir($page_path2.SUBFOLDER."/".$folder."/thumb", 0777, true);
}
$iimesl=explode('.', $_FILES['proimages']['name'][0]);
$ext= end($iimesl);
$ext=strtolower($ext);
$formati=array("jpg","jpeg","gif","png");
if(!in_array($ext, $formati)) {
$msgr='Slika nije odgovarajuceg formata';
$ende=0;
} else {
if(isset($_POST['addpro']) and $_POST['addpro']>0)
$IDpro=$_POST['addpro'];
else
if(isset($_POST['changepro']) and $_POST['changepro']>0)
$IDpro=$_POST['changepro'];
else
$IDpro=0;
$ukSlika=0;
if($IDpro>0) {
$gla = mysqli_query($conn,"SELECT slika FROM pro WHERE id=".safe($IDpro)); $gla1=mysqli_fetch_assoc($gla);
if(strlen($gla1['slika'])>5)
$ukSlika +=1;

$trsl=array();
$osl=mysqli_query($conn,"SELECT slika FROM slike WHERE idupisa=".safe($IDpro)." ORDER BY pozicija ASC");
while($osl1=mysqli_fetch_assoc($osl)){
$trsl[]=$osl1['slika'];
}
$ukSlika +=count($trsl);
}
if($ukSlika==15)
$msgr='Dozvoljen broj slika je 15!';
else {

for($i=0; $i<count($_FILES['proimages']['name']); $i++){
//for($i=0; $i<15; $i++){
$slika =UploadSlika($_FILES['proimages']['name'][$i],$_FILES['proimages']['tmp_name'][$i],$_FILES['proimages']['type'][$i],"$page_path2/$folder/",1,1);

$msgr .="<div class='m-2 upokvir'><a href='javascript:;' data='$slika' class='rotate' rel='l'><i class='fal fa-undo'></i></a> <a href='javascript:;' class='rotate' data='$slika' rel='r'><i class='fal fa-redo'></i></a> <a href='javascript:;' data='' class='' rel=''><i class='fal fa-trash-alt float-right'></i></a>
<div class='upsl'>
<a href=''>
<img src='$patH/$folder/thumb/$slika'></a><input type='hidden' value='$slika' name='images[]'>
</div>
</div>";
}
$ende=1;
}
}
//exit();
}
else
if((isset($_POST['addpro'])) and isset($_SESSION['userid']))
{
if($_POST['kat2']>0)
$wz = mysqli_num_rows(mysqli_query($conn,"SELECT id_parent FROM stavke WHERE id_parent=".safe($_POST['kat2'])));
else
$wz=0;

if($_POST['naslov'.$lang]=='' or $_POST['cena']=='' or !isset($_POST['novoli']) or ($_POST['kat2']=="" and $_POST['kat3']==""))
$msgr=$arrwords['niste_ispunili'];
else
if($_POST['kat3']==0 and $wz>0)
echo
$msgr="Izaberite podkategoriju poslednjeg nivoa!";
else {
$slikePRO="";
if(isset($_POST['images']) and count($_POST['images'])>0){
for($i=0;$i<1;$i++){
$v=$_POST['images'][$i];
if($v!='') {
//if($i==0) $kol="slika"; else $kol="slika1";
if($i==0) $kol="slika";
$slikePRO .=", $kol='$v'";
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/'.$v, $page_path2.'/galerija/'.$v);
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/thumb/'.$v, $page_path2.'/galerija/thumb/'.$v);
}
}
}


if($_POST['uvaluti']==1) $cena=$_POST['cena']*$settings['kurs_evra']; else $cena=$_POST['cena'];
if($_POST['novoli']==0) $novoli=", novo=1, izdvojeni=0"; else $novoli=", novo=0, izdvojeni=1";
$novic .="id_page=3, akt=1, cena=$cena";
$novic .=", uvaluti=".safe($_POST['uvaluti']);
$novic .=", nova_cena_dostave=".safe($_POST['dostava']);
$novic .=", brend=".safe($_POST['brendovi']);
$novic .=", link=".safe($_POST['link']);
$novic .=", limit_dostave=".safe($_POST['limdo']);
$novic .=", fiksna_dostava=".safe($_POST['fido']);
$novic .=", vegan=".safe($_POST['bedo']);
$novic .=", time=".time();
$novic .=", prodavac=".safe($_POST['prodavac']);
if(isset($_POST['images']) and count($_POST['images'])>0)
$novic .=", nepotpun_filter=0";
else
$novic .=", nepotpun_filter=1";
mysqli_query($conn, "INSERT INTO pro SET $novic$npol$novoli$slikePRO");
$idzad=mysqli_insert_id($conn);
if($idzad>0)
{
if($_POST['kat3']>0) $kategorija=$_POST['kat3'];
else if($_POST['kat2']>0) $kategorija=$_POST['kat2'];
else
if($_POST['kat1']>0) $kategorija=$_POST['kat1'];
mysqli_query($conn, "INSERT INTO kat_pro SET kat=".safe($kategorija).", pro='$idzad'");
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 {
$naslov="naslov$la1[jezik]";
$opis="opis$la1[jezik]";
$keyword="keywords$la1[jezik]";
$nazivis = "lang='$la1[jezik]', id_text='$idzad', naslov=".safe($_POST[$naslov]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", keywords=".safe($_POST[$keyword]);
 mysqli_query($conn, "INSERT INTO prol SET $nazivis");
}

if(isset($_POST['ife']) and $_POST['ife']>0){
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='".$_POST["filt$i"]."', id_pro='$idzad'");
}
}

if(isset($_POST['images']) and count($_POST['images'])>0){
for($i=0;$i<count($_POST['images']);$i++){
$v=$_POST['images'][$i];
if($v!='' and $i>0) {

mysqli_query($conn, "INSERT INTO slike SET slika=".safe($v).", idupisa=$idzad, pozicija=$i, tip=5");

@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/'.$v, $page_path2.'/galerija/'.$v);
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/thumb/'.$v, $page_path2.'/galerija/thumb/'.$v);
}
}
}
$ende=1;
$msgr="Proizvod je uspešno izmenjen!";
}
}
}else
if((isset($_POST['changepro'])) and $_POST['changepro']>0 and isset($_SESSION['userid']))
{
if($_POST['kat2']>0)
$wz = mysqli_num_rows(mysqli_query($conn,"SELECT id_parent FROM stavke WHERE id_parent=".safe($_POST['kat2'])));
else
$wz=0;

if($_POST['naslov'.$lang]=='' or $_POST['cena']=='' or !isset($_POST['novoli']) or ($_POST['kat2']=="" and $_POST['kat3']==""))
$msgr=$arrwords['niste_ispunili'];
else
if($_POST['kat3']==0 and $wz>0)
echo
$msgr="Izaberite podkategoriju poslednjeg nivoa!";
else {
$a_slike=$_POST['images'];
if(isset($_POST['imagesc']) and count($_POST['imagesc'])>0){
$slika=$_POST['imagesc'][0];
$poz=array_search($slika, $a_slike);
unset($a_slike[$poz]);
mysqli_query($conn, "UPDATE pro SET slika=NULL WHERE slika=".safe($slika));
@unlink($page_path2."/galerija/".$slika);
@unlink($page_path2."/galerija/thumb/".$slika);
}
 if(isset($_POST['imagescc']) and count($_POST['imagescc'])>0){
$slike=$_POST['imagescc'];
foreach($slike as $ks => $ss){
$slika=$ss;
$poz=array_search($slika, $a_slike);
unset($a_slike[$poz]);
mysqli_query($conn, "DELETE FROM slike WHERE slika=".safe($slika));
@unlink($page_path2."/galerija/".$slika);
@unlink($page_path2."/galerija/thumb/".$slika);
}
}
$akt_slike=array();
foreach($a_slike as $ke => $ve) {
$akt_slike[]=$ve;
}
$gla = mysqli_query($conn,"SELECT slika FROM pro WHERE id=".safe($_POST['changepro'])); $gla1=mysqli_fetch_assoc($gla);
//if($gla1['slika']!='')
$gls=$gla1['slika'];
$trsl=array();
$osl=mysqli_query($conn,"SELECT slika FROM slike WHERE idupisa=".safe($_POST['changepro'])." ORDER BY pozicija ASC");
while($osl1=mysqli_fetch_assoc($osl)){
$trsl[]=$osl1['slika'];
}
$slikePRO="";
if(isset($akt_slike)){

for($i=0;$i<count($akt_slike);$i++){
$v=$akt_slike[$i];
if($v!=''){

if($i==0) { 

if(strlen($gls)<5) {

$slikePRO=", slika='".$v."'";
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/'.$v, $page_path2.'/galerija/'.$v);
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/thumb/'.$v, $page_path2.'/galerija/thumb/'.$v);
if(in_array($v,$trsl))
@mysqli_query($conn, "DELETE FROM slike WHERE slika=".safe($v)." AND idupisa=".$_POST['changepro']."");

}
 else
if(strlen($gls)>4 and $gls!=$v)  {

$slikePRO=", slika='".$v."'";
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/'.$v, $page_path2.'/galerija/'.$v);
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/thumb/'.$v, $page_path2.'/galerija/thumb/'.$v);
$ipoz=array_search($gls, $akt_slike);
mysqli_query($conn, "INSERT INTO slike SET slika=".safe($gls).", idupisa=".$_POST['changepro'].", pozicija=$ipoz, tip=5");
if(in_array($v,$trsl))
@mysqli_query($conn, "DELETE FROM slike WHERE slika=".safe($v)." AND idupisa=".$_POST['changepro']."");

}
}
else
if($i>0  and !in_array($v,$trsl) and $v!=$gls) {

mysqli_query($conn, "INSERT INTO slike SET slika=".safe($v).", idupisa=".$_POST['changepro'].", pozicija=$i, tip=5");

@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/'.$v, $page_path2.'/galerija/'.$v);
@rename($page_path2.'/temp/'.$_SESSION['userid'].'/'.session_id().'/thumb/'.$v, $page_path2.'/galerija/thumb/'.$v);
}
}
}
}
if($_POST['uvaluti']==1) $cena=$_POST['cena']*$settings['kurs_evra'];
else
$cena=$_POST['cena'];
if($_POST['novoli']==0) $novoli=", novo=1, izdvojeni=0"; else $novoli=", novo=0, izdvojeni=1";
$novic .="cena=$cena";
$novic .=", uvaluti=".safe($_POST['uvaluti']);
$novic .=", nova_cena_dostave=".safe($_POST['dostava']);
$novic .=", brend=".safe($_POST['brendovi']);
$novic .=", link=".safe($_POST['link']);
//$novic .=", limit_dostave=".safe($_POST['limdo']);
//$novic .=", fiksna_dostava=".safe($_POST['fido']);
$novic .=", vegan=".safe($_POST['bedo']);
$novic .=", time=".time();
$novic .=", prodavac=".safe($_POST['prodavac']);
if(isset($_POST['images']) and count($_POST['images'])>0)
$novic .=", nepotpun_filter=0";
else
$novic .=", nepotpun_filter=1";
mysqli_query($conn, "UPDATE pro SET $novic$npol$novoli$slikePRO WHERE id=".safe($_POST['changepro']));
$idzad=$_POST['changepro'];
if($idzad>0)
{
if($_POST['kat3']>0) $kategorija=$_POST['kat3'];
else if($_POST['kat2']>0) $kategorija=$_POST['kat2'];
else
if($_POST['kat1']>0) $kategorija=$_POST['kat1'];
mysqli_query($conn, "DELETE FROM kat_pro WHERE pro='$idzad'");
mysqli_query($conn, "INSERT INTO kat_pro SET kat=".safe($kategorija).", pro='$idzad'");
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 {
$naslov="naslov$la1[jezik]";
$opis="opis$la1[jezik]";
$keyword="keywords$la1[jezik]";
$nazivis = "lang='$la1[jezik]',  naslov=".safe($_POST[$naslov]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", keywords=".safe($_POST[$keyword]);
 mysqli_query($conn, "UPDATE prol SET $nazivis WHERE id_text='$idzad'");
}

if(isset($_POST['ife']) and $_POST['ife']>0){
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='".$_POST["filt$i"]."', id_pro='$idzad'");
}
}


if(isset($_POST['images']) and count($_POST['images'])>0){
foreach($_POST['images'] as $ke => $v){
mysqli_query($conn, "UPDATE slike SET pozicija=$ke WHERE slika=".safe($v)." AND idupisa=$idzad");

}
}
$ende=1;
$msgr="Proizvod je uspešno izmenjen!";
echo $bbb;
}
}
}

if((isset($_POST['rotiraj_c'])) and isset($_SESSION['userid']))
{
$slika=$_POST['slika'];
$folder='galerija';
$img=$page_path2."/".$folder."/".$slika;
$img_thumb=$page_path2."/".$folder."/thumb/".$slika;

rotiraj($img, $_POST['rotiraj_c']);
rotiraj($img_thumb, $_POST['rotiraj_c']);

echo "<img src='$patH/$folder/thumb/$slika?".time()."'>";
}

if((isset($_POST['rotiraj'])) and isset($_SESSION['userid']))
{
$slika=$_POST['slika'];
$folder='temp/'.$_SESSION['userid'].'/'.session_id();
$img=$page_path2."/".$folder."/".$slika;
$img_thumb=$page_path2."/".$folder."/thumb/".$slika;

rotiraj($img, $_POST['rotiraj']);
rotiraj($img_thumb, $_POST['rotiraj']);

echo "<img src='$patH/$folder/thumb/$slika?".time()."'>";
}
if((isset($_POST['delete_c'])) and isset($_SESSION['userid']))
{
$dev=explode("#",$_POST['delete_c']);
$Tab=$dev[0];
$TabId=$dev[1];
$slika=strip_tags($_POST['slika']);

if($Tab=='slike') {

mysqli_query($conn, "DELETE FROM slike WHERE id=".safe($TabId));
}
elseif($Tab=='pro')
mysqli_query($conn, "UPDATE pro SET slika=NULL WHERE id=".safe($TabId));
@unlink($page_path2."/galerija/".$slika);
@unlink($page_path2."/galerija/thumb/".$slika);
}

if((isset($_POST['delete_pro'])) and isset($_SESSION['userid']))
{

$TabId=$_POST['delete_pro']*1;
if($TabId>0){
$v=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa=".safe($TabId));
while($v1=mysqli_fetch_assoc($v)){
@unlink($page_path2."/galerija/".$v1['slika']);
@unlink($page_path2."/galerija/thumb/".$v1['slika']);
}
mysqli_query($conn, "DELETE FROM slike WHERE idupisa=".safe($TabId));

$v=mysqli_query($conn, "SELECT * FROM pro WHERE id=".safe($TabId));
while($v1=mysqli_fetch_assoc($v)){
@unlink($page_path2."/galerija/".$v1['slika']);
@unlink($page_path2."/galerija/thumb/".$v1['slika']);
@unlink($page_path2."/galerija/".$v1['slika1']);
@unlink($page_path2."/galerija/thumb/".$v1['slika1']);
}
mysqli_query($conn, "DELETE FROM pro WHERE id=".safe($TabId));

mysqli_query($conn, "DELETE FROM pro WHERE id_text=".safe($TabId));
}
}

if(isset($_POST['ocena'])) {
$oce=explode("-",$_POST['ocena']);
if(isset($_SESSION['ocenjeno'.$oce[1]]))
echo "Već ste ocenili ovaj proizvod!";
else {

$fax=mysqli_query($conn, "SELECT * FROM pro WHERE id=".$oce[1]);
$fx1=mysqli_fetch_assoc($fax);
if(strlen($fx1['ocena'])>2)
{
$soce=explode("-",$fx1['ocena']);
$ocenaplus =$soce[0]*1;
$ocenaplus +=$oce[0];
$ocenacount=$soce[1]*1;
$ocenacount +=1;
$zajedno="$ocenaplus-$ocenacount";
} else
$zajedno=$oce[0]."-1";
mysqli_query($conn, "UPDATE pro SET ocena='$zajedno' WHERE id=".$oce[1]);
$_SESSION['ocenjeno'.$oce[1]]=1;
echo "Hvala Vam što ste ocenili ovaj proizvod!";
}
}

if(isset($_POST['add_email'])) 
{ 
if($_POST['email']=="") 
echo "0##Niste upisali email adresu ! ! !";
else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
echo "0##Email adresa nije validna";
else 
{ 
$zizi=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe(strip_tags($_POST['email']))."")); 
if($zizi>0) 
echo '0##<script language="javascript">alert("Email koji ste upisali već postoji u našoj bazi!")</script>';
else 
{
mysqli_query($conn, "INSERT INTO subscribers SET email=".safe(strip_tags($_POST['email'])).", time='".time()."'"); 
echo '1##<script language="javascript">alert("Email je uspisan u našu bazu. Hvala Vam! :)")</script>';
} 
} 
}
if(isset($_POST['iskljucipopup']) and $_POST['iskljucipopup']==1)
{
setcookie(
  "iskljucipopup",
  "1",
  time() + (2 * 60 * 60)
);
}



if(isset($_POST['obavestime']) and strlen($_POST['obavestime'])>4) {
$ni=mysqli_query($conn, "SELECT * FROM obavestenja_proizvod WHERE email=".safe($_POST['obavestime'])." AND pro=".safe($_POST['pro']));
$nin=@mysqli_num_rows($ni);
if (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $_POST['obavestime']))
{
echo "Email adresa nije validna!";

} else
if($nin>0)
echo "Već ste pohvali zahtev da dobijete obaveštenje za ovaj proizvod!";
else
{
mysqli_query($conn, "INSERT INTO obavestenja_proizvod SET email=".safe($_POST['obavestime']).", pro=".safe($_POST['pro']).", datum='".date("Y-m-d H:i:s")."'");



$aaa=sprintf($langa['obavestmsg'][0], $_POST['obavestime'],  $_POST['link'], $_POST['naziv'], $patH1, $domen);
$aaa1=strip_html_tags($aaa);
$subject="Zahtev za obavestenjem - ".$_POST['naziv'];
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);

echo 1;
}
}

if(isset($_POST['tips']) and $_POST['tips']=="obavesti" and $_POST['id']>0) {
$fi=mysqli_query($conn, "SELECT *, p.id as id, o.id as ido
FROM  pro p
INNER JOIN prol pl ON pl.id_text=p.id
INNER JOIN obavestenja_proizvod o ON o.pro=p.id
WHERE pl.lang='rs' AND o.id=".safe($_POST['id']));
$nin=mysqli_fetch_assoc($fi);

mysqli_query($conn, "UPDATE obavestenja_proizvod SET obavesten=1 WHERE id=".safe($_POST['id'])."");



$aaa=sprintf($langa['obavestOpis'],  "<a href='$patH1/proizvodi/$nin[ulink]/'><img src='$patH/galerija/thumb/$nin[slika]'></a>", "<a href='$patH1/proizvodi/$nin[ulink]/'>".$nin['naslov'].'</a>', "<a href='$patH1/proizvodi/$nin[ulink]/'>LINK</a>", "<a href='$patH1'> $domen</a>");
$aaa1=strip_html_tags($aaa);
$subject=$langa['obavestSubj']." ".$nin['naslov'];
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $nin['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1);

echo 1;

}


if(isset($_POST['delnal']) and $_SESSION['userid']>0) 
{ 
$di=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".$_SESSION['userid'].""); 
$di1=mysqli_fetch_assoc($di); 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"])) 
{ 
unlink($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"]); 
unlink($page_path2.SUBFOLDER.GALFOLDER."/thumb/".$di1["civi1"]); 
} 
$uh=mysqli_query($conn, "SELECT * FROM users_slike WHERE user_id=$_SESSION[userid] ORDER BY id DESC"); 
while($uh1=mysqli_fetch_assoc($uh)) 
{ 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$uh1["slika"])) 
{ 
unlink($page_path2.SUBFOLDER.GALFOLDER."/".$uh1["slika"]); 
unlink($page_path2.SUBFOLDER.GALFOLDER."/thumb/".$uh1["slika"]); 
} 
} 
mysqli_query($conn, "DELETE FROM users_data WHERE user_id=$_SESSION[userid]"); 
mysqli_query($conn, "DELETE FROM users_slike WHERE user_id=$_SESSION[userid]"); 
unset($_SESSION); 
header("location: $patH1"); 
}
if($_POST['posalji']) 
{
include("$page_path2/private/include/class.phpmailer.php");
//if($_POST[imes]=="" or $_POST[emails]=="" or $_POST[obraz]=="" or $_POST[telefon]=="" or $_POST['captcha']=="") 
//$msgr=$arrwords['prazna_polja'];else 
if($_SESSION["captcha"]!=$_POST["captcha"]) 
//$msgr=$arrwords['pogresan_kod']; 
{ 
?> 
<script> 
$( document ).ready(function() { 
alert("<?php echo $arrwords['pogresan_kod']; ?>"); 
});
</script> 
<?php 
} 
else 
/*if(filter_var(trim($_POST[emails]), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$arrwords['email_novalid']; 
else*/ 
{ 
$vreme=date("d-m-Y H:i:s", time()); 
$zaslanje=" 
Poslato u $vreme<br><br> 
Poruka sa Vašeg sajta Amazonka.rs
<br><br> 
<br>Naslov: $_POST[imes] 
<br>Email: $_POST[emails] 
<br>Telefon: $_POST[telefon] 
<br>Poruka:<br>".nl2br($_POST['obraz'])." 
";
$mail = new phpmailer(); 
$mail->Mailer   = "mail"; 
$subject="Nova poruka sa sajta Amazonka.rs - ".date("d-m-Y-H:i"); 
$mail->From     = $settings['from_email']; 
$mail->FromName = "Amazonka"; 
$mail->Subject = "$subject"; 
$mail->AddReplyTo($_POST['emails'],$_POST['imes']); 
// $mail->Mailer   = "mail"; 
$mail->Body    = $zaslanje; 
$mail->AltBody = ""; 
if($settings['email_zaemail']!="") 
$mail->AddAddress($settings['email_zaemail']); 
if($settings['email_zaemail1']!="") 
$mail->AddAddress($settings['email_zaemail1']);  if($mail->Send()) 
$msgr=$arrwords['poslata_poruka']; 
?> 
<script> 
$( document ).ready(function() { 
alert("<?php echo $arrwords['poslata_poruka']; ?>"); 
});
</script> 
<?php 
} 
}

/***************** activate account ********************/ 
if(isset($sarray['activate']) and $sarray['activate']!="") 
{
$test=$sarray['activate'];        $ch=mysqli_query($conn, "SELECT * FROM users_data WHERE randkod=".safe($test,1)." AND akt='N'"); 
$ch1=mysqli_fetch_array($ch);         
if(mysqli_num_rows($ch)==1) 
{ 
mysqli_query($conn, "UPDATE users_data SET akt='Y' WHERE user_id='$ch1[user_id]'"); 
$linka="<a href='".$patH1."/".$all_links[10]."/?autolog=$ch1[randkod]'>".$patH1."/".$all_links[10]."/?autolog=$ch1[randkod]</a>"; 
$akti_tekst=sprintf($arrwords2['akti_tekst'], $ch1['ime'], $patH1."/".$all_links[10]."/", $linka, $patH1, $domen); 
$akti_tekst1=strip_html_tags($akti_tekst); 
send_email("mail", $ch1['email'], $settings["from_email"], $settings["from_email"], $langa['regform'][38], $from_name, $akti_tekst, $akti_tekst1);  $msl=$langa['regform'][35]; 
 $green="_green"; 
}else 
{ 
$msl=$langa['regform'][36]; 
} 
}
/***************** autolog ********************/ 
if(isset($sarray['autolog']) and $sarray['autolog']!="") 
{
$test=$sarray['autolog'];        $ch=mysqli_query($conn, "SELECT * FROM users_data WHERE randkod=".safe($test,1)." AND akt='Y'"); 
$ch1=mysqli_fetch_array($ch);         
if(mysqli_num_rows($ch)==1) 
{  
 $_SESSION['email'] = $ch1['email']; 
   $_SESSION['password'] = tep_encrypt_password($ch1['password']);  
    $_SESSION['korisnik'] =  $ch1['ime']; 
    $_SESSION['userid'] = $ch1['user_id'];    
   $_SESSION['username'] = $ch1['nickname']; 
header("location: $patH1/");  
}
else 
{ 
$msgr=$langa['regform'][37]; 
} 
}
/*************************** contact ***********************/ 
if($_POST['contact_send']) 
{
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$korime=ifempty($_POST['korime']); 
$email = ifempty($_POST['email']); 
$tekst = ifempty($_POST['tekst']); 
if($korime=="" || $email=="" || $tekst=="" || $number=="") 
$msgr=$langa['regform'][28]; 
else if($key!=$number) 
$msgr=$langa['regform'][29]; 
elseif(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$langa['regform'][16]; 
else   
{ 
$aaa=sprintf($langa['contform'][5],$domen, datef("",2), $korime, $email, $tekst); 
$subject=$langa['contform'][6]." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['contform'][6];
$send_email=send_email("mail", $Adminmail, $from_email, $_POST['email'], $subject, $from_name, $aaa, ""); 
if($send_email==1) 
$msgr=$langa['contform'][7]; 
else 
$msgr=$langa['regform'][39]; 
}  
} 
/********************** forgot password old version ****************************/
if($_POST['forgot_password_OLD'])
{
$email = ifempty($_POST['email']);
if($email=="")
$msgr=$arrwords['niste_ispunili'];
else
if(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)
$msgr=$arrwords['email_novalid'];
else
{
$q=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email)."");
if(mysqli_num_rows($q)==1){
$gigi=mysqli_fetch_assoc($q);
$vreme=time();
$email=$_POST['email'];
$nova=base64_encode(gen_rand().$vreme);
$nova1=strtolower(substr($nova,0,8));
$pas=tep_encrypt_password($nova1);
$subject=$arrwords2['nova_sifra2']." - ".$domen." - ".date("Y-m-d");
$from_name=$domen;
$aaa=sprintf($arrwords2['nova_sifra5'], $gigi['ime'], $nova1, $patH1, $domen);
$aaa1=strip_html_tags($aaa);
$send_email=send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"],$subject, $from_name, $aaa, $aaa1);
if($send_email==1)
{
mysqli_query($conn, "UPDATE users_data SET password='$pas' WHERE email=".safe($_POST['email'],1)."");
$msgr=$arrwords2['nova_sifra'];
} else
$msgr=$arrwords2['nova_sifra3'];
} else $msgr=$arrwords2['nova_sifra4'];
}
}
/********************** forgot password  ****************************/
if($_POST['forgot_password']) 
{ 
$email = ifempty($_POST['email']);  
if($email=="") 
$msgr=$arrwords['niste_ispunili']; 
else 
if(filter_var(trim($email), FILTER_VALIDATE_EMAIL)===false)  
$msgr=$arrwords['email_novalid']; 
else 
{ 
$q=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($email).""); 
if(mysqli_num_rows($q)==1){ 
$gigi=mysqli_fetch_assoc($q); 
$vreme=time(); 
$email=$_POST['email']; 
$randi=gen_rand();
$linka="<a href='".$patH1."/".$all_links[19]."/?renew=".$randi."'>".$patH1."/".$all_links[19]."/?renew=".$randi."</a>";
$subject=$arrwords2['nova_sifra2']." - ".$domen." - ".date("Y-m-d"); 
$from_name=$domen;  
$aaa=sprintf($arrwords2['nova_sifra5'], $gigi['ime'], $linka, $patH1, $domen);
$aaa1=strip_html_tags($aaa); 
$send_email=send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"],$subject, $from_name, $aaa, $aaa1);   
if($send_email==1) 
{ 
mysqli_query($conn, "UPDATE users_data SET renew='$randi', renew_time='".date("Y-m-d H:i:s")."' WHERE email=".safe($_POST['email'],1)."");
$msgr=$arrwords2['nova_sifra']; 
} else 
$msgr=$arrwords2['nova_sifra3']; 
} else $msgr=$arrwords2['nova_sifra4']; 
} 
}


mysqli_query($conn, "UPDATE users_data SET renew=NULL, renew_time=NULL WHERE (CURRENT_TIMESTAMP()-renew_time) >3600");
$istekao_link_za_sifru=0;
if(isset($sarray['renew']) and $sarray['renew']!=''){
$fax=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users_data WHERE renew=".safe($sarray['renew']).""));
if($fax<1) {
$msgr="Link za kreiranje nove šifre je istekao. Zahtevajte novi link <a href='".$patH1."/".$all_links[19]."/'>ovde</a>";
$istekao_link_za_sifru=1;
}
}

if(isset($_POST['renew-pass']) and strlen($_POST['renew-pass'])==15)
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE renew=".safe($_POST['renew-pass'])."");
$fx1=mysqli_fetch_assoc($fax);
if($fx1['user_id']>0) {
if($_POST['password']=="" or $_POST['password1']=="")
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{

$msgr=$arrwords2['sifre_nejednake'];
} else {
$password_crypted = tep_encrypt_password(strip_tags($_POST['password']));
mysqli_query($conn, "UPDATE users_data SET password='$password_crypted' WHERE renew=".safe($_POST['renew-pass'])."");
$msgr="Nova šifra je uspešno postaljena. Možete se ulogovati <a href='".$patH1."/".$all_links[10]."/'>ovde</a>";
}
}
}

/******************* users login ***************************/ 
if(isset($_POST['sublogin'])){
   if(!$_POST['email'] || !$_POST['pass']) 
     $msgr=$langa['regform'][28];       
    else{
   $_POST['email'] = trim($_POST['email']);
   //$md5pass = md5($_POST['pass']); 
   $md5pass = trim($_POST['pass']);
   $result = confirmUser($_POST['email'], $md5pass);     if($result == 1 or $result == 2){ 
    $msgr=$langa['login'][7];
   }  
    else {
   $_POST['email'] = stripslashes($_POST['email']); 
   $_SESSION['email'] = $_POST['email']; 
   $_SESSION['panel'] = $_POST['panel']; 
   $_SESSION['password'] = tep_encrypt_password($md5pass);  
   $qi = "select * from users where email = '".$_SESSION['email']."'"; 
   $resulti = mysqli_query($conn, $qi,$conn); 
   $dbarrayi = mysqli_fetch_assoc($resulti); 
   $_SESSION['userid'] = $dbarrayi['user_id']; 
   $_SESSION['username'] = $dbarrayi['username']; 
  $ni = mysqli_query($conn, "select * from adrese where id_user = '".$dbarrayi['user_id']."'"); $ni1=mysqli_fetch_array($ni); 
   $_SESSION['name'] = $ni1['name']; 
   //mysqli_query($conn, "UPDATE users SET updatecode='Y' WHERE user_id='$dbarrayi[user_id]'",$conn); 
   setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/"); 
   /* 
   Opcija zapamti me 
    */ 
   if(isset($_POST['remember'])){ 
      setcookie("ipcookname", $_SESSION['email'], time()+60*60*24*100, "/"); 
      setcookie("ipcookpass", $_SESSION['password'], time()+60*60*24*100, "/"); 
	  setcookie("ipcookid", $_SESSION['userid'], time()+60*60*24*100, "/"); 
   } 
 if($_SESSION['findurl']!=""){ 
 header("location: $_SESSION[findurl]"); 
 unset($_SESSION['findurl']); 
 } 
 else 
 header("location: $patH/users/$_SESSION[username]/"); 
} 
} 
}

/******************** send abuse **********************/ 
if($_POST['send_abuse'] and isset($_SESSION['userid'])) 
{  
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['naslov']); 
$message = ifempty($_POST['poruka']); 
$idd = @preg_replace('#[^0-9]#i', '',$_GET['sendto']); 
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$idd"); 
$ze1=mysqli_fetch_array($ze);   
if($naslov=="" || $message==""/* || $number==""*/) 
$msgr=$langa['regform'][28]; 
else   
{
$msgr=$langa['messag'][33]; 
$korime=$ze1['ime'];  
$userlink="$patH1/$all_links[11]/".$ze1['nickname']."/"; 
$aaa=sprintf($langa['messag'][35], $userlink, $korime, $naslov, $domen, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=$langa['messag'][34]." - ".$domen; 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
}
}

if(isset($_POST['iduKom']) and $_POST['iduKom']>0) {

$uzk=mysqli_query($conn, "SELECT * FROM komentari WHERE id=".$_POST['iduKom']."");
$uzk1=mysqli_fetch_assoc($uzk);

$status = array(
		'ime'=>$uzk1['ime'],
		'email'=>$uzk1['email'],
    'komentar'=>$uzk1['komentar']
	);
}
/******************** send komentar za proizvod **********************/ 
if(isset($_POST['send_komentar']) and !mb_eregi('pop3.printemailtext.com', $_POST['email']) and !mb_eregi('pop.printemailtext.com', $_POST['email'])) 
{ 
$tipVrati='error';
$capcha_greska = 0;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = file_get_contents_curl('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success){} else
        $capcha_greska = 1;

      }


$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']);  
if($message=="" or $naslov=="" or (empty($_POST['g-recaptcha-response']) and !isset($_SESSION['userids'])))
$msgr=$arrwords['niste_ispunili1']; 
elseif($capcha_greska==1)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili!";
else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
if(mb_eregi('http', $_POST['poruka'])) 
$msgr="Koristite nedozvoljeni sadržaj u komentaru!"; 
else 
{
if(isset($_POST['id_parent']) and $_POST['id_parent']>0)
$idparent="id_parent=".safe($_POST['id_parent']).", ";
else
$idparent="";
if(!mysqli_query($conn, "INSERT INTO komentari SET 
komentar =".safe($message).",   
akt=0, 
id_pro=$_POST[idpro],
$idparent
ime='$naslov', 
email='$sendto'
")) echo mysqli_error(); 
$zid=mysqli_insert_id($conn); 
if($zid>0) 
{ 
$sz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide 
        FROM pro p 
        INNER JOIN prol pt ON p.id = pt.id_text 
        WHERE pt.lang='$lang' AND p.akt=1 AND p.prodato=0 AND p.id=$_POST[idpro]"); 
$sz1=mysqli_fetch_array($sz); 
if($sz1['tip']==4) 
$zalink=$all_links[2]; 
else 
$zalink=$all_links[3]; 


$msgr=$langa['profme'][14]; 
$tipVrati='success';

$userlink="$patH1/$zalink/".$sz1['ulink']."/"; 
$userlink=str_replace("https://www.amazonka.rs/https://www.amazonka.rs","https://www.amazonka.rs",$userlink);
$aaa=sprintf($langa['messag'][53], $naslov,  $userlink, $sz1['naslov'], $patH1, $domen); 
$aaa1=strip_html_tags($aaa);  
$subject=$langa['messag'][54]." - ".$sz1['naslov']; 
$from_name=$domen." - ".$langa['from_site'][0];   
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 

}  
}
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
}
/******************** send komentar za blog **********************/ 
if(isset($_POST['send_komentar1']) and !mb_eregi('pop3.printemailtext.com', $_POST['email']) and !mb_eregi('pop.printemailtext.com', $_POST['email']))
{   
$tipVrati='error';
 $capcha_greska = 0;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = file_get_contents_curl('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success){} else
        $capcha_greska = 1;

      }

$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']);  

if($message=="" or $naslov=="" or (empty($_POST['g-recaptcha-response']) and !isset($_SESSION['userids'])))
$msgr=$arrwords['niste_ispunili1']; 
elseif($capcha_greska==1)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili!";
else 

if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
if(mb_eregi('http', $_POST['poruka'])) 
$msgr="Koristite nedozvoljeni sadržaj u komentaru!"; 
else 
{
if(isset($_POST['id_parent']) and $_POST['id_parent']>0)
$idparent="id_parent=".safe($_POST['id_parent']).", ";
else
$idparent="";

if(!mysqli_query($conn, "INSERT INTO komentari SET 
komentar =".safe($message).",   
akt=0, 
tip=1, 
id_pro=$_POST[idpro], 
$idparent
ime='$naslov', 
email='$sendto'
")) echo mysqli_error(); 
$zid=mysqli_insert_id($conn); 
if($zid>0) 
{ 
$sz=mysqli_query($conn, "SELECT p.*, pt.* 
        FROM pages_text p 
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text         
        WHERE pt.lang='$lang' AND p.prodato=0 AND p.akt='Y'  AND p.id=$_POST[idpro]");          
$sz1=mysqli_fetch_array($sz); 
$zalink=$patH1."/".$page1["ulink"]."/".$sz1["ulink"]; 

$msgr=$langa['profme'][14]; 
$tipVrati='success';

$userlink="$patH1/$zalink/".$sz1['ulink']."/"; 
$userlink=str_replace("https://www.amazonka.rs/https://www.amazonka.rs","https://www.amazonka.rs",$userlink);
$aaa=sprintf($langa['messag'][53], $naslov,  $userlink, $sz1['naslov'], $patH1, $domen);  
$aaa1=strip_html_tags($aaa); 
$subject=$langa['messag'][54]." - ".$sz1['naslov']; 
$from_name=$domen." - ".$langa['from_site'][0];
send_email("mail", $settings['email_zaemail'], $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
}  
} 
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
}
/******************** IZMENA komentara **********************/ 
if(isset($_POST['izmena_komentara']) and $_POST['izmena_komentara']>0) 
{ 
$tipVrati='error';
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number']; 
$naslov = ifempty($_POST['ime']); 
$message = ifempty($_POST['poruka']); 
$sendto= strip_tags($_POST['email']); 
if($message=="" or $naslov=="") 
$msgr=$arrwords['niste_ispunili1'];  else 
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false) 
$msgr=$arrwords['email_novalid']; 
else 
{
if(!mysqli_query($conn, "UPDATE komentari SET 
komentar =".safe($message).", 
ime='$naslov', 
email='$sendto' 
WHERE id=$_POST[izmena_komentara] 
")) echo mysqli_error();

 $msgr="Izmena je izvrsena!"; 
$tipVrati='success';

}
$status = array(
		'type'=>$tipVrati,
		'message'=>$msgr
	);
} 
if(isset($_POST['tip']) and $_POST['tip']=="akomentar" and isset($_SESSION['userids'])) 
{   
$gel=mysqli_query($conn, "SELECT * FROM komentari WHERE id=".safe(strip_tags($_POST['id'])).""); 
$ge1=mysqli_fetch_array($gel); 
if($ge1['akt']==0) $nak=1; else $nak=0; 
mysqli_query($conn, "UPDATE komentari SET akt=$nak WHERE id=".safe(strip_tags($_POST['id'])).""); 
}
/*$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'; 
if($pageWasRefreshed ) { 
 echo "Yes"; 
} else { 
   echo "No"; 
} 
*/ 
/******************** kontak forma send messages **********************/ 
if($_POST['kontakt_send'] and isset($_SESSION['userid'])) 
{  
$key=substr($_SESSION['keys'],0,5); 
$number = $_POST['number'];   
$naslov = ifempty($_POST['name']); 
$sendto = ifempty($_POST['email']); 
$subject= strip_tags($_POST['subject']); 
$message ="<b>$subject</b><br>Ime: $naslov<br>Email: $sendto<br><br>"; 
$message .= $_POST['message'];  
if($naslov=="" || $message=="" or $sendto=="" or $subject==""/* || $number==""*/) 
$msre=$langa['regform'][28]; 
else   
{ 
$aaa1=strip_html_tags($message); 
$zasend=$subject." - ".$domen." - ".datef("us",1); 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $ge1['email'], $from_email, $sendto, $zasend, $from_name, $message, $aaa1); 
$msre=$langa['messag'][15];  
$grin="_green"; 
} 
}

/*************** Del kom *********************/ 
if(isset($_POST['tip']) and $_POST['tip']=="del_kom" and $_POST['id']>0  and isset($_SESSION['userids'])) 
{ 
if(!mysqli_query($conn, "DELETE FROM komentari WHERE id=".strip_tags($_POST['id'])."")) echo mysqli_error(); 
} 
/******************** send porudzbine **********************/
$load_nestpay_form=0;
if(isset($_POST['naruci_log']) and !isset($_SESSION[$sid])) 
{ 
$msgr="Vaša porudžbina je već prosleđena i korpa je ispražnjena!"; 
$hider="style='display:none;'"; 
} 
else 
if(isset($_POST['naruci_log']) and isset($_SESSION[$sid]) and count($_SESSION[$sid])>0)
{
$capcha_greska = 2;
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
      {
function get_page($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}
 //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LczURcUAAAAAJPa4yrrqp6B1sQM3tfKgGXEXaK2&response='.$_POST['g-recaptcha-response']);
 $verifyResponse = get_page('https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_skriveni'].'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){} else
        $capcha_greska = 1;
      }
if(isset($_SESSION['userid']) and $_SESSION['userid']>0 and $_POST['naruci_log']==1 and $_POST['opsti_uslovi']=="")
$msgr=$arrwords['niste_ispunili'];
else
if(($_POST['ime']=="" or $_POST['email']=="" or $_POST['posta']=="" or $_POST['adresa']=="" or $_POST['telefon']=="" or $_POST['grad']=="" or $_POST['nacin']=="" or $_POST['opsti_uslovi']=="") and $_POST['naruci_log']==2) 
$msgr=$arrwords['niste_ispunili']; 
else
if(isset($_POST['g-recaptcha-response']) && empty($_POST['g-recaptcha-response']) and $_POST['naruci_log']==2)
$msgr="Čekirajte da niste robot!";
elseif($capcha_greska==1 and $_POST['naruci_log']==2)
$msgr="Proverite da li ste čekirali da niste robot i da li ste sve precizno ispunili u tom delu!";
else if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false and $_POST['naruci_log']==2) 
$msgr=$arrwords['email_novalid']; 
else 
{ 
$addItems=""; 
$addTrans="";

// placanje karticom
if(isset($_POST['nacin']) and $_POST['nacin']==4)
{
if(isset($_SESSION['userid']) and $_SESSION['userid']>0)
{
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid]");
$ze1=mysqli_fetch_array($ze);
$ime=$ze1['ime'];
$posta=$ze1['postanski_broj'];
$grad=$ze1['grad'];
$pib=$ze1['pib'];
$adresa=$ze1['ulica_broj'];
$email=$ze1['email'];
$telefon=$ze1['telefon'];
$usid=$_SESSION['userid'];
}
else
{
$ime=$_POST['ime'];
$posta=$_POST['posta'];
$grad=$_POST['grad'];
$pib=$_POST['pib'];
$adresa=$_POST['adresa'];
$email=$_POST['email'];
$telefon=$_POST['telefon'];
$usid=0;
} $ukupno=0;
$arti=array();
foreach($_SESSION[$sid] as $key => $value)
{
$cena_sum=0;
$sum=0;
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.prodato=0 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
/*if($az1['cena1']>0 and $az1['akcija']==1)
$cenar=$az1['cena1'];
else*/
$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
$arti[]=$key."-".$value;
}
}
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$ukupno_promo=$ukupno-$_SESSION['promo-kod']['vrednost_koda'];
$ukupno_promo=sprintf("%4.2f",$ukupno_promo);
$idpromo=$_SESSION['promo-kod']['id'];
}
else {
$ukupno_promo=0;
$idpromo=0;
}
$ukupno=sprintf("%4.2f",$ukupno);
$kod_kupovine=implode("#",$arti); $driv=mysqli_query($conn, "SELECT * FROM privremena WHERE sid='".$sid."' AND kod_kupovine='$kod_kupovine' AND status=0 AND datum='".date("Y-m-d")."'");
$driv1=mysqli_num_rows($driv);
if($driv1==0)
{
$priv=mysqli_query($conn, "SELECT * FROM privremena ORDER BY id DESC");
$priv1=mysqli_fetch_array($priv);
 $trid=explode("-",$priv1['trackid']);
 $ntrid=end($trid)*1+1;
 $TrackId = "ABizNet-$ntrid";
	  $sql = "insert into privremena(usid, ime, mejl, telefon, adresa, grad, pib, sid, trackid,kod_kupovine, vreme, datum, poruka, nacin_kupovine, trantype, iznos, ukupnosve, iznos_sa_kodom, idpromo)
	          values('$usid', ".safe($ime).", ".safe($email).", ".safe($telefon).", ".safe($adresa).", ".safe($grad).", ".safe($pib).", '".$sid."', '$TrackId', '$kod_kupovine', '".time()."', '".date("Y-m-d")."', ".safe($_POST['poruka']).", ".safe(preg_replace('/\d/', '', $_POST['isporuka'])).", trantype='PreAuth', ".safe($ukupno).", ".safe($ukupno).", ".safe($ukupno_promo).", ".safe($idpromo).")";
if(!mysqli_query($conn, $sql)) echo mysqli_error();
$zid=mysqli_insert_id($conn);
if($zid>0)
{
foreach($_SESSION[$sid] as $key => $value)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.prodato=0 AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
mysqli_query($conn, "INSERT INTO privremena_pro SET sid='".$sid."', trackid='$TrackId', idpro='$key', naziv='$az1[naslov]', cena='".roundCene($az1['cena'],1)."', kolicina='$value'");
}
$load_nestpay_form=1;  }
}
else if($driv1>0)
{
$priv=mysqli_query($conn, "SELECT * FROM privremena WHERE sid='".$sid."' AND kod_kupovine='$kod_kupovine' AND status=0 AND datum='".date("Y-m-d")."' ORDER BY id DESC");
$priv1=mysqli_fetch_array($priv);
$TrackId = $priv1['trackid']; 
$load_nestpay_form=1;
} if($load_nestpay_form==1) {
 $domen="$patH1/intesa";
     $orgClientId  =   "13IN060589";
      $orgOid =    $TrackId;
      $storeK="AOou04453";
    if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
      $orgAmount =  $ukupno_promo;
      else
      $orgAmount =  $ukupno;
      $orgOkUrl =  "$domen/Receipt.php";
      $orgFailUrl =  "$domen/Receipt.php";
      $orgTransactionType = "PreAuth";
      $orgInstallment = "";
      $orgRnd =  microtime();
 $orgRnd=str_replace(" ","",$orgRnd);
      $orgCurrency = "941";
$instalment='';
    $clientId  =  str_replace("|", "\\|", str_replace("\\", "\\\\", $orgClientId));
      $oid =   str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOid));
      $amount = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgAmount));
      $okUrl =  str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOkUrl));
      $failUrl = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgFailUrl));
      $transactionType = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgTransactionType));
      $installment = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgInstallment));
      $rnd = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgRnd));
$currency =   str_replace("|", "\\|", str_replace("\\", "\\\\", $orgCurrency));
   $storeKey =  str_replace("|", "\\|", str_replace("\\", "\\\\", $storeK)); $plainText = $clientId . "|" . $oid . "|" . $amount . "|" . $okUrl . "|" . $failUrl . "|" .$transactionType . "||" . $rnd . "||||" . $currency . "|" . $storeKey;
 $hashValue = hash('sha512', $plainText);
 $hash = base64_encode (pack('H*',$hashValue));
 $sakrij="";
 }
}
else
if($_POST['naruci_log']==2) 
{
$ime=$_POST['ime']; 
$posta=$_POST['posta']; 
$grad=$_POST['grad']; 
$pib=$_POST['pib']; 
$adresa=$_POST['adresa']; 
$email=$_POST['email']; 
$telefon=$_POST['telefon']; 
}
elseif($_POST['naruci_log']==1 and $_SESSION['userid']>0) 
{
$ze=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid]"); 
$ze1=mysqli_fetch_array($ze); 
$ime=$ze1['ime']; 
$posta=$ze1['postanski_broj']; 
$grad=$ze1['grad']; 
$pib=$ze1['pib']; 
$adresa=$ze1['ulica_broj']; 
$email=$ze1['email']; 
$telefon=$ze1['telefon'];  
}

// placanje kreditom
if(isset($_POST['nacin']) and $_POST['nacin']==5)
{
	
//uzima ukupnu vrednost racuna

$ukupno=0;
foreach($_SESSION[$sid] as $key => $value)  
{ 
$cena_sum=0;  
$sum=0; 
if($key>0) 
{ 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p 
        INNER JOIN prol pt ON p.id = pt.id_text 
        $inner_plus        
        WHERE pt.lang='$lang' AND p.prodato=0 AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");		

$az1=mysqli_fetch_assoc($az);
$prodavac=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$az1[prodavac]"));

$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$cena_sum_idost =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
}
}

$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
$mn1=mysqli_fetch_assoc($mn);	
$kredit = $mn1['kredit'];	

//proverava da li korisnik ima dovoljno sredstva na racunu	
if ($kredit < $ukupno) {	
echo '<script type="text/javascript">';	
echo $odgKredita = "Nemate dovoljno sredstava na racunu!";	
echo 'window.location.assign("<?php echo $patH1?>/<?php echo $all_links[18]?>/");';
echo '</script>';
return;	
}
else {
	
$kredit = $kredit -  $ukupno;
mysqli_query($conn, "UPDATE users_data SET kredit=$kredit WHERE user_id=$_SESSION[userid] AND akt='Y'");

// echo '<script type="text/javascript">'; 
// echo "alert('$kredit');";
// echo '</script>';
}	
}

if(isset($_POST['nacin']) and $_POST['nacin']!=4)
{
if(isset($_SESSION['userid']) and $_SESSION['userid']>0) 
$iuser="user_id=".$_SESSION['userid'].","; 
if(!mysqli_query($conn, "INSERT INTO porudzbine SET $iuser ime=".safe($ime).", adresa=".safe($adresa).", posta=".safe($posta).", grad=".safe($grad).", telefon=".safe($telefon).", email=".safe($email).", pib=".safe($pib).", nacin_placanja=".safe($_POST['nacin']).", nacin_isporuke=".safe(preg_replace('/\d/', '', $_POST['isporuka'])).", poruka=".safe($_POST['poruka']).", vreme='".time()."'")) echo mysqli_error();
$zid=mysqli_insert_id($conn) ; 
if($zid>0) 
{ 
$green="_green";  
$msgr=$langa['messag'][33];  $zasend='	 
<table style="width:100%;border-collapse:collapse;font-family:arial" border="1" cellpadding="4"> 
<tr><td>Broj porudzbine: </td><td align="left">'.$zid.'</td></tr> 
<tr><td>Datum porudzbine: </td><td align="left">'.date("d.m.Y H:s").'</td></tr> 
<tr><td>Ime i prezime: </td><td align="left">'.$ime.'</td></tr> 
<tr><td>Adresa (ulica i broj): </td><td align="left">'.$adresa.'</td></tr> 
<tr><td>Grad: </td><td align="left">'.$grad.'</td></tr> 
<tr><td>Email adresa: </td><td align="left">'.$email.'</td></tr>
<tr><td>PIB: </td><td align="left">'.$pib.'</td></tr>
<tr><td>Telefon: </td><td align="left">'.$telefon.'</td></tr> 
<tr><td colspan="2">Poruka:<br>'.$_POST['poruka'].' </td></tr> 
</table> 
<br> 
<table style="width:100%;border-collapse:collapse;font-family:arial" border="1" cellpadding="4"> 
<thead> 
 <tr><td colspan="6"><b>Poručeni proizvodi</b></td></tr>
<tr class="cart_menu"> 
<td class="image" align="left">Slika</td> 
<td class="description" align="left">Proizvod</td> 
<td class="description" align="left">Prodavac</td> 
<td class="price">Cena</td> 
<td class="quantity">Količina</td>
<td class="total">Svega</td> 
<th>Ukupno</td>
</tr> 
</thead> 
<tbody>'; 

if(isset($_SESSION[$sid])) 
{ 
$prodArr=array();
$ponisti_iznos_dostave=0;
foreach($_SESSION[$sid] as $key => $value)
{

if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);

$prodArr[$az1['prodavac']][]=roundCene($az1['cena'],1)*$value;
}
}

$ukupno=0; 
foreach($_SESSION[$sid] as $key => $value)  
{ 
$cena_sum=0;  
$sum=0; 
if($key>0) 
{ 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p 
        INNER JOIN prol pt ON p.id = pt.id_text 
        $inner_plus        
        WHERE pt.lang='$lang' AND p.prodato=0 AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");		

$az1=mysqli_fetch_assoc($az);
$prodavac=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$az1[prodavac]"));


$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$cena_sum_idost =roundCene($cenar,1)*$value;
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
if($az1['tip']==4) $zalink=$all_links[2];
elseif($az1['tip']==6) $zalink=$all_links[48];
else $zalink=$all_links[3];
//mysqli_query($conn, "UPDATE poruceno SET kupac=$_SESSION[userid] WHERE id_porudzbine=$zid");
if(!mysqli_query($conn, "INSERT INTO poruceno SET id_porudzbine=$zid, kupac=$_SESSION[userid], id_pro=$az1[ide], naziv=".safe($az1['naslov']).", prodavac=$az1[prodavac], cena='".$az1['cena']."', kolicina=$value")) echo mysqli_error();   
$zasend .='<tr> 
<td class="cart_product"> 
<a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/"> 
<img src="'.$patH.GALFOLDER.'/thumb/'.$az1['slika'].'" title="'.$az1['titleslike'].'"> 
</a> 
</td> 
<td class="cart_description"> 
<h4><a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/">'.$az1['naslov'].'</a></h4> 
<p>Web ID: '.$az1['ide'].'</p> 
</td> 
<td class="cart_merchant text-center">
<p>';
if($prodavac['nazivfirme']==Null)
$zasend .=($prodavac['ime']);
else
$zasend .=($prodavac['nazivfirme']);
$zasend .='</p>
</td>
<td class="cart_price text-center">
<p>'.format_ceneS($az1['cena'],2).'</p>
</td> 
<td class="product-quantity"> 
<div class="quantity buttons_added"> 
<input size="2" class="input-text qty text" title="Kolicina" value="'.$value.'" readonly min="1" step="1"> 
</div> 
</td>
<td class="cart_total text-center"> 
<p class="cart_total_price">'.formatCene($cena_sum,1).'</p>
</td> 
<td class="cart_total text-center">
<p class="cart_total_price">'.formatCene($cena_sum_idost,1).'</p>
</td>
</tr>'; 
/*if($az1['tip']==4) $catirG="Mobilni telefoni"; if($az1['tip']==6) $catirG="Televizori"; else $catirG="Oprema";
$addItems .=" _gaq.push(['_addItem', '$zid', '".$az1['ide']."','".str_replace("'","",$az1['naslov'])."','$catirG','".$az1['cena']."','$value' ]);\n\r";*/
} 
} 
}
/*$limdo=(int)$settings['limit_dostava'];
$dostava=(int)$settings['cena_dostave'];
if($ukupno<$limdo) $uku=str_replace(" RSD", "", formatCene($ukupno+$dostava,1));
else*/
$ukupno=str_replace(" RSD", "", formatCene($ukupno,1));
if($_POST['nacin']==1) $inacin='Plaćanje gotovinski/pouzećem'; 
else 
if($_POST['nacin']==2) {
$inacin='Uplata na račun';
$racun='<p>Podaci za uplatu:<br>
<table style="background:url(https://amazonka.rs/slike/nalog-za-uplatu.jpg); width:794px; height:366px; background-repeat:no-repeat;overflow:hidden;position:relative;">
<tr>
<td style="padding-left:30px;padding-top:50px;height:20px;width:50%;">'.$arrwords['podaci_uplatioca'].'</td>
<td style="padding-left:250px;padding-top:40px;height:20px;;">='.$ukupno.'</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding-left:40px;padding-top:18px;height:10px">'.$arrwords['tekuci_racun'].'</td>
</tr>
<tr>
<td style="padding-left:30px;padding-top:5px;height:10px;">'.$arrwords['narudzbina_preko_sajta'].$zid.'</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding-left:130px;padding-top:0px;height:10px">'.$zid.'</td>
</tr>
<tr style="vertical-align:top;">
<td style="padding-left:30px;padding-top:19px;">'.$arrwords['podaci_firme'].'</td>
<td>&nbsp;</td>
</tr>
</table>
';
}
elseif($_POST['nacin']==4) $inacin='Platna kartica';
elseif($_POST['nacin']==5) $inacin='Kredit';
else $racun=''; 
$zasend .='
<tr> 
    <td colspan="3"> 
    <h4>Nacin placanja:</h4> 
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:13px;">'.$inacin.'</p> 
    </td> 
</tr>
<!--
<tr> 
    <td colspan="3"> 
    <h4>Nacin isporuke:</h4>
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:13px;">'.preg_replace('/\d/', '', $_POST['isporuka']).'</p>
    </td> 
</tr>
-->
<tr> 
    <td colspan="3"> 
    <h4>UKUPAN IZNOS:</h4> 
    </td> 
    <td colspan="2"> 
    <p class="ukupno" style="font-size:16px;"><b>';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
  $zasend .="<span style='color:green;'>".formatCene($ukupno,1,$_SESSION['promo-kod']['vrednost_koda'])."</span><br>"."<span style='font-size:12px;'>(<del>".formatCene($ukupno,1)."</del>)</span>";
  else
  $zasend .=formatCene($ukupno,1);
  $zasend .='</b></p>
    </td> 
</tr>';
if($ukupno<$limdo) {
//$uku=$ukupno+$dostava;
$uku=$ukupno;
$zasend .='
<!--
<tr>
<td colspan="3">Troškovi dostave</td>
<td colspan="2">'.formatCene($dostava,1).'</td>
</tr>
-->
<tr>
<td colspan="3"><h3>UKUPNO ZA PLAĆANJE</h3></td>
<td colspan="2"><h3>'.formatCene($uku,1).'</h3></td>
</tr>
';
}

/*if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']!="")
$zasend .='<tr>
    <td colspan="4">
    <h4>UKUPAN IZNOS sa promo kodom:</h4>
    </td>
    <td colspan="2">
    <p class="ukupno" style="font-size:16px;"><b>'.format_ceneS($ukupno,1,$_SESSION['promo-kod']['vrednost_koda']).'</b></p>
    </td>
</tr>';*/
$zasend .='<tr>
    <td colspan="5"> 
    <h5>NAPOMENA:</h5> 
	'.$racun.' 
    <p>Cene su prikazane u dinarima (RSD) sa uračunatim PDV-om. Plaćanje je isključivo u dinarima.</p> 
    </td> 
</tr>
					</tbody> 
				</table>'; 
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
$ukupno_za_an=formatCene($ukupno,1,$_SESSION['promo-kod']['vrednost_koda']);
else
$ukupno_za_an=formatCene($ukupno,1);
if($ukupno>0 or $ukupno_za_an>0)
$addTrans .=" _gaq.push(['_addTrans', '$zid', 'Amazonka', '".$ukupno_za_an."', '0.00', '0.00', '".preg_replace('/[^a-zA-Z]+/', '', $grad)."', '', 'RS']);\n\r";
$_SESSION['addItems']=$addItems; 
$_SESSION['addTrans']=$addTrans; 
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$idpromo=$_SESSION['promo-kod']['id'];
$ukupno_promo=sprintCene($ukupno,1, $_SESSION['promo-kod']['vrednost_koda']);
}
else {
$idpromo=0;
$ukupno_promo=0;
}
mysqli_query($conn, "UPDATE porudzbine SET iznos='".sprintCene($ukupno,1)."', iznos_sa_kodom='".$ukupno_promo."' , iznos_evra='".$settings['evro_iznos']."', idpromo='$idpromo' WHERE id=$zid");
if($idpromo>0)
mysqli_query($conn, "UPDATE promo_kodovi SET iskoriscen=iskoriscen+1 WHERE id=$idpromo");
unset($_SESSION[$sid]);
unset($_SESSION['promo-kod']);
unset($_SESSION['izf']);
$hider="style='display:none;'";  
//echo $zasend;
$aaa=sprintf($langa['messag'][35], $zid, $patH1, $domen, $zasend, $patH1, $domen); 
$aaa1=strip_html_tags($aaa); 
$subject=sprintf($langa['messag'][34],$zid)." - ".$domen; 
$from_name=$domen." - ".$langa['from_site'][0];  
send_email("mail", $email, $from_email, $replyto_email, $subject, $from_name, $aaa, $aaa1); 
send_email("mail", $settings["email_zaemail"], $settings["from_email"], $settings["from_email"], "$subject", $from_name, $aaa, $aaa1);  
//header("location: $patH1/$all_links[34]/"); 
?> 
<script type="text/javascript">  
window.location.assign("<?php echo $patH1?>/<?php echo $all_links[34]?>/");
</script> 
<?php 
}
}
} 
}
?>