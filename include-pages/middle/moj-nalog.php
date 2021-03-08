<div class="container-fluid">
<div class="row">
<?php 
if(isset($_SESSION['userid']))
{
$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
$mn1=mysqli_fetch_assoc($mn);
?>
<div id="form"><!--form-->
<div class="login-form col-sm-12"><!--sign up form-->
<h1><?php echo $page1['h1']?></h1>
<p><?php echo $page1['podnaslov']?></p>
<?php 
if($msgr!="")
echo "<div class='infob'><div class='info_box'><div>$msgr</div></div></div>";
?>               
	<form action="" method="post" id="uform">
		<div class="row">
			<div class="col-12">
			<h4>Uređivanje naloga: <?php echo $mn1['nickname']?></h4>
			</div>
            <div class="col-sm-4">
				<div class="form-select">
<?php
if($mn1['firma']==1) $sele="selected"; else $sele="";
if($mn1['firma']==0) $sele1="selected"; else $sele1="";

if($mn1['firma']==1) $disdis=''; else $disdis=' disabled';
?>
					<select name="firma-lice" id="firma-lice" required>
						<option value="">Firma ili fizičko lice?*</option>
						<option <?php echo $sele?> value="firma">Firma</option>
						<option <?php echo $sele1?> value="lice">Fizičko lice</option>
					</select>
                </div>
			</div>
			<div class="col-sm-4">
				<div class="form-select">
				<input id="nazivfirme" type="text" name='nazivfirme' placeholder="Naziv firme*" class="form-control" value="<?php echo $mn1['nazivfirme']?>" required<?php echo $disdis?>>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-select">

 <?php //if($mn1['firma']==1) { ?>
				<input id="pib" type="text" name="pib" placeholder="Unesite PIB *" class="form-control" value="<?php echo $mn1['pib']?>" required<?php echo $disdis?>>
<?php //} ?>
				</div>
			</div>
			
<script>
document.getElementById("firma-lice").onchange = function() {
    document.getElementById("nazivfirme").disabled = (this.value == "lice" || this.value == "default");
	document.getElementById("pib").disabled = (this.value == "lice" || this.value == "default");
}
document.getElementById("firma-lice").change();
</script>
			<div class="col-sm-4">
				<input type="text" name='ime' placeholder="Ime i prezime*" value="<?php echo $mn1['ime']?>" required>
			</div>
			<div class="col-sm-4">
				<input type="email" name='email' id="email" value="<?php echo $mn1['email']?>" placeholder="Email adresa*" required>
			</div>
			<div class="col-sm-4">
				<input type="password" placeholder="Lozinka*"  name="password">
			</div>
			<div class="col-sm-4">
				<input type="password" placeholder="Ponovite lozinku*"  name="password1">
			</div>
			<div class="col-sm-4">
				<input type="text" placeholder="Telefon*" name="telefon" value="<?php echo $mn1['telefon']?>" required>
			</div>
			<div class="col-sm-4">
				<input type="text" placeholder="Grad - Mesto*" value="<?php echo $mn1['grad']?>" name="grad" required>
			</div>
			<div class="col-sm-4">
				<input type="text" placeholder="Ulica i broj*" name="ulica_broj" value="<?php echo $mn1['ulica_broj']?>" required>
			</div>
            <div class="col-sm-4">
				<input type="text" placeholder="Tekući račun" name="racun" value="<?php echo $mn1['tr']?>">
            </div>
							
                        <?php 
//$zizi=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers WHERE email=".safe(strip_tags($_SESSION['email'])).""));
//if($zizi>0)
$ziz=mysqli_query($conn, "SELECT * FROM users_data WHERE email=".safe(strip_tags($_SESSION['email']))."");
$zizi=mysqli_fetch_assoc($ziz);
if($zizi['vesti']==1)
$che="checked"; else $che="";
                        ?>
	<div class="col-sm-4">
        <div class="check-box d-inline-block ml-0 ml-md-2 mt-10 mr-10">
		<input id="zelim_vesti" type="checkbox" name="vesti" value="1" class="checkbox" <?php echo $che?>>
		<label for="zelim_vesti">Želim da dobijam vesti sa sajta</label>
		<input type="hidden" name="change_cand" value='1' />
		<input type="hidden" name="avatar_curent" value='<?php echo $mn1['avatar']?>' />
		</div>
	</div>
    <div class="col-sm-12 mt-20">
		<label for="avatar">Logo ili avatar. Dozvoljeni format: .jpg, .png i .gif. Preporučena visina slike: 150px.</label>
		<input type="file" id="avatar" name="avatar">
	</div>
<?php
if(is_file($page_path2."/avatars/".$_SESSION['userid']."/".$mn1['avatar'])) {
?>
      <div class="col-sm-12">
      <img src="<?php echo $patH."/avatars/".$_SESSION['userid']."/".$mn1['avatar']?>" style='max-width:150px'>
      <br>
<input  type="checkbox" name="avatar_del" value="1" class="checkbox"> Obriši avatar/logo
      </div>
      <?php } ?>
              <div class="col-sm-12">
            <div class='alert text-right' role="alert"></div>
		<button type="submit" class="theme-button product-cart-button float-right registers">Sačuvaj izmene</button>
             </div>
		</div>
	</form>
	</div>
     
					</div><!--/sign up form-->
	</div><!--/form-->
 <?php } ?>
 </div>