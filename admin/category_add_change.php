<div class='detaljno_smestaj whites'>
<?php 

if($id_kat_get>0)
{
$se=mysqli_query($conn, "SELECT * FROM categories_group WHERE id=$id_kat_get");
$se1=mysqli_fetch_assoc($se);
}
?>
 
<div class='naslov_smestaj_padd'><h1 class="border_ha">Upis novih kategorija/podkategorija - <span style='color:#444;'><?php echo $se1['name']?></span></h1></div>
 
<b style='float:left;font-size:15px;text-transform:uppercase;display:block;background:#218FBF;padding:5px;'> <a href="#inline_content" class='inline'><span style='padding:6px 10px;font-size:15px;color:white;'>UPIŠI NOVU KATEGORIJU</span></a></b>
<br class='clear' />
<script> 
function gog(id)
{
if(id>0)
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id;
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>";
}
function delme(id)
{
var answer = confirm("Brišete ovu stranicu, sve podstranice, sve tekstove, slike i fajlove u vezi sa njom?");
if(answer)
{
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&id="+id+"&obrisi_stavke=1";
}
}
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
      }
    });
        //$(".ul").disableSelection();
$('.rem').live('click', function() {
 
  $( this ).parent().remove();
});    

$('.pode').on('change', function() {
  if(this.value>0)
  $(".zahide").fadeOut('slow');
  else
  $(".zahide").fadeIn("slow");
});
  });   
  
function doda(id, tip)
{

//var le=$("#polje"+id+" .tex" ).length;
$("#polje"+id ).prepend("<li class='tex' style='margin-bottom:1px;'><input type='checkbox' name='include_"+tip+"[]' value='text.php' /> text.php <a href='javascript:;' class='rem' style='color:red;float:right;'>X</a></li>");
}   
</script>

   
<form method="post" action=""  enctype="multipart/form-data">
<table style='width:100%'>
<tr valign='top'>
<td style='width:300px;background:#fff;padding:5px;border:2px solid #ccc;'>
<b style='color:#218FBF;font-size:15px;text-transform:uppercase;display:block;'>Izaberi kategoriju za izmenu</b>
 <br />
<table style='width:100%;'> 
             
<?php        
$tz=mysqli_query($conn, "SELECT * FROM page  WHERE nivo=1 AND id_cat=$id_kat_get ORDER BY naziv$amlang ASC");
   while($tz1=mysqli_fetch_array($tz))
     { 
  if($tz1['id']==$_GET['id']) $sele="selected"; else $sele="";
?>
<tr><td>                      
<a href="<?php echo $patHA?>/index.php?base=admin&page=<?php echo $page?>&id=<?php echo $tz1['id']?>&id_kat=<?php echo $id_kat_get?>" class="olovcica"><?php echo $tz1["naziv$amlang"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;<a href="javascript:;" onclick="delme(<?php echo $tz1['id'] ?>)" ><i class="fal fa-trash-alt"></i></a>
</td><td style='width:85px;'><a href='<?php echo $patHA?>/index.php?base=admin&page=page_add_content&idp=<?php echo $tz1['id']?>'>add tekst</a> | 
<a href='<?php echo $patHA?>/index.php?base=admin&page=page_content&idp=<?php echo $tz1['id']?>'>lista</a>
</td></tr>
<?php 
$hz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$tz1[id] order by  naziv$amlang ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
  if($hz1['id']==$_GET['id']) $selet="selected"; else $selet="";
?>
                      <tr><td colspan='2'> 
<a class="olovcica" href="<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $hz1['id']?>" <?php echo $selet?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv$amlang"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;
<a class="crvena" href="javascript:;" onclick="delme(<?php echo $hz1['id'] ?>)" ><i class="fal fa-trash-alt"></i></a></td></tr>
<?php 
$ahz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$hz1[id] order by  naziv$amlang ASC");
   while($ahz1=mysqli_fetch_array($ahz))
     {
$mn2=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM pages_text WHERE id_page=$ahz1[id]"));          
  if($ahz1[id]==$_GET[id]) $selete="selected"; else $selete="";
                      ?>
<tr><td colspan='2'>                      
<a class="olovcica" href="<?php echo $patHA?>/index.php?base=admin&page=page_add&id=<?php echo $ahz1['id']?>" <?php echo $selete?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv$amlang"]?> <i class="fas fa-pencil-alt"></i></a>&nbsp; &nbsp;<a class="crvena" href="javascript:;" onclick="delme(<?php echo $ahz1['id'] ?>)" ><i class="fal fa-trash-alt"></i></a>
</td></tr>
<?php 
}
}
}
?>
</table>						                    
</td>
<td>
 <?php 
