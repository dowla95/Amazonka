<div class="container-fluid">
<div class="row">
<?php 
if(isset($_SESSION['userid']))
{
$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
$mn1=mysqli_fetch_assoc($mn);
if($mn1['limit_dostave']==0) $placlim="Nije definisano"; else $lim=$mn1['limit_dostave'] and $placlim="";
if($mn1['fiksna_dostava']==0) $placfix="Nije definisano"; else $fix=$mn1['fiksna_dostava'] and $placfix="";
?>
<div class="w-100"><!--form-->
<div class="login-form col-sm-12"><!--sign up form-->
<h1><?php echo $page1['h1']?></h1>
<p><?php echo $page1['podnaslov']?></p>
<?php 
if($msgr!="")
echo "<div class='infob'><div class='info_box'><div>$msgr</div></div></div>";
?>               
	<form action="" method="post">
	<input type="hidden" name="pprodavca" value='1' />
		<div class="row">
            <div class="col-md-2 col-sm-12 col-12">
			<label>Unesite tekući račun <span style='color:red;'>*</span></label>
				<input type="text" placeholder="Tekući račun" name="racun" value="<?php echo $mn1['tr']?>">
            </div>
			
			<div class="col-md-3 col-sm-12 col-12">
			<label for="dostava">Cena dostave (RSD) <span style='color:red;'>*</span></label>
			<select name="dostava" id="selectBox" onchange="changeFunc();">
			<option value="5">Izaberi i podesi...</option>
			<option value="0">Besplatna dostava za sve proizvode</option>
			<option value="1">Besplatna dostava preko limita</option>
			<option value="2">Fiksna cena dostave (ili ispod limita)</option>
			</select>
			</div>
			
			<div class="col-md-3 col-sm-12 col-12" id="limit" style="display:none">
			<label>Limit za besplatnu dostavu (RSD) <span style='color:red;'>*</span></label>
			<input type="number" name="limit" min="0" value="<?php echo $lim?>" placeholder="<?php echo $placlim?>">
			</div>

			<div class="col-md-3 col-sm-12 col-12" id="fiksna" style="display:none">
			<label>Fiksna cena dostave (RSD)<span style='color:red;'>*</span></label>
			<input type="number" name="fiksna" min="0" value="<?php echo $fix?>" placeholder="<?php echo $placfix?>">
			</div>
			
            <div class="col-md-4 col-sm-12 col-12">
			<label>Trenutno podešeno:</label>
<?php
if($mn1['limit_dostave']==0) $ld="Limit za besplatnu dostavu nije definisan"; else  $ld="<p>Besplatna dostava za narudžbine preko <b>".number_format($mn1['limit_dostave'], 2,",",".")."</b> RSD.</p>";
if($mn1['fiksna_dostava']==0) $fd="Dostava ispod limita nije definisana"; else $fd="<p>Fiksna dostava ili dostava ispod limita <b>".number_format($mn1['fiksna_dostava'], 2,",",".")."</b> RSD.</p>";
if($mn1['dostava']==0) $trenutno="<p><b>Besplatna dostava za sve proizvode.</b><p>";
else if($mn1['dostava']==1 or $mn1['dostava']==2) $trenutno=$ld.$fd;
else if($mn1['dostava']==5) $trenutno="<p><b>Trenutno bez podešavanja. OBAVEZNO PODESITE!</b><p>";
else $trenutno="";
echo $trenutno;
?>
            </div>
			
			<div class="col-sm-12">
				<div class='alert text-right' role="alert"></div>
				<button type="submit" class="theme-button product-cart-button float-right">Sačuvaj izmene</button>
             </div>
		</div>
	</form>
	</div>
     
</div><!--/sign up form-->
	</div><!--/form-->
 <?php } ?>
 </div>
 <script>
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('wheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('wheel.disableScroll')
})

        function changeFunc() {
            var selectBox = document.getElementById("selectBox");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            if (selectedValue == "1") {
                $('#limit').show();
				$('#fiksna').hide();
            } else if (selectedValue == "2") {
                $('#limit').hide();
				$('#fiksna').show();
            }
        }


/*
        function changeFunc() {
            //var selectBox = document.getElementById("selectBox");
            //var selectedValue = selectBox.options[selectBox.selectedIndex].value;
			var selectedValue = "<?php echo $mn1[dostava]?>";
            if (selectedValue == "1") {
                $('#limit').show();
				$('#fiksna').hide();
            } else if (selectedValue == "2") {
                $('#limit').hide();
				$('#fiksna').show();
            }
        }
*/
</script>