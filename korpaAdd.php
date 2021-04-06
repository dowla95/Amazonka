<?php
session_start();
include("Connections/conn.php");
include(SUBFOLDERS."include/Izvrsenja.php");
$sid=session_id();
$id=$_POST['id'];
$tip=$_POST['tip'];
$psum=0;
if($tip=="yes" and isset($_POST['oldid']) and $_POST['oldid']>0)
{
$oldid=$_POST['oldid'];
$_SESSION[$sid][$id]=$_SESSION[$sid][$oldid];
unset($_SESSION[$sid][$oldid]);
}
else
if($tip=="yes")
{
if(!isset($_SESSION[$sid][$id]))
$_SESSION[$sid][$id]=1;
else
$_SESSION[$sid][$id]=$_SESSION[$sid][$id]+1;
}
else
if($tip=="minus")
{
if(isset($_SESSION[$sid][$id]))
$_SESSION[$sid][$id]=$_SESSION[$sid][$id]-1;
}
 else
if($tip=="drop")
{
if(isset($_SESSION[$sid][$id]))
unset($_SESSION[$sid][$id]);
}
if(isset($_SESSION[$sid]))
{
$prodArr=array();
$ponisti_iznos_dostave=0;
foreach($_SESSION[$sid] as $key => $value)
{
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);

$prodArr[$az1['prodavac']][]=roundCene($az1['cena'],1)*$value;
}
}
$ikorpa='';
$ukupno=0;
$kolko=0;
foreach($_SESSION[$sid] as $key => $value)
{
$cena_sum=0;
$sum=0;
if($key>0)
{
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
$az1=mysqli_fetch_assoc($az);
if(array_sum($prodArr[$az1['prodavac']])>$az1['limit_dostave'] and $az1['limit_dostave']>0)
$ponisti_iznos_dostave=1;
else
$ponisti_iznos_dostave=0;
if($ponisti_iznos_dostave==1) {
$dostIznos=0;
} else if($az1['nova_cena_dostave']>0){
$dostIznos=roundCene($az1['nova_cena_dostave'])*$value;
} else if($az1['fiksna_dostava']>0){
$dostIznos=roundCene($az1['fiksna_dostava'])*$value;
}
$cenar=$az1['cena'];
$cena_sum =roundCene($cenar,1)*$value;
$cena_sum_idost =roundCene($cenar,1)*$value+$dostIznos;
$ukupno +=roundCene($cenar)*$value+$dostIznos;
$sum =$value;
$zalink=$all_links[3];
$bz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.kupindo='$az1[kupindo]' AND $az1[nijansa]>0 AND NOT p.id=$az1[ide] ORDER BY -p.pozicija DESC, pt.naslov");
if(mysqli_num_rows($bz)==0) $bezo=" class='d-none myBtn'"; else $bezo=" class='myBtn'";

			$ikorpa .= '<tr id="row'.$az1['id'].'">
							<td class="pro-thumbnail">';
if($az1['slika']!="") {
$ikorpa .='<a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/">
<img src="'.$patH.GALFOLDER.'/thumb/'.$az1['slika'].'" title="'.$az1['titleslike'].'" alt="'.$az1['altslike'].'">';

}
else {
$ikorpa .='<a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/">
<img src="'.$patH1.'/img/no-product-image.png" title="'.$az1['titleslike'].'" alt="'.$az1['altslike'].'">';
 }
$ikorpa .='</a>
							</td>
							<td class="pro-title">
        <h4><a href="'.$patH1.'/'.$zalink.'/'.$az1['ulink'].'-'.$az1['id'].'/">'.$az1['naslov'].'</a></h4>
								<p>Web ID: '.$az1['ide'].'</p>
							</td>
							<td class="pro-price">
							<span class="notxt">Cena po jedinici: </span>';
   	 if($az1['cena1']>0) {
								$ikorpa .='<p>'.format_ceneS($az1['cena'],2).'</p>';
							 } else {
							$ikorpa .='<p>'.format_ceneS($az1['cena'],2).'</p>';
							  }
      	$ikorpa .='</td>
                            <td class="pro-quantity">
                                <div class="quantity">
                                <input type="button" class="minus" value="-"  onclick="displaySubs1('.$az1['id'].',\'minus\');">
                                <input size="2" class="brr" title="Kolicina" value="'.$value.'" min="1" step="1" id="val'.$az1['id'].'">
                                <input type="button" class="plus" value="+"  onclick="displaySubs1('.$az1['id'].',\'yes\');">
                                </div>
                            </td>
							';

							$ikorpa .='
							<td class="pro-subtotal">
								<p class="cart_total_price" id="cen'.$az1['ide'].'"><span class="notxt">SVEGA: </span>'.format_ceneS($cena_sum,2).'</p>
							</td>

							<td class="pro-remove">
							<span class="notxt">Izbaci iz korpe </span>
								<a class="cart_quantity_delete" href="javascript:;" onclick="displaySubs2('.$az1['id'].',\'drop\');"><i class="fa fa-times"></i></a>
								<hr class="razd notxt">
							</td>
						</tr>';

}
$kolko++;
}
}
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0){
$bezpdv=($ukupno-$_SESSION['promo-kod']['vrednost_koda'])/(1+$settings['pdv']/100);
$pdv=$ukupno-$_SESSION['promo-kod']['vrednost_koda']-$bezpdv;
} else {
$bezpdv=$ukupno/(1+$settings['pdv']/100);
$pdv=$ukupno-$bezpdv;
}

