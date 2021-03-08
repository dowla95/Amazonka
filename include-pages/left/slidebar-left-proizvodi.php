<div class="page-section pb-40">

	<div class="pb-10 border-bottom mb-10 mt-10">

		<div class="container">

			<div class="row">

                <div class="col-lg-12">

                    <div class="breadcrumb-content">

                        <ul>

                            <li class="has-child"><a href="<?php echo $patH1?>">Naslovna</a></li>

                            <li><?php echo $ztz1['naziv']?></li>

                        </ul>

                    </div>

				</div>

			</div>

        </div>

    </div>



			<div class="container">

			<div class="row">



<div class="col-lg-3 order-2 order-lg-1">

	<div class="page-sidebar">

		<div class="sidebar-widget-wrapper mb-30">





<?php

$iovos="";

if($base_arr_r[1]=="dodatna-oprema" and $base_arr_r[0]!="")

 {

 $ztz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide

        FROM stavke p

        INNER JOIN stavkel pt ON p.id = pt.id_page

        WHERE pt.lang='$lang' AND  p.akt=1 AND  ulink=".safe($base_arr_r[0])." AND p.id_cat=32");

   $ztz1=mysqli_fetch_array($ztz);

$iovos =" AND kategorija=".$ztz1['ide'];

 }



 $akcijska=mysqli_query($conn, "SELECT MIN(cena1) as akcmin, MAX(cena1) as akcmax FROM pro WHERE akt=1 AND tip=5 AND cena1>0");

 $akcijska1=@mysqli_fetch_assoc($akcijska);



 $minak=$akcijska1['akcmin'];

 $maxak=$akcijska1['akcmax'];





 $mi=mysqli_query($conn, "SELECT MIN(cena) as micena, MAX(cena) as macena FROM pro WHERE akt=1 AND tip=5");

 $mi1=mysqli_fetch_assoc($mi);



//$mic=$mi1['micena'];

//$mac=$mi1['macena'];



if($minak>0) $mic=$minak; else $mic=$mi1['micena'];

if($maxak>0) $mac=$maxak; else $mac=$mi1['macena'];



 $step=1;

 $plur=5;

 if($idvalute==1)

 {

 $mic=ceil($mic*EVRO)-10;

 //$mac=round($mac*EVRO)+10;

 //$mac=$mac+10;

 $step=100;

 $plur=100;

 }

 ?>

<script>

  function parseQuery(qstr) {

        var query = {};

        var a = qstr.substr(1).split('&');

        for (var i = 0; i < a.length; i++) {

            var b = a[i].split('=');

            query[decodeURIComponent(b[0])] = decodeURIComponent(b[1] || '');

        }

        return query;

    }



 function toObject(arr) {

  var rv = {};

  for (var i = 0; i < arr.length; ++i)

    if (arr[i] !== undefined) rv[i] = arr[i];

  return rv;

}



  $(function() {



  var v1=<?php echo $mic?>;

  var v2=<?php echo format_ceneSS($mac,$idvalute)+$plur?>;

   var gethash=window.location.hash;

   var geth=gethash.replace('#','');

        getha=parseQuery(geth);



      if(getha['price']!="" && getha['price']!=undefined)

      {

    var sp=getha['price'].split("-");

    var v1=sp[0];

  var v2=sp[1];



    }



    $( "#slider-range" ).slider({

      step: <?php echo $step?>,

      range: true,

      min: <?php echo $mic?>,

      max: <?php echo format_ceneSS($mac,$idvalute)+$plur?>,

      values: [ v1, v2 ],

      slide: function( event, ui ) {

        $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );

      },

      stop: function( event, ui ) {

        var gethash=window.location.hash;

        var geth=gethash.replace('#','');

        getha=parseQuery(geth);



        price1 = ui.values[ 0 ];

        price2 = ui.values[ 1 ];



        getha['price']=price1+"-"+price2;



        obje=$.extend({}, getha);

        string="#&"+decodeURIComponent( $.param(obje));

        window.location.hash=string;

   if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)

window.location="<?php echo $patH?>/"+$("#load-filter").attr('data')+"/"+string;

sev=$(".sev").val();

        $.ajax({

type: "POST",

dataType: "json",

url: "<?php echo $patH?>/include-pages/ajax-load/oprema-load.php?va=<?php echo $idvalute?>&sev="+sev,

data: {hashe: string, uris: window.location.href},

cache: false,

success: function(datas){



$("#load-filter").html(datas[0]);

$("#load-lista").html(datas[1]);

}

});

        }

    });

    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 )+" <?php echo $valut?>" +

      " - " + $( "#slider-range" ).slider( "values", 1 )+" <?php echo $valut?>" );

  });



 /*****************load  *******************/

