<?php 
$get_calend = @preg_replace('#[^0-9]#i', '', $_GET['kid']);

include("Connections/conn.php");
 
$cal=mysqli_query($conn, "SELECT * FROM ce_calendars WHERE id=".strip_tags($get_calend)."");
$cal1=mysqli_fetch_array($cal);
$hk=mysqli_query($conn, "SELECT * FROM ce_templates WHERE id='$cal1[template]'");
$hk1=mysqli_fetch_array($hk);
 
$id_lang=array_search($load_lang,$lniz); 
 
  

 
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>	
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />	
     
    <title>Booking events calendar
    </title>	
    <meta http-equiv="Content-Language" content="en-us" />	
    <meta http-equiv="imagetoolbar" content="no" />	
    <meta name="MSSmartTagsPreventParsing" content="true" />	
    <meta name="description" content="GreenGrass Template" />	
    <meta name="keywords" content="free css template" />  
    <link rel="stylesheet" href="<?php echo $patH;?>/css/style_form_reservation.css" type="text/css" media="screen" />    
    <link rel="stylesheet" href="<?php echo $patH?>/css/jquery.datepick.css" type="text/css" media="screen" /> 
    <?php 
$font=$hk1["font"];
 $load_google_font=$hk1["load_google_font"];

if($load_google_font==1)
{
$font1=str_replace(" ","+",$font);
 
?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $font1?>">
<?php 
}    
    ?>
<script type="text/javascript" src="<?php echo $patH?>/js/jquery.js"></script>    
<script type="text/javascript" src="<?php echo $patH?>/js/jquery.datepick.js"></script> 
<script type="text/javascript">

$(function() {
$('#startPicker,#endPicker').datepick({ 
    onSelect: customRange, showTrigger: '#calImg',dateFormat: "<?php echo $dformat?>",   pickerClass: 'noPrevNext', minDate: 0 }); 
 });    
function customRange(dates) { 
    if (this.id == 'startPicker') { 
        $('#endPicker').datepick('option', 'minDate', dates[0] || null); 
    } 
    else { 
        $('#startPicker').datepick('option', 'maxDate', dates[0] || null); 
    } 
}


 
 $(document).ready(function() {
$( "#sendform<?php echo $get_calend;?>" ).submit(function( event ) {
 

var datastring = $("#sendform<?php echo $get_calend;?>").serialize();
var id=$("#kida<?php echo $get_calend;?>").val();  
 
$.ajax({
type: "POST",
dataType: "json",
 url: "<?php echo $patH?>/reservation_send.php?kid="+ id+"&lang=<?php echo $load_lang?>",
data: datastring,
cache: false,
 beforeSend : function (){
$(".sajax-loadings1").fadeIn();
            },
success: function(datas){
//alert(datas)
 
$(".sajax-loadings1").fadeOut();

$(".dapi"+id).html("<div class='"+datas[1]+"'><div>"+datas[0]+"</div></div>");
$(".dapi"+id).show();
if(datas[3]==1)
{
$("#sendform"+id).hide();
 
 
}
  parent.$.fn.colorbox.resize({
        innerWidth: $(document).width(),
        innerHeight: $(document).height() 
         
    });
}

}); 
//event.preventDefault();
 return false;
 });  
}); 
</script>

   

<style type="text/css">
body, #content, input, button
{
font-family: "<?php echo $font?>", "Arial";
}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4360295-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>
 
<link rel='stylesheet' type='text/css' href='<?php echo $patH;?>/colorbox/colorbox1.css'>
<script type='text/javascript' src='<?php echo $patH;?>/colorbox/jquery.colorbox-min.js'></script>
 
<script type="text/javascript">
$(document).ready(function() {
    parent.$.fn.colorbox.resize({
        innerWidth: $(document).width(),
        innerHeight: $(document).height() 
         
    });
});
 
</script>

  </head>	
  <body>
    <div id="content">
    <div class='sajax-loadings1'></div>  
<?php 
$sod=$dos="";
if($format==1 and isset($_GET['sod']) and isset($_GET['dos'])  and !isset($_POST['sod']))
{
$eod1=explode("-",strip_tags($_GET['sod']));
$eod1=array_reverse($eod1);
$sod=implode("-",$eod1);
$edo1=explode("-",strip_tags($_GET['dos']));
$edo1=array_reverse($edo1);
$dos=implode("-",$edo1);
}
else
if($format!=1 and isset($_GET['sod']) and isset($_GET['dos'])  and !isset($_POST['sod']))
{
$sod=strip_tags($_GET['sod']);
$dos=strip_tags($_GET['dos']);
}
  
if(isset($_POST['sod'])) $sod=$_POST['sod'];
if(isset($_POST['dos'])) $dos=$_POST['dos'];

if($cal1['minday']>0)  
$ipis=sprintf($langa['reservation_form'][19],$cal1['minday']);
      ?> 
      <h3 class='h3naslov1'>
        <span><?php echo $langa['reservation_form'][7]?><?php echo $ipis?>:
        </span></h3> 
