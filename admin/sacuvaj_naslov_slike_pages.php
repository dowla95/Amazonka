<?php 
include("../Connections/conn_admin.php");
$page_path3 ="$page_path2/".SUBFOLDER."admin";
$patHA=$patH."/admin";
$id=$_POST[id];
$lang=$_POST[lang];
mysqli_query($conn, "UPDATE slike_paintb SET naslov$lang=".safe($_POST[naslov])." WHERE id=$id");
if(mysqli_affected_rows()>0)
echo "IZMENJENO";
?>
