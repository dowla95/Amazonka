    <div class="breadcrumb-area mb-20">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH1?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Istorija naručivanja</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="container-fluid">

<?php 
if(isset($_SESSION['userid']))
{
$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
$mn1=mysqli_fetch_assoc($mn);
?>
		<div class="section-title">
			<h3>Stanje</h3>
		</div>
		<div class="row ">			
			<div class="col-md-2">
				<p>Vas kredit je: <?php echo $mn1['kredit']?> RSD</p>
			</div>			
			<div class="col-md-2">
				<div class="theme-button product-cart-button float-left collapsed" data-toggle="collapse" data-parent="#prok" href="#prok">Dopuni kredit</button></div>
			</div>
			<div class="col-md-3">
				<div class="theme-button product-cart-button float-left collapsed" data-toggle="collapse" data-parent="#vaucer" href="#vaucer">Dodaj vaucer</button></div>
			</div>	
		</div>
		<div id="prok" class="collapse"><hr>	
			<div class="row ">			
				<div class="col-md-2"><p>Izaberite sumu: </p></div>				
				<div class="col-md-2">						
					<select name="" class="w-100">
						<option value="0">500,00 RSD</option>
						<option value="1">1.000,00 RSD</option>
						<option value="2">2.000,00 RSD</option>
						<option value="3">5.000,00 RSD</option>
					</select>			
				</div>
				<div class="col-md-2">
					<button type="" class="theme-button product-cart-button2"> Nastavi sa uplatom </button>
				</div>
			</div>				
		</div>
		<div id="vaucer" class="collapse"><hr>	
			<div class="row">
				<div class="col-md-2"><p>Unos vaucer-a: </p></div>                    
				<div class="col-md-7">
					<div class="input-group">
							<input class="form-control" type="text" name="promo-kod" maxlength="6" id="promo-kod" <?php echo $isable?> value="<?php echo $_SESSION['promo-kod'] ?>" placeholder="Unesite promo KOD">
							
							<a class="theme-button product-cart-button2" id="iskoristi_vaucer" href="#" style="margin-left:10px;">Upotrebi KOD</a>
							<div id="promo-info" style='width:100%;color:red;'></div>
						</div>
					</div>
				</div>			
		</div>	
 <?php } ?>
		<hr>		
		<div class="section-title">
			<h3>Istorija naručivanja</h3>
		</div>
		<div class="row">
			<div class="col-12">
			<div class="cart-table table-responsive mb-40">
				<table class="table text-center">
<?php 
$pz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM porudzbine p
        INNER JOIN poruceno pt ON p.id = pt.id_porudzbine AND p.user_id=$_SESSION[userid] GROUP BY p.id
        ORDER BY vreme DESC");
if(mysqli_num_rows($pz)==0) echo "<h2>Do sada nemate nijednu narudžbinu!</h2>"; else { ?>
					<thead>
						<tr>
							<td>Narudžina br.</td>
							<td>Br. pošiljke</td>
							<td>Praćenje pošiljke</td>
							<td>Vreme kreiranja</td>
							<td>Iznos</td>
							<td>Poslato</td>
							<td>Dana</td>
						</tr>
					</thead>
<?php } ?>
					<tbody>
<?php
while($pz1=mysqli_fetch_array($pz))
{
if($pz1['status']==1)
 $status=" jeste"; else $status=" nije";
 ?>
			<tr>
			<td>
			<a href="<?php echo $patH1?>/poruceno.php?id=<?php echo $pz1['ide']?>"><?php echo $pz1['ide']?></a>
			</td>
			<td>
<?php if($pz1['br_posiljke']!="") echo $pz1['br_posiljke']; else echo ""; ?>
			</td>
            <td>
<?php if($pz1['br_posiljke']!="") {
if(substr($pz1['br_posiljke'], 0, 2)=="PE") $prlink=$settings['prati_posiljku']."?broj=".pz1['br_posiljke'];
elseif(substr($pz1['br_posiljke'], 0, 3)=="BEX") $prlink="http://www.bex.rs/onlinepracenjeposiljke.php";
else $prlink="#";
?>
<a href='<?php echo $prlink?>' target="_blank" class="btn-2 home-btn">Prati pošiljku</a>
<?php } ?>
			</td>
			<td><?php echo date("d.m.Y H:i",$pz1['vreme']); ?></td>
			<td><?php 
      if($pz1['iznos_sa_kodom']>0 and $pz1['iznos']>$pz1['iznos_sa_kodom'])
      echo "<span style='font-size:11px;'>".format_ceneS2($pz1['iznos'],0)."</span><br>cena sa promo kodom:<br>".format_ceneS2($pz1['iznos_sa_kodom'],0);
   else echo format_ceneS2($pz1['iznos'],0);
      ?></td>
			<td class="fa fa-circle<?php echo $status?>"></td>
			<td><?php 
            if($pz1['datum_isporuke']!="")
            echo datum($pz1['datum_isporuke']); 
            else
            echo "-";
            ?></td>
						</tr>
<?php } ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>


 	