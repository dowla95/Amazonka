<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Smestaj poseduje - stavke</h1></div>
 
 
 
<script> 
function gog(id)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
}
</script>
 
<?php 
if($_POST[save_stavkes])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
$naziv="novastavka$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."naziv$jez=".safe($_POST[$naziv]);
$i++; 
 }
$tips=$_POST[tips]; 
//echo $nazivis;
  if(!mysqli_query($conn, "INSERT INTO categories_content SET $nazivis, tip=$tips")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Upisano</div></div>";
}
if($_POST[izmene_stavkes])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
$naziv="starastavka$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."naziv$jez=".safe($_POST[$naziv]);
$i++; 
 }
$tips=$_POST[tipsa]; 
 if(!mysqli_query($conn, "UPDATE categories_content SET $nazivis, tip=$tips WHERE id=$id_get")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Izmenjeno</div></div>"; 
 
}
if($_POST[obrisi_stavkes])
{
mysqli_query($conn, "DELETE FROM content_oglas WHERE ids=$_GET[id]");
mysqli_query($conn, "DELETE FROM categories_content WHERE id=$_GET[id]");
 echo "<div class='infos1'><div>Obrisano</div></div>";
}
?> 
  
<form method="post" action="">
<ul class='forme_klasicne'>
<li>
<span>Apartmani poseduju</span>
 
<select name="kat" class='selecte' onchange="gog(this.value)">
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=0 ORDER BY nazivslo ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
       if($tz1[id]==$_GET[id]) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?>><?php echo $tz1[nazivslo]?></option>
						         	 <?php 
                      }
                        ?>
						                    </select>
                        
</li>
<li>
<span>Lokacija apartmana (centar, vracar)</span>
 
<select name="kat" class='selecte' onchange="gog(this.value)">
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=1 ORDER BY nazivslo ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
       if($tz1[id]==$_GET[id]) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?>><?php echo $tz1[nazivslo]?></option>
						         	 <?php 
                      }
                        ?>
						                    </select>
                        
</li>
<li>
<span>Tip smestaja</span>
 
<select name="kat" class='selecte' onchange="gog(this.value)">
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=2 ORDER BY nazivslo ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
       if($tz1[id]==$_GET[id]) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?>><?php echo $tz1[nazivslo]?></option>
						         	 <?php 
                      }
                        ?>
						                    </select>
                        
</li>
<?php 
if($_GET[id]>0)
{
?>
<li style='background:#444;color:white;'>
<div style='padding:10px 10px; 0px 10px'>
 
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <tr>
 <?php 
 
$zz=mysqli_query($conn, "SELECT * FROM categories_content WHERE id=$id_get");
$zz1=mysqli_fetch_array($zz); 
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {

$jez=$la1[jezik];
$naziv="naziv$jez";
$nazivi=$zz1[$naziv];
 ?>
<!-- <td align='right' style='width:25px;padding-right:5px;'>
<?php echo $la1[jezik]?>
 </td>-->
 <td>
<input type="text" value="<?php echo $nazivi?>" name='starastavka<?php echo $jez?>' class='selecte' style='width:99%' />
 </td>
 <td width="5"></td>
 <?php 
 }
 if($zz1[tip]==0) $ctips="selected"; else $ctips="";
 if($zz1[tip]==1) $ctips1="selected"; else $ctips1="";
 if($zz1[tip]==2) $ctips2="selected"; else $ctips2="";
 ?>
<td>tip <select name='tipsa'>
<option value='0' <?php echo $ctips?>>Apartmani poseduju</option>
<option value='1' <?php echo $ctips1?>>Lokacija</option>
<option value='2' <?php echo $ctips2?>>Tip smestaja</option>
</select></td>
 <td width="100"><input type='submit' name='izmene_stavkes' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'></td>
 <td width="100" align="right"><input type='submit' name='obrisi_stavkes' class="submit_dugmici_blue" value='Obriši'></td>
 </tr>
 </table>
 </div>
</li>
<?php 
}
?>
<li>
 <br />
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <tr>
 <?php 
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
 <!--<td align='right' style='width:25px;padding-right:5px;'>
 <?php echo $la1[jezik]?></td>-->
 <td>
 <?php 
 $jez=$la1[jezik];
 ?>
 <input type="text" name='novastavka<?php echo $jez?>' class='selecte' style='' />
 </td>
 <?php 
 }
 ?>
 <td width="5"></td>
<td><select name='tips' class='selecteb'>
<option value='0'>Apartmani poseduju</option>
<option value='1'>Lokacija</option>
<option value='2'>Tip smestaja</option>
</select></td>
 </tr>
 </table>
</li>
<li>

<input type='submit' name='save_stavkes' class="submit_dugmici_blue" value='<?php echo $langa['language'][3]?>'>
 </li>
 </ul>
<br />

</form>

		
</div> 




			

