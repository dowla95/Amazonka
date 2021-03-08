<?php
$reks = mysqli_query($conn, "SELECT * FROM slike, slike_lang WHERE slike.id=slike_lang.id_slike AND slike.akt='Y' AND slike.tip=3 AND slike.subtip=6 ORDER BY pozicija, rand()");
?>
    <div class="banner-statics">
        <div class="container-fluid">
<?php while($reks1=mysqli_fetch_array($reks)) {
if($reks1['ulink']!="") {
$alink="<a href='".$reks1['ulink']."'>";
$alink1="</a>";
}
else {
$alink="";
$alink1="";
}
?>
            <div class="single-banner-statics mt-20 mb-20">
                <?php echo $alink?><img class="w-100" src="galerija/<?php echo $reks1['slika']?>" title="<?php echo $reks1['title']?>" alt="<?php echo $reks1['alt']?>"><?php echo $alink1?>
            </div>
<?php } ?>
        </div>
    </div>