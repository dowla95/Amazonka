  <?php 
if($_GET[korak]!=5)
{  
include("tiny_mce.php");
?>
  <script src="<?php echo $patH?>/js/jquery.validate.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
 
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
    drzava: {
				required: true			 
			},
    grad: {			 
			required: true
			},
			emails: {			 
				email: true
			},
			id_cat: {
				required: true
			
			},
      podkat: {
				required: true
			
			},
      potrebna_strucna_sprema: {
				required: true
			
			},
     /*kr_opis_rm: {
      required: true
        
      },*/
      nameAds: {
      required: true
       
      },
      nameAds_eng: {
      required: true
       
      },
			pocetak_dan: {
				required: true        
				
			},    
      pocetak_mesec: {
				required: true        
				
			},
      pocetak_godina: {
				required: true        
				
			},
      	kraj_dan: {
				required: true        
				
			},    
      kraj_mesec: {
				required: true        
				
			},
      tip_posla: {
			 required: true,
				
			},   
       plata: {
			 required: function(element) {
if ($("#tip_posla").val()=="" || $("#tip_posla").val()==1 || $("#tip_posla").val()==2) { 
                    return true;
                }
                else {
                    return false;
                }
            }
				
			},   
      plata1: {
			 required: function(element) {
if ($("#tip_posla").val()==3) {
                    return true;
                }
                else {
                    return false;
                }
            }
				
			},   
			tekst: {
			required: function() {
					tinyMCE.triggerSave();
          return true;
            }
			 
			}
      
		},
		messages: {
    	drzava: {
				required: "Izaberite državu!"
			 
			},
    		grad: {
				required: "Izaberite grad!"
			 
			},
			emails: {
				required: "Upišite validnu email adresu!",
				email: "Upišite validnu email adresu!"
			},
		id_cat: {
				required: "Izaberite kategoriju!"
			 
			},
      podkat: {
				required: "Izaberite podkategoriju!"
			 
			},
      potrebna_strucna_sprema: {
				required: "Izaberite stručnu spremu!"
			 
			},
       /*kr_opis_rm: {
       required: "Upišite kratak opis oglsa!"
			 
      },*/
      nameAds: {
       required: "Upišite naziv smeštaja!"
			 
      },
       nameAds_eng: {
       required: "Upišite naziv smeštaja na ENG jeziku!"
			 
      },
				pocetak_dan: {
			 required: "Izaberite dan!"
				
			},  
      	pocetak_mesec: {
			 required: "Izaberite mesec!"
				
			},
      kraj_dan: {
			 required: "Izaberite dan!"
				
			},  
      kraj_mesec: {
			 required: "Izaberite mesec!"
				
			},       
      tip_posla: {
			 required: "Izaberite tip posla!"
				
			},  
       plata: {
			 required: "Izaberite mesečnu platu!"
				
			},    
       plata1: {
			 required: "Izaberite platu po satu!"
				
			},   
			tekst: {
				required: "Upišite opis smeštaja!"
			 
			}
		},
    
		// set this class to error-labels to indicate valid fields
   
		success: function(label) {
    
			label.addClass("checked");
		}
	});
});
</script>

<?php 
}
?>          	
											

 <br class='clear' /><br />
 
<?php 

if($_GET[korak]==1 or $_GET[korak]=="") $tren1="class='acti'"; else $tren1="";
if($_GET[korak]==2) $tren2="class='acti'"; else $tren2=""; 
if($_GET[korak]==3) $tren3="class='acti'"; else $tren3="";
if($_GET[korak]==4) $tren4="class='acti'"; else $tren4="";
if($_GET[korak]==5) $tren5="class='acti'"; else $tren5="";
?> 
<ul class='koraci'>
<?php 
for($i=1;$i<6;$i++)
{
if($i==1) $korak="Prvi korak";
if($i==2) $korak="Opis smeštaja";
if($i==3) $korak="Smeštaj sadrži";
if($i==4) $korak="Cene smeštaja";
if($i==5) $korak="Galerija slika";
?>
<li><a href='<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $ai1[id]?>&korak=<?php echo $i?>' <?php echo ${"tren$i"}?>><span><?php echo $korak?> - korak <?php echo $i?></span></a></li>
<?php 
}
?>

