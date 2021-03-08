<?php 
include("header-top.php");
?>
 <script>
  
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   
 
      }
    });
    });
function load_model(id)
{
if(id>0)
window.location="?model="+id+"&id=<?php echo $id_get?>";
else
window.location="istakni-upisani-tekst.php?id=<?php echo $id_get?>";
}    
</script>
<form method="post">
<br />
<select name="model" class='selecte' onchange="load_model(this.value); load_mod(this.value)">
<option value=''>Izaberite model</option>
<?php 
$az=mysqli_query($conn, "SELECT * FROM categories_group WHERE akt='1' AND tip=2 ORDER BY name ASC");
while($az1=mysqli_fetch_assoc($az))
{
if($az1['id']==$_GET['model']) $ses="selected"; else $ses="";
echo "<option value='$az1[id]' $ses>$az1[name]</option>";
}
?>
</select> <br /><br />
<?php 
if($_GET['model']>0)
{ 
$zz=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model=$_GET[model]");
$zz1=mysqli_fetch_assoc($zz);
$al=mysqli_query($conn, "SELECT * FROM pages_text_lang WHERE id_text=$id_get");
$AL1=mysqli_fetch_assoc($al);
?>
<span>Izaberi stranice koje koriste ovaj model</span>
 
<select name="id_page" class='selecte  mselect'  style='width:102%;' multiple="multiple">
                   
                      <?php 

$tz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  nivo=1 AND model=$_GET[model]  AND id_cat=0 ORDER BY p.position ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
     
$hz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$tz1[id_page] AND model=$_GET[model] AND id_cat=0 ORDER BY p.position ASC");   
     
     if($zz1['id_page']==$tz1['id_page']) $sel="selected"; else $sel="";
     if(mysqli_num_rows($hz)>0) $dis="disabled"; else $dis="";
                      ?>
<option value="<?php echo $tz1[id_page]?>" <?php echo $sel?> <?php echo $dis?>><?php echo $tz1["naziv"]?></option>
						         	 <?php 
  
                    

   while($hz1=mysqli_fetch_array($hz))
     {
$rz = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$firstlang' AND  id_parent=$hz1[id_page]  AND model=$_GET[model] AND id_cat=0 ORDER BY p.position ASC");
             
      if($zz1['id_page']==$hz1['id_page']) $sel="selected"; else $sel="";                  
      if(mysqli_num_rows($rz)>0) $dis="disabled"; else $dis="";
      ?>
<option value="<?php echo $hz1[id_page]?>" <?php echo $sel?> <?php echo $dis?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv"]?></option>

<?php 
  
                       

   while($pz1=mysqli_fetch_array($pz))
     {
     if($zz1['id_page']==$pz1['id_page']) $sel="selected"; else $sel="";                  
                      ?>
<option value="<?php echo $pz1[id_page]?>" <?php echo $sel?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pz1["naziv"]?></option>
						         	 <?php 
                      }

						         	 
                      }
                      }
                        ?>
</select>    
<br /><br />
<?php } ?>
<div class='ui-tabs-panel ipad mods'>


<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>
<td>
Uključi tekst u gornjem delu sajta: <br />

<?php 

fajlovi(1,"crveno","left","left", $zz1 , $zz1['id'],"text-$id_get",$AL1['naslov'],1)
?>
</td>
</tr>
 <tr valign='top'>
<td>
Uključi tekst u levom delu sajta: <br />

<?php 

fajlovi(3,"plavo","left","left", $zz1 , $zz1['id'],"text-$id_get",$AL1['naslov'],1)
?>
</td>
</tr>
 <tr valign='top'>
<td>
Uključi tekst u desnom delu sajta: <br />

<?php 

fajlovi(5,"crveno","left","left", $zz1 , $zz1['id'],"text-$id_get",$AL1['naslov'],1)
?>
</td>
</tr>
<tr>
 <td>
 
Uključi tekst sredisnem delu sajta: <br />


<?php 

fajlovi(4,"plavo","middle","middle", $zz1 , $zz1['id_model'],"text-$id_get",$AL1['naslov'],1)
?>
</td>        
</tr>
 <tr valign='top'>
<td>
Uključi tekst u donjem delu sajta: <br />

<?php 

fajlovi(2,"crveno","left","left", $zz1 , $zz1['id'],"text-$id_get",$AL1['naslov'],1)
?>
</td>
</tr>
</tr>
</table>
 

 
 
 
</div>
<br />
<input style='float:right;' type='submit' name='save_istaknuti_tekst' class="submit_dugmici_blue" value='<?php echo $langa['time_zone'][3]?>'>
 </form>
 