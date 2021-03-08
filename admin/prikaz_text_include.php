<?php 
$id_page=$zz1[id_page];

 
 
?>

<div class='detaljno_smestaj whites'>
 
 
 
 
 
<form method="post" action="" enctype="multipart/form-data">
<ul class='forme_klasicne'>
<li>
 
 
<?php 
if($id_page>0)
{ 
$iper=mysqli_query($conn, "SELECT * FROM page WHERE id=$id_page");
$iper1=mysqli_fetch_assoc($iper);
$arrayM = explode(",",$iper1['include_file_middle']);
$arrayL = explode(",",$iper1['include_file_left']);
$arrayR = explode(",",$iper1['include_file_right']);
$arrayF = explode(",",$iper1['include_file_dole']);
$arrayT = explode(",",$iper1['include_file_vrh']);
}
else if($id_page==0)
{
$arrayM=$arrayL=$arrayR=$arrayF=$arrayT=array("text.php","izmedju.php","text.php");
}
?> 
 
<script>             
$(document).ready(function(){
    var layM = new Array();
  $('.layM:checked').each(function() 
{    
    if( $(this).prop('checked') == true)  
     layM.push($(this).val());
}); 
 
   $('input:checkbox').click(function(){
  // alert(layM[0]);
    var vid=$(this).attr('id').replace(/[^a-zA-Z]/g,'');
    var vid1=$(this).attr('id');
    var valt=$(this).val();
  
$.ajax({
type: "POST",
url:"show_text_position_page.php",
data: {id_page:"<?php echo $id_page?>", id_text:"<?php echo $idu?>",box:vid, box_position:valt}, 
cache: false,
success: function(html){  
  $("#D"+vid1+" .ul").html(html);
}
});    
    
    //  $('input:checkbox.'+vid).removeAttr('checked');
 
   /*if( $(this).prop('checked') == false)
     $(this).attr('checked','checked');
      else
    if( $(this).prop('checked') == true)       
    $(this).prop('checked', false);
        //$(this).val('uncheck all');
     */ 
    })
})
function getis(vid)
{
$.ajax({
type: "POST",
url:"show_text_position_page.php",
data: {id_page:"<?php echo $id_page?>", id_text:"<?php echo $idu?>",box:vid, box_position:0,bbb:0}, 
cache: false,
success: function(html){
  $("#D"+vid1).html(html);
}
});    
}
/*getis("layM");
getis("layL");
getis("layR");
getis("layF");
getis("layT");*/
</script> 
 <br /><br />
 <script>
 
  
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   
        $.ajax({
          type: "POST",
   
url: "<?php echo $patHA?>/save_position.php?table=page_text&tip=<?php echo $_GET[tip]?>",
          data: qString,
          cache: false,
          beforeSend: function(html){
          
       $(".ul").css("opacity", "0.6");
      // $(".ul").append("load...");
          },
          success: function(html){
         
          $(".ul").css("opacity", "1.0")
         
          }
        });
      }
    });
        //$(".ul").disableSelection();
  });   
  
   
</script>
 <?php 
 
