<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">City Add / Change</h1></div>
 
 

<script> 
function gog(id)
{
if(id>0)
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>";
}
</script>
 
<?php 
 $inp_niz=array("naziv","title","keywords","description");

if($_POST[save_stavke])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
foreach($inp_niz as $key => $value)
{
$naziv="n$value$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."$value$jez=".safe($_POST[$naziv]);
if($value=="naziv")
$nazivis .=", $value$jez=".safe(replace_implode2($_POST[$naziv]));
$i++;
} 
}
$tips=$_POST[tips]; 
 if($id_get>0)
 {
$zz=mysqli_query($conn, "SELECT * FROM city_name WHERE id=$id_get");
$zz1=mysqli_fetch_array($zz);
$nivo=$zz1[nivo]+1;
$nivos=", id_parent=$id_get, nivo=$nivo"; 
 }
  if(!mysqli_query($conn, "INSERT INTO city_name SET $nazivis$nivos, include_file_middle=".safe($_POST[include_middles]).", include_file_left=".safe($_POST[include_lefts]).", include_file_right=".safe($_POST[include_rights]).", include_file_footer=".safe($_POST[include_footers]).", include_file_top=".safe($_POST[include_tops])."")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Upisano</div></div>";
}
if($_POST[izmene_stavke])
{
$i=0;
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
foreach($inp_niz as $key => $value)
{
$naziv="s$value$jez";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."$value$jez=".safe($_POST[$naziv]);
if($value=="naziv")
$nazivis .=", $value"."1$jez=".safe(replace_implode2($_POST[$naziv]));
$i++;
}
 
 }

$tips=$_POST[tipsa]; 
$position=$_POST[pozicija];
if($_POST[katu]>0)
{
$sn=mysqli_query($conn, "SELECT * FROM city_name WHERE id=$_POST[katu]");
$sn1=mysqli_fetch_array($sn);
$novi_nivo=$sn1[nivo]+1;
$katu=", nivo=$novi_nivo, id_parent=$sn1[id]";
}
if($_POST[akt]==1) $akt=1; else $akt=0;
//echo $nazivis;
 if(!mysqli_query($conn, "UPDATE city_name SET $nazivis, position=$position, akt=$akt, include_file_middle=".safe($_POST[include_middle]).", include_file_left=".safe($_POST[include_left]).", include_file_right=".safe($_POST[include_right]).", include_file_footer=".safe($_POST[include_footer]).", include_file_top=".safe($_POST[include_top]).", tip_layout=".safe($_POST[lay])."$katu WHERE id=$id_get")) echo mysqli_error(); else
 echo "<div class='infos1'><div>Izmenjeno</div></div>"; 
 
}
if($_POST[obrisi_stavke])
{

mysqli_query($conn, "DELETE FROM city_name WHERE id=$_GET[id]");
 echo "<div class='infos1'><div>Obrisano</div></div>";
 
}
?> 
  
<form method="post" action="">
<ul class='forme_klasicne'>
<li>
<span>Izaberi stavku za izmenu</span>
 
<select name="kat" class='selecte' onchange="gog(this.value)">
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM city_name  WHERE nivo=1 ORDER BY nazivslo ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
 $mn=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM oglasi WHERE id_cat=$tz1[id]"));       
  if($tz1[id]==$_GET[id]) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?> style="font-weight:bold;color:black;"><?php echo $tz1[nazivslo]?> (<?php echo $mn?>)</option>
						         	 <?php 
                       
$hz=mysqli_query($conn, "SELECT * FROM city_name  WHERE id_parent=$tz1[id] order by -position DESC, nazivslo ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
$mn1=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM oglasi WHERE id_cat=$hz1[id]"));          
  if($hz1[id]==$_GET[id]) $selet="selected"; else $selet="";
                      ?>
<option value="<?php echo $hz1[id]?>" <?php echo $selet?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1[nazivslo]?> (<?php echo $mn1?>)</option>
						         	 <?php 
                      }
                       
                      }
                        ?>
						                    </select>
                        
</li>
 
<?php 
if($_GET[id]>0)
{
?>
<li>
<span>Prebaci u</span>
 
<select name="katu" class='selecte'>
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM city_name  WHERE nivo=1 ORDER BY nazivslo ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
                      ?>
<option value="<?php echo $tz1[id]?>"><?php echo $tz1[nazivslo]?> (<?php echo $mn?>)</option>
						         	 <?php 
                       
$hz=mysqli_query($conn, "SELECT * FROM city_name  WHERE id_parent=$tz1[id] order by -position DESC, nazivslo ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
                      ?>
<option value="<?php echo $hz1[id]?>">&nbsp;&nbsp;<?php echo $hz1[nazivslo]?> (<?php echo $mn1?>)</option>
						         	 <?php 
                      }
                       
                      }
                        ?>
						                    </select>
                        