if($_GET['uspeh']==1)
$msr="Upisana je stranica. Unesite dodatne izmene za upisanu stranicu!";
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";

if($_GET['id']>0)
{
?>
 
<span>Prebaci u</span>
 
<select name="katu" class='selecte'>
<option value=''>---</option>                  
<?php 
$tz=mysqli_query($conn, "SELECT * FROM page  WHERE nivo=1 AND id_cat=$id_kat_get ORDER BY  naziv$amlang ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
?>
<option value="<?php echo $tz1['id']?>" style="font-weight:bold;color:black;"><?php echo $tz1["naziv$amlang"]?></option>
<?php 
$hz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$tz1[id] order by  naziv$amlang ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
 ?>
<option value="<?php echo $hz1['id']?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv$amlang"]?></option>
<?php 
}
}
?>
</select>
  <script>
 function slug(str, jez) {
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();
 
  // remove accents, swap ñ for n, etc
  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to   = "aaaaeeeeiiiioooouuuunc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes
 
  $("#"+jez+"1").val(str);
}
  </script>   
                 
 <br class='clear' /><br />
<div class="ui-tabs">
	<ul class="ui-tabs-nav">
<?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabs-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
  <?php 
$n=0;
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<div id="tabs-<?php echo $la1['id']?>" class="ui-tabs-panel">
 
<table style='width:100%' cellspacing='0' cellpadding='0'>
 <?php 

 foreach($inp_niz1 as $key => $value)
 {
 ?>
 <tr>
 <?php 
$zz=mysqli_query($conn, "SELECT * FROM page WHERE id=$id_get AND id_cat=$id_kat_get");
$zz1=mysqli_fetch_array($zz); 

if($n>0) $stp=" style='padding-left:5px;'"; else $stp="";
$jez=$la1['jezik'];
$naziv=$inp_niz[$key].$jez;
$nazivi=$zz1[$naziv];
 ?>
 <td<?php echo $stp?>>
<?php echo $value?><br />
<?php 
if($inp_niz[$key]=="podnaslov")
{
?>
<textarea name='s<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' placeholder="Ovo je kratak opis stranice koji se pojvljuje na vrhu stranice ispod H1 taga"><?php echo $nazivi?></textarea>
<?php if($n==0){ ?>
 
<?php 
}
}else
{
if($inp_niz[$key]=="naziv") $placeholder="placeholder='Upisati naziv stavke koja ce se prikazati u meniju'";
elseif($inp_niz[$key]=="ulink") $placeholder="placeholder='Link upisite u formatu primera: deo-kocnice-zeleznickog-vagona/  Mala engleska slova, bez razmaka!'";
elseif($inp_niz[$key]=="h1") $placeholder="placeholder='Upisati H1 tag samo ako na stranici postoje vise unosa'";
elseif($inp_niz[$key]=="title") $placeholder="placeholder='Upisati title tag, preporuka do 70 karaktera'";
elseif($inp_niz[$key]=="keywords") $placeholder="placeholder='Upisati kljucne reci medjusobno odvojene zarezom'";
elseif($inp_niz[$key]=="description") $placeholder="placeholder='Upisati description tag, preporuka do 160 karaktera'";
// onkeyup="slug(this.value,'echo $jez')
?>
<input type="text" value="<?php echo $nazivi?>" id="<?php echo $jez?><?php echo $key?>" name='s<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' <?php echo $placeholder?> /> 
<?php } ?>
 </td>
 
 </tr>
 <?php 
 }
 ?>
 </table>
 
	</div>
	<?php $n++; } ?>
