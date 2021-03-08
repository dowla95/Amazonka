<?php 
session_start();
include("../../Connections/conn.php");
 include("levo-filter.php");
//require_once "../../paginate/Paginated.php";
//require_once "../../paginate/DoubleBarLayout.php";
  
 include("mobilni-lista.php");
 
$niv=array($flista, $mlista);

echo json_encode($niv); 
?>