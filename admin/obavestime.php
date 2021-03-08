<br class='clear'>
<br>
<table style='width:100%;' cellspacing="0" cellpadding="0">
<tr><td width="65%">
<?php 
$ova=mysqli_query($conn, "SELECT * FROM page WHERE id='$idp'");
$ova1=mysqli_fetch_assoc($ova);
if($_GET['tip']==5) $io="-o";
?>
<div class='naslov_smestaj'><h1>"OBAVESTI ME" LISTA</h1></div>
</td>
 <td align='right'>
<div class='trakica_pozadina'></div>
</td>
<td align='right'>
<div class='trakica_pozadina'></div>
</td>
</tr>
</table>              
<?php 
//$orderby=" -pozicija DESC";
$orderby=" p.id DESC";
?>
 <script>
 function gog(id,tip,idp)
{
if(id!="")
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>&"+tip+"="+id+"&idp="+idp
else
window.location="<?php echo $patHA?>/index.php?base=<?php echo $base?>&page=<?php echo $page?>"+"&idp="+idp;
}
</script>
<?php  
if($_GET['ord']=="") $view="&ord=1"; 
if($_GET['ord']==1) 
{
$orderby=" br_pregleda ASC";
$view="&ord=2";
}
if($_GET['ord']==2) 
{
$orderby=" br_pregleda DESC";
$view="&ord=1";
}
$ByPage1=100;
if($_GET['search']==1)
{
$plun="";
$pojams=$_GET['pojams'];
if($pojams!="") 
{
$pojams=str_replace(" ","_",$pojams);
$poh=explode("_",$pojams);
for($t=0;$t<count($poh); $t++)
{ 
if(strlen($poh[$t])>2){
$pret = addcslashes($poh[$t], '%_');
//$plus .=" AND (naslov LIKE '%$pret%' OR opis LIKE '%$pret%' OR opis1 LIKE '%$pret%' OR kraj LIKE '%$pret%' OR idfirme IN (SELECT id FROM proizvodi_page WHERE naslov LIKE '%$pret%'))";
//$pret = str_replace(array('š', 'ć', 'č', 'ž', 's', 'c', 'z','Š', 'Ć', 'Č', 'Ž', 'S', 'C', 'Z'), array('(š|s)', '(ć|c)', '(č|c)', '(ž|z)', '(š|s)', '(c|ć|č)', '(ž|z)','(Š|S)', '(Ć|C)', '(Č|C)', '(Ž|Z)', '(Š|S)', '(C|Ć|Č)', '(Ž|Z)'), $pret);  
//$plun .=" AND (p.naziv REGEXP '[[:<:]]".$pret."[[:>:]]' OR p.opis  REGEXP '%*".$pret."[[:>:]]')";
$plun .=" AND (pl.naslov LIKE '%".$pret."%' or pl.opis LIKE '%".$pret."%')";
}
}
}
} 
if($_GET['tipi1']=="1")
$plun .=" AND p.coment=0";
if($_GET['admino']==7) $plun .=" AND p.vegan='1'";
if($_GET['admino']==6) $plun .=" AND p.izdvojeni='1'";
if($_GET['admino']==4) $plun .=" AND p.akcija='1'";
if($_GET['admino']==5) $plun .=" AND p.naslovna='1'";
if($_GET['admino']==3) $plun .=" AND p.novo='1'";
if($_GET['admino']==1) $plun .=" AND p.akt='1'";
if($_GET['admino']==2) $plun .=" AND p.akt='0'";
if($_GET['id']>0) $plun .=" AND p.id=$id_get"; 
if($_GET['id_kat']>0) $plun .=" AND p.katid=$id_kat_get";
if($_GET['id_page']>0) $plun .=" AND p.id_page=$id_page_get";
if($_GET['id_user']>0) $plun .=" AND p.user_id=$id_user_get";
if($_GET['idp']>0) $andidpS="p.id_page IN(".kategorije($_GET['idp'],"page",1).") AND "; 
$page_cur=0;


