<?phpif(isset($hashA["filt1"]) and $hashA["filt1"]!="") $ini=" in"; else $ini='';if(isset($hashA["filt1"])){$showte=' show';$colte='';$arrExpe=' aria-expanded="true"';}else {$arrExpe='';$showte='';$colte=' collapsed';}$flista .='<div class="single-sidebar mb-45"><div id="accordion" class="accordion">        <div class="card">            <div class="card-header'.$colte.'" data-toggle="collapse" data-parent="#accordion" href="#izdvoji"'.$arrExpe.'>                <a class="card-title">'.$arrwords['izdvojeni'].'</a>            </div>            <div id="izdvoji" class="card-body collapse'.$showte.'" data-parent="#accordion">                <ul>';$noaNiz=array('1'=>'akcija_obicna', '2'=>'novo', '3'=>'izdvojeni', '4'=>'naslovna', '5'=>'vegan');if($katSvi!='')$ikatsvi="AND p.id IN ($katSvi) ";else$ikatsvi="";foreach($noaNiz as $ni => $v) {$dodas=" AND p.$v=1";$inner_plus3=str_replace("$dodas", "", $inner_plus1);$uk=@mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pro p  INNER JOIN pro_filt f ON f.id_pro=p.id WHERE p.akt=1  $ikatsvi $dodas $inner_plus3 $koniPlus GROUP BY p.id"));$uk = @mysqli_num_rows(mysqli_query($conn, "SELECT p.*, p.id as ide        FROM pro p        WHERE p.akt=1 AND p.tip=5 $koniPlus $inner_plus3 $ikatsvi $dodas $ibrendis GROUP BY p.id "));if($uk==0) $nono=" class='d-none'"; else $nono="";if(isset($hashA["filt1"]) and in_array($ni,explode("-",$hashA["filt1"]))) $che1="checked"; else $che1=""; $flista .='<li'.$nono.'><label class="checkbox"><input type="checkbox" '.$che1.'  class="cho" rel="sis" value="'.hashlink($ni,$hashA,1,"filt1").'"><span>'.$arrwords['karakteristika'.$ni].' ('.$uk.') </span></label></li>';}$flista .='</ul>            </div>        </div>    </div></div>';