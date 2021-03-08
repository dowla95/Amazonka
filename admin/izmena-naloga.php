 <?php 
if($age==0) exit();
?>  
<link rel="stylesheet" href="<?php echo $patH?>/tooltip1/tipsy.css" type="text/css" />
<script type="text/javascript" src="<?php echo $patH?>/tooltip1/jquery.tipsy.js"></script>
<script type='text/javascript'>
  $(function() {
    $('.north').tipsy({gravity: 'n'});
    $('.south').tipsy({gravity: 's'});
    $('.east').tipsy({gravity: 'e'});
    $('.west').tipsy({gravity: 'w'});
    $('.north-west').tipsy({gravity: 'nw'});
    $('.north-east').tipsy({gravity: 'ne'});
    $('.south-west').tipsy({gravity: 'sw'});
    $('.south-east').tipsy({gravity: 'se'});
     $('.focus-example [title]').tipsy({trigger: 'focus', gravity: 'w'});
  });
</script>   	     	
<script src="<?php echo $patH?>/js/jquery.validate.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			koriime: {
				required: true
			},
      pass1: {
       
        minlength: 6
      },
      pass2: {
       
        minlength: 6,
        equalTo: "#pass"
      },
			naziv_preduzeca: {
				required: true        
				
			},
      	maticni_broj: {
				required: true,        
				number: true,
        minlength: 8,
        maxlength: 8,
			},
      postanski_broj: {
				required: true,        				
			},
      adresa: {
				required: true,        				
			},
       telefon: {
				required: true,        				
			},
       kontakt_osoba: {
				required: true,        				
			},
      number: {
				required: true,        				
			},
       uslovi: {
				required: true,        				
			},
			message: {
				required: true,
				minlength: 10
			}
		},
		messages: {
			email: {
				required: "Upišite validnu email adresu!",
				minlength: "Upišite validnu email adresu!"
			},
			korime: {
				required: "Upišite korisničko ime!"
				
			},
       pass1: {
       required: "Upišite prvu lozinku!",
			 minlength: "Lozinka mora imati najmanje 6 karaktera!"
      },
      pass2: {
       required: "Upišite  lozinku još jednom!",
			 minlength: "Lozinka mora imati najmanje 6 karaktera!",
       equalTo:  "Prva i druga lozinka nisu jednake!"
      },
			naziv_preduzeca: {
				required: "Upišite naziv preduzeća!"
				
			},
      maticni_broj: {
			 required: "Upišite matični broj!",
			 number: "Matični broj može biti samo broj!",
       minlength: "Matični broj mora imati 8 karaktera!",
       maxlength: "Matični broj mora imati 8 karaktera!",
			},
      postanski_broj: {
				required: "Izaberite grad!"
				
			},
       adresa: {
				required: "Upišite adresu!"
				
			},
       telefon: {
				required: "Upišite kontakt telefon!"
				
			},
       kontakt_osoba: {
				required: "Upišite ime kontakt osobe!"
				
			},
       number: {
				required: "Prepišite kod!"
				
			},
      uslovi: {
				required: "Prihvatite uslove korišćenja!"
				
			},
			message: {
				required: "You need to enter a message!",
				minlength: jQuery.format("Enter at least {0} characters")
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
$fi=mysqli_query($conn, "SELECT * FROM users_info WHERE  user_id=".safe($che1[user_id])."");
$fi1=mysqli_fetch_array($fi);



?>


<table class='registracija_naslov'>
<tr>
<td style='width:510px'>
<div class='naslov_smestaj'><h1>Izmena naloga korisnika</h1></div>
</td>
<td>
<p class="obavezno_blue">| Obavezno popuniti</p>
</td>
</table>
<br class='clear' />
<form enctype="multipart/form-data" action="" method="post" class='gf-form' id="contactform" >
 
<?php 
if(strlen($msgr)>4)
{
echo "<div class='box'>";
echo "<div>$msgr</div>";
echo "</div>";
}
?>

 
 

	<table class="admintable  focus-example" width="100%" >
	 
    
	
	
	<tr>
		

		
		<td class="cck_label">
		E-mail
		</td>
		
		<td class="cck_field" >
			<input class="text input_poljes_sivob validate-email" title='Email adresa na kojoj primate poruke na vase oglase' type="text" name="email"  size="32" value="<?php echo $_POST[email]?$_POST[email]:$che1[email]?>"  role="input" aria-required="true" />		 
      
			 
		</td>
 
    </tr>
	<!--<tr>
 
 
		<td class="cck_label">
		Korisničko ime
		</td>
		
		<td class="cck_field">
	<input class="text input_poljes_sivob validate-email" title='Korisničko ime vidljivo za posetioce sajta i po njemu možete biti prepoznatljivi' type="text"  name="korime"  size="32" value="<?php echo $_POST[korime]?$_POST[korime]:$che1[username]?>"  role="input" aria-required="true" />		 
     
			 
		</td>
    </tr>-->
	<input type="hidden" name="korime" value='korime' />
	<tr> 
 
		
		<td class="cck_label">
		Lozinka
		</td>
		
		<td class="cck_field" >
	<input class="input_poljes_sivo"  type="password" id="pass" name="pass1" maxlength="50" size="32" value=""  role="input" aria-required="true" />	
		</td>

	</tr>
	
	<tr>
	 
		
		<td class="cck_label">
	Ponovite lozinku 
		</td>
		
		<td class="cck_field">

		<input class="password input_poljes_sivo"  type="password" id="loza2" name="pass2" maxlength="50" size="32"    value=""  role="input" aria-required="true" />	 
		</td>
	</tr>
	
 
	
	
	<tr>
	 
		
		<td class="cck_label">
			Ime i prezime

		</td>
		
		<td class="cck_field">
	<input class="text input_poljes_sivob" type="text" id="naziv_preduzeca"   name="naziv_preduzeca"  size="32" value="<?php echo $_POST[naziv_preduzeca]?$_POST[naziv_preduzeca]:$fi1[naziv_preduzeca]?>"  role="input" aria-required="true"  />
		</td>
	</tr>
	
 
<!--			<tr>
	 
		<td class="cck_label">
	Vaša država
		</td>
     
		<td class="cck_field">-->
	<?php 
if($fi1[id_drzave]==0) $des1="selected"; else $des1="";
if($fi1[id_drzave]==147) $des2="selected"; else $des2="";
if($fi1[id_drzave]==2) $des3="selected"; else $des3="";
if($fi1[id_drzave]==1) $des4="selected"; else $des4="";
  ?>	
      
<!--<select name="drzava" class='selecteb' id="drzava" onChange="getgrad(this.options[this.selectedIndex].value,0)">      
<option value="0" <?php echo $des1?>>Srbija</option>
<option value="147" <?php echo $des2?>>Crna Gora</option>
<option value="2" <?php echo $des3?>>BIH</option>
<option value="1" <?php echo $des4?>>Hrvatska</option>
      </select>

 
		</td>
	</tr>-->
 <script>
 //getgrad(<?php echo $fi1[id_drzave]?>, <?php echo $fi1[id_grada]?>);
 </script>
	<!--	<tr>
	 
		<td class="cck_label">
	Vaš grad
		</td>
     
		<td class="cck_field">
		
      
<select name="grad" class='selecteb' id="postanski_broj"  size="1">
   <option value=""  selected="selected">- Odaberite grad -</option>   
      
      
      </select>

 
		</td>
	</tr>
	
-->
 <input type="hidden" value="0" name="drzava" id="drzava" />
 <input type="hidden" value="1" name="grad" id="postanski_broj" />
	
	<tr>
		
		<td class="cck_label">
			Kontakt telefon
		</td>
		
		<td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="telefon" name="telefon" maxlength="50" size="32" value="<?php echo $_POST[telefon]?$_POST[telefon]:$fi1[telefon]?>"  role="input" aria-required="true" />
		</td>
	</tr>

 
 
	<tr>
 
		
 
			<td class="cck_label"> </td>
		<td align="right" style='padding-top:20px;'>
    
 
		
<!--<a href="javascript:;" onclick="lols('<?php echo $patH1?>/prijavi_problem.php')" class="thickbox" style='float:left;padding-top:10px;'>Prijavite problem</a>-->
   
			<input  type="submit"  name="registracija_izmena" class='submit_dugmici_blue' value="SAČUVAJ IZMENE" id="submitButton" />			
   
      
      
      
    
      
<br />

		</td>
    </tr>
	<tr><td colspan="2" align="right">
	<br />
  <br />
   
  
  
	</td></tr>
	</table>


 



 </form>
