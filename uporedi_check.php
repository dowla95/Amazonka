<?php
session_start();
$sidu="uporedi";

if(isset($_SESSION[$sidu]) && count($_SESSION[$sidu])==4)
$niz1=4;
else {

include("Connections/conn.php");
$idd=$_POST['idpro'];
//unset($_SESSION[$sidu][0]);
$i=1;
if(!isset($_SESSION[$sidu]) or (isset($_SESSION[$sidu]) && count($_SESSION[$sidu])<5)){
if($idd>0 and !isset($_SESSION[$sidu][$idd])) {
$_SESSION[$sidu][$idd]=$idd;
}
if(isset($_SESSION[$sidu])) {
foreach($_SESSION[$sidu] as $key => $value)
{
if($i>4 and count($_SESSION[$sidu])>5)
unset($_SESSION[$sidu][$value]);
$i++;
}
}
}
if(isset($_POST['ukloni']))
{
$ukloni=$_POST['ukloni'];
unset($_SESSION[$sidu][$ukloni]);
}
$c=1;
$novi=array();
if(isset($_SESSION[$sidu]))
foreach($_SESSION[$sidu] as $key => $value)
{
$novi[$c]=$value;
$c++;
}
if(isset($_SESSION[$sidu]) && count($_SESSION[$sidu])>0)
$niz1='<a href="'.$patH1.'/'.$all_links[11].'/"><i class="fal fa-balance-scale""></i></a>';
}
if(isset($_SESSION[$sidu]) && count($_SESSION[$sidu])>0)
$niz2=count($_SESSION[$sidu]);
else
$niz2=0;
echo json_encode(array($niz1, $niz2));