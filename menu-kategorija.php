<!-- MENU kategorija pocetak -->
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
        WHERE pt.lang='$lang' AND (p.id_cat=32) AND p.id IN (".implode(",",katImaPro()).") ORDER BY p.position ASC");
   while($me1=mysqli_fetch_array($tz))
     {
$benuArr[$me1['nivo']][]=$me1;
$benuArrp[$me1['parent']][]=$me1;
$nArrp[$me1['ide']]=$me1;
}
$ce=0;
foreach($benuArr[1] as $ke => $me1)
{
if(is_array($benuArrp[$me1['ide']])){
foreach($benuArrp[$me1['ide']] as $zzzzz => $nnnnn) {
$dukis=$benuArrp[$nnnnn['ide']] && count($benuArrp[$nnnnn['ide']]);
}
}
if(is_array($benuArrp[$me1['ide']])) $prom=count($benuArrp[$me1['ide']]); else $prom=0;
if($prom>0) $ulinka="javascript:void(0)";
else {
if(isset($me1['aktivan']) and $me1['aktivan']==0)
$ulinka="#";
else
if(preg_match("/.php/",$me1['ulink'])) $ulinka=$me1['ulink'];
else if($me1['ulink']!="") $ulinka=$patH1."/proizvodi/".$me1['ulink']."/";
else $ulinka="$patH1/";
}
if($me1['class_for_icon']!="") $uklas=" class='".$me1['class_for_icon']."'"; else $uklas="";
if($page1['id']==$me1['ide']) $curre=' class="active"'; else $curre="";

if($benuArrp[$me1['ide']] && count($benuArrp[$me1['ide']])>0)
$strdesno=" <span class='lnr lnr-chevron-right'></span>"; else $strdesno="";
//if($benuArrp[$me1['ide']] && count($benuArrp[$me1['ide']])>0){
if($me1['mega_menu']==1) {
$ecc=" class='mega-menu mega-full'";
$ecc1=" class='mega-title'";
$static=" class='static'";
$ecc2="";
}
else {
$ecc2=$ecc=" class='dropdown'";
$ecc1="";
$static="";
}
?>
<li<?php echo $static?>><a href="<?php echo $ulinka?>" title="<?php echo $me1['naziv']?>"><?php echo $me1['naziv'].$strdesno?></a>
<?php
$pros = mysqli_query($conn,"SELECT slika FROM page WHERE id=3");
$pros1 = mysqli_fetch_assoc($pros);
if($benuArrp[$me1['ide']] && count($benuArrp[$me1['ide']])>0){
?>
<ul<?php echo $ecc?>>
<?php
foreach($benuArrp[$me1['ide']] as $ce => $ze1)
{
if(is_array($benuArrp[$ze1['ide']])) $prome=count($benuArrp[$ze1['ide']]); else $prome=0;
if ($prome>0) {
$klink="javascript:void(0)";
$li="";
}
else {
$ulinka1=$ze1['ulink']."/";
$ulinkar=$me1['ulink']."/";
$ulinka1=$ze1['ulink'];
$klink=$patH1."/proizvodi/".$me1['ulink']."/".$ze1['ulink']."/";
$li="</li>";
}
if($ze1['slika']!="" and $me1['mega_menu']==1) $slikkat="<img class='d-none d-lg-block d-xl-block float-left katimg1' src='".$patH."/".GALFOLDER."/".$ze1['slika']."' alt='".$ze1['naziv']."' title='".$ze1['naziv']."'>"; else $slikkat="";
if($ze1['class_for_icon']!="") $uklas1=" class='".$ze1['class_for_icon']."'"; else $uklas1="";
if($benuArrp[$ze1['ide']] && count($benuArrp[$ze1['ide']])>0 and $me1['mega_menu']==0)
$strdesno1=" <span class='lnr lnr-chevron-right'></span>"; else $strdesno1="";
?>
<li<?php echo $ecc1?>>
<a href="<?php echo $klink?>" title="<?php echo $ze1['naziv']?>">
<?php echo $slikkat.$ze1['naziv']." ".$strdesno1?>
</a><?php echo $li?>
<?php
if($benuArrp[$ze1['ide']] && count($benuArrp[$ze1['ide']])>0){
?>
<ul<?php echo $ecc2?>>
<?php
foreach($benuArrp[$ze1['ide']] as $ce => $ne1)
{
if($ne1['slika']!="" and $me1['mega_menu']==1) $slikkat2="<img class='d-none d-lg-block d-xl-block float-left katimg1' src='".$patH."/".GALFOLDER."/".$ne1['slika']."' alt='".$ne1['naziv']."' title='".$ne1['naziv']."'>"; else $slikkat2="";
if($ne1['ulink']!="") $ulinka1=$ne1['ulink']."/"; else $ulinka1="";
if($me1['ulink']!="") $ulinkar=$me1['ulink']."/"; else $ulinkar="";
if(preg_match("/.php/",$ne1['ulink']))
$ulinka1=$ne1['ulink'];
if($ne1['class_for_icon']!="") $uklas1=" class='".$ne1['class_for_icon']."'"; else $uklas1="";
?>
<li><a href="<?php echo $patH1?>/proizvodi/<?php echo $me1['ulink']?>/<?php echo $ze1['ulink']?>/<?php echo $ulinka1?>" title="<?php echo $ne1['naziv']?>"><?php echo $slikkat2.$ne1['naziv']?></a></li>
<?php
}
?>
</ul>
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
$ce=0;
?>
<!-- MENU kategorija kraj -->