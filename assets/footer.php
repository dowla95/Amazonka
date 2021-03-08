<?php if($settingsb['poz_footer']!="") $pozboja=" style='background:".$settingsb['poz_footer']."'"; else $pozboja="";?>
        <div class="footer-top pt-50 pb-50"<?php echo $pozboja?>>
            <div class="container-fluid">
<!--
				<div class="row mb-30">
                	<div class="col-lg-5 col-12 col-sm-6">
<img src="<?php echo $patH?>/images/icon/visa.png" title="Visa platna kartica" alt="Visa platna kartica" class="mr-10">
<img src="<?php echo $patH?>/images/icon/mastercard.png" title="Master Card platna kartica" alt="Master Card kartica" class="mr-10">
<img src="<?php echo $patH?>/images/icon/maestro.png" title="Maestro platna kartica" alt="Maestro kartica" class="mr-10">
<img src="<?php echo $patH?>/images/icon/aex.png" title="American Expres platna kartica" alt="American Expres platana kartica" class="mr-10">
<img src="<?php echo $patH?>/images/icon/dina.jpg" title="Dina platna kartica" alt="Dina platana kartica">
                    </div>
                    <div class="col-lg-2 col-12 col-sm-6">
<a href="http://www.bancaintesabeograd.com" title="Banca Intesa" target="_blank"><img src="<?php echo $patH?>/images/icon/intesa.jpg" title="Banca Intesa" alt="Banca Intesa"></a>
                    </div>
                    <div class="col-lg-5 col-12 col-sm-6 text-right">
<a href="https://rs.visa.com/pay-with-visa/security-and-assistance/protected-everywhere.html " title="Verified by Visa" target="_blank"><img src="<?php echo $patH?>/images/icon/vvisa.png" title="Verified by Visa" alt="Verified by Visa" class="mr-10"></a>
<a href="http://www.mastercard.com/rs/consumer/credit-cards.html" title="MasterCard Secure Code" target="_blank"><img src="<?php echo $patH?>/images/icon/mastersq.png" title="MasterCard Secure Code" alt="MasterCard Secure Code"></a>
                    </div>
                </div>
-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-content-wrapper border-top pt-40">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">                                    
                                    <div class="single-footer-widget">
                                        <div class="footer-logo mb-10">
<?php
$logf = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=2");
$logf1=mysqli_fetch_array($logf);
if($logf1['slika']!="") { ?>
										<a href="<?php echo $patH?>"><img class="img-fluid" src="galerija/<?php echo $logf1['slika']?>" alt="<?php echo $logf1['alt']?>" title="<?php echo $logf1['title']?>"></a>
<?php } ?>
                                        </div>
<!--
                                        <div class="footer-text-block mb-10">
                                            <h5 class="footer-text-block__title"><?php echo $arrwords2['adresa']?></h5>
                                            <p class="footer-text-block__content"><?php echo $arrwords2['adresa_prva']?></p>
                                        </div>