</div>   

<div class='ui-tabs-panel ipad'> 
 <table style='width:100%' class='forma-lista' cellspacing='0' cellpadding='0'>
 <tr>
 
<td style='padding-left:5px;'>
 
Vidljiva stranica: 
<br />
<?php 
if($zz1['akt']==0) $akti="selected"; else $akti="";
if($zz1['akt']==1) $akti1="selected"; else $akti1="";
?>
<select name='akti' class='selecte'>
<option value='0' <?php echo $akti?>>NE</option>
<option value='1' <?php echo $akti1?>>DA</option>
</select>
</td>
<td style='padding-left:15px;'>

Slika: 
<br /> 
  <input type="file" class="file_input_div1"  id="avatar" name='slika' style='width:180px;' />
</td>
</tr>
</table> 
</div>
<?php 

if($_SESSION['emails']=="stogoran@gmail.com" or $_SESSION['emails']=="aleksandrou@gmail.com")
{
$opa=mysqli_query($conn, "SELECT * FROM page WHERE id=$id_get AND id_cat=$id_kat_get");
$opa1=mysqli_fetch_array($opa);

$ftz=mysqli_query($conn, "SELECT * FROM page_settings WHERE id_page=$id_get");
$ftz1=mysqli_fetch_array($ftz);
?>
<br class='clear' /><br />
<div class='ui-tabs-panel ipad'>
<span>Koristi model prikaza jedne od stranica koja ima svoja podešavanja</span>
 
<select name="katu_pod" class='selecte pode'>
<option value='0'>Postavi po izboru</option>                  
<?php 
$tz=mysqli_query($conn, "SELECT * FROM page  WHERE  NOT id=$id_get AND id IN(SELECT id_page FROM page_settings WHERE id=id_page) AND id_cat=0  ORDER BY  naziv$amlang ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
     if((isset($_POST['katu_pod']) and $_POST['katu_pod']==$tz1['id']) or $tz1['id']==$ftz1['katu_pod'])
     $sev="selected"; else $sev="";
?>
<option value="<?php echo $tz1['id']?>" style="font-weight:bold;color:black;"  <?php echo $sev?>><?php echo $tz1["naziv$amlang"]?></option>
<?php 
}
?>
</select><br /><br />
<?php 
if((isset($_POST['katu_pod']) and $_POST['katu_pod']>0) or $ftz1['katu_pod']>0)
echo "<style>.zahide{display:none;}</style>";
?>
 <table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
  <tr valign='top'>
 <td>
 
Uključi fajlove na vrh: <br />

<?php 
fajlovi(1,"zuto","top","top", $ftz1 , $ftz1['id_page'])
?>
</td>
   
<td class='form-left-pad'>
Uključi fajlove dole: <br />

<?php 
fajlovi(2,"zeleno","footer","footer", $ftz1 , $ftz1['id_page'])
?>

</td>
</tr>
</table>
<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>
<td>
Uključi fajlove levo: <br />
<?php 
fajlovi(3,"crveno","left","left", $ftz1 , $ftz1['id_page'])
?>
</td>
 <td  class='form-left-pad'>
Uključi fajlove u sredini: <br />
<?php 
fajlovi(4,"plavo","middle","middle", $ftz1 , $ftz1['id_page'])
?>
</td>        
<td class='form-left-pad'>
Uključi fajlove desno: <br />

<?php 
fajlovi(5,"zuto","right","right", $ftz1 , $ftz1['id_page'])
?>
</td>
</tr>
</table>
<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>
<td>
CSS klasa levo: 

<?php 
klase("left", $ftz1)
?>
</td>
 <td  class='form-left-pad'>
CSS klasa u sredini: 
<?php 
klase("middle", $ftz1)
?>
</td>        
<td class='form-left-pad'>
CSS klasa desno: 
<?php 
klase("right", $ftz1)
?>
</td>
</tr>
</table>

 <table style='width:100%' class='forma-lista' cellspacing='0' cellpadding='0'>
 <tr>
 <td>
Grupiši ovu stranicu u sledeće plugine (odvoji ih zapetama ako ih ima više): <br />
<input type='text' name='grupisanje' class='selecte' value="<?php echo $zz1['grupisanje']?>" />
</td>        
 
</tr>
</table>
</div>
<?php }else
{
?>
<input type="hidden" name="include_vrh" value="<?php echo $zz1['include_file_vrh']?>" />
<input type="hidden" name="include_left" value="<?php echo $zz1['include_file_left']?>" />
<input type="hidden" name="include_middle" value="<?php echo $zz1['include_file_middle']?>" />
<input type="hidden" name="include_dole" value="<?php echo $zz1['include_file_dole']?>" />
<input type="hidden" name="grupisanje" value="<?php echo $zz1['grupisanje']?>" />
<?php 
}
 ?>
