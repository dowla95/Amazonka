    <div class="breadcrumb-area mb-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo $patH?>">Naslovna</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Kontakt</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
<?php echo "<h1>".$page1['h1']."</h1>" ?>
                </div>
            </div>
        </div>
    <section class="contact-style-2 pt-30 pb-35">
<?php if($settings['gmapa']!="") { ?><div class="mb-45"><?php echo $settings['gmapa']?></div><?php } ?>
       <!--=====  End of google map container  ======-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 offset-lg-1 col-md-12 mb-sm-45 order-1 order-lg-2 mb-md-45">
                    <!--=======  contact page side content  =======-->
                    <div class="contact-page-side-content">
                        <h3 class="contact-page-title">Kontakt info</h3>
                        <p class="contact-page-message mb-30"><?php echo $settings['txt_kontakt_info']?></p>
                        <!--=======  single contact block  =======-->
                        <div class="single-contact-block">
                            <h4><i class="fal fa-envelope"></i> Email</h4>
                            <p><?php echo $settings['email_zaemail']?></p>
                        </div>
                        <!--=======  End of single contact block  =======-->
                    </div>
                    <!--=======  End of contact page side content  =======-->
                </div>
                <div class="col-lg-6 col-md-12 order-2 order-lg-1">
                    <!--=======  contact form content  =======-->
                    <div class="contact-form-content">
                        <h3 class="contact-page-title">Pišite nam</h3>
	    			<div class="contact-form">
	    				<div class="status alert alert-success" style="display:none"></div>
              <div class="status alert alert-warning" style="display:none"></div>
				    	<form id="main-contact-form" class="contact-form row" name="contact-form" method="post">
				            <div class="form-group col-md-6">
				                <input type="text" name="name" class="form-control" required placeholder="Ime i prezime*">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="email" class="form-control" required placeholder="Email*">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text" name="subject" class="form-control" placeholder="Naslov poruke">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="message" id="message" class="form-control" rows="8" placeholder="Tekst poruke*" required></textarea>
				            </div>
<div class="form-group col-md-12">
<span class='obavezno'>*</span> Čekirajte da niste robot: <br />
<div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_html']?>"></div>
</div>
				            <div class="form-group col-md-12">
				                <input type="submit" name="submit" class="theme-button contact-button" value="Pošalji">
							<!--
								<button type="submit" value="submit" id="submit" class="theme-button contact-button" name="submit">Pošalji</button>
							-->
				            </div>
				        </form>
	    			</div>
                    </div>
                </div>
            </div>
        </div>
    </section>