-->
                                        <div class="footer-text-block mb-10">
                                            <h5 class="footer-text-block__title"><?php echo $arrwords['treba_vam_pomoc']?></h5>
                                            <p class="footer-text-block__content"><?php echo $arrwords['zadovoljstvo_kupaca']?></p>
                                        </div>

                                        <div class="footer-social-icon-block mb-20">
											<ul>
											<?php if($settings['google']!="") {?><li><a href="<?php echo $settings['google']?>" target="_blank"><i class="fas fa-map-marker-alt"></i></a></li><?php }?>
											<?php if($settings['facebook']!="") {?><li><a href="<?php echo $settings['facebook']?>" target="_blank"><i class="fab fa-facebook"></i></a></li><?php }?>
											<?php if($settings['twitter']!="") {?><li><a href="<?php echo $settings['twitter']?>" target="_blank"><i class="fab fa-twitter"></i></a></li><?php }?>
											<?php if($settings['linkedin']!="") {?><li><a href="<?php echo $settings['linkedin']?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php }?>
											<?php if($settings['instagram']!="") {?><li><a href="<?php echo $settings['instagram']?>" target="_blank"><i class="fab fa-instagram"></i></a></li><?php }?>
											<?php if($settings['youtube']!="") {?><li><a href="<?php echo $settings['youtube']?>" target="_blank"><i class="fab fa-youtube-square"></i></a></li><?php }?>
											<?php if($settings['tiktok']!="") {?><li><a href="<?php echo $settings['tiktok']?>" target="_blank"><img class="tiktok" src="<?php echo $patH?>/css/svg/tiktok.svg" title="Pratite nas na Tiktok" alt="Pratite nas na Tiktok"></a></li><?php }?>
											</ul>
                                        </div>
                                    </div>
                                    
                                    <!--=======  End of single footer widget  =======-->
                                </div>
            
                                <div class="col-lg-5 col-md-6 mt-sm-30">
                                    <!--=======  single footer widget  =======-->
                                    
                                    <div class="single-footer-widget">
                                        <h4 class="footer-widget-title"><a href="#"><?php echo $arrwords['novosti_prijava_footer']?></a></h4>
							<p><?php echo $arrwords['prijem_novosti_footer']?></p>
                            <div class="footer-form">
								<form action="#" method="post" class="add_email">
								<div id="infomsg"></div>
								<script>document.querySelector("form").setAttribute("action", "")</script>
                                    <input class="float-left" type="email" name="email" placeholder="<?php echo $arrwords['unesi_email_adresu']?>" required>
									<input type="hidden" name="add_email" value="1">
                                    <button type="submit" class="theme-button product-cart-button2 float-right prij"><?php echo $arrwords2['prijava']?></button>
                                </form>
                            </div>
                                    </div>
                                    
                                    <!--=======  End of single footer widget  =======-->
                                </div>
            
                                <div class="col-lg-4 col-md-6 mt-md-30 mt-sm-30">
                                    <!--=======  single footer widget  =======-->
                                    
                                    <div class="single-footer-widget">
                                        <h5 class="montserrat-footer-widget-title">INFO</h5>
            
                                        <div class="footer-navigation">
                                            <nav>
							<ul>
							<?php
$me=mysqli_query($conn, "SELECT * FROM menus_list WHERE id_menu=37 ORDER BY position ASC");
while($me1=mysqli_fetch_assoc($me))
{              
$pe=mysqli_query($conn, "SELECT * FROM pagel WHERE id_page=$me1[id] AND lang='$lang'");
$pe1=mysqli_fetch_assoc($pe);
$pa=mysqli_query($conn, "SELECT * FROM page WHERE id=$me1[id]");
$pa1=mysqli_fetch_assoc($pa);
if(mb_eregi(".php",$pe1['ulink'])) $ulinka=$pe1['ulink']; else
if($pe1['ulink']!="") $ulinka=$pe1['ulink']."/"; else $ulinka="";
?>
<li><a href="<?php echo $patH1?>/<?php echo $ulinka?>" title="<?php echo $pe1['naziv']?>"><b class="<?php echo $pa1['class_for_icon']?>"></b> <?php echo $pe1['naziv']?></a></li>
<?php } ?>
							</ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text-area">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-center text-md-left mb-sm-15">
                                    <div class="copyright-text">
                                        <p>Copyright © 2020 <a href="<?php echo $patH?>">Amazonka.rs</a>. Sva prava zadržana.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center text-md-right">
                                    <div class="copyright-text">
                                        <p class="float-right">Designed by <span><a target="_blank" href="https://www.biznet.rs/usluge/izrada-web-sajta/">BizNet izrada sajtova</a></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Modal -->
<div class="modal" id="modal-name">
  <div class="modal-sandbox"></div>
  <div class="modal-box">
    <div class="modal-header">
      <div class="close-modal">&#10006;</div>
      <div class='mh'>Proizvod je prebačen u korpu!</div>
    </div>
    <div class="modal-body">
<div id="resus"></div>
<div class="row">
<div class="col-6"><a href="javascript:;" class="nastavi-kupovinu close-modal1">Nastavi kupovinu</a></div>
<div class="col-6 text-right"><a href="<?php echo $patH1?>/korpa/" class="zavrsi-kupovinu">Naruči odmah</a></div>
</div>
</div>
    </div>
  </div>

    <!-- scroll to top -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div> <!-- /End Scroll to Top -->

<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>

<script src="js/main.js"></script>
<script src="js/active.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
      $('#summernote').summernote({
        placeholder: 'Unesite opis',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['font', ['bold', 'underline', 'italic' 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          /*['table', ['table']],*/
        ]
      });
    </script>
<script>

AOS.init({
	easing: 'ease-in-out-sine',
	duration: 1200,
});
</script>
<script src="assets/js/ajax-mail.js"></script>
<script src="assets/js/main.js"></script>
<script src="js/mk.js"></script>
<script>
$(document).on("click", '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
</script>
  <script>
    $(document).ready(function() {
        $(".mk_menu").simpleMobileMenu({
            onMenuLoad: function(menu) {
                console.log(menu)
                console.log("menu loaded")
            },
            onMenuToggle: function(menu, mk_opened) {
                console.log(mk_opened)
            },
            "menuStyle": "mk_slide"
        });
    })
    </script>
<?php if(strpos(curPageURL(), $all_links[3]) == true){ ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<?php } ?>
</body>
</html>