</ul>
<?php 
if(strlen($msgr)>4)
{
?>
<br class='clear' /><div class='box' style='width:95%;'><div><?php echo $msgr?></div></div>
 

<?php 
}
if($_GET[korak]==1)
{

?>
<form enctype="multipart/form-data" action="" class='gf-form' method="post" id="contactform" name="myform" <?php echo $sakrij_formu?>>
  
  
<input type="hidden" name="idoglasa" value="<?php echo $ai1[id]?>" />
	<table   cellspacing='4' style='float:left;width:96%;'>
	    
 

  <tr>
			<td class="cck_label">Naziv smeštaja <span style='color:red;font-size:18px;'>*</span></td>
      <td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="nameAds" name="nameAds"  size="32" value="<?php echo htmlspecialchars($_POST[nameAds]?$_POST[nameAds]:$ai1[nameAdsslo], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>
 
 <tr><td colspan="2" height="20"></td></tr>
<tr valign='top'>   
<td>      
  <b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Glavna slika smeštaja</b> <span style='color:red;font-size:18px;'>*</span>
    
 </td>
    
 <td>
<span id="fileListsR"></span>
 
  <input type="file" class="file_input_div1"  id="avatar" name='slika' />

 
<?php 
if($ai1[slika]!="")
{
echo "<div style='float:right;margin-top:-25px;'>";
echo "<a href='$patH/apartmani_beograd/$ai1[slika]' class='group1'><img src='$patH/apartmani_beograd/thumb/$ai1[slika]' width='50' style='border:2px solid #f1f1f1;' /></a>";
echo "</div><input type='hidden' value='$ai1[slika]' name='stara' />";
//Obriši <input type='checkbox' name='obrisi' value='1' />
}
?>
        </td>
        
        </tr>   
 
 <tr><td colspan="2" height="20"></td></tr>
   <tr>
			<td class="cck_label">Title tag </td>
      <td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="nameAds" name="title"  size="32" value="<?php echo htmlspecialchars($_POST[title]?$_POST[title]:$ai1[title], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>
     <tr><td colspan="2" height="20"></td></tr>
     <tr>
			<td class="cck_label">Description tag </td>
      <td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="nameAds" name="desct"  size="32" value="<?php echo htmlspecialchars($_POST[desct]?$_POST[desct]:$ai1[description], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>
     <tr><td colspan="2" height="20"></td></tr>
     <tr>
			<td class="cck_label">Keywords tag </td>
      <td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="nameAds" name="keyt"  size="32" value="<?php echo htmlspecialchars($_POST[keyt]?$_POST[keyt]:$ai1[keywords], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>
     <tr><td colspan="2" height="20"></td></tr>
<tr>

<td colspan="2">
    
      
     <input type="submit" name='izmena_korak11' value='SAČUVAJ IZMENE I IDI NA SLEDEĆI KORAK &raquo;' class='submit_dugmici_blue' id="submitButton" style='float:right;width:50%;border:1px solid #444;' />
 <input type="submit" name='izmena_korak1' value='SAČUVAJ IZMENE I OSTANI NA OVOM KORAKU' class='submit_dugmici_blue' id="submitButton" style='float:right;width:49%;border:1px solid #444;margin-right:7px;' />
    
</td>
 
 </tr>
    </table>
   

</form>
<?php 
}
if($_GET[korak]==2)
{

?>
<form enctype="multipart/form-data" action="" class='gf-form' method="post" id="contactform" name="myform">
  
  
<input type="hidden" name="idoglasa" value="<?php echo $ai1[id]?>" />
	<table   cellspacing='4' style='float:left;width:96%;'>
 <tr>
			<td class="cck_label" style='width:300px;'>Kvadratura smeštajnog prostora</td>
      <td class="cck_field">
			<input class="text input_poljes_sivo" type="text"  name="kvadratura"  style='width:100px;' size="32" value="<?php echo htmlspecialchars($_POST[kvadratura]?$_POST[kvadratura]:$ai1[kvadratura], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>    
    <tr>
			<td class="cck_label">Smeštajni prostor može da primi osoba:</td>
      <td class="cck_field">
			<input class="text input_poljes_sivo" type="text"  name="maxbroj"   style='width:100px;' size="32" value="<?php echo htmlspecialchars($_POST[maxbroj]?$_POST[maxbroj]:$ai1[maxbroj], ENT_QUOTES)?>"  />	
       
      	</td>
		</tr>
     <tr>
			<td class="cck_label">Youtube video link:</td>
      <td class="cck_field">
      <table style='width:100%;' cellspacing="0" cellpadding="0">
      <tr>
      <td>
		<input class="text input_poljes_sivo" type="text"  name="youtube"   size="32" value="<?php echo htmlspecialchars($_POST[yotube]?$_POST[youtube]:$ai1[youtube], ENT_QUOTES)?>"  />	
       </td>
    <!--   <td>
			Facebook link: <input class="text input_poljes_sivo" type="text"  name="fb"   size="32" value="<?php echo htmlspecialchars($_POST[yotube]?$_POST[fb]:$ai1[fb], ENT_QUOTES)?>"  />	
       </td>-->
       <input type="hidden" name="fb" value="1" />
       </tr>
       </table>
      	</td>
		</tr>
	<tr>
		<td colspan="2" style='padding-top:10px;'><b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Opis  smeštaja</b>  
    <span style='color:red;font-size:18px;'>*</span> 
     
		
                          
               
			<textarea  class="mceEditor"   name="tekst" id="tekst" cols="25" rows="33" style="height:300px;width:99%;"><?php echo $_POST[tekst]?$_POST[tekst]:$ai1[tekstslo]?></textarea></td>
      </tr>
    
      <tr><td colspan="2" height="20"></td></tr>
<tr><td colspan="2">      
      	<table   cellspacing='0' style='float:left;width:99%;'>
<tr>
 <td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $ai1[id]?>&korak=1"><span>&laquo; Prethodni korak</span></a>
 </td>
<td>
    
      
     <input type="submit" name='izmena_korak22' value='SAČUVAJ IZMENE I IDI NA SLEDEĆI KORAK &raquo;' class='submit_dugmici_blue' id="submitButton" style='float:right;width:50%;border:1px solid #444;' />
 <input type="submit" name='izmena_korak2' value='SAČUVAJ IZMENE I OSTANI NA OVOM KORAKU' class='submit_dugmici_blue' id="submitButton" style='float:right;width:49%;border:1px solid #444;margin-right:7px;' />
    
</td>
 
 </tr>
 </table>
 </td></tr>  
  </table>
  </form>
<?php 
}
if($_GET[korak]==3)
{

?>
<form enctype="multipart/form-data" action="" class='gf-form' method="post" id="contactform" name="myform">
  
  
<input type="hidden" name="idoglasa" value="<?php echo $ai1[id]?>" />
	<table   cellspacing='4' style='float:left;width:96%;'>

 <tr><td colspan="2">
 <br />
 <b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Smeštaj poseduje lezajeve (ukucajte broj u odgovarajuće polje):</b> 
 <br />
 <ul class='sobes' style="padding:0px;margin:0px;margin-top:10px;">
 <?php 
$sad=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=2 ORDER BY nazivslo ASC");
while($sad1=mysqli_fetch_assoc($sad))
{
 $ah=mysqli_query($conn, "SELECT * FROM oglas_number_rooms WHERE ido=$ai1[id] AND niz_id=$sad1[id]");
 $ah1=mysqli_fetch_assoc($ah);
 echo "<li style='float:left;width:32%;margin-bottom:3px;list-style:none;'><input type='text' class='input_poljes_sivo' placeholder='0' style='width:40px;' name='sobe_broj[$sad1[id]]' value='$ah1[br_soba]' /> $sad1[nazivslo]</li>";
 }
 ?>
 </ul>
 </td></tr>

 <tr><td colspan="2">
<!--<br class='clear' /><br />
<b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Lokacija:</b><br />-->
<?php 
/*$sad=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=1 ORDER BY nazivslo ASC");
while($sad1=mysqli_fetch_assoc($sad))
{
$pros=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM content_oglas WHERE ido=$ai1[id] AND ids=$sad1[id]"));
if($pros>0) $toje="checked"; else $toje=""; 
echo "<div style='font-size:11px;float:left;width:33%;'><input type='checkbox' name=sadrzaj[] value='$sad1[id]' id='sadrz$sad1[id]' $toje /> <label  for='sadrz$sad1[id]'>$sad1[nazivslo]</label></div>";
}*/
?>
 
<br class='clear' /><br />
<b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Smeštaj poseduje:</b><br />
<?php 
$sad=mysqli_query($conn, "SELECT * FROM categories_content WHERE tip=0 ORDER BY nazivslo ASC");
while($sad1=mysqli_fetch_assoc($sad))
{
$pros=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM content_oglas WHERE ido=$ai1[id] AND ids=$sad1[id]"));
if($pros>0) $toje="checked"; else $toje=""; 
echo "<div style='font-size:11px;float:left;width:33%;'><input type='checkbox' name=sadrzaj[] value='$sad1[id]' id='sadrz$sad1[id]' $toje /> <label  for='sadrz$sad1[id]'>$sad1[nazivslo]</label></div>";
}
?>
<br class='clear' />
</td></tr>
      <tr><td colspan="2" height="20"></td></tr>
<tr>
 <td>
<a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $ai1[id]?>&korak=2"><span>&laquo; Prethodni korak</span></a>
 </td>
<td>
    
      
     <input type="submit" name='izmena_korak33' value='SAČUVAJ IZMENE I IDI NA SLEDEĆI KORAK &raquo;' class='submit_dugmici_blue' id="submitButton" style='float:right;width:50%;border:1px solid #444;' />
 <input type="submit" name='izmena_korak3' value='SAČUVAJ IZMENE I OSTANI NA OVOM KORAKU' class='submit_dugmici_blue' id="submitButton" style='float:right;width:49%;border:1px solid #444;margin-right:7px;' />
    
</td>
 
 </tr>  
  </table>
  </form>
<?php 
}
if($_GET[korak]==4)
{

?>
<form enctype="multipart/form-data" action="" class='gf-form' method="post" id="contactform" name="myform">
  
  
<input type="hidden" name="idoglasa" value="<?php echo $ai1[id]?>" />
	<table   cellspacing='4' style='float:left;width:96%;'>

 <tr><td>Cena je u</td>   
 <td>
 <table style='width:100%;;margin:5px 0px;'><tr>
      <td style='width:95px;'>
<?php 

if($ai1[cenau]==0) {$zis0="checked"; $zis1="";}
if($ai1[cenau]==1) {$zis1="checked"; $zis0="";}
 
?>		
	<input type="radio" name="invalid" id='invalid' class='gf-radio' value="0" class="styled" size="1" <?php echo $zis0?> />
	<label for='invalid'>cena u €</label>
  </td>
  <td>
  <input type="radio" name="invalid" id='invalid0'  class='gf-radio' value="1"  class="styled" size="1" <?php echo $zis1?> /> <label for='invalid1'>cena u din</label> 
	</td>
  </tr>
  </table>
 </td>
 </tr> 


 <tr>

	<td class="cck_label">
    Tip cene 
      </td>
			<td class="cck_field">
		
  <select name="cenapo" class='selecte'>
  <?php 
  foreach($tip_cene as $key => $val)
  {
if($_POST[cenapo]==$key or $ai1[cenapo]==$key) $toje="selected"; else $toje="";
  echo "<option value='$key' $toje>$val</option>";
  }
  ?>
  </select>
  
			</td>

		</tr>	
<tr>

	<td class="cck_label">
    CENA smeštaja
      </td>
			<td class="cck_field">
		<table style='width:100%;;margin:5px 0px;'><tr>
     
	
  <!--<td style='width:60px;'>Minimalna cena</td>
  <td style='width:70px;'>
  <input class="text west input_poljes_sivo" type="text"  name="cena" placeholder="min cena"   value="<?php echo $_POST[cena]?$_POST[cena]:$ai1[cena]?>" />
  </td>-->
  <input class="text west input_poljes_sivo" type="hidden"  name="cena"    value="0" />
  <!--<td style='width:60px;'>Maksimalna cena</td>-->
  <td style='width:70px;'>
  <input class="text west input_poljes_sivo" type="text"  name="cenado" placeholder="max cena"   value="<?php echo $_POST[cenado]?$_POST[cenado]:$ai1[cenado]?>" />
  </td>
 
	</tr></table>
			</td>

		</tr>

	<tr>
		<td colspan="2" style='padding-top:10px;'><b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Detaljni cenovnik</b>  <span style='color:red;'>(Linkovi do vaseg sajta trenutno nisu dozvoljeni)</span> 
         
			<textarea  class="mceEditor"   name="cenovnik" cols="25" rows="33" style="height:200px;width:99%;"><?php echo $_POST[cenovnik]?$_POST[cenovnik]:$ai1[cenovnik]?></textarea></td>
      </tr>
   <!--   
      <tr>
		<td colspan="2" style='padding-top:10px;'><b style="color:#218FBF;font-size:14px;text-transform:uppercase;">Detaljni cenovnik na ENG jeziku</b>   
         
			<textarea  class="mceEditor"   name="cenovnik_eng" cols="25" rows="33" style="height:200px;width:99%;"><?php echo $_POST[cenovnik_eng]?$_POST[cenovnik_eng]:$ai1[cenovnikeng]?></textarea></td>
      </tr>
 -->
 

	 <tr valign='top'>   
<td colspan="2">      
<br />
  <b style="color:#218FBF;font-size:14px;">DETALJNI CENOVNIK U PDF ili WORD FORMATU</b>
    
  <br />
    
 
  <input type="file"  name='cena_pdf' />

 
<?php 
if($ai1[cena_pdf]!="")
{
echo "<br class='clear' /><br /><b><a href='$patH/cenovnici/$ai1[cena_pdf]' >TRENUTNO POSTAVLJEN CENOVNIK</a><input type='hidden' value='$ai1[cena_pdf]' name='stari_pdf' /></b><br /><input type='checkbox' value='1' name='obrisi_pdf' /> selektuj za brisanje fajla cenovnika";
}
?>
        </td>
        
        </tr> 



      <tr><td colspan="2" height="20"></td></tr>
<tr>
 <td>
 <a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $ai1[id]?>&korak=3"><span>&laquo; Prethodni korak</span></a>
 </td>
<td>
    
      
     <input type="submit" name='izmena_korak44' value='SAČUVAJ IZMENE I IDI NA SLEDEĆI KORAK &raquo;' class='submit_dugmici_blue' id="submitButton" style='float:right;width:50%;border:1px solid #444;' />
 <input type="submit" name='izmena_korak4' value='SAČUVAJ IZMENE I OSTANI NA OVOM KORAKU' class='submit_dugmici_blue' id="submitButton" style='float:right;width:49%;border:1px solid #444;margin-right:4px;' />
    
</td>
 
 </tr>  
  </table>
  </form>
<?php 
}