<input type="hidden" name="id_cat" value="<?php echo $id_kat_get?>" /> 
<div style="float:right;padding-top:15px;">
<input type='submit' name='izmene_stavke' class="submit_dugmici_blue" value='Izmeni kategoriju'> 
 <input type='submit' name='obrisi_stavke' class="submit_dugmici_blue" value='Obriši' style="<?php echo $skloni?>">
</div>

<?php 
}
?>
</form>

 </td>
 </tr>
 </table>
<br />

 
 <div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'> 
      <form method="post" action="">
 <br />
 <div class="ui-tabs">
 <select name="kat" class='selecte'>
<option value=''>---</option>                  
                      <?php 
$tz=mysqli_query($conn, "SELECT * FROM page  WHERE nivo=1  AND id_cat='$id_kat_get' ORDER BY -naziv$amlang ASC");
   while($tz1=mysqli_fetch_array($tz))
     {
     
  if($tz1[id]==$_GET['id']) $sele="selected"; else $sele="";
                      ?>
<option value="<?php echo $tz1[id]?>" <?php echo $sele?> style="font-weight:bold;color:black;"><?php echo $tz1["naziv$amlang"]?></option>
						         	 <?php 
                       
$hz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$tz1[id] order by  naziv$amlang ASC");
   while($hz1=mysqli_fetch_array($hz))
     {
 
  if($hz1[id]==$_GET['id']) $selet="selected"; else $selet="";
                      ?>
<option value="<?php echo $hz1['id']?>" <?php echo $selet?> style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hz1["naziv$amlang"]?></option>
<?php                       
$ahz=mysqli_query($conn, "SELECT * FROM page  WHERE id_parent=$hz1[id] order by  naziv$amlang ASC");
   while($ahz1=mysqli_fetch_array($ahz))
     {
  if($ahz1[id]==$_GET['id']) $selete="selected"; else $selete="";
?>
<option value="<?php echo $ahz1[id]?>" <?php echo $selete?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ahz1["naziv$amlang"]?></option>
<?php 
}
}
}
?>
</select><br class='clear' /><br />
	<ul class="ui-tabs-nav">
<?php 

$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y'  order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
<li><a href="#tabsa-<?php echo $la1['id']?>"><?php echo $la1['jezik']?></a></li>
<?php } ?>
	</ul>
  <?php 
$la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
 ?>
	<div id="tabsa-<?php echo $la1['id']?>" class="ui-tabs-panel">
 <table style='width:100%' cellspacing='0' cellpadding='0'>
  <?php 

 foreach($inp_niz1 as $key => $value)
 {
 if($key<4 and $key!=1)
 {
 ?>
 <tr>

 <td>
 <?php echo $value?><br />
 <?php 
 $jez=$la1['jezik'];
 ?>
 <input type="text" name='n<?php echo $inp_niz[$key]?><?php echo $jez?>' class='selecte' style='' />
 </td>

 </tr>
 <?php 
 }
 }
 ?>
 </table>
 </div>
<?php } ?>

<input type="hidden" name="id_cat" value="<?php echo $id_kat_get?>" />
<input type='submit' name='save_stavke' class="submit_dugmici_blue" value='Dodaj novu kategoriju'>
 </form>
</div>
 </div>
</div>
</div>