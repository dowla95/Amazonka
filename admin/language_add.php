<div class='detaljno_smestaj whites'>
 
	<div class='naslov_smestaj_padd'><h1 class="border_ha">Upis - Izmena - Brisanje jezika</h1></div>
 
 
 
<script> 
function gog(id)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
}
    $(document).ready(function(){
    $("#sorting .ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   
 
      }
    });
        //$("#sorting .ul").disableSelection();
  });   
  
</script>
 
<?php 



//if(!mysqli_query($conn, "ALTER TABLE `page` DROP `podnaslovslo`, DROP `h1slo`")) echo mysqli_error();

if($_POST[save_novi_jezik])
{
$file_ime=$_POST['novijez'];

$jezi=mysqli_query($conn, "SELECT * FROM language WHERE jezik='$file_ime'");
$jezi1=mysqli_fetch_assoc($jezi);

if($_POST['novijez']=="")
$msr="Upišite 2 do 3 slova za novi jezik!";
if(is_file("language/$file_ime.php") or $jezi1['jezik']!="")
$msr="Taj jezik <b>$file_ime</b> vec postoji upisan!";
elseif($_FILES['slika']['name']=="")
$msr="Niste izabrali sliku zastavice za novi jezik!";
else
{
$la=mysqli_query($conn, "SELECT * FROM language  order by pozicija DESC");
$la1=mysqli_fetch_array($la);
$newpoz=$la1['pozicija']+1;


if($_FILES['slika']['tmp_name'])
{
$slika =UploadSlika($_FILES['slika']['name'],$_FILES['slika']['tmp_name'],$_FILES['slika']['type'],$page_path2.SUBFOLDER."/images/icon/");
} 


mysqli_query($conn, "INSERT INTO language SET jezik=".safe($_POST['novijez']).", akt='N', pozicija='$newpoz', slika='$slika'");


if(is_file("language/$firstlang".".php"))
{
$myfile = @fopen("language/".trim($firstlang), "r") or die("Unable to open file!");
$proc= @fread($myfile,filesize("language/$firstlang".".php"));
if(!is_file("language/".trim($_POST['novijez']).".php"))
{
  $f=fopen("language/".trim($_POST['novijez']).".php","w");
      $proc=str_replace("\"","'",$proc);
  if (fwrite($f,$proc)>0){
   fclose($f);
  }
}
fclose($myfile);
}
//mysqli_query($conn, "INSERT INTO language2 SET jezik=".safe($_POST['novijez']).", akt='N', pozicija='$newpoz', slika='$slika'");

$msrok="Upis novog jezika je uspešno izvršen!";


/**** ALTER TABLES COLUMN **************/

//alter($_POST['novijez'],$page_add_array,"add");
  
 }
}

/**** CHANTE LANGUAGE SETTINGS **************/

if($_POST[save_izmena_jezika])
{

if(is_file("$page_path2/language/$firstlang".".php"))
{
$myfile = @fopen("$page_path2/language/".trim($firstlang.".php"), "r") or die("Unable to open file!");
$proc= @fread($myfile,filesize("$page_path2/language/$firstlang".".php"));
}
$ima=$praznos=$prazno=0;

foreach($_POST['lang'] as $key => $value)
{
if($value=="")
{
$prazno=1;
break;
}
}

foreach($_POST['lang'] as $key => $value)
{
$jezi=mysqli_query($conn, "SELECT * FROM language WHERE jezik='$value' AND NOT id='$key'");
$jezi1=mysqli_fetch_assoc($jezi);

if($jezi1['jezik']!="")
{
$ima=1;
break;
}
}

foreach($_FILES['slika']['name'] as $key => $value)
{
 
if($value=="" and $_POST['stara_slika'][$key]=="")
{
$praznos=1;

break;
}
}

if($prazno==1)
$msr="Jedno ili više polja za naziv jezika je ostalo prazno!";
else
if($praznos==1)
$msr="Niste izabrali slike za zastavicu!";
else
if($ima==1)
$msr="Jedan od jezika vec postoji upisan!";
else
{
$i=1;
foreach($_POST['lang'] as $key => $value)
{
$jezik=$_POST['lang'][$key];
 
$jezik_old=$_POST['lang_old'][$key];
if($_POST['akti'][$key]>0)
$akti="Y";
else
$akti="N";


 

if($_FILES['slika']['tmp_name'][$key])
{
$slika =UploadSlika($_FILES['slika']['name'][$key],$_FILES['slika']['tmp_name'][$key],$_FILES['slika']['type'][$key],$page_path2.SUBFOLDER."/images/icon/");
@unlink($page_path2.SUBFOLDER."/images/icon/$_POST[stara_slika][$key]");
}
else $slika=$_POST['stara_slika'][$key];


 

if(!mysqli_query($conn, "UPDATE language SET jezik=".safe($jezik).", akt='$akti', pozicija='$i', slika='$slika' WHERE id='$key'")) echo mysqli_error();


if(!is_file("$page_path2/language/".trim($jezik.".php")) and $firstlang!=$jezik)
{
  $f=fopen("$page_path2/language/".trim($jezik).".php","w");
      $proc=str_replace("\"","'",$proc);
  if (fwrite($f,$proc)>0){
   fclose($f);
  }
}


$i++; 

//alter($jezik,$page_add_array,"ren",$jezik_old);
//alter($jezik,$page_add_array,"add");
}
$msrok="Izmena je izvršena uspešno!"; 


/**** ALTER TABLES COLUMN **************/


}


 
}

 
?> 
  
 
<ul class='forme_klasicne'>
<li>
<span>Lista upisanih jezika (jezik koji je prvi je pocetni jezik sajta)</span>
 <?php 
