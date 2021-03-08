<?php 
if(curPageURL()!=$patH1."/") {
?>
<div class="content-grids">
<div class="wrap">
<?php 
}
$sred1="";
$sred="";
if(($contR>0 or $zgeR>0) and ($contL>0 or $zgeL>0))
{
$sred="<div class='sredina'>";
$sred1="</div>";
} elseif((($contR>0 or $zgeR>0) and $contL==0 and $zgeL==0) or ($contL>0 or $zgeL>0) and $contR==0 and $zgeR==0) 
{
$sred="<div class='sredinaLR'>";
$sred1="</div>";
} 

/* include za leva kolona */ 
if($contL>0 or $zgeL>0)
{
?>
<div class="levo">
<?php 
foreach($arrayL as $ke=> $va)
{
$lokac="left";
if(is_file("private/include-pages/$lokac/$va"))
{
 
include("private/include-pages/$lokac/$va");
 
}
}
?>
    </div>
<?php 
} 
/* leva kolona kraj */
?>

           
 <?php 

echo $sred;
if($contM>0 or $zgeM>0)
{

$layGD="layM";
$gd=0;


foreach($arrayM as $ke=> $va)
{
$layP="layM";
$lokac="middle";
if(is_file("private/include-pages/$lokac/$va"))
{
 
include("private/include-pages/$lokac/$va");
 
}
}
}
echo $sred1;
 
if($contR>0 or $zgeR>0)
{
?>
    <div class="desno">
<?php 
foreach($arrayR as $ke=> $va)
{

$lokac="right";
if(is_file("private/include-pages/$lokac/$va"))
{
 
include("private/include-pages/$lokac/$va");
 
}
}
?>
</div>
<?php 
} 
 ?>
<?php 
if(curPageURL()!=$patH1."/") {
?>          
</div>
<div class="razmak"></div>
</div>
<?php } ?>