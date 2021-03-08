<?php 
/*********************** upis izmena grupe kategorija *******************/
if($_GET['id']>0 and isset($_POST['up_iz']))
{ 
mysqli_query($conn, "UPDATE categories_group SET name=".safe($_POST['name']).", akt='$_POST[akt]', multi='$_POST[multi]' WHERE id=$id_get");
header("location: index.php?base=$base&page=$page");
}
else
if(isset($_POST['up_iz']))
{
if(!mysqli_query($conn, "INSERT INTO categories_group SET name=".safe($_POST['name']).", tip='$_POST[tip]', akt='$_POST[akt]', multi='$_POST[multi]'")) echo mysqli_error();
}  
if(isset($_POST['idpore']))
{
mysqli_query($conn, "UPDATE porudzbine SET br_posiljke=".safe(trim($_POST['br_posiljke']))." WHERE id=$_POST[idpore]");
$akti_tekst="Poštovani,
<br><br>
Vaša pošiljka je otpremljena. Broj pošiljke je <b>".trim($_POST['br_posiljke'])."</b>
<br><br>
Očekujte je sutra u toku dana (ako nije nedelja).
<br><br><br><br>
Pošiljku možete pratiti i putem <a href='".$settings['prati_posiljku']."?broj=".trim($_POST['br_posiljke'])."'>LINKA</a>.
<br>Na ovoj stranici unesite broj pošiljke i dobićete sve informacije o trenutnom statusu Vaše pošiljke.
<br>
Vaša <a href='https://amazonka.com/'>Amazonka</a>
";
$from_name="Amazonka";
$akti_tekst1=strip_html_tags($akti_tekst);
$subject="Broj posiljke - ".trim($_POST['br_posiljke']);
send_email("mail", $_POST['email'], $settings["from_email"], $settings["from_email"], $subject, $from_name, $akti_tekst, $akti_tekst1);
}
/*************** NOVi korisnik ****************************/
if(isset($_POST['reg_cand']))
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($post_niz['email'])."");
$fx1=mysqli_fetch_assoc($fax);
if($_POST['ime']=="" or $_POST['email']=="" or $_POST['password']=="" or $_POST['password1']=="" or $_POST['pbroj']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="")
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{
$stop=1;
$msgr=$arrwords2['sifre_nejednake'];
}
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false)
{
$stop=1; 
$msgr=$arrwords['email_novalid'];
}
else
if($fx1['user_id']>0)
{
$stop=1;
$msgr=$arrwords['email_postoji'];
}
else
{
if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0;
//$br1=md5(md5(strip_tags($_POST['password']).time()));
$password_crypted = tep_encrypt_password(strip_tags($_POST['password']));
$date_birth=$post_niz['year']."-".$post_niz['month']."-".$post_niz['day'];
$randi=gen_rand();
if(!mysqli_query($conn, "INSERT INTO users_data SET  ime=".safe($_POST['ime']).", email=".safe($_POST['email']).", pib=".safe($_POST['pib']).", akt='Y', password=".safe($password_crypted).", telefon=".safe($_POST['telefon']).", grad=".safe($_POST['grad']).", postanski_broj=".safe($_POST['pbroj']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti', randkod='$randi'")) echo mysqli_error();
$zid=mysqli_insert_id($conn);
$msgr=$arrwords2['registracija_uspesna'];
$ende=1;
$green="_green";
}
}
if(isset($_POST['change_cand']) and $_POST['change_cand']>0)
{
if($_POST['email']!="")
{
$fax=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe($_POST['email'])." AND NOT user_id=".$_POST['change_cand']);
$fx1=mysqli_fetch_assoc($fax);
}
/*if($_SESSION["captcha"]!=$_POST["captcha"])
$msgr=$arrwords['pogresan_kod'];
else*/
if($_POST['ime']=="" or $_POST['email']=="" or $_POST['pbroj']=="" or $_POST['grad']=="" or $_POST['ulica_broj']=="")
$msgr=$arrwords['niste_ispunili'];
else
if($_POST["password"]!=$_POST["password1"])
{
$stop=1;
$msgr=$arrwords2['sifre_nejednake'];
}
else
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)===false)
{
$stop=1; 
$msgr=$arrwords['email_novalid'];
}
else
if($fx1['user_id']>0)
{
$stop=1;
$msgr=$arrwords['email_postoji'];
}
else
{
$password_crypted = tep_encrypt_password(strip_tags($_POST['password']));
if($_POST["password"]!="" and $_POST["password1"]!="")
$novi_pass=", password=".safe($password_crypted);
else
$novi_pass="";
//$br1=md5(md5(strip_tags($_POST['password']).time()));
 if(isset($_POST['vesti']) and $_POST['vesti']>0) $ivesti=1; else $ivesti=0;
if(!mysqli_query($conn, "UPDATE users_data SET  ime=".safe($_POST['ime']).", email=".safe($_POST['email']).", pib=".safe($_POST['pib']).", telefon=".safe($_POST['telefon']).", grad=".safe($_POST['grad']).", postanski_broj=".safe($_POST['pbroj']).", ulica_broj=".safe($_POST['ulica_broj']).", datum='".date("Y-m-d")."', vesti='$ivesti'$novi_pass WHERE user_id=".$_POST['change_cand']."")) echo mysqli_error();
$msgr=$arrwords2['uspesna_izmena'];
$ende=1;
}
}
if(isset($_POST['delnal']) and $_POST['delnal']>0)
{ 
$di=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=".$_POST['delnal']."");
$di1=mysqli_fetch_assoc($di);
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"]))
{
unlink($page_path2.SUBFOLDER.GALFOLDER."/".$di1["civi1"]);
unlink($page_path2.SUBFOLDER.GALFOLDER."/thumb/".$di1["civi1"]);
}
mysqli_query($conn, "DELETE FROM users_data WHERE user_id=".$_POST['delnal']);
if(!isset($_POST['no']))
header("location: $patHA/new_candidate.php");
}
/****************************** UPIS STRANICA *************************/
$inp_niz=array("naziv","ulink",  "h1", "h2","title","keywords","description","podnaslov");
$inp_niz1=array("Naziv u linku","Link stranice", "H1 tag", "H2 tag","Title","Linkuj sliku","Description tag","Opis");
if($_POST['save_stranice'])
{
unset($_POST['save_stranice']);
if($_POST["naziv$firstlang"]=="")
$msr="Potrebno je da upišete 'Link stranice' i 'Naziv u linku'!";
else
{
$i=0;
$tips=$_POST['tips']; 
if($_GET['id_cat']>0)
$nivos .=", id_cat=$_GET[id_cat]";
$nivos .=", id_parent=$_POST[id_parent]";
if($_POST['id_parent']>0)
{
$pp=mysqli_query($conn, "SELECT * FROM page WHERE id=$_POST[id_parent]");
$pp1=mysqli_fetch_assoc($pp);
$nivor=$pp1['nivo']+1;
$nivos .=", nivo=$nivor";
}
if(mysqli_query($conn, "INSERT INTO page SET datum='".date("Y-m-d")."'$nivos"))
{  
$zid=mysqli_insert_id($conn);
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1['jezik'];
$nazivis="";
$i=0;
foreach($inp_niz as $key => $value)
{
if($key<4)
{
$naziv="$value$jez";
if($i>0) $zar=", "; else $zar=""; 
if($_POST[$naziv]!="")
$nazivis .= $zar."$value=".safe($_POST[$naziv]);
else
{
if($value=="ulink")
$nazivis .= $zar."$value='".replace_implode1($_POST["naziv$jez"])."'";
}
$i++;
}
}
//echo $nazivis;
//print_r($_POST);
//echo $nazivis."<br>";
if(!mysqli_query($conn, "INSERT INTO pagel SET lang='$jez', id_page=$zid, $nazivis")) echo mysqli_error(); 
}
}
else
$msr=mysqli_error();
if($zid>0)
{
header("location: index.php?base=$base&page=$page&id=$zid&id_cat=".$_GET['id_cat']."&uspeh=1");
}
} 
}
/****************************** IZMENA STRANICE *************************/
if($_POST['izmena_stranice'])
{
if($_POST["naziv$firstlang"]==""/*  || $_POST["ulink$firstlang"]==""*/)
$msr="Potrebno je da upišete 'Link stranice' i 'Naziv u linku', model stranice!";
else
{
$i=0;
$tips=$_POST['tips']; 
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",1,1);
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
}elseif($_POST['brisi']==1) 
{
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
$slika="";
}else $slika=$_POST['stara_slika'];
$nivos .=", id_cat=$_GET[id_cat]";
$nivos .=", slika='$slika'";
$nivos .=", model='$_POST[model]'";
$nivos .=", model1='$_POST[model1]'";
$nivos .=", id_parent=$_POST[id_parent]";
if($_POST['id_parent']>0)
{
$pp=mysqli_query($conn, "SELECT * FROM page WHERE id=$_POST[id_parent]");
$pp1=mysqli_fetch_assoc($pp);
$nivor=$pp1['nivo']+1;
$nivos .=", nivo=$nivor";
}
if(isset($_POST['show_for_users'])) $show_for_users=1; else $show_for_users=0;
if(mysqli_query($conn, "UPDATE page SET show_for_users=$show_for_users, class_for_icon=".safe($_POST['class_for_icon']).", class_for_icon1=".safe($_POST['class_for_icon1']).", tabela_za_brojanje=".safe($_POST['tabela_za_brojanje']).", datum='".date("Y-m-d")."'$nivos WHERE id=$id_get"))
{  
if(isset($_POST['kategi']))
{
mysqli_query($conn, "DELETE FROM pages_kat WHERE id_page=$_GET[id]");
foreach($_POST['kategi'] as $key => $value)
{
mysqli_query($conn, "INSERT INTO pages_kat SET id_page=$_GET[id], id_kat=$value");
}
}
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1['jezik'];
$nazivis="";
$i=0;
foreach($inp_niz as $key => $value)
{
$naziv="$value$jez";
if($i>0) $zar=", "; else $zar=""; 
if($_POST[$naziv]!="" or $_POST[$naziv]=="")
$nazivis .= $zar."$value=".safe($_POST[$naziv]);
else
{
if($value=="ulink")
//$nazivis .= $zar."$value='".replace_implode1($_POST["naziv$jez"])."'";
$nazivis .= $zar."$value='".replace_implode1($_POST["ulink$jez"])."'";
}
$i++;
}
$imali=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page='$id_get' AND lang='$jez'");
$imali1=mysqli_fetch_assoc($imali);
if($imali1['id']>0)
mysqli_query($conn, "UPDATE pagel SET $nazivis WHERE lang='$jez' AND id_page=$id_get");
else
mysqli_query($conn, "INSERT INTO pagel SET $nazivis, lang='$jez', id_page=$id_get"); 
}
$msr="Stranica / kategorija je izmenjena!"; 
}
else
$msr=mysqli_error();
} 
}
/****************************** IZMENA STAVKE *************************/
if($_POST['izmene_stavke'])
{
if($_POST['id_parent']>0)
{
$uni=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[id_parent]");
$uni1=mysqli_fetch_assoc($uni);
$nivo=$uni1['nivo']+1;
} else
$nivo=1;
$rtz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND p.id_cat=".strip_tags($_GET['id_cat'])."  AND NOT p.id=".strip_tags($_GET['id'])."  AND pt.ulink='".replace_implode1($_POST["naziv$firstlang"])."' AND p.nivo=$nivo AND id_parent=".safe($_POST['id_parent']));
   $rtz1=mysqli_fetch_array($rtz);

 if($rtz1['id']>0)
 $msr="Link za upisanu kategoriju već postoji, izmenite naziv linka!";
 else
{ 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
{
$jez=$la1['jezik'];
$nazivis="";
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM stavkel WHERE lang='$jez' AND id_page=$id_get"))==0)
mysqli_query($conn, "INSERT INTO stavkel SET naziv='".$_POST["naziv$jez"]."', alt='".$_POST["alt$jez"]."', titlesl='".$_POST["titlesl$jez"]."', ulink='".$_POST["ulink$jez"]."', title='".$_POST["title$jez"]."', keywords='".$_POST["keywords$jez"]."', descriptions='".$_POST["descriptions$jez"]."', lang='$jez', id_page=$id_get");
else
mysqli_query($conn, "UPDATE stavkel SET naziv='".$_POST["naziv$jez"]."', alt='".$_POST["alt$jez"]."', title='".$_POST["title$jez"]."', titlesl='".$_POST["titlesl$jez"]."', ulink='".$_POST["ulink$jez"]."', title='".$_POST["title$jez"]."', keywords='".$_POST["keywords$jez"]."', descriptions='".$_POST["descriptions$jez"]."' WHERE lang='$jez' AND id_page=$id_get");  
}
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],$page_path2.SUBFOLDER.GALFOLDER."/",1,1);
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
}elseif($_POST['brisi']==1) 
{
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
$slika="";
}else $slika=$_POST['stara_slika'];
if($_POST['id_parent']>0)
{
$uni=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[id_parent]");
$uni1=mysqli_fetch_assoc($uni);
$nivos=$uni1['nivo']+1;
$id_parent=", id_parent=$_POST[id_parent], nivo=$nivos";

} else $id_parent=", id_parent=0, nivo=1";

