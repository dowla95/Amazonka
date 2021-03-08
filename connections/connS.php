<?php 
include("configs.php");
$conn = @mysqli_connect($hostname_conn, $username_conn, $password_conn) or die(mysqli_error());
mysqli_select_db($database_conn, $conn) or die(mysqli_error());
mysqli_query($conn, "SET NAMES utf8");
mysqli_query($conn, "SET CHARACTER SET utf8");
mysqli_query($conn, "SET COLLATION_CONNECTION='utf8_unicode_ci'");
include($page_path2.SUBFOLDER."/include/functions.php");
$search_values=explode("?",strip_tags(curPageURL()));
$nodom=str_replace("$patH1/","",$search_values[0]);
$sodom_ex=$nodom_ex=explode("/",$nodom);
$nodom_ex_r=array_reverse($nodom_ex);
if($nodom_ex_r[0]=="" or mb_eregi("/\?",$nodom))
array_shift($nodom_ex_r);
if(!preg_match("/.php/",$nodom_ex_r[0]) and !preg_match("/.html/",$nodom_ex_r[0])) $ici="/"; else $ici="";
$my_lang=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' ORDER BY pozicija");
while($mylang=mysqli_fetch_assoc($my_lang))
{
$jezici[]=$mylang['jezik'];
if($nodom_ex[0]==$mylang['jezik'])
{
$lang=$mylang['jezik'];
$langu=$mylang['jezik'];
array_shift($nodom_ex);
}
}
$fullink=implode("/",$nodom_ex);
if($lang=="")
{
$lang=$jezici[0];
$patH1=$patH1;
}else
$patH1=$patH1."/$lang";
if(isset($_GET['lang']) and $_GET['lang']!="")
$lang=strip_tags($_GET['lang']);
$allpage = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang'");
$all_links=array();
while($allpage1=mysqli_fetch_assoc($allpage))
{
$all_links[$allpage1['id']]=$allpage1['ulink'];
}
//print_r($all_links);
if($sodom_ex[0]!="")
{
$page = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  ulink=".safe($sodom_ex[0])."");
$page1=mysqli_fetch_assoc($page);
if($page1['id']>0)
$ceolink=1;
}
else
{
$page=mysqli_query($conn, "SELECT  *, case when ulink IS NULL or ulink = ''
            then 'empty'
            else ulink
       end as ulink  FROM pagel WHERE lang='$lang'");
$page1=mysqli_fetch_assoc($page);
}
if($page1['id']>0 and $sodom_ex[1]!="")
{
$spage = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  ulink=".safe($sodom_ex[1])." AND p.id_parent=$page1[id_page]");
$spage1=mysqli_fetch_assoc($spage);
$titles=$spage1['title']?$spage1['title']:$page1['naziv']." / ".$spage1['naziv'];
$keywords=$spage1["keywords"];
$descripts=$spage1["description"];
}
if($page1['id']>0 and mb_eregi(".html",$nodom_ex_r[0]))
{
if(isset($spage1['id_page'])) $ipagers=$spage1['id_page']; else $ipagers=$page1['id_page'];
$pate = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt='Y' AND p.id_page=$ipagers AND ulink=".safe(str_replace(".html","",$nodom_ex_r[0]))."");
$pate1=mysqli_fetch_array($pate);
if($pate1['id']>0)
{
$titles=$pate1['title']?$pate1['title']:$pate1['naslov'];
$keywords=$pate1["keywords"];
$descripts=$pate1["description"];
$and_tekst=" AND p.id=$pate1['id']";
$idup=$pate1['id'];
}
}
else
if($page1['id']>0 and $sodom_ex[1]!="" and empty($spage1['id']))
{
$pate = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt='Y' AND p.id_page=$page1[id_page] AND ulink=".safe($nodom_ex_r[0])."");
$pate1=mysqli_fetch_array($pate);
if($pate1['id']>0)
{
$titles=$pate1['title']?$pate1['title']:$pate1['naslov'];
$keywords=$pate1["keywords"];
$descripts=$pate1["description"];
$and_tekst=" AND p.id=$pate1['id']";
$idup=$pate1['id'];
}
if(empty($pate1['id'])){
$dztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id_page=$page1[id_page] AND ulink=".safe($nodom_ex_r[0])."");
$dztz1=mysqli_fetch_array($dztz);
$titles=$dztz1['title']?$dztz1['title']:$dztz1['naslov'];
$keywords=$dztz1["keywords"];
$descripts=$dztz1["descriptions"];
}
if(empty($pate1['id']) and empty($dztz1['id'])){
       $ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND  p.akt=1 AND  ulink=".safe($sodom_ex[1])." AND p.id_cat=32");
$ztz1=mysqli_fetch_array($ztz);
$titles=$ztz1['title']?$ztz1['title']:$ztz1['naziv']." | ".$page1["title"];
$keywords=$ztz1["keywords"];
$descripts=$ztz1["descriptions"];
}
}
else
if($page1['id']>0 and empty($spage1['id']))
{
$titles=$page1["title"]?$page1["title"]:$page1["h1"];
if($titles=="") $titles=$page1["naziv"];
$keywords=$page1["keywords"];
$descripts=$page1["description"]?$page1["description"]:$page1["h1"];
if($page1['ulink']==$all_links[11] or $page1['ulink']==$all_links[12])
{
$prof=mysqli_query($conn, "SELECT * FROM users_data WHERE nickname=".safe(strip_tags($nodom_ex_r[0]))." AND akt='Y' AND akt1='1'");
$prof1=mysqli_fetch_assoc($prof);
}
}
$arrayV = array();
$arrayD = array();
$arrayM = array();
$arrayL = array();
$arrayR = array();
$arrayF = array();
$arrayT = array();
if($page1['id']>0)
{
if(isset($spage1['id']) and $spage1['id']>0)
$fper=mysqli_query($conn, "SELECT * FROM page WHERE id='$spage1[id_page]'");
else
$fper=mysqli_query($conn, "SELECT * FROM page WHERE id='$page1[id_page]'");
$fper1=mysqli_fetch_assoc($fper);
if($dztz1['id']>0 and $fper1['model1']>0) $modelcic=$fper1['model1']; else
$modelcic=$fper1['model'];
$iper=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model='$modelcic'");
$iper1=mysqli_fetch_assoc($iper);
if($iper1['include_file_vrh']!="")
$arrayV = explode(",",$iper1['include_file_vrh']);
if($iper1['include_file_dole']!="")
$arrayD = explode(",",$iper1['include_file_dole']);
if($iper1['include_file_middle']!="")
$arrayM = explode(",",$iper1['include_file_middle']);
if($iper1['include_file_left']!="")
$arrayL = explode(",",$iper1['include_file_left']);
if($iper1['include_file_right']!="")
$arrayR = explode(",",$iper1['include_file_right']);
if($iper1['include_file_footer']!="")
$arrayF = explode(",",$iper1['include_file_footer']);
if($iper1['include_file_top']!="")
$arrayT = explode(",",$iper1['include_file_top']);
$class_left=$iper1['class_left'];
$class_middle=$iper1['class_middle'];
$class_right=$iper1['class_right'];
if($iper1['katu_pod']>0)
{
$ziper=mysqli_query($conn, "SELECT * FROM page_settings WHERE id_page='$iper1[katu_pod]'");
$ziper1=mysqli_fetch_assoc($ziper);
if($ziper1['include_file_vrh']!="")
$arrayV = explode(",",$ziper1['include_file_vrh']);
if($ziper1['include_file_dole']!="")
$arrayD = explode(",",$ziper1['include_file_dole']);
if($ziper1['include_file_middle']!="")
$arrayM = explode(",",$ziper1['include_file_middle']);
if($ziper1['include_file_left']!="")
$arrayL = explode(",",$ziper1['include_file_left']);
if($ziper1['include_file_right']!="")
$arrayR = explode(",",$ziper1['include_file_right']);
if($ziper1['include_file_footer']!="")
$arrayF = explode(",",$ziper1['include_file_footer']);
if($ziper1['include_file_top']!="")
$arrayT = explode(",",$ziper1['include_file_top']);
$class_left=$ziper1['class_left'];
$class_middle=$ziper1['class_middle'];
$class_right=$ziper1['class_right'];
}
$contD=count($arrayD);
$contV=count($arrayV);
$contM=count($arrayM);
$contL=count($arrayL);
$contR=count($arrayR);
$contT=count($arrayT);
$contF=count($arrayF);
}
include("$page_path2".SUBFOLDERS."/language/$lang.php");
/*if($lang=='slo')
$patH1=$patH1;
  else
$patH1=$patH1."/".$lang;
 */
$base_arr=base_ret($_GET[base]);
$base_arr_r=base_ret_rev(curPageURL());
//echo $base_arr_r[0];
$strana = $_SERVER['PHP_SELF'];
$exp_str=explode("/",$strana);
$rev_str=array_reverse($exp_str);
$file_exp=explode(".php",$rev_str[0]);
$file_p="$file_exp[0]".".php";
$sett=mysqli_query($conn, "SELECT * FROM settings");
while($sett1=mysqli_fetch_assoc($sett))
{
$polje=$sett1[fields];
$settings[$polje]=$sett1[vrednosti];
}
define("EVRO",$settings['evro_iznos']);
$ge=array("");
$geti=array("");
putenv ("TZ=Europe/Belgrade");
$stav = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND id_cat=8 ORDER BY -position DESC");
$drz_arr[]="---";
while($stav1=mysqli_fetch_assoc($stav))
{
$drz_arr[]=$stav1['naziv'];
}
$staV = mysqli_query($conn, "SELECT p.*, pt.*, pt.id as ide, p.id as id
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page
        WHERE pt.lang='$lang' AND id_cat=17 ORDER BY -position DESC");
$drz_arr1[]="---";
while($staV1=mysqli_fetch_assoc($staV))
{
$drz_arr1[]=$staV1['naziv'];
}
//$drz_arr=array("---", "Austrija", "Nemačka", "Francuska", "Italija", "SAD", $arrwords2['orijent4']);
//$drz_arr1=array("---", "Srbija", "Hrvatska", "Bosna i Hercegovina", "Crna Gora", "Makedonija", $arrwords2['orijent5']);
$or_arr=array("---", $arrwords2['orijent1'], $arrwords2['orijent2'], $arrwords2['orijent3'], $arrwords2['orijent4']);
$tra_arr=array("---", $arrwords2['tmuski'], $arrwords2['tzenski'],
$arrwords2['tnebitno']);
$sta_arr=array("---", $arrwords2['sta1'], $arrwords2['sta2'],
$arrwords2['sta3'], $arrwords2['sta4']);
$ovde_arr=array("---", $arrwords2['ovde1'], $arrwords2['ovde2'],
$arrwords2['ovde3'], $arrwords2['ovde4'], $arrwords2['ovde5']);
include($page_path2."/".SUBFOLDERS."include/login_check.php");
if($page1['show_for_users']==1 and  !isset($_SESSION['userid']))
{
$_SESSION['forredi']=curPageURL();
header("location: $patH1/".$all_links[10]."/");
}
if(isset($_SESSION['userid']) and $_SESSION['userid']>0)
{
$blo=mysqli_query($conn, "SELECT * FROM kontakt_blok WHERE bloker='$_SESSION[userid]' OR blokiran='$_SESSION[userid]'");
$oht=$oht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$oht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$oht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
$blo=mysqli_query($conn, "SELECT * FROM kontakt_blok_privremena WHERE bloker='$_SESSION[userid]' or blokiran='$_SESSION[userid]'");
$zoht=$zoht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$zoht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$zoht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
$blo=mysqli_query($conn, "SELECT * FROM kontakt_prijatelji WHERE bloker='$_SESSION[userid]' OR blokiran='$_SESSION[userid]'");
$poht=$oht1=array();
while($blo1=mysqli_fetch_assoc($blo))
{
$poht[$blo1['tip']][$blo1['bloker']]=$blo1['blokiran'];
$poht1[$blo1['tip']][$blo1['blokiran']]=$blo1['bloker'];
}
}
$search_values=explode("?",strip_tags(curPageURL()));
if($search_values[1])
{
$search_values[1]=urldecode($search_values[1]);
parse_str($search_values[1],$sarray);
parse_str($search_values[1],$sarrayP);
/*foreach($sarram as $key => $valt)
{
$sarray[$key]=strip_tags($valt);
$sarrayP[$key]=strip_tags($valt);
}*/
//unset($sarrayP['p']);
}
if(!isset($_SESSION['userid']) and $page1['show_for_users']==1)
header("location: $patH1/$all_links[10]/");
//if($page1['show_for_users']==1 and !isset($_SESSION['userid']))
//header("location: $patH1/$all_links[10]/");
if(empty($dztz1['id']) and empty($pate1['id']) and empty($page1['id']))
$nstop=100;
?>