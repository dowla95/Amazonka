<?php 
 //error_reporting( E_ALL ^ E_NOTICE ^ E_WARNING );
 // ini_set("display_errors", 1);
include("header-top-add-user.php");
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
</head><!--/head-->
<body>
<div id='inline_content' style='padding:10px; background:#fff;width:615px;margin:0 auto;'>
  <h1 style='font-size:18px;'>Upis novog promo koda</h1>
<?php 
if($msr!="")
echo "<div class='infos1'><div>$msr</div></div>";
?>
 <br />
 <form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="tip" value="<?php echo $_GET['tip']?>" />
<?php 
$zvez="<span style='color:red;'>*</span>"; 
$vazido=$_POST['vazido']?$_POST['vazido']:"";
$min_potrosnja=$_POST['min_potrosnja']?$_POST['min_potrosnja']:"";
$vr_koda=$_POST['vr_koda']?$_POST['vr_koda']:"";
$br_kodova=$_POST['br_kodova']?$_POST['br_kodova']:"";
?>
<div class='ui-tabs-panel ipad'>
<label>BROJ KODOVA  <span style='color:red;'>*</span></label><br />
<input type="number" min="1" name='br_kodova' class='selecte' value="<?php echo $br_kodova?>" />
</div>
<br />
<div class='ui-tabs-panel ipad'>
<table style="width:100%;">
<tr>
<td>
<label>VREDNOST KODA  <span style='color:red;'>*</span></label><br />
<input type="text" name='vr_koda' class='selecte' value="<?php echo $vr_koda?>" />
</td>
<td>
Procenat ili RSD  <?php echo $zvez?>
<select name="tip_koda" class='selecte'>
                      <?php 
$proc_arr=array("Procenat", "RSD");
foreach($proc_arr as $k => $v)
{
if(isset($_POST['vr_tip']) and $k==$_POST['vr_tip'])
$che="selected"; else $che="";
echo "<option value='$k' $che>$v</option>";
}
                        ?>
</select>
</td>
</tr>
</table>
</div>
<br />
<div class='ui-tabs-panel ipad'>
<label>MINIMALNA POTROSNJA (popuniti samo ako se izabere RSD)</label><br />
<input type="text" name='min_potrosnja' class='selecte' value="<?php echo $min_potrosnja?>"/>
</div>
<br />
<div class='ui-tabs-panel ipad'>
<?php 
$izdi="";
if(isset($_POST['upotrebljivost'])) $izdi="checked";
?>
<label><b>Višekratni:</b> <input type="checkbox" value='1' name='upotrebljivost' style="position:relative;top:3px;"<?php echo $izdi?> /></label>
</div>
<br />
<div class='ui-tabs-panel ipad'>
<label>VAZI DO <?php echo $zvez?></label><br />
<input type="text" name='vazido' id="datepicker" class='selecte' value="<?php echo $vazido?>" />
</div>
<br />
<div class='ui-tabs-panel ipad' style="display:none;">
<label>KATEGORIJE <?php echo $zvez?></label><br />
<select name="kategorije[]" class='selecte mselect' style="width:44%" multiple="multiple">
                 <?php 
foreach($kar_arr as $k => $v)
{
if(isset($_POST['kategorije']) and in_array($k, $_POST['kategorije']))
$che="selected";
echo "<option value='$k' selected>$v</option>";
}
                        ?>
</select>
</div>
<br />
<input type='submit' name='save_promo_kod' class="submit_dugmici_blue" value='GENERIŠI'>
<br />
</form>
</body>
</html>