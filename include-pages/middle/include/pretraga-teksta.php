<div class="container mb-40">
<div class="row">
<?php 
$ByPage1=10;
$page_cur=$sarray['p'];  
$pojam=trim(strip_tags($sarray['word']));
if($pojam) 
{
$poh=explode(" ",$pojam);
for($t=0;$t<count($poh); $t++)
{ 
if(strlen($poh[$t])>2){
$pret = addcslashes($poh[$t], '%_');
$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";
$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);  
$plun .=" AND (pt.naslov REGEXP '[[:<:]]".$pret."[[:>:]]' OR pt.opis  REGEXP '%*".$pret."[[:>:]]')";
}
}
} 
$ukupnos = mysqli_num_rows(mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE pt.lang='$lang'  AND p.akt='Y' $plun "));
$pagedResults = new Paginated($ukupnos, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout()); 

$pte = mysqli_query($conn, "SELECT p.*, pt.*
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text     
        WHERE pt.lang='$lang'  AND p.akt='Y' $plun  ORDER BY -p.pozicija DESC, time ASC LIMIT $str,$ByPage1"); 
$ptenum=mysqli_num_rows($pte);
$br=0;
if($ptenum==0)
echo "<div class='col-12'><h2 class='title text-center'>Nije pronađen nijedan tekst!</h2></div>"; 
else
echo "<div class='col-12'><h2 class=' mb-30 mt-20'>Rezultat pretrage tekstova</h2></div>";
while($pte1=mysqli_fetch_assoc($pte))
{
$stropis1=strlen($pte1["opis1"]);
$stropis2=strlen($pte1["opis"]);

$page = mysqli_query($conn, "SELECT p.*, pt.*
        FROM page p
        INNER JOIN pagel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.id=$pte1[id_page]");
$page1=mysqli_fetch_assoc($page);

if($pte1['id_page']==26 or $pte1['id_page']==4) {
$link_det="<a href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>";
$dugme="<a class='theme-button product-cart-button2 float-right' href='".$patH1."/".$page1["ulink"]."/".$pte1["ulink"]."/'>CEO TEKST</a>";
}
elseif($pte1['id_page']==1) {
$link_det="<a href='".$patH1."/'>";
$dugme="<a class='theme-button product-cart-button2 float-right' href='".$patH1."'>CEO TEKST</a>";
}
else {
$link_det="<a href='".$patH1."/".$page1["ulink"]."'>";
$dugme="<a class='theme-button product-cart-button2 float-right' href='".$patH1."/".$page1["ulink"]."'>CEO TEKST</a>";
}
$link_det1="</a>";
?>

<div class="col-12 col-md-4 text-center mt-30">
<?php 
if(is_file($page_path2.SUBFOLDER.GALFOLDER."/$pte1[slika]"))
{
$wh=explode("-",image_size1(170,128,$pte1['slika']));
?>

<?php echo $link_det ?>
<img src="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $pte1['slika']?>" alt="<?php echo $pte1["altslike"]?>" title="<?php echo $pte1["titleslike"]?>" class="w-100" />
<?php 
echo $link_det1;
}
?>
</div>

<div class="col-12 col-md-8 mt-30">
<?php 
echo $link_det.'<h2>'.$pte1["naslov"].'</h2>'.$link_det1;
echo "<p>".strip_tags(substr($pte1["opis"],0,500))."...</p>";
?>
<div class="w-100"></div>
<?php echo $dugme?>
</div>

<?php 
 $br++;
} ?>
</div>
<?php 
if($idup=="")
{
if($ukupnos>$ByPage1){
{
?>
<div class="pagination-area pull-right">
<ul class="pagination">
<?php 
echo $pagedResults->fetchPagedNavigation($search_values[0]."?word=$pojam&pron=".strip_tags($sarray['pron'])."&p=");
?>								
</ul>
</div>
<?php 
}
}
}
?>
</div>