</li>
<li style='background:#444;color:white;'>
<div style='padding:10px 10px; 0px 10px'>
 
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <?php 

 foreach($inp_niz as $key => $value)
 {
 ?>
 <tr>
 <?php 
 
$zz=mysqli_query($conn, "SELECT * FROM city_name WHERE id=$id_get");
$zz1=mysqli_fetch_array($zz); 
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 $n=0;
 while($la1=mysqli_fetch_array($la))
 {
  if($n>0) $stp=" style='padding-left:5px;'"; else $stp="";
$jez=$la1[jezik];
$naziv="$value$jez";
$nazivi=$zz1[$naziv];
 ?>

 <td<?php echo $stp?>>
 <?php echo $la1[jezik]?> <?php echo $value?><br />
<input type="text" value="<?php echo $nazivi?>" name='s<?php echo $value?><?php echo $jez?>' class='selecte' />
 </td>
 <?php 
 $n++;
 }
 ?>
 </tr>
 <?php 
 }
 ?>
 </table>
 <ul style="padding:15px 0px 0px 0px;">
 <li>
Include file middle: <br />
<input type="text" name='include_middle' class='selecte' value="<?php echo $zz1[include_file_middle]?>" />
</li>        
<li>
Include file left: <br />
<input type="text" name='include_left' class='selecte' value="<?php echo $zz1[include_file_left]?>" />
</li>
<li>
Include file right: <br />
<input type="text" name='include_right' class='selecte' value="<?php echo $zz1[include_file_right]?>" />
</li>
<li>
Include file footer: <br />
<input type="text" name='include_footer' class='selecte' value="<?php echo $zz1[include_file_footer]?>" />
</li>
 <li>
Include file footer: <br />
<input type="text" name='include_top' class='selecte' value="<?php echo $zz1[include_file_top]?>" />
</li>

 <li>
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <tr>
 
 
<td style='padding-left:5px;'>poz 
<?php 
$brnivo=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM city_name WHERE id_parent=$zz1[id_parent]"));
 
?>
<br />
<select name='pozicija' class='selecte'>
<option value='NULL' >NULL</option>
<?php 
for($i=1;$i<=$brnivo;$i++)
{
if($zz1[position]==$i) $cpoz="selected"; else $cpoz="";
echo "<option value='$i' $cpoz>$i</option>";
}
?>
</select></td>
</tr>
</table> 
 </li>
<li>
<?php 
if($zz1[akt]==1) $pri="checked"; else $pri="";
?>
<input type="checkbox" name="akt" value="1" <?php echo $pri?> /> Prikaži na sajtu
</li>
<li>
 <?php 
 if($zz1[tip_layout]==0) $ltips="selected"; else $ltips="";
 if($zz1[tip_layout]==1) $ltips1="selected"; else $ltips1="";
 if($zz1[tip_layout]==2) $ltips2="selected"; else $ltips2="";
 if($zz1[tip_layout]==3) $ltips3="selected"; else $ltips3="";
 if($zz1[tip_layout]==4) $ltips4="selected"; else $ltips4="";
 if($zz1[tip_layout]==5) $ltips5="selected"; else $ltips5="";
 if($zz1[tip_layout]==6) $ltips6="selected"; else $ltips6="";
 ?>
<td>tip layout<br /><select name='lay' class='selecte'>
<option value='0' <?php echo $ltips?>>Levo - Sredina - Desno</option>
<option value='1' <?php echo $ltips1?>>Levo - Desno - Sredina</option>
<option value='2' <?php echo $ltips2?>>Sredina - Desno - Levo</option>
<option value='3' <?php echo $ltips3?>>Levo (siroko) - Sredina</option>
<option value='4' <?php echo $ltips4?>>Levo (usko) - Sredina</option>
<option value='5' <?php echo $ltips5?>>Sredina - Levo (siroko)</option>
<option value='6' <?php echo $ltips6?>>Sredina - Levo (usko)</option>
</select>
</li>
<li><input type='submit' name='izmene_stavke' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'> 
 <input type='submit' name='obrisi_stavke' class="submit_dugmici_blue" value='Obriši'></li>
 

 
</ul>
 </div>
</li>

<?php 
}
?>
<li>
 <br />
 <table style='width:100%' cellspacing='0' cellpadding='0'>
  <?php 

 foreach($inp_niz as $key => $value)
 {
 ?>
 <tr>
 <?php 
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 $n=0;
 while($la1=mysqli_fetch_array($la))
 {
 if($n>0) $stp=" style='padding-left:5px;'"; else $stp="";
 ?>
 <td<?php echo $stp?>>
 <?php echo $la1[jezik]?> <?php echo $value?><br />
 <?php 
 $jez=$la1[jezik];
 ?>
 <input type="text" name='n<?php echo $value?><?php echo $jez?>' class='selecte' style='' />
 </td>
 <?php 
 $n++;
 }
 ?>

 </tr>
 <?php 
 }
 ?>
 </table>
</li>
<li>
Include file middle: <br />
<input type="text" name='include_middles' class='selecte' value="" />
</li>        
<li>
Include file left: <br />
<input type="text" name='include_lefts' class='selecte' value="" />
</li>
<li>
Include file right: <br />
<input type="text" name='include_rights' class='selecte' value="" />
</li>
<li>
Include file footer: <br />
<input type="text" name='include_footers' class='selecte' value="" />
</li>
<li>
Include file footer: <br />
<input type="text" name='include_tops' class='selecte' value="" />
</li>
 
 
<li>

<input type='submit' name='save_stavke' class="submit_dugmici_blue" value='<?php echo $langa['language'][3]?>'>
 </li>

 </ul>
<br />

</form>
0 - simple link | 1 - listanje | 2 - submeni simple link
		
</div> 




			