function loads() {

path=$("#path").attr("href");



 sev=$(".sev").val();

var gethash=window.location.hash;

 if(gethash!="")

 {

$.ajax({

type: "POST",

dataType: "json",

url: path+"/include-pages/ajax-load/oprema-load.php?va=<?php echo $idvalute?>&sev="+sev,

data: {hashe: gethash, uris: window.location.href},

cache: false,

success: function(datas){



$("#load-filter").html(datas[0]);

$("#load-lista").html(datas[1]);

}

});

}

}

loads();

  </script>



<div class="sidebar-widget">

<h3 class="sidebar-widget-title mb-30 mt-0"><?php echo $arrwords['paket1']?></h3>

             <div class="price-range"><!--price-range-->

				<div class="sidebar-price">

							<div class="well text-center">

                <input type="text" id="amount" name="range" readonly style="border:0; color:#222; font-weight:bold;">

				<div id="slider-range" style="width:99%;margin:0 auto;"></div>

							</div>

						</div>

						</div><!--/price-range-->

</div>





<div class="sidebar-widget">

<h3 class="sidebar-widget-title">Amorina kozmetika</h3>



    <div id="accordion" class="accordion">

        <div class="card mb-0 promen">





<?php

$tz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide

        FROM stavke p

        INNER JOIN stavkel pt ON p.id = pt.id_page

        WHERE pt.lang='$lang' AND  p.akt=1 AND p.nivo=1 AND p.id_cat=32 ORDER BY -p.position DESC");

 $i=1;

   while($tz1=mysqli_fetch_array($tz))

     {

     if($ztz1['id_parent']==$tz1['ide']) $inig=" in"; else $inig="";

        $hz = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide

        FROM stavke p

        INNER JOIN stavkel pt ON p.id = pt.id_page

        WHERE pt.lang='$lang' AND  p.akt=1 AND p.nivo=2 AND id_parent=$tz1[ide] ORDER BY -p.position DESC");

$brr=mysqli_num_rows($hz);

if($brr==0) {

$bezicon=" bezicon";

$neo="d-none ";

$lnkk=" href='".$patH1."/".$all_links[3]."/".$tz1['ulink']."/' title='".$tz1['naziv']."'";

}

else {

$bezicon="";

$neo="";

$lnkk="";

}

?>

            <div class="card-header collapsed<?php echo $bezicon?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>">

                <a class="card-title"<?php echo $lnkk?>>

                <?php echo $tz1['naziv'];?>

                </a>

            </div>

            <div id="collapse<?php echo $i?>" class="<?php echo $neo?>card-body collapse" data-parent="#accordion" >

                <ul>

<?php

while($hz1=mysqli_fetch_array($hz)) {

 ?>

					<li><a href="<?php echo $patH1?>/<?php echo $all_links[3]?>/<?php echo $tz1['ulink']?>/<?php echo $hz1['ulink']?>/" title="<?php echo $hz1['naziv']?>"><?php echo $hz1['naziv'];?>aa</a></li>



<?php } ?>

				</ul>

            </div>

<?php $i++; } ?>

        </div>

    </div>

</div>



<div class="sidebar-widget">

<?php

if($nodom_ex_r[0]!=$all_links[3] and empty($ztz1['ide']))

{

$dd="data='".$all_links[3]."'";

}

?>

<div id="load-filter" rel="<?php echo $idvalute?>" <?php echo $dd?>>

<?php

include("include-pages/ajax-load/levo-filter-oprema.php");

echo $flista;

?>

							</div>

						</div>

					<div>

				</div>

            </div>

</div>

</div>

<!--

<script src="js/bootstrap.min.js"></script>

-->