<?php 
include("Connections/conn.php");


if($_POST[ime]!="")
{

extract($_POST);
if(empty($ime))
$msg.=$niz[forma_false][0];
elseif(empty($mail))
$msg.= $niz[forma_false][5];
elseif (!mb_eregi("^[A-Z0-9._%-]+[@][A-Z0-9._%-]+[.][A-Z]{2,6}$", $mail)) 
$msg.=$niz[forma_false][7];

else
{
$impr=$ime." ".$lname;
$time= "Čas: ".date("d/m/Y H:i", time());
$ip= "nIP: ".$_SERVER['REMOTE_ADDR'];
$message= " 
<table style=\"font-size:11px; font-family:verdana,helvetica,arial;\">
<tr><td><b>Čas/IP:</b></td><td> ".$time." / $ip</td></tr>

<tr><td><b>Ime:</b></td><td> ".strip_tags($impr)."</td></tr>
<tr><td><b>Ime podjetja:</b></td><td> ".strip_tags($company)." </td></tr>
<tr><td><b>Telefon:</b></td><td> ".strip_tags($phone)." </td></tr>
<tr><td><b>E-mail:</b></td><td> ".strip_tags($mail)." </td></tr>
<tr><td align=\"left\" colspan=\"2\"><b>Opomba:</b></td></tr>
<tr><td align=\"left\" colspan=\"2\">".strip_tags($text)."</td></tr>
</table>
";
$st="font-weight:normal;";
$message1= " 
<table style=\"font-size:11px; font-family:verdana,helvetica,arial;\">
<tr><td><b>Čas/IP:</b></td><td style=\"$st\"> ".$time." / $ip</td></tr>

<tr><td><b>Ime:</b></td><td style=\"$st\"> ".strip_tags($impr)."</td></tr>

<tr><td><b>Ime podjetja:</b></td><td style=\"$st\"> ".strip_tags($company)." </td></tr>
<tr><td><b>Telefon:</b></td><td> ".strip_tags($phone)." </td></tr>
<tr><td><b>E-mail:</b></td><td style=\"$st\"> ".strip_tags($mail)." </td></tr>
</table>
";

 //$insert = str_replace("<", "&lt;", $insert);
 //$insert = str_replace(">", "&gt;", $insert);
$insert1=addslash($message1);
$insert2=strip_tags($text);
$insert3="";

$subject="Contact from site Duol  - $impr";
$headers="From:$mail\n" .
    "MIME-Version: 1.0\n" .
    "Content-type: text/html; charset=utf-8";
    $Adminmail="aleksandrou@gmail.com";
   
@mail($Adminmail, $subject, $message, $headers);

######povratni mail########
$headers1="From:$Adminmail\n" .
    "MIME-Version: 1.0\n" .
    "Content-type: text/html; charset=utf-8";
   $povrporuka="<span style='font-weight:bold'>Spoštovani $impr</span><br />";
//$povrporuka .=mailmessage();   
//@mail($mail, "BV-DESIGN TEAM", $povrporuka, $headers1);
#########End Povratni mail#######

if(@mysqli_query($conn, "INSERT INTO kontakt_forme SET  naslov='".$insert1."', opis='$insert2', tekst1='$insert3', id_page='".idpages("kontakt.php","slo")."',datum='$dat'"))
if($lang=="slo")
$msg="Vaše povprešavanje je bilo posredovano!<br />
Kontaktirali vas bomo v kratkem roku!";
else if($lang=="eng")
$msg="Your inquiry has been forwarded! <br />
We will contact you at short notice!";
else
$msg="Vaša poruka je poslata!<br />
Kontaktiracemo vas u najkracem mogucem roku!";
}
echo "<span style='color:red;'>$msg</span>";
}

?>