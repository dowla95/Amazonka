<?php 
include("../Connections/conn_admin.php");
$idu=$_POST['id']; 
if($idu>0)
{
$zap=mysqli_query($conn, "SELECT * FROM page WHERE id=$idu");
$zap1=mysqli_fetch_assoc($zap); 

if($zap1[model]>0)
{

$zz=mysqli_query($conn, "SELECT * FROM page_models WHERE id_model=$zap1[model]");
$zz1=mysqli_fetch_assoc($zz);
echo "<input type='hidden' value='$zap1[model]' name='id_model' />";
?>
 <script>
  
    $(document).ready(function(){
    $(".ul").sortable({ 
      stop: function(){
        qString = $(this).sortable("serialize");
   
 
      }
    });
    });
</script> 
<br />
 


<table style='width:100%' class='forma-lista zahide' cellspacing='0' cellpadding='0'>
 <tr valign='top'>
 

<td style='width:49%;'>
Uključi fajlove levo: <br />

<?php 
fajlovi(3,"crveno","left","left", $zz1 , $zz1['id_model'],"text-$idu",$_POST['nasl'],1)
?>
</td>
 <td  class='form-left-pad'>
 
Uključi fajlove u sredini: <br />


<?php 
fajlovi(4,"plavo","middle","middle", $zz1 , $zz1['id_model'],"text-$idu",$_POST['nasl'],1)
?>
</td>        

 
</tr>
</table>

<?php 
}
} 
?>