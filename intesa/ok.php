<?php 
error_reporting( E_ALL ^ E_NOTICE ^ E_WARNING );
ini_set("display_errors", 1);
echo "<a href='index.php'>Index.php</a>";
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
 ?>
<html>
<head>
<title>3D</title>
  <meta http-equiv="Content-Language" content="tr">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="now">
</head>
<body>
<h1>3D Payment Page</h1>
<h3>Payment Response</h3>
<table border="1">

<?php 
     $originalClientId ="13IN060589";
    $mustParameters = array("clientid","oid","Response");
     $isValid = true;
    for($i=0;$i<3;$i++)
           {
             if($_POST[$mustParameters[$i]] == null || $_POST[$mustParameters[$i]] == "" )
              {
          if($mustParameters[$i] == "oid"){
                    if($_POST["ReturnOid"] == null || $_POST["ReturnOid"] == "" ){
                        $isValid = false;
                        echo "<tr><td>Missing Required Param</td>"+"<td>oid / ReturnOid</td></tr>";
                    }
                }else{
                  $isValid = false;
                 echo "<tr><td>Missing Required Param</td>"+"<td>"+
$mustParameters[$i]+"</td></tr>";
                }
              }
           }
         if($_POST["clientid"] != $originalClientId){
             echo "<h4>Security Alert. Incorrect Client Id.</h4>";
             return;
         }

         if(! $isValid){
             echo "<h4>Security Alert. The digital signature is not valid. Required Paramaters are
missing.</h4>";
             return;
         } else {
?>
    <tr>
        <td><b>Parameter Name</b></td>
        <td><b>Parameter Value</b></td>
    </tr>
<?php 
  $paymentparams =
array("AuthCode","Response","HostRefNum","ProcReturnCode","TransId","ErrMsg");
  foreach($_POST as $key => $value)
  {
    $check=1;
    for($i=0;$i<6;$i++)
    {
      if($key ==  $paymentparams[$i])
      {
        $check=0;
              break;
      }
    }
    if($check ==  1)
    {
      echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
    }
  }
?>
</table>
<br>
<br>
<?php 
    $hashparams = $_POST["HASHPARAMS"];
    $hashparamsval = $_POST["HASHPARAMSVAL"];
    $hashparam = $_POST["HASH"];
    $storekey="AOou04453";
    $paramsval="";
    $index1=0;
    $index2=0;
    $escapedStoreKey = "";

  if ($_POST["hashAlgorithm"] == "ver2"){
    $parsedHashParams = explode("|", $hashparams);
    foreach ($parsedHashParams as $parsedHashParam) {
      $vl = $_POST[$parsedHashParam];
      if($vl ==  null)
        $vl = "";

      $escapedValue = str_replace("\\", "\\\\", $vl);
      $escapedValue = str_replace("|", "\\|", $escapedValue);
      $paramsval = $paramsval . $escapedValue . "|";
   
    }

    $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storekey));
    $hashval = $paramsval. $escapedStoreKey;
    $hash = base64_encode(pack('H*',hash('sha512', $hashval)));
    
  } else {
     while($index1 < strlen($hashparams))
     {
      $index2 = strpos($hashparams,":",$index1);
      $vl = $_POST[substr($hashparams,$index1,$index2- $index1)];
      if($vl ==  null)
        $vl = "";

        $paramsval = $paramsval . $vl;
        $index1 = $index2 + 1;
    }
    $escapedStoreKey = $storeKey;
    $hashval = $paramsval.$escapedStoreKey;
    $hash = base64_encode(pack('H*',sha1($hashval)));
  }
  $hashparamsval = $hashparamsval. "|". $escapedStoreKey;
echo $hashval."<br>";
echo $hashparamsval."<br>";
    echo $hash."<br>";
    echo $hashparam."<br>";
  if($hashval != $hashparamsval || $hashparam != $hash) {
    echo "<h4>Security Alert. The digital signature is not valid.</h4>"  . " <br />\r\n";
    echo "Generated Hash Value : ". $hashval . " <br />\r\n";
    echo "Sent hash value : " . $hashparamsval. " <br />\r\n";
    echo "Generated Hash  : ". $hash . " <br />\r\n";
    echo "Sent hash  : " . $hashparam. " <br />\r\n";
  }

  $mdStatus = $_POST["mdStatus"];
  $ErrMsg = $_POST["ErrMsg"];
  if($mdStatus ==  1 ||  $mdStatus == 2 || $mdStatus == 3 || $mdStatus == 4)
  {
    echo "<h5>3D Transaction is Success</h5><br/>";
?>
  <h3>Payment Response</h3>
        <table border="1">
            <tr>
               <td><b>Parameter Name</b></td>
               <td><b>Parameter Value</b></td>
            </tr>
<?php 

  for($i=0;$i<6;$i++)
    {
    $param = $paymentparams[$i];
    echo "<tr><td>".$param."</td><td>".$_POST[$param]."</td></tr>";

    }
?>
  </table>
<?php 
    $response = $_POST["Response"];
    if($response == "Approved")
    {

   echo "Payment Process is Successfull";
    }
    else
    {
      echo "Transaction is not Success. Error = ".$ErrMsg;
    }
  }
  else
  {
     echo "<h5>3D Transaction is not Success</h5>";
  }
}
?>
</body>
</html>