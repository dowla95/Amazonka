    <div class="breadcrumb-area mb-30">
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
<div class="row">
<?php
$pter = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' ORDER BY time DESC LIMIT 3");
?>
<div class="col-lg-3 order-2 order-lg-1">
	<div class="page-sidebar">
		<div class="sidebar-widget-wrapper mb-30">
<div class="sidebar-widget">
<h3 class="sidebar-widget-title">POSLEDNJE VESTI</h3>
	<div class="block-container mt-20">
<?php 
while($izg2=mysqli_fetch_assoc($pter))
{
?>
		<div class="single-block d-flex">
            <div class="image">
				<a href='<?php echo $patH1?>/<?php echo $page1["ulink"]?>/<?php echo $izg2["ulink"]?>/'>
<?php if(isset($izg2['slika']) and $izg2['slika']!="") { ?>
                <img class="img-fluid" src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $izg2['slika']?>" alt="<?php echo $izg2["altslike"]?>" title="<?php echo $izg2["titleslike"]?>" />
<?php } else echo '<i class="fal fa-image fa-3x"></i>'; ?>
                </a>
			</div>
			<div class="content">
			<p><a href='<?php echo $patH1?>/<?php echo $page1["ulink"]?>/<?php echo $izg2["ulink"]?>/'><?php echo $izg2['naslov']?></a></p>
			<p><?php echo date("H:i",$izg2['time'])?> | <?php echo datum(date("Y-m-d",$izg2['time']))?></p>
			</div>
		</div>
<?php } ?>
	</div>
</div>
            </div>
</div>
</div>