if($_GET[korak]==5)
{

?>
 
  
 
	<table   cellspacing='4' style='float:left;width:96%;'>

 <script type="text/javascript" src="<?php echo $patHA?>/js/jquery.form.js"></script>
<script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			        //  $("#preview").html('');
			    $("#previews").html('<img src="<?php echo $patHA?>/images/loader_tape.gif" alt="Sačekajte...."/>');
			$("#imageform").ajaxForm({
					 
            success: function(response) {
            
            
       if(response==12) 
       {
       $("#previews").html('');
       alert("Već ste upisali 12 dozvoljenih slika!");
       
       }
       else
    $("#preview").prepend(response);
     $("#previews").html('');
  }
		}).submit();
		
			});
        }); 
</script>
<script>
function delas(id,slika){ 
var answer = confirm("Da li želite da obrišete izabranu sliku?");
if(answer){
jQuery('#del'+id).html('<div>load...</div>');
    var url="<?php echo $patHA?>/del_image_pages.php?id="+id+"&slika="+slika;
   jQuery('#del'+id).load(url);
}
}
function save_nas(ide, jez){ 
 
vre=$("#na"+jez+ide).val();
 
 $.ajax({
type: "POST",
url: "<?php echo $patHA?>/sacuvaj_naslov_slike_pages.php",
data: {naslov: vre, id: ide, lang: jez},
cache: false,
beforeSend: function(){
$("#prev"+jez+ide).html('<img src="<?php echo $patHA?>/images/loader.gif" alt="Sačekajte...."/>'); 	 
},
success: function(html){
 
$("#prev"+jez+ide).html(html);

}
});

}
</script>

 <tr><td colspan="2">
 