if(!mysqli_query($conn, "UPDATE stavke SET akt='$_POST[akti]', id_cat_kupindo='$_POST[id_cat_kupindo]', slika='$slika'$id_parent WHERE id=$id_get")) echo mysqli_error(); else
{
$msr="Izmena je izvrsena"; 
 }
}
}
if($_GET['obrisi_stranice']>0 and $_GET['id']>0)
{
$katke=kategorije($_GET['id'],"page",1);
$texi=mysqli_query($conn, "SELECT * FROM pages_text WHERE id_page IN($katke)");
while($texi1=mysqli_fetch_assoc($texi))
{
$fxi=mysqli_query($conn, "SELECT * FROM files WHERE idupisa='$texi1[id]'");
while($fxi1=mysqli_fetch_assoc($fxi))
{
@unlink("..".FILFOLDER."/$fxi1[slika]");
mysqli_query($conn, "DELETE FROM files_lang WHERE id_fajla='$fxi1[id]'");
}
$sxi=mysqli_query($conn, "SELECT * FROM slike WHERE idupisa='$texi1[id]'");
while($sxi1=mysqli_fetch_assoc($sxi))
{
@unlink("..".GALFOLDER."/$sxi1[slika]");
@unlink("..".GALFOLDER."/thumb/$sxi1[slika]");
mysqli_query($conn, "DELETE FROM slike_lang WHERE id_slike='$sxi1[id]'");
}
@unlink("..".GALFOLDER."/thumb/$texi1[slika]");
@unlink("..".GALFOLDER."/$texi1[slika]");
@unlink("..".GALFOLDER."/thumb/$texi1[slika1]");
@unlink("..".GALFOLDER."/$texi1[slika1]");
mysqli_query($conn, "DELETE FROM files WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM slike WHERE idupisa='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_lang WHERE id_text='$texi1[id]'");
mysqli_query($conn, "DELETE FROM pages_text_kat WHERE id_text='$texi1[id]'");
}
mysqli_query($conn, "DELETE FROM pages_text WHERE id_page IN ($katke)");
mysqli_query($conn, "DELETE FROM page WHERE id IN ($katke)"); 
mysqli_query($conn, "DELETE FROM pagel WHERE id_page IN ($katke)");
header("location: index.php?base=$base&page=$page&id_cat=$_GET[id_cat]");
}
if($_GET['obrisi_stavke']>0 and $_GET['id']>0)
{
mysqli_query($conn, "DELETE FROM stavke WHERE id='$id_get'");
mysqli_query($conn, "DELETE FROM stavkel WHERE id_page='$id_get'");
header("location: index.php?base=$base&page=$page&id_cat=$_GET[id_cat]");
}
/*********************** upis stavke ***************/
if($_POST['save_stavke'])
{

if($_POST['id_parent']>0)
{
$uni=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[id_parent]");
$uni1=mysqli_fetch_assoc($uni);
$nivo=$uni1['nivo']+1;
} else
$nivo=1;


$rtz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND p.id_cat=".strip_tags($_GET['id_cat'])." AND pt.ulink='".replace_implode1($_POST["naziv$firstlang"])."' AND p.nivo=$nivo AND id_parent=".safe($_POST['id_parent']));
   $rtz1=mysqli_fetch_array($rtz);



if($_POST["naziv$firstlang"]=="")
$msr="Potrebno je da upišete 'Link stranice' i 'Naziv u linku'!";
else
if($rtz1['id']>0)
$msr="Link za upisanu kategoriju već postoji, izmenite naziv linka!";
else
{
$i=0;
$tips=$_POST['tips']; 
if($_POST['kat']>0)
{
$zz=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[kat]");
$zz1=mysqli_fetch_array($zz);
$nivo=$zz1['nivo']+1;
$nivos=", id_parent=$_POST[kat], nivo=$nivo";
}
if($_GET['id_cat']>0)
$nivos .=", id_cat=$_GET[id_cat]";
if($_POST['id_parent']>0)
{
$uni=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[id_parent]");
$uni1=mysqli_fetch_assoc($uni);
$nivo=$uni1['nivo']+1;
$nivos .=", id_parent=$_POST[id_parent], nivo=$nivo"; 
} else $nivos .="";
if(mysqli_query($conn, "INSERT INTO stavke SET datum='".date("Y-m-d")."'$nivos"))
{
$zid=mysqli_insert_id($conn);
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1['jezik'];
if(!mysqli_query($conn, "INSERT INTO stavkel SET lang='$jez', id_page=$zid, naziv=".safe($_POST["naziv$jez"]).", ulink='".replace_implode1($_POST["naziv$jez"])."'")) echo mysqli_error();
}
}
else
$msr=mysqli_error();
if($zid>0)
{
header("location: index.php?base=$base&page=$page&id=$zid&id_cat=".$_GET['id_cat']."&uspeh=1");
}
} 
}
/************************* UPIS IZMENA MODELA STRANICE *********************/
if(isset($_POST['izmena_modela']))
{
function izbaci_text($niz)
{
/*if(count($niz)>0)
{ 
$novi=array();
foreach($niz as $key => $value)
{
$novi[]=preg_replace("/text[1-9]+.php/","text.php",$value);
}
}*/
if($niz && count($niz)>0)
return implode(",",$niz);
else
return "";
}

if(isset($_POST['id_mod']))
$id_get=$_POST['id_mod'];
$imiddle=izbaci_text($_POST['include_middle']);
$ileft=izbaci_text($_POST['include_left']);
$iright=izbaci_text($_POST['include_right']);
$idole=izbaci_text($_POST['include_footer']);
$ivrh=izbaci_text($_POST['include_top']);
if($_POST['klasa_left']=="") 
$klase =", class_left=NULL"; else $klase =", class_left='".$_POST['klasa_left']."'"; 
if($_POST['klasa_middle']=="") 
$klase .=", class_middle=NULL"; else $klase .=", class_middle='".$_POST['klasa_middle']."'";
if($_POST['klasa_right']=="") $klase .=", class_right=NULL"; else $klase .=", class_right='".$_POST['klasa_right']."'"; 
if(isset($_POST['id_mod'])) $klase="";
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM page_models WHERE id_model=$id_get"))==0)
{
if(!mysqli_query($conn, "INSERT INTO page_models SET id_model=$id_get, include_file_middle=".safe($imiddle).", include_file_left=".safe($ileft).", include_file_top=".safe($ivrh).", include_file_footer=".safe($idole).", include_file_right=".safe($iright).$klase."")) echo mysqli_error();
}else
{
if(!mysqli_query($conn, "UPDATE page_models SET  include_file_middle=".safe($imiddle).", include_file_left=".safe($ileft).", include_file_top=".safe($ivrh).", include_file_footer=".safe($idole).", include_file_right=".safe($iright).$klase." WHERE id_model=$id_get")) echo mysqli_error();
} 

$msr="Izmena je izvrsena";
}