if($msr!="" and $_POST['save_izmena_jezika'])
echo "<div class='box_beeg'><div>$msr</div></div>";
else
if($msrok!="" and $_POST['save_izmena_jezika'])
echo "<div class='box_beeg_ok'><div>$msrok</div></div>";
 ?>
 <form method="post" action=""   enctype="multipart/form-data">
<div  id='sorting' ><ul  class='ul langi' style='float:left;'><li id='new_image'></li><li id='sortid_0'></li>
                      <?php 
$i=0;                      
$tz=mysqli_query($conn, "SELECT * FROM language WHERE id>0 ORDER BY pozicija ASC");
   while($tz1=mysqli_fetch_array($tz))
     {  
     
if(count($_POST['save_izmena_jezika'])>0)
$curpost=$_POST['lang'][$tz1['id']];
else      
$curpost=$tz1[jezik];         
                      ?>
<li id='sortid_<?php echo $tz1['id']?>'>
<table>
<tr>
<td>
Naziv (upisujete 2-3 slova): <input type="text" name="lang[<?php echo $tz1[id]?>]" value="<?php echo $curpost?>" class='inputli' />
<input type="hidden" name="lang_old[<?php echo $tz1[id]?>]" value="<?php echo $tz1[jezik]?>" class='inputli' />
</td>
<td>
Slika zastavice: <input type="file" name="slika[<?php echo $tz1[id]?>]"  class='inputli' />
<?php 
if($tz1['slika']!="")
{
echo "<image src='$patH/images/icon/$tz1[slika]' width='18' />";
echo "<input type='hidden' name='stara_slika[$tz1[id]]' value='$tz1[slika]' />";
}
else
echo "<image src='$patH/admin/images/bela-zast.gif' width='18' />";
?>
</td>
<td>
<?php 
if($tz1['akt']=="Y") $aktch="checked"; else $aktch="";
?>
Prikazivanje na sajtu: <input type="checkbox" name="akti[<?php echo $tz1[id]?>]" value="<?php echo $tz1[id]?>" <?php echo $aktch?> />
<input type="hidden" name="hidniz[<?php echo $tz1[id]?>]" value="<?php echo $tz1[id]?>" />
</td>
<td align='right'>
<a href='javascript:;' onclick="obris(<?php echo $tz1['id']?>,'language','id', 'Brisanjem ovog jezika brisete sve unesene reci (ako ste ih uneli) za ovaj jezik. Da nastavim?')"><img src='images/b_drop.png'></a>
</td>
</tr>
</table>
</li>
<?php 
$i++;
}
?>
						                    </ul>
</div>               
<br class='clear' /><br />
<input type='submit' name='save_izmena_jezika' class="submit_dugmici_blue fright" value='<?php echo $langa['time_zone'][3]?>'>                 
</form>                        
</li>
 
 
 <br class='clear' /><br /><br />
<li>


 <?php 
if($msr!="" and $_POST['save_novi_jezik'])
echo "<div class='box_beeg'><div>$msr</div></div>";
else
if($msrok!="" and $_POST['save_novi_jezik'])
echo "<div class='box_beeg_ok'><div>$msrok</div></div>";
 ?>
 <form method="post" action=""   enctype="multipart/form-data">
<b>Naziv novog jezika (2-3 slova):</b>  <input type="text" name='novijez' class='selecte' value="<?php echo $_POST['novijez']?>" style='width:155px;' />
  Slika zastavice: <input type="file" name="slika" class='inputli' />

<input type='submit' name='save_novi_jezik' class="submit_dugmici_blue" value='Dodaj novi jezik' style='position:relative;top:2px;'>
</form>
<br /><br />
 </li>
 </ul>
<br />



		
</div> 




			