//if($kdkd==1)
//$inpagination=urldecode(http_build_query($_POST)); else
if($search_values[1]!="")
$inpagination=urldecode($search_values[1]);
$inpagin=explode("&p=",$inpagination);
$inpagination=$inpagin[0]."&";
$page_cur=$sarray['p'];
$br_upisa=mysqli_num_rows(mysqli_query($conn, "SELECT *, p.id as id, o.id as ido FROM  pro p
INNER JOIN obavestenja_proizvod o ON o.pro=p.id
WHERE p.id>0 $plun GROUP BY o.id"));
$pagedResults = new Paginated($br_upisa, $ByPage1, $page_cur);
$str=$pagedResults->fetchPagedRow();
$pagedResults->setLayout(new DoubleBarLayout());



$fi=mysqli_query($conn, "SELECT *, p.id as id, o.id as ido FROM  pro p
INNER JOIN obavestenja_proizvod o ON o.pro=p.id
WHERE o.id>0 $plun GROUP BY o.id ORDER BY datum DESC LIMIT $str,$ByPage1");
 ?>
<div style='width:100%;font-size:11px;padding-bottom:5px;height:25px;'>
<form method="get" action="" style="float:right;width:200px;">
    <input type="hidden" name="idp" value="<?php echo $_GET['idp']?>" />
    <input type="hidden" name="base" value="<?php echo $_GET['base']?>" />
    <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
    <input type="hidden" name="tip" value="<?php echo $_GET['tip']?>" />
    <input type="hidden" name="search" value="1" />
    <input type='text' name='id' class='input_poljes' style='padding:3px;float:left;width:100px;' value="<?php echo $_GET['id']?>">
    <input type="submit" value="Pronađi ID" name='nadji_oglas' class='submit_dugmici_blues' style='float:left;width:95px;border:1px solid #888;padding:2px;margin-left:2px;' />
    </form>  
</div>

 <div id='sorting'>
<table class='upitnici_oglasi'>
<tbody id="slickbox1">
<tr class="yellow" id="sortid_0"> 
<td>ID</td>
<td>Naziv</td>
<td>Slika</td>
<td>Email</td>
<td>Datum</td>
<td>Obavesti</td>
<td>Brisanje</td>
</tr>
<?php 
$i=0;
while($og1=mysqli_fetch_array($fi)){
if($i%2==0) $ba='background:#f1f1f1;'; else $ba='background:#fff;';
$msg_id=$og1['id']; 
$zzL=mysqli_query($conn, "SELECT * FROM prol  WHERE id_text=$og1[id] AND lang='$firstlang'");
$zzL1=mysqli_fetch_array($zzL); 
?>
<tr id="sortid_<?php echo $og1['ido']?>" style='<?php echo $ba?>'>

<td style='width:30px;'><?php echo $og1['id']?></td>

<td style='width:350px;'>
<a href="<?php echo $patHA?>/index.php?base=admin&page=edit_proizvoda&id=<?php echo $og1['id']?>&tip=<?php echo $_GET['tip']?>" title="<?php echo str_replace("\"","",$zzL1["naslov"])?>"><?php echo $zzL1["naslov"]?></a>
 </td>
 <td>
 <?php if(is_file("..".GALFOLDER."/$og1[slika]")){ ?>
 <a href="..<?php echo GALFOLDER?>/<?php echo $og1['slika']?>" class='group1'>
 <img src="..<?php echo GALFOLDER?>/thumb/<?php echo $og1['slika']?>" width='50' />
 </a>
 <?php } ?>
 </td>
<?php 
$ttt=2;
?> 
<td>
<?php 
echo $og1["email"];
?>
</td>
<td>
<?php 
echo $og1["datum"];
?>
</td>
<?php 
if($og1['obavesten']==1) $obav="class='d-none'";
//echo 'poslato';
else
//echo 'nije';
$obav="";
?>
<td>
<input <?php echo $obav?> type='button' value='Obavesti' onclick="obavesti('<?php echo $og1['ido']?>', 'obavesti')" />
</td>

<td>

<a href="javascript:;" class="crvena" onclick="obrisime(<?php echo $og1['ido']?>,'obavestenja_proizvod')"><i class="fal fa-trash-alt"></i></a>
</td>
</tr>
<?php 
$i++;
}
?>
</tbody>
  </table>
  </div>
  <?php 
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by ISNULL(pozicija), pozicija ASC");
//$fi=mysqli_query($conn, "SELECT * FROM oglasi WHERE id>0 order by -pozicija DESC");
//while($fi1=mysqli_fetch_array($fi))
//echo $fi1[nameAds]." - $fi1[pozicija]<br>"; 
?>
<div class='pagination_o'>	
	<?php 
$hah=preg_replace("/&p=[0-9]/","",curPageURL());
 if($br_upisa>$ByPage1)
echo $pagedResults->fetchPagedNavigation("$patHA/index.php?".$inpagination."p=");
  ?>
</div>
