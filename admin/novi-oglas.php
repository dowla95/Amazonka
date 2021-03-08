 
<link rel="stylesheet" href="<?php echo $patH?>/tooltip1/tipsy.css" type="text/css" />
<script type="text/javascript" src="<?php echo $patH?>/tooltip1/jquery.tipsy.js"></script>
<script type='text/javascript'>
  $(function() {
    $('.north').tipsy({gravity: 'n'});
    $('.south').tipsy({html: true, gravity: 's'});
    $('.east').tipsy({gravity: 'e'});
    $('.west').tipsy({trigger: 'focus', gravity: 'w'});
    $('.north-west').tipsy({gravity: 'nw'});
    $('.north-east').tipsy({gravity: 'ne'});
    $('.south-west').tipsy({gravity: 'sw'});
    $('.south-east').tipsy({gravity: 'se'});
    // $('.focus-example [title]').tipsy({trigger: 'focus', gravity: 'w'});
  });
  
  
 
</script>    
		
	 
 <script type="text/javascript" src="<?php echo $patH?>/panel/tiny_mce1/tiny_mce.js"></script>
<script type="text/javascript">
	/*tinyMCE.init({
		mode : "textareas",
		theme : "advanced"
		
	});*/
	tinymce.create('tinymce.plugins.ExamplePlugin', {
    createControl: function(n, cm) {
    
        switch (n) {
            case 'mylistbox':
                var mlb = cm.createListBox('mylistbox', {
                     title : 'My list box',
                     onselect : function(v) {
                         tinyMCE.activeEditor.windowManager.alert('Value selected:' + v);
                     }
                });

                // Add some values to the list box
                mlb.add('Some item 1', 'val1');
                mlb.add('some item 2', 'val2');
                mlb.add('some item 3', 'val3');

                // Return the new listbox instance
                return mlb;

            case 'mysplitbutton':
                var c = cm.createSplitButton('mysplitbutton', {
                    title : 'My split button',
                    image : 'img/example.gif',
                    onclick : function() {
                        tinyMCE.activeEditor.windowManager.alert('Button was clicked.');
                    }
                });

                c.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Some title', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                    m.add({title : 'Some item 1', onclick : function() {
                        tinyMCE.activeEditor.windowManager.alert('Some  item 1 was clicked.');
                    }});

                    m.add({title : 'Some item 2', onclick : function() {
                        tinyMCE.activeEditor.windowManager.alert('Some  item 2 was clicked.');
                    }});
                });

                // Return the new splitbutton instance
                return c;
        }

        return null;
    }
});

// Register plugin with a short name
tinymce.PluginManager.add('example', tinymce.plugins.ExamplePlugin);

// Initialize TinyMCE with the new plugin and listbox
tinyMCE.init({
    editor_selector : "mceEditor",
    editor_deselector : "mceNoEditor",
    plugins : '-example,table', // - tells TinyMCE to skip the loading of the plugin
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo, forecolor, fontsizeselect,removeformat,code",
    theme_advanced_buttons2 : "tablecontrols,hr",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_resizing : true,
    theme_advanced_statusbar_location : "bottom"
});

 
</script>
<?php 
$ip=getenv(REMOTE_ADDR);
 
if($ip=="89.110.212.56A" or $ip=="127.0.0.1A")
{
?>
<script>
obnovi_sessiju_test();
</script>
<?php 
}
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
				required: "Upišite tekst oglasa!"
			 
			}
		},
    
		// set this class to error-labels to indicate valid fields
   
		success: function(label) {
    
			label.addClass("checked");
		}
	});
});
</script>

 

 
 
 
 <table class='registracija_naslov' style='width:95%;'>
<tr>
<td style='width:510px'>
<div class='naslov_smestaj'><h1>Upis novog smeštaja</h1></div>
</td>
<td align="right">
<p class="obavezno_blue"><span style='color:red;font-size:18px;'>*</span> Obavezno popuniti</p>
</td>
</tr>
</table>

 
<?php 
if(strlen($msgr)>4)
{
?>
<br class='clear' /><div class='box' style='width:95%;'><div><?php echo $msgr?></div></div>
 

<?php 
}
?>
<form enctype="multipart/form-data" action="" class='gf-form' method="post" id="contactform" name="myform" >
  
  
 
	<table   cellspacing='4' style='float:left;width:96%;'>
	    
 

  <tr>
			<td class="cck_label">Naziv smeštaja <span style='color:red;font-size:18px;'>*</span></td>
      <td class="cck_field">
			<input class="text input_poljes_sivob" type="text" id="nameAds" name="nameAds" maxlength="80" size="32" value="<?php echo htmlspecialchars($_POST[nameAds], ENT_QUOTES)?>"  />	
       
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

 
 
        </td>
        
        </tr>   
 
 <tr><td colspan="2" height="20"></td></tr>
<tr>
 <td>
 
 </td>
<td>
    
      
     <input type="submit" name='upis_korak11' value='SAČUVAJ IZMENE I IDI NA SLEDEĆI KORAK &raquo;' class='submit_dugmici_blue' id="submitButton" style='float:right;width:50%;border:1px solid #444;' />
 
    
</td>
 
 </tr>
    </table>
   

</form>
 
 
        
