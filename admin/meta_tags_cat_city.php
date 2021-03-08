<div class='detaljno_smestaj whites'>
 
<div class='naslov_smestaj_padd'><h1 class="border_ha">Default shablon meta tags for city and categories</h1></div>
 
 

 
 
<?php 
 $inp_niz=array("title","keywords","description");
 
if($_POST[izmene_stavke])
{
$i=0;
$zz=mysqli_query($conn, "SELECT * FROM meta_tags_default");
while($zz1=mysqli_fetch_array($zz))
{ 
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
foreach($inp_niz as $key => $value)
{
$naziv="$value$jez$zz1[id]";
if($i>0) $zar=", "; else $zar=""; 
$nazivis .= $zar."$value$jez=".safe($_POST[$naziv]);
 
$i++;
}
 
 }
 //echo $nazivis;
 $ff=0;
 if(!mysqli_query($conn, "UPDATE meta_tags_default SET $nazivis WHERE id=$zz1[id]")) echo mysqli_error(); else $ff=1;
 
 }
 
 if($ff==1)
 echo "<div class='infos1'><div>Izmenjeno</div></div>";
}
 
?> 
  
<form method="post" action="">
<ul class='forme_klasicne'>
 
 
 
 
<li style='background:#444;color:white;'>
<div style='padding:10px 10px; 0px 10px'>
 
 <table style='width:100%' cellspacing='0' cellpadding='0'>
 <?php 
$zz=mysqli_query($conn, "SELECT * FROM meta_tags_default");
while($zz1=mysqli_fetch_array($zz))
{ 
echo "<tr><td style='height:10px'></td></tr>";
echo "<tr><td colspan='3' style='padding:5px 0px 5px 5px;background:#218FBF;color:#fff;text-transform:uppercase;'>$zz1[default_type]</td></tr>";
echo "<tr><td style='height:2px'></td></tr>";
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
$jez=$la1[jezik];
$naziv="$value$jez";
$nazivi=$zz1[$naziv];
 ?>

 <td<?php echo $stp?>>
 <?php echo $la1[jezik]?> <?php echo $value?><br />
<input type="text" value="<?php echo $nazivi?>" name='<?php echo $value?><?php echo $jez?><?php echo $zz1[id]?>' class='selecte' />
 </td>
 <?php 
 $n++;
 }
 ?>
 </tr>
 <?php 
 }
 }
 ?>
 </table>
 <ul style="padding:15px 0px 0px 0px;">
 
 

 <li>
 
 </li>

<li><input type='submit' name='izmene_stavke' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'> 
 
 

 
</ul>
 </div>
</li>

 
 
 

 </ul>
<br />

</form>
0 - simple link | 1 - listanje | 2 - submeni simple link
		
</div> 




			

