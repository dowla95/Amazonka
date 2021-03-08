<?php 
$sliv=mysqli_query($conn, "SELECT * FROM slike WHERE id_page=0 and akt='Y' and tip=2 ORDER BY -pozicija DESC");
?> 
 <div class="hero-slider-area mb-40">
            <!--=======  hero slider wrapper  =======-->
            <div class="hero-slider-wrapper">
                <div class="ht-slick-slider"
                data-slick-setting='{
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "arrows": false,
                    "dots": true,
                    "autoplay": true,
                    "autoplaySpeed": 5000,
                    "speed": 1000,
                    "fade": true
                }'
                data-slick-responsive='[
                    {"breakpoint":1501, "settings": {"slidesToShow": 1} },
                    {"breakpoint":1199, "settings": {"slidesToShow": 1} },
                    {"breakpoint":991, "settings": {"slidesToShow": 1} },
                    {"breakpoint":767, "settings": {"slidesToShow": 1} },
                    {"breakpoint":575, "settings": {"slidesToShow": 1} },
                    {"breakpoint":479, "settings": {"slidesToShow": 1} }
                ]'
                >

<?php                    
while($sliv1=mysqli_fetch_assoc($sliv)) {
$liv=mysqli_query($conn, "SELECT * FROM slike_lang WHERE id_slike=$sliv1[id]");
$liv1=mysqli_fetch_assoc($liv);
?>					
                    <!--=======  single slider item  =======-->
                    <div class="single-slider-item">
                        <div class="hero-slider-item-wrapper hero-slider-item-wrapper--fullwidth" style="background:url(<?php echo $patH?>/galerija/<?php echo $sliv1['slika']?>);background-repeat:no-repeat;background-size:cover;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="hero-slider-content">
                                            <p class="slider-title slider-title--small"><?php echo $liv1['alt']?></p>
                                            <p class="slider-title slider-title--big-bold"><?php echo $liv1['title']?></p>
                                            <p class="slider-title slider-title--big-light"><?php echo $liv1['ulink']?></p>
		<?php if($sliv1['link']!="") { ?><a class="theme-button hero-slider-button" href='<?php echo $sliv1['link']?>'><?php echo $arrwords['vise_oovome']?></a><?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--=======  End of single slider item  =======-->
<?php } ?>
                </div>
            </div>
        </div><!--=======  End of hero slider wrapper  =======-->