/************************ UPIS TEKSTA *****************************/

if($_POST['save_tekst'])
{
$stop_video=0;
if($_FILES['video']['name']) {
$iimesl=explode('.', $_FILES['video']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);

$videoArr=array("mp4", "ogg", "webm");
if(!in_array($ext,$videoArr))
$stop_video=1;
}
if($stop_video==1)
$msr="Video je pogresnog formata!";
else {
$za=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC LIMIT 1");
$za1=mysqli_fetch_array($za);
/*if($_POST["naslov$za1[jezik]"]=="")
$msr="Upišite naslove";
else{*/
 if($_FILES['video']['tmp_name'])
{
$video =UploadSlika($_FILES['video']['name'],$_FILES['video']['tmp_name'],$_FILES['video']['type'],"$page_path2/video-fajlovi/",1,1);
}else
$video="";
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika="";
 if($_FILES['slika1']['tmp_name'])
{
$slika1 =UploadSlika($_FILES['slika1']['name'],$_FILES['slika1']['tmp_name'],$_FILES['slika1']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika1="";
 if($_FILES['slika2']['tmp_name'])
{
$slika2 =UploadSlika($_FILES['slika2']['name'],$_FILES['slika2']['tmp_name'],$_FILES['slika2']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika2="";
 if($_FILES['slika3']['tmp_name'])
{
$slika3 =UploadSlika($_FILES['slika3']['name'],$_FILES['slika3']['tmp_name'],$_FILES['slika3']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika3="";
if($_POST['pozicija']>0) $pozicija="pozicija=".strip_tags($_POST['pozicija']); else $pozicija="pozicija=NULL";
if($_POST['youtube_prikaz']==1) $youtubep=1; else $youtubep=0;
if($_POST['full']==1) $esnos=1; else $esnos=0;
if($_POST['mslide']==1) $sld=1; else $sld=0;
if($_POST['polapola']==1) $polpol=1; else $polpol=0;
$nazivisa ="id_page='$_POST[id_page]', slika='$slika', video='$video', $pozicija,  time='".time()."', akt='N', youtube=".safe($_POST['youtube']).", youtube_prikaz=".safe($youtubep).", full_img_width='$esnos', mini_slider='$sld', polapola='$polpol', link=".safe($_POST['link'])."";
 mysqli_query($conn, "INSERT INTO pages_text SET $nazivisa");
 $idzad=mysqli_insert_id($conn);
 if($idzad>0)
 {
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 { 
$naslov="naslov$la1[jezik]";
$ulink="ulink$la1[jezik]";
$pretragalink="pretragalink$la1[jezik]";
$opis="opis$la1[jezik]";
$opis1="opis1$la1[jezik]";
$title="title$la1[jezik]";
$keyword="keywords$la1[jezik]";
$description="description$la1[jezik]";
$titleslike="titleslike$la1[jezik]";
$altslike="altslike$la1[jezik]";
//, ulink=".safe($_POST[$ulink])."

$nazivis = "lang='$la1[jezik]', id_text='$idzad', naslov=".safe($_POST[$naslov]).", pretraga_link=".safe($_POST[$pretragalink]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", opis1=".safe($_POST[$opis1]).", title=".safe($_POST[$title]).", keywords=".safe($_POST[$keyword]).", description=".safe($_POST[$description]).", titleslike=".safe($_POST[$titleslike]).", altslike=".safe($_POST[$altslike]);
 mysqli_query($conn, "INSERT INTO pages_text_lang SET $nazivis");
}
if(isset($_POST['kat']) and is_array($_POST['kat']))
{
foreach($_POST['kat'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pages_text_kat SET id_cat='$value', id_text='$idzad'");
}
}
}
if($idzad>0)
header("Location: $patHA/index.php?base=admin&page=page_edit_content&id=$idzad&uspeh=1"); 
else
$msr="Došlo je do greške u pokušaju upisa teksta!";
 //echo "<div class='infos1'><div>Upisano</div></div>";
//}
}
}

/********************** IZMENA TEKSTA **********************/
if(isset($_POST['save_tekst_change']))
{
$stop_video=0;
if($_FILES['video']['name']) {
$iimesl=explode('.', $_FILES['video']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);

$videoArr=array("mp4", "ogg", "webm");
if(!in_array($ext,$videoArr))
$stop_video=1;
}
if($stop_video==1)
$msr="Video je pogresnog formata!";
else {

$za=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC LIMIT 1");
$za1=mysqli_fetch_array($za);
//if($_POST["naslov$za1[jezik]"]=="")
 //echo "<div class='infos1'><div>Upišite naslove!</div></div>"; else {
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER.GALFOLDER."/",1,1);
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
}elseif($_POST['brisi']==1) 
{
unlink("..".GALFOLDER."/$_POST[stara_slika]");
unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
$slika="";
}else $slika=$_POST['stara_slika'];

$video="";
 if($_FILES['video']['tmp_name'])
{
$video =UploadSlika($_FILES['video']['name'],$_FILES['video']['tmp_name'],$_FILES['video']['type'],"$page_path2/video-fajlovi/",1,1);
@unlink("../video-fajlovi/$_POST[stari_video]");

}elseif($_POST['brisi_video']==1)
{
unlink("../video-fajlovi/$_POST[stari_video]");

$video="";
}else $video=$_POST['stari_video'];

for($i=1; $i<4; $i++)
{
 if($_FILES["slika$i"]['tmp_name'])
{
${"slika$i"} =UploadSlika($_FILES["slika$i"]['name'],$_FILES["slika$i"]['tmp_name'],$_FILES["slika$i"]['type'],"$page_path2".SUBFOLDER.GALFOLDER."/",1,1);
@unlink("..".GALFOLDER."/".$_POST["stara_slika$i"]);
@unlink("..".GALFOLDER."/thumb/".$_POST["stara_slika$i"]);
}elseif($_POST["brisi$i"]==1) 
{
@unlink("..".GALFOLDER."/".$_POST["stara_slika$i"]);
@unlink("..".GALFOLDER."/thumb/".$_POST["stara_slika$i"]);
${"slika$i"}="";
}else ${"slika$i"}=$_POST["stara_slika$i"];
}
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$naslov="naslov$la1[jezik]";
$pretragalink="pretragalink$la1[jezik]";
$ulink="ulink$la1[jezik]";
$opis="opis$la1[jezik]";
$opis1="opis1$la1[jezik]";
$title="title$la1[jezik]";
$titleslike="titleslike$la1[jezik]";
$altslike="altslike$la1[jezik]";
$keyword="keywords$la1[jezik]";
$description="description$la1[jezik]";

$nazivis = "naslov=".safe($_POST[$naslov]).", pretraga_link=".safe($_POST[$pretragalink]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", opis1=".safe($_POST[$opis1]).", title=".safe($_POST[$title]).", keywords=".safe($_POST[$keyword]).", description=".safe($_POST[$description]).", titleslike=".safe($_POST[$titleslike]).", altslike=".safe($_POST[$altslike]);

if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pages_text_lang WHERE lang='$la1[jezik]' AND id_text=$id_get"))==0)
mysqli_query($conn, "INSERT INTO pages_text_lang SET $nazivis, lang='$la1[jezik]',  id_text=$id_get");
else
 mysqli_query($conn, "UPDATE pages_text_lang SET $nazivis WHERE lang='$la1[jezik]' AND id_text=$id_get");
 }
if($_POST['youtube_prikaz']==1) $youtubep=1; else $youtubep=0;
if($_POST['pozicija']>0) $pozicija="pozicija=".strip_tags($_POST['pozicija']); else $pozicija="pozicija=NULL";
if($_POST['youtube_prikaz']==1) $youtubep=1; else $youtubep=0;
if($_POST['full']==1) $esnos=1; else $esnos=0;
if($_POST['mslide']==1) $sld=1; else $sld=0;
if($_POST['polapola']==1) $polpol=1; else $polpol=0;
  
$nazivisa ="id_page='$_POST[id_page]', slika='$slika', video='$video', $pozicija, akt='Y', youtube=".safe($_POST['youtube']).", youtube_prikaz=".safe($youtubep).", full_img_width='$esnos', mini_slider='$sld', polapola='$polpol', link=".safe($_POST['link'])."";
if(!mysqli_query($conn, "UPDATE pages_text SET $nazivisa WHERE id=$id_get")) echo mysqli_error(); 
$tipovi=array("middle","left","right","footer","top");
mysqli_query($conn, "DELETE FROM pages_text_kat WHERE id_text=$id_get");
if(isset($_POST['kat']) and is_array($_POST['kat']))
{
foreach($_POST['kat'] as $key => $value)
{
if($value>0)
if(!mysqli_query($conn, "INSERT INTO pages_text_kat SET id_cat='$value', id_text='$id_get'")) echo mysqli_error();
}
}
function izbaci_text($niz)
{
if($niz && count($niz)>0)
return implode(",",$niz);
else
return "";
}
if(isset($_POST['id_mod']))
$id_get=$_POST['id_mod'];
$imiddle=izbaci_text($_POST['include_middle']);
$ileft=izbaci_text($_POST['include_left']);
//print_r($_POST['include_middle']);
//if(!mysqli_query($conn, "UPDATE page_models SET  include_file_middle=".safe($imiddle).", include_file_left=".safe($ileft)." WHERE id_model=$_POST[id_model]")) echo mysqli_error();
$msr='Tekst je uspesno izmenjen'; 
}
}

/*********************** END IZMENA TEKSTA *********************/


/************************ UPIS PROIZVODA *****************************/
if(isset($_POST['save_pro']))
{
$stop_video=0;
if($_FILES['video']['name']) {
$iimesl=explode('.', $_FILES['video']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);

$videoArr=array("mp4", "ogg", "webm");
if(!in_array($ext,$videoArr))
$stop_video=1;
}
if($stop_video==1)
$msr="Video je pogresnog formata!";
$za=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC LIMIT 1");
$za1=mysqli_fetch_array($za);
$ta=mysqli_query($conn, "SELECT * FROM pro WHERE link=".safe(trim($_POST['link']))."");
$ta1=mysqli_num_rows($ta);
if((/*$_POST["brendovi"]=="" and */$_GET['tip']==4) or (!isset($_POST["kategorija"])  and $_GET['tip']==5) or $_POST["cena"]=="" or $_POST["naslov$firstlang"]=="")
$msr="Upišite polja oznacena zvezdicom!";
else
if($ta1>0 and strlen($_POST['link'])>3)
$msr="EAN kod koji ste upisali već je dodeljen nekom proizvodu!";
else
{
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 { 
$naslov="naslov$la1[jezik]";
$di=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM prol WHERE naslov=".safe(trim($_POST[$naslov])).""));
}
if($di>0)
$msr="Naziv proizvoda koji ste upisali već postoji u bazi! Izmenite naziv.";
else
{
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika="";

if($_FILES['video']['tmp_name'])
{
$video =UploadSlika($_FILES['video']['name'],$_FILES['video']['tmp_name'],$_FILES['video']['type'],"$page_path2/video-fajlovi/",1,1);
}else
$video="";

 if($_FILES['slika1']['tmp_name'])
{
$slika1 =UploadSlika($_FILES['slika1']['name'],$_FILES['slika1']['tmp_name'],$_FILES['slika1']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/",1,1);
}else $slika1="";
if($_POST['pozicija']>0) $pozicija="pozicija=".strip_tags($_POST['pozicija']); else $pozicija="pozicija=NULL";
if(isset($_POST['akt'])) $akt="akt=1"; else $akt="akt=0";
if(isset($_POST['akcija'])) $akci="akcija=1"; else $akci="akcija=0";
if(isset($_POST['novo'])) $novic="novo=1"; else $novic="novo=0";
if(isset($_POST['vegan'])) $vegani="vegan=1"; else $vegani="vegan=0";
if(isset($_POST['naslovna'])) $nasc="naslovna=1"; else $nasc="naslovna=0";
if(isset($_POST['izdvojeni'])) $izac="izdvojeni=1"; else $izac="izdvojeni=0"; 

if(isset($_POST['tip1'])) $tipi1="tip_1=1"; else $tipi1="tip_1=0";
if(isset($_POST['tip2'])) $tipi2="tip_2=1"; else $tipi2="tip_2=0";
if(isset($_POST['tip3'])) $tipi3="tip_3=1"; else $tipi3="tip_3=0";
if(isset($_POST['tip4'])) $tipi4="tip_4=1"; else $tipi4="tip_4=0";
if(isset($_POST['iukat'])) $iuk="izdvoj_u_kategoriji=1"; else $iuk="izdvoj_u_kategoriji=0";

if(isset($_POST['nijansa'])) $izac .=", nijansa=$_POST[nijansa]"; else $izac .=", nijansa=0";
if($_POST['tip']==6) $tipko=48; else $tipko=$_POST['tip']-2;
if($_POST['tip']==6) $kupindo=441;
else
if($_POST['tip']==4) $kupindo=136;
else if($_POST['tip']==5111) {
$uz_st=mysqli_query($conn, "SELECT * FROM stavke WHERE id=$_POST[kategorija]");
$uzst=mysqli_fetch_assoc($uz_st);
if($uzst['id_cat_kupindo']>0)
$kupindo=$uzst['id_cat_kupindo'];
else
$kupindo=0;
}
//, kategorija='$_POST[kategorija]'
$nazivisa ="akcijatraje='$_POST[akcijatraje]', link='$_POST[link]', lager='$_POST[lager]', video='$video', cena='$_POST[cena]', cena1='$_POST[cena1]', tip='$_POST[tip]', canurl='$_POST[canurl]', id_page='".$tipko."', slika='$slika', slika1='$slika1', $pozicija, $akt, $akci, $novic, $vegani, $tipi1, $tipi2, $tipi3, $tipi4, $iuk, $nasc, $izac, time='".time()."', brend='$_POST[brendovi]', kupindo='$_POST[kupid]'";

$filteri=array();
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
$filteri[]=$_POST["filt$i"];
}
if(count($filteri)>0)
$ifilt=", filteri='".implode(",",$filteri)."'";
else
$ifilt="";


mysqli_query($conn, "INSERT INTO pro SET $nazivisa$ifilt");
$idzad=mysqli_insert_id($conn);
if($idzad>0)
{
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 { 
$naslov="naslov$la1[jezik]";
$marka="marka$la1[jezik]";
$opis="opis$la1[jezik]";
$title="title$la1[jezik]";
$keyword="keywords$la1[jezik]";
$description="description$la1[jezik]";
$titleslike="titleslike$la1[jezik]";
$altslike ="altslike$la1[jezik]";
//, ulink=".safe($_POST[$ulink])."
$nazivis = "lang='$la1[jezik]', id_text='$idzad', naslov=".safe($_POST[$naslov]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", marka=".safe($_POST[$marka]).", title=".safe($_POST[$title]).", keywords=".safe($_POST[$keyword]).", description=".safe($_POST[$description]).", altslike=".safe($_POST[$altslike]).", titleslike=".safe($_POST[$titleslike]);
 mysqli_query($conn, "INSERT INTO prol SET $nazivis");  
}
//mysqli_query($conn, "DELETE FROM pro_filt  WHERE id_pro='$idzad'");
//mysqli_query($conn, "DELETE FROM pro_slicni  WHERE id_pro='$idzad'");
if(isset($_POST['kategorija']) and is_array($_POST['kategorija']))
{
foreach($_POST['kategorija'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO kat_pro SET kat='$value', pro='$idzad'");
}
}
if(isset($_POST['filteri']) and is_array($_POST['filteri']))
{
foreach($_POST['filteri'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='$value', id_pro='$idzad'");
}
}
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='".$_POST["filt$i"]."', id_pro='$idzad'");
}
if(isset($_POST['pro1']) and is_array($_POST['pro1']))
{
foreach($_POST['pro1'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pro_kupili SET id_pro1='$value', id_pro='$idzad'");
}
}
if(isset($_POST['oprema']) and is_array($_POST['oprema']))
{
foreach($_POST['oprema'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pro_slicni SET id_pro1='$value', id_pro='$idzad', tip=1");
}
} 
}
if($idzad>0)
header("Location: $patHA/index.php?base=admin&page=edit_proizvoda&id=$idzad&uspeh=1&tip=$_GET[tip]"); 
else
$msr="Došlo je do greške u pokušaju upisa teksta!";
 //echo "<div class='infos1'><div>Upisano</div></div>";
}
}
}

/********************** IZMENA PROIZVODA **********************/
if(isset($_POST['save_change_pro']))
{
$stop_video=0;
if($_FILES['video']['name']) {
$iimesl=explode('.', $_FILES['video']['name']);
$ext= end($iimesl);
$ext=strtolower($ext);

$videoArr=array("mp4", "ogg", "webm");
if(!in_array($ext,$videoArr))
$stop_video=1;
}
if($stop_video==1)
$msr="Video je pogresnog formata!";

$za=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC LIMIT 1");
$za1=mysqli_fetch_array($za);
$ta=mysqli_query($conn, "SELECT * FROM pro WHERE NOT id=$id_get AND link=".safe(trim($_POST['link']))."");
$ta1=mysqli_num_rows($ta);
if((/*$_POST["brendovi"]=="" and */$_GET['tip']==4) or (!isset($_POST["kategorija"]) and $_GET['tip']==5) or $_POST["cena"]=="" or $_POST["naslov$firstlang"]=="")
$msr="Upišite polja oznacena zvezdicom!";
else
if($ta1>0 and strlen($_POST['link'])>3)
$msr="EAN kod koji ste upisali vec je dodeljen nekom proizvodu!";
else
{
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
while($la1=mysqli_fetch_array($la))
 { 
$naslov="naslov$la1[jezik]";
$di=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM prol WHERE naslov=".safe(trim($_POST[$naslov]))."  AND NOT id_text=$id_get"));
}
if($di>0)
$msr="Naziv proizvoda koji ste upisali vec postoji u bazi! Izmenite naziv.";
else
{
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER.GALFOLDER."/",1,1);
@unlink("..".GALFOLDER."/$_POST[stara_slika]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
}elseif($_POST['brisi']==1) 
{
unlink("..".GALFOLDER."/$_POST[stara_slika]");
unlink("..".GALFOLDER."/thumb/$_POST[stara_slika]");
$slika="";
}else $slika=$_POST['stara_slika'];

 if($_FILES['slika1']['tmp_name'])
{
$slika1 =UploadSlika($_FILES['slika1']['name'],$_FILES['slika1']['tmp_name'],$_FILES['slika1']['type'],"$page_path2".SUBFOLDER.GALFOLDER."/",1,$crop,$resizep);
@unlink("..".GALFOLDER."/$_POST[stara_slika1]");
@unlink("..".GALFOLDER."/thumb/$_POST[stara_slika1]");
}elseif($_POST['brisi1']==1) 
{
unlink("..".GALFOLDER."/$_POST[stara_slika1]");
unlink("..".GALFOLDER."/thumb/$_POST[stara_slika1]");
$slika1="";
}else $slika1=$_POST['stara_slika1'];

$video="";
 if($_FILES['video']['tmp_name'])
{
$video =UploadSlika($_FILES['video']['name'],$_FILES['video']['tmp_name'],$_FILES['video']['type'],"$page_path2/video-fajlovi/",1,1);
@unlink("../video-fajlovi/$_POST[stari_video]");

}elseif($_POST['brisi_video']==1)
{
unlink("../video-fajlovi/$_POST[stari_video]");

$video="";
}else $video=$_POST['stari_video'];
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$naslov="naslov$la1[jezik]";
$ulink="ulink$la1[jezik]";
$opis="opis$la1[jezik]";
$marka="marka$la1[jezik]";
$title="title$la1[jezik]";
$keyword="keywords$la1[jezik]";
$description="description$la1[jezik]";
$titleslike="titleslike$la1[jezik]";
$altslike ="altslike$la1[jezik]";
$nazivis = "naslov=".safe($_POST[$naslov]).", ulink=".safe(replace_implode1($_POST[$naslov])).", opis=".safe($_POST[$opis]).", marka=".safe($_POST[$marka]).", title=".safe($_POST[$title]).", keywords=".safe($_POST[$keyword]).", description=".safe($_POST[$description]).", altslike=".safe($_POST[$altslike]).", titleslike=".safe($_POST[$titleslike]);
if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM prol WHERE lang='$la1[jezik]' AND id_text=$id_get"))==0)
mysqli_query($conn, "INSERT INTO prol SET $nazivis, lang='$la1[jezik]',  id_text=$id_get");
else
 mysqli_query($conn, "UPDATE prol SET $nazivis WHERE lang='$la1[jezik]' AND id_text=$id_get");
 }
if($_POST['pozicija']>0) $pozicija="pozicija=".strip_tags($_POST['pozicija']); else $pozicija="pozicija=100000";
if(isset($_POST['akt'])) $akt="akt=1"; else $akt="akt=0";
if(isset($_POST['akcija'])) $akci="akcija=1"; else $akci="akcija=0";
if(isset($_POST['novo'])) $novic="novo=1"; else $novic="novo=0";
if(isset($_POST['naslovna'])) $nasc="naslovna=1"; else $nasc="naslovna=0";
if(isset($_POST['izdvojeni'])) $izac="izdvojeni=1"; else $izac="izdvojeni=0";
if(isset($_POST['vegan'])) $vegani="vegan=1"; else $vegani="vegan=0";
if(isset($_POST['lager'])) $lager=$_POST['lager']; else $lager=0; 
if(isset($_POST['nijansa'])) $izac .=", nijansa=$_POST[nijansa]"; else $izac .=", nijansa=0";
if(isset($_POST['tip1'])) $tipi1="tip_1=1"; else $tipi1="tip_1=0";
if(isset($_POST['tip2'])) $tipi2="tip_2=1"; else $tipi2="tip_2=0";
if(isset($_POST['tip3'])) $tipi3="tip_3=1"; else $tipi3="tip_3=0";
if(isset($_POST['tip4'])) $tipi4="tip_4=1"; else $tipi4="tip_4=0";
if(isset($_POST['iukat'])) $izuk="izdvoj_u_kategoriji=1"; else $izuk="izdvoj_u_kategoriji=0";
//, kategorija='$_POST[kategorija]'
$nazivisa ="sponzorisano_do='".datum1(str_replace("-","-",$_POST['sponzorisanodo'])).', akcijatraje='$_POST[akcijatraje]', kupindo='$_POST[kupid]', link='$_POST[link]', canurl='$_POST[canurl]', video='$video', lager='$lager', cena='$_POST[cena]', cena1='$_POST[cena1]', slika='$slika', slika1='$slika1', $pozicija, $akt, $akci, $novic, $nasc, $izac, $vegani, $tipi1, $tipi2, $tipi3, $tipi4, $izuk, time='".time()."', brend='$_POST[brendovi]'";
$filteri=array();
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
$filteri[]=$_POST["filt$i"];
}
if(count($filteri)>0)
$ifilt=", filteri='".implode(",",$filteri)."'";
else
$ifilt="";

if(!mysqli_query($conn, "UPDATE pro SET $nazivisa$ifilt WHERE id=$id_get")) echo mysqli_error();
mysqli_query($conn, "DELETE FROM pro_filt  WHERE id_pro='$id_get'");
mysqli_query($conn, "DELETE FROM pro_slicni  WHERE id_pro='$id_get'");
mysqli_query($conn, "DELETE FROM pro_kupili  WHERE id_pro='$id_get'");
mysqli_query($conn, "DELETE FROM kat_pro WHERE pro='$id_get'");
if(isset($_POST['kategorija']) and is_array($_POST['kategorija']))
{
foreach($_POST['kategorija'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO kat_pro SET kat='$value', pro='$id_get'");
}
}
if(isset($_POST['filteri']) and is_array($_POST['filteri']))
{
foreach($_POST['filteri'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='$value', id_pro='$id_get'");
}
}
for($i=0; $i<$_POST['ife'];$i++)
{
if($_POST["filt$i"]>0)
mysqli_query($conn, "INSERT INTO pro_filt SET id_filt='".$_POST["filt$i"]."', id_pro='$id_get'");
}
if(isset($_POST['pro1']) and is_array($_POST['pro1']))
{
foreach($_POST['pro1'] as $key => $value)
{
if($value>0)
mysqli_query($conn, "INSERT INTO pro_kupili SET id_pro1='$value', id_pro='$id_get'");
}
}
if(isset($_POST['oprema']) and is_array($_POST['oprema']))
{
foreach($_POST['oprema'] as $key => $value)
{  
if($value>0)
mysqli_query($conn, "INSERT INTO pro_slicni SET id_pro1='$value', id_pro='$id_get', tip=1");
}
} 
$msr='Podaci su uspesno izmenjeni'; 
}
}
}

/************************ UPIS PROMO KODOVA *****************************/

if(isset($_POST['save_promo_kod']))

{
$randi=gen_rand6();

$ta=mysqli_query($conn, "SELECT * FROM promo_kodovi WHERE kod=".safe($randi)."");
$ta1=mysqli_num_rows($ta);

if($_POST["br_kodova"]=="" or $_POST["vr_koda"]==""  or $_POST["vazido"]=="" or count($_POST['kategorije'])<1)

$msr="Upišite polja oznacena zvezdicom!";
else
if($_POST["vr_koda"]>100 and $_POST['tip_koda']==0)
$msr="Vrednost procenta ne moze da bude veci od 100!";
else
if($_POST["vr_koda"]<0)
$msr="Vrednost koda ne moze da bude manji od 0!";
else
if($ta1>0)
$msr="Generisani kod vec postoji, kliknite jos jednom na dugme <b>GENERISI KOD</b>!";
else
{
$upotrebljivost=$kategorije="";

if(isset($_POST['upotrebljivost']) and $_POST['upotrebljivost']==1) $upotrebljivost=", upotrebljivost=1";

if(isset($_POST['kategorije']) and count($_POST['kategorije'])>0) $kategorije=", kategorije='".implode(",",$_POST['kategorije'])."'";

if($_POST['tip_koda']==0) $min_potr=0; else $min_potr=$_POST['min_potrosnja'];

for($i=1; $i<=$_POST['br_kodova']; $i++){
$randi=gen_rand6();

$nazivis = "kod = '$randi', broj_kodova=".safe(trim($_POST['br_kodova'])).", vrednost_koda=".safe(trim($_POST['vr_koda'])).", tip_koda=".safe(trim($_POST['tip_koda'])).", min_potrosnja=".safe(trim($min_potr)).", vazi_do=".safe(trim($_POST['vazido'])." 23:59:59").$upotrebljivost.$kategorije;
 if(!mysqli_query($conn, "INSERT INTO promo_kodovi SET $nazivis")) echo mysqli_error();
 $idzad=mysqli_insert_id($conn);
}
 if($idzad>0)
$msr="Generisanje kodova uspešno završeno!";
}
}

/*********************** brisanje izabranih promo kodova ****************/
if(isset($_POST['obrisi_ovo']) and $_POST['obrisi_ovo']!=""){
if(!mysqli_query($conn, "DELETE FROM promo_kodovi WHERE id IN (".$_POST['obrisi_ovo'].")")) echo mysqli_error();
}

/*********************** END IZMENA PROIZVODA *********************/

if(isset($_POST['novi_admin']))
{
$ime=$_POST['ime'];
$tip=$_POST['tip'];
$email=$_POST['emails'];
$password=$_POST['sifra'];
$password_crypted = tep_encrypt_password($password);
if($ime=="" or $email=="" or $password=="")
$msgr="Ispunite sva  polja!";
elseif (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $email)) 
$msgr="Email adresa nije validna!";
else
{
if(mysqli_query($conn, "INSERT INTO users_admin SET name=".safe($ime).", tip=".safe($tip).", email=".safe($email).", password=".safe($password_crypted).", active=2, akt='Y', date='".date("Y-m-d")."'"))
$msgr="Upis novog admina je izvršen!";
}
}

if(isset($_POST['izmeni_admin']))
{ 
$ime=$_POST['ime'];
$tip=$_POST['tip'];
$email=$_POST['emails'];
$password=$_POST['sifra'];
$password_crypted = tep_encrypt_password($password);
if($ime=="" or $email=="")
$msgr="Upišite ime i prezime!";
else
{
if($password!="") $pass=", password=".safe($password_crypted)."";
if(mysqli_query($conn, "UPDATE users_admin SET name=".safe($ime).", tip=".safe($tip).", email=".safe($email)."$pass WHERE user_id=$_POST[user_id]"))
$msgr="Izmena je izvršena!";
else echo mysqli_error();
}
}

if(isset($_POST['save_time_zone']))
{
mysqli_query($conn, "UPDATE settings SET vrednosti=".safe($_POST['timezone'])." WHERE fields='timezone'");
mysqli_query($conn, "UPDATE settings SET vrednosti=".safe($_POST['mday'])." WHERE fields='dateformat'");
header("location: ".curPageURL());
}
if(isset($_POST['add_language']))
{
}
if(isset($_POST['reg_kode'])!="")
{
$key=substr($_SESSION['keys'],0,5);
$number = $_POST['number'];
$ime = $_POST['ime'];
$korime=$_POST['korime'];
$email = $_POST['email'];
$password=$_POST['pass1'];
$passwordd1=$_POST['pass2'];
$naziv_preduzeca = $_POST['naziv_preduzeca'];
$maticni_broj = $_POST['maticni_broj'];
$pib = $_POST['pib'];
$kateg = $_POST['kateg'];
$adresa=$_POST['adresa'];
$grad=$_POST['grad'];
$opstina = $_POST['opstina'];
$drzava = $_POST[drzava];
$telefon = $_POST['telefon'];
$avatar=$_FILES['avatar']['name'];
$opis = $_POST['opis'];
$pro_email=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($email)."");
$pro_kor_ime=mysqli_query($conn, "SELECT * FROM users WHERE username=".safe($kor_ime)." "); 
//echo "$ime || $prezime ||  $password || $passwordd1  || $telefon || $ulica || $posta || $grad || $zemlja || $email || $agencija";
if($password=="" || $passwordd1=="" || $naziv_preduzeca=="" || $drzava==""    || $grad==""   || $telefon=="" )
$msgr="Niste ispunili sva obavezna polja!";
//else if($key!=$number)
//$msgr="Niste pravilno upisali kod!";
elseif (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $email)) 
$msgr="Email adresa nije validna!";
else if(mysqli_num_rows($pro_email)>0)
$msgr="Upisana email adresa je već u upotrebi!";
else if($password!=$passwordd1)
$msgr="Prva i druga lozinka nisu iste!";
else if(check_image($avatar)==0 and $avatar!="")
$msgr="Format slike nije odgovarajući!";
else  
{
 $slika=""; 
$vreme=$newtime;
$br1=md5(md5($password.$vreme));
$password_crypted = tep_encrypt_password($password);
if(mysqli_query($conn, "INSERT INTO users SET
username =".safe($korime).",
email =".safe($email).", 
password =".safe($password_crypted).",
date ='".$newtime."',
active='0',
akt='N',
agencija='1',
potvrda =".safe($br1).", 
dozvoljen_br_biografija=1,
last_login='0'
")){
$zad_id=mysqli_insert_id($conn);
if(!mysqli_query($conn, "INSERT INTO users_info SET
naziv_preduzeca =".safe($naziv_preduzeca).", 
id_grada =".safe($grad).",
id_drzave =".safe($drzava).",
telefon =".safe($telefon).",
time ='".$newtime."',
user_id='$zad_id'
")) echo mysqli_error();
$msgr="Podaci su sačuvani. Da biste mogli da vršite upis oglasa, morate najpre aktivirati nalog, klikom na link koji je poslat na upisanu email adresu!";
$disables="style='display:none;'";   
$link=$patH1."/aktivacija/".$br1."1/"; 
 echo $link;
include("$page_path2".SUBFOLDER."/class.phpmailer.php");
$gup=mysqli_query($conn, "SELECT * FROM city_name WHERE id=".safe($grad)."");
$gup1=mysqli_fetch_assoc($gup);
$aaa="
Postovani,<br /><br />
Uspesno ste se registrovali na sajtu $domen
<br />
Da biste mogli da upisujete oglase potrebno je da aktivirate nalog klikom  na link: <br /><a href='$link'>$link</a>
<br /><br />
<b>Pri registraciji ste upisali sledece podatke:</b>
<br />

IP: ".$_SERVER['REMOTE_ADDR']."<br />
Email: $email<br />
Korisnicko ime: $korime<br />
Ime i prezime: $naziv_preduzeca<br />
Grad: $gup1[grad]<br />
Telefon: $telefon<br />
<br />
<br />
<br /><br />Vaša $domen<br /><br />

$from_email";
 $aaa1="
Postovani,
\n\rUspesno ste se registrovali na sajtu $domen
\n\rDa biste mogli da upisujete oglase potrebno je da aktivirate nalog klikom  na link: $link.
\n\rPri registraciji ste upisali sledece podatke: 
\n\rIP: ".$_SERVER['REMOTE_ADDR']." 
\n\rEmail: $email
\n\rKorisnicko ime: $korime
\n\rIme i prezime: $naziv_preduzeca
\n\rGrad: $gup1[grad]
\n\rTelefon: $telefon
\n\r\n\rVaša $domen
\n\r$from_email";
$subject="Registracija korisnika $naziv_preduzeca na sajtu $domen";
$mail->FromName = "ApartmaniBeogradSmestaj - registracija $naziv_preduzeca";
$mail             = new phpmailer();

/*$mail->IsSMTP();  
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "mail.klikdooglasa.com"; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "kontakt@klikdooglasa.com"; // SMTP account username
$mail->Password   = $kontakt_pass;        // SMTP account password
*/
$mail->Mailer   = "mail";
$mail->From=$from_email;
$mail->FromName = "apartmanibeogradsmestaj.com - registracija $naziv_preduzeca";
$mail->Subject = "$subject";
$mail->Body=$aaa;
    $mail->AltBody = $aaa1;
$mail->AddAddress("$_POST[email]");
$mail->AddAddress("aleksandrou@gmail.com");
if($_SERVER["SERVER_NAME"]!="localhost")

     $mail->Send();
}else echo mysqli_error();
}
}
if(isset($_POST['registracija_izmena']))
{
$ime = $_POST['ime'];
$korime=$_POST['korime'];
$email = $_POST['email'];
$emails = $_POST['emails'];
$password=$_POST['pass1'];
$password1=$_POST['pass2'];
$naziv_preduzeca = $_POST['naziv_preduzeca'];
$grad=$_POST['grad'];
$drzava = $_POST['drzava'];
$telefon = $_POST['telefon'];
$kontakt_osoba = $_POST['kontakt_osoba'];
$avatar=$_FILES['avatar']['name'];
$opis = $_POST['opis'];

if($naziv_preduzeca=="" || $grad==""  || $telefon=="" ||  $email=="" || $korime=="")
{
$msgr="Niste ispunili sva obavezna polja!";

}elseif (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $email)) 
$msgr="Email adresa nije validna!";
else
if(($password!="" and $password1!="") and ($password!=$password1))

{
$msgr="Upisana i ponovljena lozinka nisu jednake!";
}
else
{
if(($password!="" and $password1!="") and ($password==$password1)) 

$new_pass=", password='".tep_encrypt_password($password)."'"; else $new_pass="";

mysqli_query($conn, "UPDATE users SET username=".safe($korime).", email=".safe($email).", azurirano ='".$newtime."'$new_pass WHERE user_id=$_SESSION[userid]"); 

if(mysqli_query($conn, "UPDATE users_info SET
naziv_preduzeca =".safe($naziv_preduzeca).", 
id_grada =".safe($grad).",
id_drzave =$drzava,

telefon =".safe($telefon)." WHERE user_id=$_SESSION[userid]

")) {

$msgr="Podaci su uspešno izmenjeni!";
}
else echo mysqli_error();
}
}

/* Upis novog oglasa */

if(isset($_POST['upis_korak11']))
{
$grad=$_POST['grad'];
$id_cat=$_POST['id_cat'];
$nameAds=$_POST['nameAds'];
$nameAds_eng=$_POST['nameAds_eng'];
if($nameAds=="" or ($_FILES['slika']['tmp_name']==""))
{
$msgr="Niste ispunili sva obavezna polja!";
}
else
{
if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/");
}  
if(mysqli_query($conn, "INSERT INTO oglasi SET
nameAdsslo =".safe($nameAds).",
slika =".safe($slika).",
akt='N',
akt1 ='1',
datum ='".time()."'
"))
 {
 $zadnji_id=mysqli_insert_id($conn);
$msgr="Podaci su uspešno izmenjeni!"; 
if($_POST['upis_korak11'])
header("location: $patHA/index.php?base=admin&page=izmena-oglas&id=$zadnji_id&korak=1");
}else echo mysqli_error();
}
}

/************ IZMENA OGLASA **************/
if(isset($_POST['izmena_korak1']) or isset($_POST['izmena_korak11']))
{
$ve=mysqli_query($conn, "SELECT * FROM oglasi WHERE  id=$_POST[idoglasa]");
$ai1=mysqli_fetch_assoc($ve); 
$grad=$_POST['grad'];
$id_cat=$_POST['id_cat'];
$nameAds=$_POST['nameAds'];
$nameAds_eng=$_POST['nameAds_eng'];
if($nameAds=="" ||  ($_FILES['slika']['tmp_name']=="" and $_POST['stara']==""))
{
$msgr="Niste ispunili sva obavezna polja!";
}
else
{
 if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],"$page_path2".SUBFOLDER."".GALFOLDER."/");
@unlink("$page_path2".SUBFOLDER."".GALFOLDER."/$_POST[stara]");
@unlink("$page_path2".SUBFOLDER."".GALFOLDER."/thumb/$_POST[stara]");
} elseif($_POST["stara"]!="")
$slika=$_POST["stara"];
else $slika="";
if(mysqli_query($conn, "UPDATE oglasi SET
nameAdsslo =".safe($nameAds).",
slika =".safe($slika).",
title =".safe($_POST['title']).",
keywords =".safe($_POST['keyt']).",
description =".safe($_POST['desct']).",
datum_izmene ='".time()."'
 WHERE id=$_POST[idoglasa]
"))
 {
$msgr="Podaci su uspešno izmenjeni!"; 
if($_POST['izmena_korak11'])
header("location: $patHA/index.php?base=admin&page=izmena-oglas&id=$_POST[idoglasa]&korak=2");
}else echo mysqli_error();
}
}
 if(isset($_POST['izmena_korak2']) or isset($_POST['izmena_korak22']))
{
$ve=mysqli_query($conn, "SELECT * FROM oglasi WHERE  id=$_POST[idoglasa]");
$ai1=mysqli_fetch_assoc($ve); 
$opisslo=$_POST['tekstslo'];
$opiseng=$_POST['teksteng'];
$opis1slo=$_POST['tekst1slo'];
$opis1eng=$_POST['tekst1eng'];
if(mysqli_query($conn, "UPDATE oglasi SET
tekstslo =".safe($opisslo).",
teksteng =".safe($opiseng).",
tekst1slo =".safe($opis1slo).",
tekst1eng =".safe($opis1eng).", 
kvadratura =".safe($_POST['kvadratura']).", 
adresaslo =".safe($_POST['adresaslo']).",
adresaeng =".safe($_POST['adresaeng']).",
maxbroj =".safe($_POST['maxbroj']).",
youtube =".safe($_POST['youtube']).",
mapa =".safe($_POST['mapa']).",
cena =".safe($_POST['cena']).",
cenado =".safe($_POST['cenado']).",
pm =".safe($_POST['pm'])." 
 WHERE id_page=$_POST[idoglasa]
"))
 {
$msgr="Podaci su uspešno izmenjeni!"; 
if($_POST['izmena_korak22'])
header("location: $patHA/index.php?base=admin&page=izmena-oglas&id=$_POST[idoglasa]&korak=3");
}else echo mysqli_error();
}
if(isset($_POST['izmena_korak3']) or isset($_POST['izmena_korak33']))
{
$ve=mysqli_query($conn, "SELECT * FROM oglasi WHERE  id_page=$_POST[idoglasa]");
$ai1=mysqli_fetch_assoc($ve); 
$opis=$_POST['tekst'];
  if($_POST['tipsm']>0) $tipsm=$_POST['tipsm']; else $tipsm=0;
  if($_POST['lokacija']>0) $lokacija=$_POST['lokacija']; else $lokacija=0;
mysqli_query($conn, "DELETE FROM content_oglas WHERE ido=$_POST[idoglasa]"); 
//mysqli_query($conn, "DELETE FROM oglas_number_rooms WHERE ido=$_POST[idoglasa]");
if(!mysqli_query($conn, "UPDATE oglasi SET tipsm='$tipsm', lokacija='$lokacija' WHERE id_page='$_POST[idoglasa]'")) echo mysqli_error();
if(is_array($_POST['sadrzaj']))  
foreach($_POST['sadrzaj'] as $key => $value)
{ 
mysqli_query($conn, "INSERT INTO content_oglas set ido=$_POST[idoglasa], ids=$value");
}
/*foreach($_POST[sobe_broj] as $key => $value)
{
$dis=$key;
if($value>0)
{
if(!mysqli_query($conn, "INSERT INTO oglas_number_rooms set ido=$_POST[idoglasa], niz_id=$dis, br_soba=$value")) echo mysqli_error();
}
}*/
$msgr="Podaci su uspešno izmenjeni!"; 
if($_POST['izmena_korak33'])
header("location: $patHA/index.php?base=admin&page=izmena-oglas&id=$_POST[idoglasa]&korak=4");
}
 if(isset($_POST['izmena_korak4']) or isset($_POST['izmena_korak44']))
{
$ve=mysqli_query($conn, "SELECT * FROM oglasi WHERE  id=$_POST[idoglasa]");
$ai1=mysqli_fetch_assoc($ve); 
$invalid=$_POST['invalid']; 
if($_FILES['cena_pdf']['name']!="")
$ext= end(explode('.', $_FILES['cena_pdf']['name']));
if($ext!="pdf" and $ext!="PDF" and $ext!="doc" and $ext!="DOC" and $ext!="docx" and $ext!="DOCX" and $_FILES['cena_pdf']['name']!="")
$msgr="Cenovnik fajl nije u PDF ili WORD formatu!"; 
else
{
 if($_FILES['cena_pdf']['tmp_name'])
{
$cena_pdf =UploadSlika($_FILES['cena_pdf']['name'],$_FILES['cena_pdf']['tmp_name'],$_FILES['cena_pdf']['type'],"$page_path2".SUBFOLDER."/cenovnici/");
@unlink("$page_path2".SUBFOLDER."/cenovnici/$_POST[stari_pdf]");
}else
if($_POST['obrisi_pdf']==1) 
{ 
$cena_pdf="";
@unlink("$page_path2".SUBFOLDER."/cenovnici/$_POST[stari_pdf]");
}elseif($_POST["stari_pdf"]!="")
$cena_pdf=$_POST["stari_pdf"];
else $cena_pdf="";
if($_POST['cena']>0) $cenas=$_POST['cena']; else $cenas=0;
if($_POST['cenado']>0) $cenasdo=$_POST['cenado']; else $cenasdo=0; 
if($_POST['cenapo']==0) 
{$cenas=0; $cenasdo=0;}
if(mysqli_query($conn, "UPDATE oglasi SET
cenau =".safe($invalid).",
cenapo =".safe($_POST['cenapo']).",
cenovnik =".safe($_POST['cenovnik']).",
cena =".safe($cenas).",
cenado =".safe($cenasdo).",
cena_pdf =".safe($cena_pdf)."
 WHERE id=$_POST[idoglasa]
"))
 {
$msgr="Podaci su uspešno izmenjeni!"; 
if($_POST['izmena_korak44'])
header("location: $patHA/index.php?base=admin&page=izmena-oglas&id=$_POST[idoglasa]&korak=5");
}else echo mysqli_error();
}
}
if(isset($_POST['zahtev1']))
{
include("$page_path2".SUBFOLDER."/class.phpmailer.php");
$pos=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".safe($_SESSION['userid'])."");
$pos1=mysqli_fetch_assoc($pos);
if($pos1['agencija']==1) $adkp="users_info"; else $adkp="adrese_kandidati";
$cos=mysqli_query($conn, "SELECT * FROM $adkp WHERE user_id=".safe($_SESSION['userid'])."");$cos1=mysqli_fetch_assoc($cos);
$vreme=date("d-m-Y H:i:s", $newtime);
if($pos1['agencija']==1)
{
$zaslanje="
Poslato u $vreme<br /><br />
Poslato sa strane sajta:
<br />
".curPageURL()."
<br /><br />
<br />Firma: $cos1[naziv_preduzeca]
<br />Email: $pos1[email]
<br />Telefon: $cos1[telefon]
<br />Poruka:<br />$_POST[obraz]
";
}
else
{
$zaslanje="
Poslato u $vreme<br /><br />
Poslato sa strane sajta:
<br />
".curPageURL()."
<br /><br />
<br />Ime i prezime: $cos1[ime]
<br />Email: $pos1[email]
<br />Telefon: $cos1[telefon]
<br />Poruka:<br />$_POST[obraz]
";
}

$mail = new phpmailer();
/*
 $mail->IsSMTP();  
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "mail.klikdooglasa.com"; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "kontakt@klikdooglasa.com"; // SMTP account username
$mail->Password   = $kontakt_pass;        // SMTP account password
*/
 $mail->Mailer   = "mail";
$subject="Poruka sa sajta apartmanibeogradsmestaj.com";
$mail->From     = "$us1[email]";
$mail->FromName = "Poruka sa sajta $domen";
$mail->Subject = "$subject";
// $mail->Mailer   = "mail";
$mail->Body    = $zaslanje;
    $mail->AltBody = "";
 $mail->AddAddress($us1['email']);
//$mail->AddAddress("aleksandrou@gmail.com");
     if($mail->Send())
         $msgr="Vaš poruka je uspešno poslata kandidatu!";
}

/************ odgovor poslodavca na prijavu kandidata ****************/
if(isset($_POST['odgovor_poslodavca_naprijavu']))
{ 
$onj=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".safe($_SESSION['userid']).""); 
$onj1=@mysqli_fetch_assoc($onj);
$adp=mysqli_query($conn, "SELECT * FROM users_info WHERE user_id=$_SESSION[userid]"); 
$adp1=mysqli_fetch_assoc($adp);  
$korisnik=$adp1['naziv_preduzeca'];
$zdp=mysqli_query($conn, "SELECT * FROM ".strip_tags($_POST[tns])." WHERE id=".safe($_POST['ons']).""); 
$zdp1=mysqli_fetch_assoc($zdp);
if($_POST['tns']=="prijave_na_oglas")
{
$zdp=mysqli_query($conn, "SELECT * FROM prijave_na_oglas WHERE id=".safe($_POST['ons']).""); $zdp1=mysqli_fetch_assoc($zdp);
$ge=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".safe($zdp1['id_kandidata'])."");
$ge1=@mysqli_fetch_assoc($ge);
}
$ogl=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=".safe($zdp1['id_oglasa']).""); 
$ogl1=mysqli_fetch_assoc($ogl);

if($_POST['naslov']=="" or $_POST['poruka']=="")
$msgr="Molimo Vas da ispunite polja označena zvezdicom !";
else
{
include("$page_path2".SUBFOLDER."/class.phpmailer.php");
$mail = new phpmailer();
if($_POST['tns']=="prijave_na_oglas1")
{
$message="<br>Postovani, <br><br>Obaveštavamo Vas da ste primili novu poruku od poslodavca <b>$korisnik</b> kao odgvor na vasu prijavu na oglas <b><a href='$patH1/".replace_implode1($ogl1[nameAds])."-$ogl1[id].html'>$ogl1[nameAds]</a></b><br><br>
PORUKA GLASI:
<br><b>$_POST[naslov]</b><br />
$_POST[poruka]
<br><br>
<a href='$patH1'>$domen</a><br>";
$messageT="\n\rPostovani, 
\n\rObavestavamo Vas da ste primili novu poruku od poslodavca $korisnik kao odgvor na Vasu prijavu na oglas ($ogl1[nameAds]) $patH1/".replace_implode1($ogl1[nameAds])."-$ogl1[id].html
\n\r\n\rPORUKA GLASI:
\n\r$_POST[naslov]
\n\r$_POST[poruka]
\n\r\n\r$domen";
}
if($_POST['tns']=="prijave_na_oglas")
{
$message="<br>Postovani, <br><br>Obavestavamo Vas da ste primili novu poruku od poslodavca <b>$korisnik</b> kao odgvor na Vasu prijavu na oglas <b><a href='$patH1/".replace_implode1($ogl1[nameAds])."-$ogl1[id].html'>$ogl1[nameAds]</a></b><br><br>
Da biste procitali poruku, potrebno je da kliknete na sledeci link koji Vas automatski loguje na sajt $domen i vodi Vas u korisnicki panel, gde cete procitati poruku.
<br>
<a href='$patH1/logins.php?tim=$ge1[date]&pot=$ge1[potvrda]&pri=$zdp1[id]&tip=prij'>Procitaj poruku</a><br><br>$domen<br>";
$messageT="\n\rPostovani, 
\n\r\n\rObavestavamo Vas da ste primili novu poruku od korisnika $korisnik
\n\rDa biste procitali poruku, potrebno je da kliknete na sledeci link koji Vas automatski loguje na sajt $domen i vodi Vas u korisnicki panel, gde cete procitati poruku:
\n\r
$patH1/logins.php?tim=$ge1[date]&pot=$ge1[potvrda]&pri=$zdp1[id]&tip=prij
\n\r\n\r$domen";
}
//echo $message;
$subject="ApartmaniBeogradSmestaj - odgovor poslodavca $korisnik";
if($tips==1)
$mail->From     = $onj1['email'];
else
$mail->From     = "$from_email";
$mail->FromName = "Odgovor poslodavca na konkurs";
$mail->Subject = "$subject";
//$mail->Host     = "smtp1.bv-design.net;smtp2.bv-design.net";
$mail->Mailer   = "mail";
$mail->Body    = replacem($message);
$mail->AltBody = replacem($messageT);
$mail->AddAddress($ge1[email], $subject);
if($_POST['tns']=="prijave_na_oglas") $itab=0; else $itab=1;
mysqli_query($conn, "INSERT INTO kontakt_naprijavu SET user_id='$_SESSION[userid]', suser_id='$zdp1[id_kandidata]', id_por='$_POST[ons]', naslov=".safe($_POST['naslov']?$_POST['naslov']:"").", poruka=".safe($_POST['poruka']?$_POST['poruka']:"").", vreme='$newtime', tab=$itab");
if($mail->Send())
$msgr="Vaša poruka je uspešno poslata kandidatu!";
}
} 

/************ odgovor kandidata na prijavu kandidata ****************/
if($_POST['odgovor_kandidata_naprijavu'])
{ 
$onj=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".safe($_SESSION['userid']).""); 
$onj1=@mysqli_fetch_assoc($onj);
$adp=mysqli_query($conn, "SELECT * FROM adrese_kandidati WHERE user_id=$_SESSION[userid]"); 
$adp1=mysqli_fetch_assoc($adp);  
$korisnik=$adp1['ime'];
$ge=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".safe($_POST['ons'])."");
$tips=mysqli_num_rows($ge);
$ge1=@mysqli_fetch_assoc($ge);
$zdp=mysqli_query($conn, "SELECT * FROM prijave_na_oglas WHERE id_kandidata=".safe($_SESSION['userid']).""); $zdp1=mysqli_fetch_assoc($zdp);
$ogl=mysqli_query($conn, "SELECT * FROM oglasi WHERE id=".safe($zdp1['id_oglasa']).""); 
$ogl1=mysqli_fetch_assoc($ogl);
if($_POST['naslov']=="" or $_POST['poruka']=="")
$msgr="Molimo Vas da ispunite polja označena zvezdicom !";
else
{
include("$page_path2".SUBFOLDER."/class.phpmailer.php");
$mail = new phpmailer();
$message="<br>Postovani, <br><br>Obavestavamo Vas da ste primili novu poruku od poslodavca <b>$korisnik</b> kao odgvor na Vasu prijavu na oglas <b><a href='$patH1/".replace_implode1($ogl1[nameAds])."-$ogl1[id].html'>$ogl1[nameAds]</a></b><br><br>
Da biste procitali poruku, potrebno je da kliknete na sledeci link koji Vas automatski loguje na sajt $domen i vodi Vas u korisnicki panel, gde cete procitati poruku.
<br>
<a href='$patH1/logins.php?tim=$ge1[date]&pot=$ge1[potvrda]&pri=$zdp1[id]&tip=prij'>Procitaj poruku</a><br><br>$domen<br>";
$messageT="\n\rPostovani, 
\n\r\n\rObavestavamo Vas da ste primili novu poruku od korisnika $korisnik
\n\rDa biste procitali poruku, potrebno je da kliknete na sledeci link koji Vas automatski loguje na sajt $domen i vodi Vas u korisnicki panel, gde cete procitati poruku:
\n\r
$patH1/logins.php?tim=$ge1[date]&pot=$ge1[potvrda]&pri=$zdp1[id]&tip=prij
\n\r\n\r$domen";
//echo $message;
$subject="ApartmaniBeogradSmestaj - odgovor poslodavca $korisnik";
$mail->From     = "$from_email";
$mail->FromName = "Odgovor poslodavca na konkurs";
$mail->Subject = "$subject";
//$mail->Host     = "smtp1.bv-design.net;smtp2.bv-design.net";
$mail->Mailer   = "mail";
$mail->Body    = replacem($message);
$mail->AltBody = replacem($messageT);
$mail->AddAddress($ge1['email'], $subject);
mysqli_query($conn, "INSERT INTO kontakt_naprijavu SET user_id='$_SESSION[userid]', suser_id='$_POST[ons]', id_por=".safe($_POST['idpr']).", naslov=".safe($_POST['naslov']?$_POST['naslov']:"").", poruka=".safe($_POST['poruka']?$_POST['poruka']:"").", vreme='$newtime', tab=0");

if($mail->Send())

$msgr="Vaša poruka je uspešno poslata kandidatu!";

}

                    



}



/// nova lozinka ///

if($_POST['posalji'])

{ 

if(empty($_POST['email'])){

$msge="Upišite email adresu!";

}elseif (!empty($_POST['email']) and !mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $_POST['email'])) 

$msge=$langa['contact_form9'];

else

{

$q=mysqli_query($conn, "SELECT * FROM users WHERE email=".safe($_POST['email'])."");

if(mysqli_num_rows($q)==1){

$vreme=time();

$email=$_POST['email'];

$nova=base64_encode($email.$vreme);

$nova1=strtolower(substr($nova,0,8));

$pas=tep_encrypt_password($nova1);



   		$message = $langa['lost_pass5'];

	$tekst1 = $langa['lost_pass6'];

include("$page_path2".SUBFOLDER."/class.phpmailer.php");

$mail = new phpmailer();

 

$subject=$langa['lost_pass7'];

$mail->From     = $from_email;

$mail->FromName = $langa['lost_pass8'];

$mail->Subject = "$subject";

 

 $mail->Mailer   = "mail";

$mail->Body    = 	$message;

    $mail->AltBody = $tekst1;
    $mail->AddAddress($_POST['email']);
    //$mail->AddAddress("aleksandrou@gmail.com");
    if($mail->Send())      

   		{
mysqli_query($conn, "UPDATE users SET password='$pas' WHERE email=".safe($_POST['email'])."");
$msge=$langa['lost_pass9'];
}
} else $msge=$langa['lost_pass10'];
}
}
?>