$ikorpa .='<tr class="sukupno">
<td><h4>UKUPNO:</h4></td>
<td>
</td>
<td colspan="2">';
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0) {
$del1="<del>";
$del2="</del>";
}
else {
$del1="";
$del2="";
}
if(formatCene($ukupno,1) == formatCene($ukupno,1, $_SESSION['promo-kod']['vrednost_koda'])) $nono=" d-none"; else $nono="";

$ikorpa .='<p class="ukupno'.$nono.'">'.$del1.format_ceneS($ukupno,2).$del2.'</p>
</td>
<td colspan="2">
<p class="ukupno-promo ukupno">'.format_ceneS($ukupno,2, $_SESSION['promo-kod']['vrednost_koda']).'</p>
</td>
</tr>';


$cena_sum_korpa=$cena_sum=0;
$sum=0;
$zaHeaderKorpu="";
if(isset($_SESSION[$sid]))
{
foreach($_SESSION[$sid] as $key => $value)
{
if($key>0)
{
$pr=mysqli_query($conn, "SELECT * FROM pro WHERE id=$key AND akt=1");
$pr1=mysqli_fetch_assoc($pr);


if($id==$key and $tip=="yes") {

$prl=mysqli_query($conn, "SELECT * FROM prol WHERE id_text=$key");
$prl1=mysqli_fetch_assoc($prl);

$cenarER=$pr1['cena'];
$cena_sumER =roundCene($cenarER,1)*$value;
$ukupnoER +=roundCene($cenarER)*$value;
$zalinkER=$all_links[3];


$zaHeaderKorpu ='<div class="single-item" id="item-korpa'.$pr1['id'].'">

<div class="image">
<a href="'.$patH1.'/'.$zalinkER.'/'.$prl1['ulink'].'/">
<img class="img-fluid" src="'.$patH.GALFOLDER.'/thumb/'.$pr1['slika'].'" title="'.$prl1['naslov'].'" alt="'.$prl1['naslov'].'">
</a>
</div>
<div class="content">
<p class="cart-name"><a href="'.$patH1.'/'.$zalinkER.'/'.$prl1['ulink'].'/">'.$prl1['naslov'].'</a></p>

<p class="cart-quantity"><span class="quantity-mes"> '.$value.' x </span> '.$pr1['cena'].' = <span>'.formatCene($cena_sumER,1).'</span></p>
</div>

<a class="remove-icon" href="javascript:;" onclick="displaySubs2('.$pr1['id'].',\'drop\');"><i class="fal fa-trash-alt"></i></a>
</div>';
}
//
/*if($pr1['cena1']>0 and $pr1['akcija']==1)
$cenar=$pr1['cena1'];
else*/
$cenar=$pr1['cena'];
$psum=roundCene($cenar,1)*$value;
if($id==$key)
$cena_sum +=roundCene($cenar,$idvalute)*$value;
$cena_sum_korpa +=roundCene($cenar,1)*$value;
$sum +=$value;
}
}
}
if($sum==0 and isset($_SESSION['promo-kod']))
unset($_SESSION['promo-kod']);

if(isset($_COOKIE['valuta']))
$idvalute=""; else
$idvalute=1;
$bezpdv=$cena_sum_korpa/(1+$settings['pdv']/100);
$pdv=$cena_sum_korpa-$bezpdv;
if(isset($_SESSION['promo-kod']['vrednost_koda']) and $_SESSION['promo-kod']['vrednost_koda']>0)
$promo=1;
else
$promo=0;




$niv=array(formatCene($cena_sum,$idvalute), $sum, formatCene($cena_sum,1), $_SESSION[$sid][$id], formatCene($cena_sum_korpa,1),formatCene($bezpdv,1),formatCene($pdv,1),$promo, formatCene($cena_sum_korpa,1,$_SESSION['promo-kod']['vrednost_koda']),$zaHeaderKorpu,$ikorpa);
echo json_encode($niv);