if($id_page>0)
{ 
 ?>
 <table style='width:100%' class='forma-lista' cellspacing='1' cellpadding='5'>
 <tr valign="top">
 <td>
Prikaži tekst na sredini sajta: <br />
<div style='width:100%;height:100px;border:1px solid #999;background:white;overflow:auto;'>
<?php 
foreach($arrayM as $ke=> $va)
{
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layM' AND box_position='$ke' AND id_page='$id_page' AND id_text='$idu'");


if(!preg_match("/text/",$va))
{
$dis="disabled";
$col="color:#999;font-weight:normal;";
}
else
{
$dis="";
$col="";
}
if(mysqli_num_rows($mi)>0) $ich="checked"; else $ich="";
if($va!="")
echo "<input type='checkbox' $ich $dis name='layM' class='layM' value='$ke' id='layM$ke' /> $ke - <label style='$col' for='layM$ke'>$va</label><br />";
}

?>
</div>

<?php 

foreach($arrayM as $ke=> $va)
{
if(preg_match("/text/",$va))
{
echo "<div id='DlayM$ke'><ul class='ul' style='padding:0px;margin:0px;'><li id='sortid_0'></li>";
echo "<li><b>Pozicija $ke</b></li>";

$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layM' AND box_position='$ke' AND id_page='$id_page' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "</ul></div>";
}
}

?>
 
</td>        
<td>
Prikaži tekst u levoj koloni sajta: <br />
<div style='width:100%;height:100px;border:1px solid #999;background:white;overflow:auto;'>
<?php 
foreach($arrayL as $ke=> $va)
{
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layL' AND box_position='$ke' AND id_page='$id_page' AND id_text='$idu'");


if(!preg_match("/text/",$va))
{
$dis="disabled";
$col="color:#999;font-weight:normal;";
}
else
{
$dis="";
$col="";
}
if(mysqli_num_rows($mi)>0) $ich="checked"; else $ich="";
if($va!="")
echo "<input type='checkbox' $ich $dis name='layL' class='layL' value='$ke' id='layL$ke' /> <label style='$col' for='layL$ke'>$va</label><br />";
}

?>
</div>
<?php 

foreach($arrayL as $ke=> $va)
{
if(preg_match("/text/",$va))
{
echo "<div id='DlayL$ke'><ul class='ul' style='padding:0px;margin:0px;'><li id='sortid_0'></li>";
echo "<li><b>Pozicija $ke</b></li>";

$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layL' AND box_position='$ke' AND id_page='$id_page' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "</ul></div>";
}
}

?>
</td>
<td>
Prikaži tekst u desnoj koloni sajta: <br />
<div style='width:100%;height:100px;border:1px solid #999;background:white;overflow:auto;'>
<?php 
foreach($arrayR as $ke=> $va)
{
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layR' AND box_position='$ke' AND id_page='$id_page' AND id_text='$idu'");


if(!preg_match("/text/",$va))
{
$dis="disabled";
$col="color:#999;font-weight:normal;";
}
else
{
$dis="";
$col="";
}
if(mysqli_num_rows($mi)>0) $ich="checked"; else $ich="";
if($va!="")
echo "<input type='checkbox' $ich $dis name='layR' class='layR' value='$ke' id='layR$ke' /> <label style='$col' for='layR$ke'>$va</label><br />";
}

?>
</div>
<?php 

foreach($arrayR as $ke=> $va)
{
if(preg_match("/text/",$va))
{
echo "<div id='DlayR$ke'><ul class='ul' style='padding:0px;margin:0px;'><li id='sortid_0'></li>";
echo "<li><b>Pozicija $ke</b></li>";

$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layR' AND box_position='$ke' AND id_page='$id_page' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "</ul></div>";
}
}

?>
 
</td>
<td>
Prikaži tekst u donjem (footer) delu sajta: <br />
<div style='width:100%;height:100px;border:1px solid #999;background:white;overflow:auto;'>
<?php 
foreach($arrayF as $ke=> $va)
{
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layF' AND box_position='$ke' AND id_page='$id_page' AND id_text='$idu'");


if(!preg_match("/text/",$va))
{
$dis="disabled";
$col="color:#999;font-weight:normal;";
}
else
{
$dis="";
$col="";
}
if(mysqli_num_rows($mi)>0) $ich="checked"; else $ich="";
if($va!="")
echo "<input type='checkbox' $ich $dis name='layF' class='layF' value='$ke' id='layF$ke' /> <label style='$col' for='layF$ke'>$va</label><br />";
}

?>
</div>
<?php 

foreach($arrayF as $ke=> $va)
{
if(preg_match("/text/",$va))
{
echo "<div id='DlayF$ke'><ul class='ul' style='padding:0px;margin:0px;'><li id='sortid_0'></li>";
echo "<li><b>Pozicija $ke</b></li>";

$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layF' AND box_position='$ke' AND id_page='$id_page' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "</ul></div>";
}
}

?>
 
</td>
 <td>
Prikaži tekst u gornjem (top) delu sajta: <br />
<div style='width:100%;height:100px;border:1px solid #999;background:white;overflow:auto;'>
<?php 
foreach($arrayT as $ke=> $va)
{
$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layT' AND box_position='$ke' AND id_page='$id_page' AND id_text='$idu'");


if(!preg_match("/text/",$va))
{
$dis="disabled";
$col="color:#999;font-weight:normal;";
}
else
{
$dis="";
$col="";
}
if(mysqli_num_rows($mi)>0) $ich="checked"; else $ich="";
if($va!="")
echo "<input type='checkbox' $ich $dis name='layT' class='layT' value='$ke' id='layT$ke' /> <label style='$col' for='layT$ke'>$va</label><br />";
}

?>
</div>
<?php 

foreach($arrayT as $ke=> $va)
{
if(preg_match("/text/",$va))
{
echo "<div id='DlayT$ke'><ul class='ul' style='padding:0px;margin:0px;'><li id='sortid_0'></li>";
echo "<li><b>Pozicija $ke</b></li>";

$mi=mysqli_query($conn, "SELECT * FROM page_text WHERE box='layT' AND box_position='$ke' AND id_page='$id_page' ORDER BY pozicija ASC");
while($mi1=mysqli_fetch_assoc($mi))
{
if($mi1[id_text]>0)
{
$it=mysqli_query($conn, "SELECT * FROM pages_text WHERE id=$mi1[id_text]");
$it1=mysqli_fetch_array($it);
echo "<li id='sortid_$mi1[id]' style='padding:3px;background:#218FBF;width:100%;float:left;color:white;margin:1px 0px;'>$it1[naslovslo]</li>";
}
}
echo "</ul></div>";
}
}

?>
 
</td>
</tr>
<tr><td colspan="5">
<div style="width:100%" id='resu'></div>
</td></tr>
</table>
<?php 
}
?>
</li>
 </ul>
<br />

</form>
 
		
</div> 

