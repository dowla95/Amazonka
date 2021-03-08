<?php 
session_start();
$sid=session_id();

include("Connections/conn.php"); 

$dztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
            
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=".strip_tags($_GET['id'])."");
$dztz1=mysqli_fetch_array($dztz);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titles?></title>        
<meta name="description" content="<?php echo $descripts?>" />
	<meta name="keywords" content="" />
    <meta name="author" content="">
    <base href="<?php echo $patH1?>/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
 
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="js/js.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo $patH?>/images/icon/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
 
<body style='background:none;' onload="print()">


 
 
 
<div class="col-sm-9 padding-right">
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
 
<div class="glavna-slika">
<a href='<?php echo $patH?><?php echo GALFOLDER?>/<?php echo $dztz1['slika']?>' class='highslide' onclick='return hs.expand(this)' title=''>
<img src="<?php echo $patH?><?php echo GALFOLDER?>/thumb/<?php echo $dztz1['slika']?>" title="<?php echo $dztz1['titleslike']?>" alt="<?php echo $dztz1['altslike']?>">
</a>
</div>
 
<div class="clear"></div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<h1><?php echo $dztz1['naslov']?></h1>
								<p><?php echo $dztz1['marka']?></p>
								<span>
									<span>Cena: <?php echo format_ceneS($dztz1['cena'],$idvalute)?></span>

								 
								</span>
                <div class="clear"></div>
<?php 
$brend=mysqli_query($conn, "SELECT * FROM stavkel WHERE id_page=$dztz1[brend] AND lang='$lang'");
$brend1=mysqli_fetch_assoc($brend);
?>                
                                <p><strong>Brend:</strong> <?php echo $brend1['naziv']?></p>
                <?php 
   $fis = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.nivo=1 AND  p.akt=1 AND p.id_cat=28 ORDER BY -p.position DESC");
 
    
 $i=0;
 while($fis1=mysqli_fetch_array($fis))
 {                 
$nd = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        INNER JOIN pro_filt pf ON pf.id_pro=$dztz1[id]
        WHERE pt.lang='$lang' AND  p.akt=1 AND id_parent=$fis1[ide] GROUP BY p.id ORDER BY -position DESC");
 
$nd1=mysqli_fetch_assoc($nd);

                ?>                
    <p><strong><?php echo $fis1['naziv']?>:</strong> <?php echo $nd1['naziv']?></p>
<?php 

}
?>								
						 
                                
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
 
<div class="clear mrgbottom20"></div>
<div class="category-tab shop-details-tab"><!--category-tab-->
 
						<div class="col-sm-12">
						 
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="details" >
              	<div style='padding:10px 20px 15px;'>
				<?php
$filtris=explode(",",$dztz1["filteri"]);
$filt=array();
foreach($filtAll as $kuk => $vuk) {
if(in_array($kuk, $filtris))
$filt[$kuk]=$vuk;
}
if(strlen($dztz1["filteri"])>0){
echo '<strong>Karakterisike proizvoda:</strong><br>';

$iv=0;
foreach($filt as $k => $v){
$parent=$v['id_parent'];
echo $filtAll[$parent]['naziv'].": ";
echo "<strong>".$v['naziv']."</strong><br>";
$iv++;
}
}
        ?>
							<br>
                <b>Opis proizvoda</b><br />
                <?php echo $dztz1['opis']?></div>
								
								
							</div>
							
						 
              	<div style='padding:10px 20px 15px;'>
                <b>CENA UZ MTS PAKET</b><br />
<table class="tabela">
					<thead>
						<tr>
							<td>Mobilni telefon</td>
                            <td>MTS Paket</td>
							<td>Cena u dinarima</td>
						</tr>
					</thead>
					<tbody>
                    	<tr>
                        	<td rowspan="10">Samsung Galaxy Grand Prime</td>
                            <td>Priča</td>
                            <td>12.599</td>
                        </tr>
                        <tr>
                        	<td>Miks S</td>
                            <td>9.799</td>
                        </tr>
                        <tr>
                        	<td>Priča Plus</td>
                            <td>8.549</td>
                        </tr>
                        <tr>
                        	<td>Miks M</td>
                            <td>5.339</td>
                        </tr>
                        <tr>
                        	<td>Miks L</td>
                            <td>2.699</td>
                        </tr>
                        <tr>
                        	<td>Miks XL</td>
                            <td>1</td>
                        </tr>
                        <tr>
                        	<td>Miks XL Plus</td>
                            <td>1</td>
                        </tr>
                        <tr>
                        	<td>Miks XXL</td>
                            <td>1</td>
                        </tr>
                        <tr>
                        	<td>Super</td>
                            <td>1</td>
                        </tr>
                        <tr>
                        	<td>Super Plus</td>
                            <td>1</td>
                        </tr>
					</tbody>
				</table>
        </div>
						 
 
							
						</div>
					</div>
<div class='clear'></div>
<br />


 

</div>

 
            
	 

</body>

</html>