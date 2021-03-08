<div class='detaljno_smestaj whites'>
<?php 
$zai=mysqli_query($conn, "SELECT * FROM categories_group WHERE id=$id_get");
$zai1=mysqli_fetch_assoc($zai);
$zanas="Upis / izmena modela - <i style='color:#444;'>$zai1[name]</i>";

?>
<script>
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
      }
    });
    });
</script> 
<div class='naslov_smestaj_padd'><h1 class="border_ha"><?php echo $zanas?></h1></div>
 
<script>
 function gog(id)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id

}
</script>
<b>Izaberi ostale modele za izmenu</b>
<select name="" onchange="gog(this.value)" class='selecte'>
<?php 
$mo=mysqli_query($conn, "SELECT * FROM categories_group WHERE tip=2 ORDER BY name ASC");
while($mo1=mysqli_fetch_assoc($mo))
{
if($_GET['id']==$mo1['id']) $sss="selected"; else $sss="";
echo "<option value='$mo1[id]' $sss>$mo1[name]</option>";
}
?>
</select>   
<form method="post" action=""  enctype="multipart/form-data">
<table style='width:100%'>
<tr valign='top'>

<td>                                

 <?php 
if($_GET['uspeh']==1)
$msr="Upisana je stranica. Unesite dodatne izmene za upisanu stranicu!";
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";

?>

<?php 
if($_GET['id']>0)
{
$zz=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model=$id_get");
$zz1=mysqli_fetch_assoc($zz);
?>
<br />
<div class='ui-tabs-panel ipad'>

<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>

<!--
<td>
Uključi fajlove levo: <br />

<?php 
fajlovi(3,"crveno","left","left", $zz1 , $zz1['id_model'])
?>
</td>
-->
 <td  class='form-left-pad'>
 
Uključi fajlove za prikaz na stranici: <br />


<?php 
fajlovi(4,"plavo","middle","middle", $zz1 , $zz1['id_model'])
?>
</td>        

<!--
<td class='form-left-pad'>
Uključi fajlove desno: <br />
<?php 
fajlovi(5,"zuto","right","right", $zz1 , $zz1['id_model'])
?>
</td>
-->
</tr>
</table>
 <!--
 <table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
  <tr valign='top'>
 <td>
 
Uključi fajlove na vrh: <br />

<?php 
fajlovi(1,"zuto","top","top", $zz1 , $zz1['id_model'])
?>
</td>
   
<td class='form-left-pad'>
Uključi fajlove dole: <br />

<?php 
fajlovi(2,"zeleno","footer","footer", $zz1 , $zz1['id_model'])
?>

</td>
</tr>
</table>
-->
 
</div>
 
<div style="float:right;padding-top:15px;">
<input type='submit' name='izmena_modela' class="submit_dugmici_blue" value='Izmeni model stranice'> 
 
</div>
 
 
 

<?php 
}
?>
</form>

 </td>
 </tr>
 </table>
<br />
		
</div> 