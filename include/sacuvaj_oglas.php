<?php 
include("Connections/conn.php");
session_start();
if(!$_COOKIE['soglasi']) $_SESSION['soglasi']="";
if(!$_SESSION['soglasi'] and isset($_COOKIE['soglasi'])) 
$_SESSION['soglasi']=$_COOKIE['soglasi'];
$nizic=explode(",",$_SESSION['soglasi']);
foreach($nizic as $key => $value)
{
if($value>0)
{
$my=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM oglasi WHERE id=$value"));
if($my==0)
{
unset($nizic[$key]);
}
}
}
if($nizic[0]=="")
array_shift($nizic);
if(!in_array($_POST['id'],$nizic))
{
$nizic[]=$_POST['id'];
$novi=implode(",",$nizic);
$_SESSION['soglasi']=$novi;
$link="<a href='javascript:;' onclick=\"sacuvaj_oglas('$_POST['id']')\" class='save1'><span>Sačuvan oglas</span></a>"; 
}else
{
if (($key = array_search($_POST['id'], $nizic)) !== false) 
    unset($nizic[$key]);
$novi=implode(",",$nizic);
$_SESSION['soglasi']=$novi;
$link="<a href='javascript:;' onclick=\"sacuvaj_oglas('$_POST['id']',0)\" class='save'><span>Sačuvaj oglas</span></a>"; 
}
setcookie("soglasi", $novi, time()+60*60*24*30, "/");
 
//echo $_SESSION[soglasi]; 
$niv=array($link,$novi,count($nizic));
echo json_encode($niv);
?>