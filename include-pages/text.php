      <div class="col-sm-9 padding-right">

						
<?php 
$ByPage1=10;
$page_cur=$sarray['p'];  

$ukupnos = mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst"));

$pagedResults = new Paginated($ukupnos, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout()); 

$pte = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' AND p.id_page='$page1[id]' $and_tekst ORDER BY -p.pozicija DESC, time ASC LIMIT $str,$ByPage1");
        
$ptenum=mysqli_num_rows($pte);
if($ptenum==0)
echo "<h2 class='title text-center'>".$page1['h1']."</h2>"; 
$br=0;
?>

<div class='blog-post-area'>
<?php 
while($pte1=mysqli_fetch_assoc($pte))
{ 
$stropis1=strlen($pte1["opis1"]);
$stropis2=strlen($pte1["opis"]);

 

if($pte1["ulink"]!="")
$link_det="<a href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>";
$link_det1="</a>"; 
?>
<div class='single-blog-post'>
<?php 
if($br==0)
echo "<h2 class='title text-center'>".$page1['h1']."</h2>"; 

if($idup=="" and $stropis1>10 and $stropis2>10)
{
 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
$wh=explode("-",image_size1(170,128,$pte1['slika']));
?> 

<div class="col-sm-2">
<?php echo $link_det ?>

<img src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" style="position:relative;top:20px;" class="img-responsive" /></a>
<div class="highslide-caption"><?php echo $pte1["altslike"]?></div>
</div>

<?php 
$cols=10;
}else $cols=12;
 
?>
<div class="col-sm-<?php echo $cols?>">
<?php 
echo $link_det.'<h3>'.$pte1["naslov"].'</h3>'.$link_det1;
echo $pte1["opis1"];

echo "<a class='btn btn-primary pull-right' href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>detaljnije</a>";
?>
</div>


<div class="post-meta pull-left">
								<ul>
									<li><i class="fa fa-user"></i> Admin</li>
									
								</ul>
							</div>
</div>
<div class="clear"></div>              
<?php 
}else
if($idup=="" and $stropis1<10 and $stropis2>10)
{
 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
$wh=explode("-",image_size1(170,128,$pte1['slika']));
?> 

<div class="col-sm-2">
<a href="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" class="highslide" onclick="return hs.expand(this)" title="<?php echo $pte1["titleslike"]?>">
<img src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" style="position:relative;top:20px;" class="img-responsive" /></a>
<div class="highslide-caption"><?php echo $pte1["altslike"]?></div>
</div>

<?php 
$cols=10;
}else $cols=12;
 
?>
<div class="col-sm-<?php echo $cols?>">
<?php 
echo '<h3>'.$pte1["naslov"].'</h3>';
echo $pte1["opis"];
?>
<div class="post-meta pull-left">
								<ul>
									<li><i class="fa fa-user"></i> Admin</li>
									
								</ul>
							</div><br class='clear' />
<?php 
read_files("idupisa",$pte1['id'],$page1['id'],$patH,$page_path2,0);
include("$page_path2".SUBFOLDER."/include-pages/middle/galerija-page.php");
 
?>

</div>              
<?php 
}
else
 
if($idup>0 or ($stropis1<10 and $stropis2>10))
{
?>
 <div class="col-sm-12">
<?php 
if($pte1["naslov"]!="")
echo "<h1 class='vestih1'>".$pte1["naslov"]."</h1>";
$velt=12;
$velt1=3;
 
if($pte1['full_img_width']==1)
$velt1=12;

if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
?> 
 <div class="col-sm-<?php echo $velt1?>">
<a href="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" class="highslide" onclick="return hs.expand(this)" title="<?php echo $pte1["titleslike"]?>"><img class="img-responsive" src="<?php echo $patH?><?php echo GALFOLDER ?>/thumb/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" /></a>
<div class="highslide-caption"><?php echo $pte1["altslike"]?></div>
 </div>
<?php 
if($pte1['full_img_width']==0)
$velt=9;
}
?>
<div class="col-sm-<?php echo $velt?>">
<?php 
echo $pte1["opis"];
?>
<div class="post-meta pull-left">
								<ul>
									<li><i class="fa fa-user"></i> Admin</li>
									
								</ul>
							</div>
</div>
<br class='clear' />
<?php 
read_files("idupisa",$pte1['id'],$page1['id'],$patH,$page_path2,0);
include("$page_path2".SUBFOLDER."/include-pages/middle/galerija-page.php");
 
?>
<br class='clear' />
<a class="btn btn-primary pull-right mrgbottom20" href="javascript:history.back()">Nazad</a>
 </div>
 </div>
<?php 
}
 $br++;
}
if($idup=="")
{
if($ukupnos>$ByPage1){
{
?>
<div class="pagination-area pull-right">
							<ul class="pagination">
	
<?php 
echo $pagedResults->fetchPagedNavigation($search_values[0]."?p=");
?>								
								
							</ul>
</div>
<?php 
}
}
}
?>

</div>
 
</div>        
                