<div style='padding:5px;font-size:14px;'>
<span style='display:block;padding-bottom:7px;font-size:15px;font-weight:bold;color:black;'>UPIS NOVIH SLIKA (Podržani formati slika:<strong style='color:red;'> jpg, gif, png</strong>) </span>

<span style='font-size:11px;color:red'>
Dodajete jednu po jednu sliku, jer učitavanje više slika odjednom server neće dozvoliti. Pozivanjem slike sa vašeg računara ona se automatski učitava.<br />

</span>
<br /><br />
<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $patHA?>/ajaximage_pages.php?ide=<?php echo $ai1[id]?>&tip=1&tabela=slike_paintb'>
<input type='file'  name="photoimg" id="photoimg"  /><br />
</form><br class='clear' />

<div id='previews'></div>
<div id='preview'></div>

 

<?php 
$das=mysqli_query($conn, "SELECT * FROM slike_paintb WHERE idupisa=$ai1[id] AND tip=1 ORDER BY id DESC");

$i=1;

while($p1=mysqli_fetch_assoc($das))
 {  
  $b=$i%2;
// if($b==1 and $i>0)
 //echo "<div style='float:left;width:130px;font-size:1px;height:2px;'></div>";

 echo "<div style='float:left;width:100%;font-size:11px;color:black;position:relative;' id='del$p1[id]'>";
if(strlen($p1[slika])>3){

$img=image_size3(55,'',$p1[slika],"apartmani_beograd");

$im=explode("-",$img);

//echo "<a href='$patH/galerija/$p1[slika]'  rel='lightbox[slide]' alt='airsoft paintball club'>";

$j=$i+1;

if($im[1]>45){

$img=image_size3('',45,$p1[slika],"apartmani_beograd");

$im=explode("-",$img);
}
if($jezik=="eng")
$naslov=$p1[nasloveng];
else
$naslov=$p1[naslovslo];

echo "<table style='width:100%;' cellpadding='1' cellspacing='0'>
<tr valign='middle'>
<td align='left' style='width:100px;'>
<a href='".$patH."/apartmani_beograd/".$p1[slika]."' class='group1'  style='display:block;width:$im[0]px;'><img src='".$patH."/apartmani_beograd/thumb/".$p1[slika]."' width='$im[0]' height='45'  alt='".$res['naslov']."' style='border:1px solid #999;padding:2px;' /></a></td>";
 $la=mysqli_query($conn, "SELECT * FROM language WHERE akt='Y' order by pozicija ASC");
 while($la1=mysqli_fetch_array($la))
 {
$jez=$la1[jezik];
echo "<td>
Opis slike: <input type='text' value='".$p1["naslov$jez"]."' id='na$jez$p1[id]'  onblur=\"save_nas($p1[id],'$jez')\" class='input_poljes_sivo' style='width:210px;' />
</td><td width='100'><span id='prev$jez$p1[id]'><span></td>
<td>";
}
if($p1[akt]=="Y") $ch="checked"; else $ch="";
echo "<td align='right' width='100'>";
?>
prikaz: <input type='checkbox' onclick="akti(<?php echo $p1[id]?>,  'show_image')" value='1' <?php echo $ch?>  />
<?php 
echo "</td>";
echo "<td align='right' width='100'>
<a href='javascript:;' title='brisi sliku - delete image' onclick=\"delas($p1[id],'$p1[slika]')\"  style=''>OBRIŠI SLIKU</a>
</td>
</tr></table>";


 

echo "</div>";
} $i++;
 }  

?>

</div>
 
 
</td></tr>
	 

<tr><td colspan="2" height="20">	 

<?php 
if($_POST[izmena_korak5])
{
?>
<div class='box'><div>UPIS JE SAČUVAN I ČEKA ODOBRENJE ADMINISTRATORA UKOLIKO NIJE ODOBRAVAN DO SADA</div></div>
<?php 
}
?>
</td></tr>
 <tr><td colspan="2" height="20"></td></tr>
<tr>
 <td>
 <a href="<?php echo $patHA?>/index.php?base=admin&page=izmena-oglas&id=<?php echo $ai1[id]?>&korak=4"><span>&laquo; Prethodni korak</span></a>
 </td>
 
<td>

<form method="post" action="">
 <input type="submit" name='izmena_korak5' value='SAČUVAJ IZMENE' class='submit_dugmici_blue' id="submitButton" style='float:right;width:49%;border:1px solid #444;margin-right:4px;' />   
</form>      
 
</td>
 
 </tr>  
  </table>
 
<?php 
}
?>
 <br /><br />

 