<?php 
if(strlen($msr)>4)
echo "<div class='$klasa'><div>$msr</div></div>";
      ?>
      <div class='dapi<?php echo $get_calend;?>'></div>
      <form method='post' action=''  name="sendform<?php echo $get_calend;?>" id="sendform<?php echo $get_calend;?>">  	
        <ol class="forms">		 	
        <li class="half_left">        
               
                <label for="subject"><?php echo $langa['reservation_form'][2]?> 
                  <span class='need'>*
                  </span>
                </label>
                <input type="text" name="sod" autocomplete ="off" id="startPicker"  value="<?php echo $sod;?>" />
                </li>
                <li class="half_right">        
                <label for="subject"><?php echo $langa['reservation_form'][3]?> 
                  <span class='need'>*
                  </span>
                </label>
             <input type="text" name="dos" autocomplete ="off" id="endPicker"  value="<?php echo $dos;?>" />  
          </li>	
<?php 

$lf=mysqli_query($conn, "SELECT * FROM ce_labels_form WHERE id='$cal1[id_forme]'");
$lf1=mysqli_fetch_array($lf);
$idform=$lf1['id'];
 
$lab=mysqli_query($conn, "SELECT * FROM ce_labels WHERE id_form='$idform' AND level=1 ORDER BY position ASC");
while($lab1=mysqli_fetch_assoc($lab))
{
$zab=mysqli_query($conn, "SELECT * FROM ce_labels WHERE id_form='$idform' AND level=1 AND position<$lab1[position] ORDER BY position DESC LIMIT 1");
$zab1=mysqli_fetch_array($zab);
$labi=$lab1['labels'];
if(isset($_POST[$labi]))
$postlab=$_POST[$labi];
else
$postlab="";
if(($lab1['half']==1 and $zab1['half']==0) or ($lab1['half']==0 and $zab1['half']==1))
{
$break="<br />";
if($lab1['half']==0 and $zab1['half']==1)
$halfclas=" class='half_right'"; else $halfclas=" class='half_left'";
}
else
{
$halfclas="";
$break=" &nbsp; &nbsp; ";
}
?>          			
          <li<?php echo $halfclas?>>
          <label for="subject"><?php 
          $lniz = (array) json_decode($lab1['namelabel'],true);
          echo $lniz[$id_lang];
          ?>
            <?php 
            if($lab1['need']==1)
            echo "<span class='need'>* </span>";
            ?>
          </label>
         
        	           
          	
<?php 

$dva=substr($lab1['labels'],0,2);
if($dva=="ch" or $dva=="se" or $dva=="ra")
{
if($dva=="se")
{
echo "<select class='select' name='$labi' id='$labi'>";
echo "<option value=''> ----- </option>";
}
$plab=mysqli_query($conn, "SELECT * FROM ce_labels WHERE id_form='$idform' AND level=2 AND id_group='$lab1[id_group]' ORDER BY position ASC");
 
while($plab1=mysqli_fetch_array($plab))
{
$plniz = (array) json_decode($plab1['namelabel'],true);
$nlabel= $plniz[$id_lang];
$rep_lab=str_replace("opt","label",$plab1['labels']);
if($dva=="se")
{
if(isset($_POST[$labi]) and $_POST[$labi]=="$plab1[position]") $sellab="selected"; else $sellab="";
echo "<option value='$plab1[position]' $sellab>$nlabel</option>";
}
else
if($dva=="ch")
{
if(@in_array("$plab1[position]",$_POST[$labi])) $chlab="checked"; else $chlab="";
echo "<input type='checkbox' name='".$labi."[]' value='$plab1[position]' $chlab /> $nlabel$break";
}
if($dva=="ra")
{
if(isset($_POST[$labi]) and $_POST[$labi]=="$plab1[position]") $ralab="checked"; else $ralab="";
echo "<input type='radio' name='".$labi."' value='$plab1[position]' $ralab /> $nlabel$break";
} 
}
if($dva=="se")
echo "</select>";
}elseif($dva=="tx" or $dva=="em")
{
?>
 <input type="text"  name="<?php echo $labi?>" id="<?php echo $labi?>" value="<?php echo $postlab;?>" />
<?php 
}
elseif($dva=="ms")
{
?>
<textarea name="<?php echo $labi?>" id="<?php echo $labi?>" rows="5" cols="60"><?php echo $postlab;?></textarea>
 
<?php 
}
 }
?>      
  </li>  			 		 			
          <li>           
            <input type="checkbox"  name="send_copy" value="1" />  <?php echo $langa['reservation_form'][5]?>       
            <button type="submit" id="submit"   class='submit_button'><?php echo $langa['reservation_form'][6]?>
            </button>
  <input type="hidden" name="kid" id="kida<?php echo $get_calend;?>" value="<?php echo $get_calend;?>" />
        <input type="hidden" name="half" value="<?php echo $cal1['half'];?>" />
        <input type="hidden" name="langra" value="<?php echo $id_lang;?>" />
       
          <input type="hidden" name="book_days" id="submitted" value="true" />
        
  <input type="hidden" name="status" value="<?php echo $cal1['pend_res'];?>" />
         
          </li>			
          <li id="availabler">
          </li>		
        </ol>     
      </form>  
      <?php 
      if(!isset($_GET['popup']))
      {
      ?>
        <br style="clear:both;" />    
<a href="javascript:;" id='hidev1' onclick="calendars1(<?php echo $get_calend?>)"><?php echo $langa['reservation_form'][20]?></a>
<?php }?>        
    </div>
   
  </body>
</html>
