<?php 
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors',1);
$tipov=array("","Naslovna","Akcija","NOVI","","Izdvojeni");
$Adminmail="stogoran@gmail.com";
$din="€";
$ddv=20;
$uk_gr=176;
$higs=110;
$from_email="noreply@amazonka.rs";
$replyto_email="office@amazonka.rs"; 
define("FILFOLDER","/files");
define("GALFOLDER","/galerija");
define("SUBFOLDER", ""); //  /private
define("SUBFOLDERS", ""); //  private/

define("FOLDERTINYMC", $_SERVER['DOCUMENT_ROOT']."/images-text/");



$domen="amazonka.rs";
$patH="https://$domen".SUBFOLDER;
$patHA="https://".$domen.SUBFOLDER."/admin";
$patH1="https://$domen";

define("PATH", $patH);

$hostname_conn = "mysql686.loopia.se";
$database_conn = "amazonka_rs";
$username_conn = "goxi@a53798";
$password_conn = "WGX2EBVzf";

$page_path = dirname(__FILE__) ;
if(mb_eregi("xampp",$page_path))
$page_path1=explode("\\",$page_path);
else
$page_path1=explode("/",$page_path);
array_pop($page_path1);
//array_pop($page_path1);
$page_path2=implode("/",$page_path1);
$hide_cats=0;
$hide_stavkeZ=0;
$hide_stavke=1;

$nizSub=array(0=>"---", "1-1"=>"Logo", "2-1"=>"Slika (Logo) u footeru", "3-1"=>"Favicon", 4=>"3 reklamna banera", 5=>"2 reklamna banera", 6=>"1 reklamni baner");