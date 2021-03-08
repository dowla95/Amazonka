<?php 
include("header-top.php");
$te=mysqli_query($conn, "SELECT * FROM pages_text WHERE id='$idu'");
$te1=mysqli_fetch_array($te);
$ve=mysqli_query($conn, "SELECT * FROM pages_text_lang WHERE id_text='$te1[id]' and lang='$firstlang'");
$ve1=mysqli_fetch_array($ve);
 
?>
<body>
<script>
  
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   
 
      }
    });
    });
</script> 
<div class='detaljno_smestaj whites'>
 
 
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td>

	<div class='naslov_smestaj_padd'><h1 class="border_ha" style='font-size:15px;'>Istakni tekst <span style='color:black'><?php echo $ve1['naslov']?></span> na odredjenoj poziciji stranica koje koriste odredjene modele:</h1></div>
</td>

 
 

</tr>
</table>        
 
 
<?php 
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
 
 
?> 

<form method="post" action=""  enctype="multipart/form-data">
<table style='width:100%'>
<tr valign='top'>

<td>                                

 <?php 


 
if($idu>0)
{
?>

 <script>
 function gog(id,tip)
{
if(id!="")
window.location="prikaz_text.php?idu=<?php echo $idu?>&tip=<?php echo $_GET[tip]?>&"+tip+"="+id;

}
</script>
<span>Izaberi stranicu na kojoj zelite da se prikaze ovaj tekst na odredjenom delu stranice</span>
 
<select name="kat" class='selecte' onchange="gog(this.value,'id_mod')">
<option value=''>Izaberi model stranice</option>    
      
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM  categories_group WHERE tip=2 ORDER BY name ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
  
  if($tz1[id]==$_GET['id_mod']) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?> style="font-weight:bold;color:black;"><?php echo $tz1[name]?></option>
					<?php             
                      }
                        ?>
						                    </select>
        <?php 
 
 

if($_GET[id_mod]>0)
{
echo "<input type='hidden' value='$_GET[id_mod]' name='id_mod' />";
$zz=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model=$_GET[id_mod]");
$zz1=mysqli_fetch_assoc($zz);

?>
 
<br />
<div class='ui-tabs-panel ipad'>




 



 <table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
  <tr valign='top'>
 <td>
 
Uključi fajlove na vrh: <br />

<?php 
 

fajlovi(1,"zuto","top","top", $zz1 , $zz1['id_model'],"$_GET[tip]-$idu",$ve1['naslov'])
?>
</td>
   
<td class='form-left-pad'>
Uključi fajlove dole: <br />

<?php 
fajlovi(2,"zeleno","footer","footer", $zz1 , $zz1['id_model'],"$_GET[tip]-$idu",$ve1['naslov'])
?>

</td>
</tr>
</table>
<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>
 

<td>
Uključi fajlove levo: <br />

<?php 
fajlovi(3,"crveno","left","left", $zz1 , $zz1['id_model'],"$_GET[tip]-$idu",$ve1['naslov'])
?>
</td>
 <td  class='form-left-pad'>
 
Uključi fajlove u sredini: <br />


<?php 
fajlovi(4,"plavo","middle","middle", $zz1 , $zz1['id_model'],"$_GET[tip]-$idu",$ve1['naslov'])
?>
</td>        

 
<td class='form-left-pad'>
Uključi fajlove desno: <br />


<?php 
fajlovi(5,"zuto","right","right", $zz1 , $zz1['id_model'],"$_GET[tip]-$idu",$ve1['naslov'])
?>
</td>

</tr>
</table>
 

 
 
 
</div>
 
<div style="float:right;padding-top:15px;">
<input type='submit' name='izmena_modela' class="submit_dugmici_blue" value='Izmeni model stranice'> 
 
</div>
 
 
 

<?php 
}
}
?>
</form>
		
</div> 

</body>
</html>	

