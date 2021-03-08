    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Zaboraljena lozinka</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
<section id="form"><!--form-->
	<div class="container-fluid">
			<div class="row">
				<div class="col-12">
				<div class="login-form mt-30 w-100"><!--login form-->
				

<?php


if(isset($sarray['renew']) and $sarray['renew']!=''){
?>
<h2>Izmena šifre</h2>
            	<p>Ukucajte novu šifru dva puta i potvrdite.</p>
              <?php
if($msgr!="")
echo "<div class='info_box$green'><div>$msgr</div></div>";
if($istekao_link_za_sifru==0) {
?>
						<form action="" method="post">
                        <script>document.querySelector("form").setAttribute("action", "")</script>
					<div class="row">
                        <div class="col-sm-5">
							<input type="password" autocomplete="new-password"  data="true" name="password" value="" id="password"> <i class="far fa-eye-slash eyes" id="showpass_login"></i>
						</div>
                        <div class="col-sm-5">
							<input type="password" autocomplete="new-password"  data="true" name="password1" value="" id="password1"> <i class="far fa-eye-slash eyes" id="showpass_login1"></i>
						</div>
						<input type="hidden" name="renew-pass" class="btn red" value="<?php echo $sarray['renew']?>">
                        <div class="col-sm-2">
							<button type="submit" class="register-button mt-0">IZMENI</button>
						</div>
					</div>

                        </form>

<script>
$(document).ready(function (e) {

$('#showpass_login').on('click touchstart tap',(function(e) {
    var x = $("#password").attr("type");
    if (x == "password") {
        $("#password").attr("type","text");
        $(this).attr("class","far fa-eye eyes")
    } else {
         $("#password").attr("type","password");
                 $(this).attr("class","far fa-eye-slash eyes")
    }
    }));


$('#showpass_login1').on('click touchstart tap',(function(e) {
    var x = $("#password1").attr("type");
    if (x == "password") {
        $("#password1").attr("type","text");
        $(this).attr("class","far fa-eye eyes")
    } else {
         $("#password1").attr("type","password");
                 $(this).attr("class","far fa-eye-slash eyes")
    }
    }));
});
</script>
<?php
}
} else {
    ?>
    <h2><?php echo $page1['h1']?></h2>
            	<p><?php echo $page1['podnaslov']?></p>
              <?php
if($msgr!="")
echo "<div class='info_box$green'><div>$msgr</div></div>";

?>
    	<form action="" method="post">
		<div class="row">
            <div class="col-xl-6 col-lg-6">
                <input type="email" name="email" placeholder="Email adresa *" required>
            </div>
				<input type="hidden" name="forgot_password" value="1">
            <div class="col-xl-3 col-lg-4">
				<button type="submit" class="theme-button product-cart-button2">Promena lozinke</button>
			</div>
     
            <div class="col-xl-3 col-lg-2">
            <a class="theme-button list-cart-button" href="<?php echo $patH1?>/<?php echo $all_links[10]?>/" title="<?php echo $arrwords2['prijava']?>"><?php echo $arrwords2['prijava']?></a>
            </div>
		</div>
    </form> <?php } ?>
				</div><!--/login form-->
			</div>
		</div>
	</div>
</section>