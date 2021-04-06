<?php 
session_start([
    'cookie_lifetime' => 86400,
]);
$sid=session_id();
include("../Connections/conn.php");
include("Izvrsenja.php");

unset($_SESSION['promo-kod']);
if(!isset($_GET['zanemari'])) {
if(!isset($_POST['promo']) or trim($_POST['promo'])=="")
echo "Upišite kod!";

elseif(isset($_POST['promo']) and trim($_POST['promo'])!="")
{
$array = array();
$ima=0;
$promo=mysqli_query($conn, "SELECT * FROM promo_kodovi");
while($promo1=mysqli_fetch_assoc($promo)){
 if($promo1['kod']==trim($_POST['promo']))
 {
 $ima=1;
 if(($promo1['iskoriscen']==1 and $promo1['upotrebljivost']==0) or $promo1['istekao']==1 or date("Y-m-d H:i:s")>=$promo1['vazi_do']) {
 $ima=0;
 }
 if($ima==1)
 $array[0] = $promo1;
 }
}
if($ima==0)
 echo "Uneli ste pogrešan PROMO KOD. <br>Molimo Vas pokušajte ponovo!";
else {

$mn=mysqli_query($conn, "SELECT * FROM users_data WHERE user_id=$_SESSION[userid] AND akt='Y'");
$mn1=mysqli_fetch_assoc($mn);
$promo=mysqli_query($conn, "SELECT * FROM promo_kodovi");
$promo1=mysqli_fetch_assoc($promo);

$kredit  = $mn1['kredit'];
$vrednost = $promo1['vrednost_koda'];
$kod=trim($_POST['promo']);

$kredit += $vrednost;

mysqli_query($conn, "UPDATE users_data SET kredit=$kredit WHERE user_id=$_SESSION[userid] AND akt='Y'");
mysqli_query($conn, "UPDATE promo_kodovi SET iskoriscen=1 WHERE kod='$kod'");

echo "<div id='promo-info' style='width:100%;color:green;'>Uspešno ste iskoristili vaš vačuer.</div>";

// $secondsWait = 5;
// header("Refresh:$secondsWait");
}
}
}
?>