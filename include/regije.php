<?php 
session_start();
include("../Connections/conn.php");
$id=$_POST['ide'];
if($id==34)
{
echo "<option value=''> --- </option>";
$po=mysqli_query($conn, "SELECT * FROM countryes  WHERE id_parent=".safe($id)." AND nivo=2 ORDER BY name ASC");
while($po1=mysqli_fetch_assoc($po))
{
echo "<optgroup label='$po1[name]'>";
$spo=mysqli_query($conn, "SELECT * FROM countryes  WHERE id_parent=".safe($po1['id'])." ORDER BY name ASC");
while($spo1=mysqli_fetch_assoc($spo))
{
if($_POST['reg']==$spo1['id'])
  $regi="selected"; else $regi="";
echo "<option value='$spo1['id']' $regi>$spo1[name]</option>";
}
echo "</optgroup>";
}
}else
{
echo "<option value=''> --- </option>";
$po=mysqli_query($conn, "SELECT * FROM countryes  WHERE id_parent=".safe($id)." AND nivo=2 ORDER BY name ASC");
while($po1=mysqli_fetch_assoc($po))
{
if($_POST['reg']==$po1['id'])
  $regi="selected"; else $regi="";
echo "<option value='$po1['id']' $regi>$po1[name]</option>";
}
}
?>