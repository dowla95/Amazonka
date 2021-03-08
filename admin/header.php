<div class="header_sivo">
 <?php 
 if($_SESSION['userids'] and $admins==2)
 {
$admi=mysqli_query($conn, "SELECT tip FROM users_admin WHERE user_id=$_SESSION[userids] AND akt='Y'");
$admi1=mysqli_fetch_array($admi);
 ?>
 
<div class="container-fluid">
	<div class="row">
		<div class="col-12"> 
			<nav id="menu">
			  <label for="tm" id="toggle-menu">Navigacija <span class="drop-icon"><i class="fas fa-caret-down"></i></span></label>
			  <input type="checkbox" id="tm">
			  <ul class="main-menu clearfix">
				<li><a href="#">Users 
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm1"><i class="fas fa-caret-down"></i></label>
				  </a>
				  <input type="checkbox" id="sm1">
				  <ul class="sub-menu">
					<li><a href="./" rel="<?php echo $patHA?>" id="home">Admin</a></li>
					<li><a href="<?php echo $patHA?>/index.php?base=admin&page=users&tip=1">Ostali (<?php echo $uk_users1?>)</a></li>
				  </ul>
				</li>
<?php $sums1=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM porudzbine"));?>
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=porudzbine">Porudžbine (<?php echo $sums1?>)</a></li>
<?php $sums2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM subscribers"));?>
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subscribers">Vesti pr (<?php echo $sums2?>)</a></li>
<?php if($admi1['tip']==1) { ?>
				<li><a href="#">Podešavanja
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm2"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm2">
					<ul class="sub-menu">
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=podesavanjaAA">Glavne postavke</a></li>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=moduli">Uključivanje modula</a></li>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=izgled">Postavke izgleda</a></li>
<!--
  <li><a href="<?php echo $patHA?>/index.php?base=admin&page=language_add">Dodavanje jezika</a></li>
-->
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=language_words">Sistemski izrazi</a></li>
					</ul>
				</li>
<?php } if($admi1['tip']==1) { ?>
				<li><a href="#">Stranice
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm3"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm3">
					<ul class="sub-menu">
						<li><a href='<?php echo $patHA?>/index.php?base=admin&page=page_add&id_cat=0'>Upis - izmena stranica</a></li>	    
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=menus">Meniji</a></li>

<?php } if($hide_cats==1) { ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=categories">Kategorije</a></li>
<?php } ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=models">Modeli stranica</a></li>
<?php if($hide_stavke==1) { ?>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=stavke">Stavke</a></li>
<?php } ?>
					</ul>
				</li>
<?php if($admi1['tip']==1 or $admi1['tip']==2) { ?>
				<li><a href="#">Slike
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm4"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm4">
					<ul class="sub-menu">
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subslike&idupisa=0&tip=2">Slike slider</a></li>
						<li><a href="<?php echo $patHA?>/index.php?base=admin&page=subslike&idupisa=0&tip=3">Slike nezavisne</a></li>
					</ul>
				</li>
<?php } ?>
				<li><a href="#">Tekstovi
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm5"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm5">
					<ul class="sub-menu">
					<li><a href="<?php echo $patHA?>/index.php?base=admin&page=page_content">Svi tekstovi</a></li>    
					<li><a href="<?php echo $patHA?>/index.php?base=admin&page=page_add_content&tip=id_page">Dodaj novi tekst</a></li>
					</ul>
				</li>
 <?php 
 $sump=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=4"));
 $sumpa=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=4 AND akt=1"));
 $sump1=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=5"));
 $sumpa1=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=5 AND akt=1"));
 $sump2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=6"));
 $sumpa2=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro WHERE tip=6 AND akt=1"));
 if($admi1['tip']==1 or $admi1['tip']==2) {
 ?>
				<li><a href="#">Proizvodi
					<span class="drop-icon"><i class="fas fa-caret-down"></i></span>
					<label title="Toggle Drop-down" class="drop-icon" for="sm6"><i class="fas fa-caret-down"></i></label>
					</a>
					<input type="checkbox" id="sm6">
					<ul class="sub-menu">
					<li><a href="<?php echo $patHA?>/index.php?base=admin&page=proizvodi&tip=5">Svi proizvodi (<?php echo $sumpa1?> / <?php echo $sump1?>)</a></li>
					<li><a href="<?php echo $patHA?>/index.php?base=admin&page=add_proizvoda&tip=5">Dodaj novi proizvod</a></li>
					</ul>
				</li>
<?php if($modulArr['promo-kodovi']==1) { ?>
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=promo-kodovi">Promo kodovi</a></li>
<?php } ?>
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=obavestime">Obaveštenja</a></li>
				<!--
				<li><a href="<?php echo $patHA?>/index.php?base=admin&page=excel_load">Excel file</a></li>
				-->
				<li class='float-right'><a href="<?php echo $patHA?>/logout.php"><i class="far fa-sign-out-alt"></i></a></li>
				<li class='float-right'><a href="<?php echo $patH1?>" target="_blank"><i class="far fa-browser"></i></a></li>
			  </ul>
			</nav>
		</div>
	</div>
</div>
<?php } ?>
<?php } ?> 
</div>