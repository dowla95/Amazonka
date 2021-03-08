    <div class="brand-area pb-70">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3><span>Brendovi</span></h3>
                    </div>
                </div>
                <div class="col-12">
					<div class="tab-content">
					<div class="tab-pane fade show active">
						<div class="product-gallary-wrapper">
							<div class="product-gallary-active owl-carousel owl-arrow-style product-spacing">
<?php  
$ap=mysqli_query($conn,"SELECT *, s.slika as slika FROM stavke s
INNER JOIN stavkel sl ON sl.id_page=s.id
INNER JOIN pro p ON p.brend=s.id
WHERE s.id_cat=27 AND s.akt=1 AND p.akt=1 AND s.slika IS NOT NULL AND s.slika !='' GROUP BY s.id ORDER BY s.position ASC");
if(!$ap) echo $conn->error;
while($ap1=mysqli_fetch_assoc($ap)){
?>						<div class="text-center">
							<a href="<?php echo $patH?>/<?php echo $all_links[3]?>/brend-<?php echo $ap1['ulink']?>/" title="<?php echo $ap1['naziv']?>">
								<img class="" src="galerija/thumb/<?php echo $ap1['slika']?>" alt="<?php  echo $ap1['alt']?>" title="<?php echo $ap1['titlesl']?>" style="height:70px">
                            </a>
						</div>
<?php  } ?>
							</div>
						</div>
					</div>
					</div>
                </div>
			</div>
		</div>
	</div>