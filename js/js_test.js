/******* AKTIVNOST **************/
function akti(idd,tipi){ 
path=$("#path").attr("href"); 
$.ajax({
type: "POST",
url: path+"/empty.php?nol=1",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
}
});
}
 /*******  **************/
function delm(idd,tipi){ 
path=$("#path").attr("href"); 
$.ajax({
type: "POST",
url: path+"/empty.php?nol=1",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
  $("#kom"+idd).html(html);
}
});
}

/******* Uporedi **************/

function uporedi(idd){ 
path=$("#path").attr("href"); 
$.ajax({
type: "GET",
url: path+"/uporedi_check.php",
data: {idpro:idd}, 
cache: false,
success: function(html){
 if(html>0) alert("Možete uporediti maksimalno "+html+" proizvoda");
 else if(html!="")
 {
 $("#up"+idd).html(html);
 alert("Proizvod je prebačen na stranicu za poređenje!");
 }
}
});
} 
$(document).ready(function() {
$(".close-modal, .close-modal1").click(function(){
  $(".modal").css({"display":"none"});
});
$(document).on('change', '.sev', function() {
sev=$(this).val();
fajl=$(this).attr("rel");
var gethash=window.location.hash;
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/"+fajl+"?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]);
}
});
});
$(document).on('click', '#narucis', function() {
if($("#upotrebi-kod").length>0 && $("#promo-kod").val()!="") {
alert("Kliknite na Upotrebi kod kako biste upisani kod iskoristili, a zatim nastavite klikom na Naruči!");
return false;
}

});
$(document).on('click', '#upotrebi-kod', function() {
sev=$("#promo-kod").val();
izf=$("#glavna-forma").serialize();


$.ajax({
type: "POST",
url: path+"/include/upotrebi-kod.php",
//data: {promo: sev},
data: izf,
cache: false,
success: function(datas){ 
if(datas==1) 
location.reload();
else
$("#promo-info").html(datas);
}
});

return false;
});

$(document).on('click', '#zanemari-kod', function() {
sev=$("#promo-kod").val();
izf=$("#glavna-forma").serialize();


$.ajax({
type: "POST",
url: path+"/include/upotrebi-kod.php?zanemari=1",
//data: {promo: sev},
data: izf,
cache: false,
success: function(datas){

location.reload();

}
});

return false;
});

$(document).ready(function(){
    $(".upotr-kod").click(function(){
        $("#upkod").toggle();
        $("#zelkod").toggle();
    });
});

/*****************load m. telefona *******************/       
$(document).on('click', '.ch', function() {
path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();

$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/mobilni-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]); 
}
});
});


/*****************load televizora *******************/       
$(document).on('click', '.chtv', function() {
path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/tv-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]); 
}
});
});

/*****************load opreme *******************/
$(document).on('click', '.cho', function() {
path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/oprema-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]); 
}
});
});

/*****************send mail *******************/       
//$(document).on('click', '.sendmail', function() {
$("#main-contact-form").submit(function(){
path=$("#path").attr("href");
 var datastring = $("#main-contact-form").serialize();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/sendemail.php",
data: datastring,
cache: false,
success: function(datas){
$(".alert-success").fadeIn();
if(datas['type']=="success")
{
$(".alert-success").html(datas['message']);
} 
}
});
return false;
});
$("#submit_btn").click(function() { 
path=$("#path").attr("href");
  var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields		
		$("#futrole-form input[required=true]").each(function(){  
			$(this).css('border-color',''); 
			if(!$.trim($(this).val())){ //if this field is empty 
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
			//check invalid email
			var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
			if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
		});
  if($('input[name=file_attach]')[0].files[0]==undefined || $('input[name=file_attach]')[0].files[0]=="")
  {
  $("#atfile div").css({           
            "border": "1px solid red",
            "padding": "5px"
          }); 
  proced = false;
  } else {
   $("#atfile div").css({           
            "border": "0px",
            "padding": "5px"
          }); 
  } 
        if(proceed) //everything looks good! proceed...
        { 
  var m_data = new FormData();
    m_data.append( 'name', $('input[name=name]').val());
    m_data.append( 'adresa', $('input[name=adresa]').val());
    m_data.append( 'tel', $('input[name=tel]').val());
    m_data.append( 'email', $('input[name=email]').val());
    m_data.append( 'model', $('input[name=model]').val());
    m_data.append( 'postbr', $('input[name=postbr]').val());
	m_data.append( 'grad', $('input[name=grad]').val());
    m_data.append( 'message', $('textarea[name=message]').val());
 	m_data.append( 'file_attach', $('input[name=file_attach]')[0].files[0]);
$("#submit_btn").prop("disabled",true);
$.ajax({
type: "POST",
data: m_data,
processData: false,
contentType: false,
dataType: "json",
url: path+"/futrole-naruci.php",
cache: false,
success: function(datas){
$(".alert-success").fadeIn();
if(datas['type']=="success")
{
$(".alert-success").html(datas['message']);
} else
$("#submit_btn").prop("disabled",false);
}
});
}
return false;
});

/* forma posao */
$("#submit_posao").click(function() { 
path=$("#path").attr("href");
  var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields		
		$("#posao-form input[required=true], #posao-form select[required=true]").each(function(){  
			$(this).css('border-color',''); 
			if(!$.trim($(this).val())){ //if this field is empty       
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
			//check invalid email
			var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
			if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag				
			}
		});
  if($('input[name=file_attach_a]')[0].files[0]==undefined || $('input[name=file_attach_a]')[0].files[0]=="")
  {
  $("#atfile-a div").css({           
            "border": "1px solid red",
            "padding": "5px"
          }); 
  proced = false;
  } else {
   $("#atfile-a div").css({           
            "border": "0px",
            "padding": "5px"
          });
  } 
    if($('input[name=file_attach_b]')[0].files[0]==undefined || $('input[name=file_attach_b]')[0].files[0]=="")
  {
  $("#atfile-b div").css({           
            "border": "1px solid red",
            "padding": "5px"
          });
  proced = false;
  } else {
   $("#atfile-b div").css({           
            "border": "0px",
            "padding": "5px"
          }); 
  }
   if (!$("input[name='pol']:checked").val()) {      
  $("#pol div").css({           
            "border": "1px solid red",
            "padding": "5px"
          });
  proced = false;
   } else
   {
    $("#pol div").css({           
            "border": "0px",
            "padding": "5px"
          });
   }
        if(proceed) //everything looks good! proceed...
        { 
  var m_data = new FormData();
    m_data.append( 'ime', $('input[name=ime]').val());
    m_data.append( 'prezime', $('input[name=prezime]').val());
    m_data.append( 'adresa', $('input[name=adresa]').val());
    m_data.append( 'postbr', $('input[name=postbr]').val());
    m_data.append( 'mesto', $('input[name=mesto]').val());
    m_data.append( 'pol', $("input[name='pol']:checked").val());
    m_data.append( 'dan', $('select[name=dan]').val());
    m_data.append( 'mesec', $('select[name=mesec]').val());
    m_data.append( 'godina', $('select[name=godina]').val());
    m_data.append( 'mob', $('input[name=mob]').val());
    m_data.append( 'tel', $('input[name=tel]').val());
      var allVals = [];
    $('#dozvola input[type="checkbox"]:checked').each(function() { 
          allVals.push($(this).val());
    });
    if($("#invalid").is(':checked')) var invalid="DA"; else var invalid="NE";
    m_data.append( 'dozvola', allVals.join(", "));
    m_data.append( 'inv', invalid);
    m_data.append( 'ssp', $('select[name=ssp]').val());
    m_data.append( 'skola', $('input[name=skola]').val());
    m_data.append( 'zanimanje', $('input[name=zanimanje]').val());
    m_data.append( 'lokacija', $('input[name=lokacija]').val());
    m_data.append( 'ocena', $('input[name=ocena]').val());
    m_data.append( 'poceo', $('input[name=poceo]').val());
    m_data.append( 'zavrsio', $('input[name=zavrsio]').val());
    m_data.append( 'racunar', $('select[name=racunar]').val());
    m_data.append( 'programi', $('textarea[name=programi]').val());
    m_data.append( 'ostalo', $('textarea[name=ostalo]').val());
    m_data.append( 'profint', $('textarea[name=profint]').val());
    m_data.append( 'ostint', $('textarea[name=ostint]').val());
    m_data.append( 'email', $('input[name=email]').val());
 	m_data.append( 'file_attach_a', $('input[name=file_attach_a]')[0].files[0]);
	m_data.append( 'file_attach_b', $('input[name=file_attach_b]')[0].files[0]);

$.ajax({
type: "POST",
data: m_data,
processData: false,
contentType: false,
dataType: "json",
url: path+"/posao-forma-send.php",
cache: false,
success: function(datas){
  $('html, body').animate({
        scrollTop: $(".contact-form").offset().top-70
    }, 500);    
$(".alert-success").fadeIn();
if(datas==1)
document.getElementById('myModal').style.display = "block";
//$(".alert-success").html("Vaša prijava je uspešno proslata. Kontaktiraćemo Vas ukoliko uđete u uži krug");
else
$(".alert-success").html("Vaša prijava nije poslata. Pokušajte ponovo.");
}
});
}
return false;
});

/* end forma posao */

$("#naruci-form").submit(function(){
path=$("#path").attr("href");
 var datastring = $("#naruci-form").serialize();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/sendemailforma.php",
data: datastring,
cache: false,
success: function(datas){
if(datas['type']=="success")
{
//$(".alert-success").html(datas['message']);
window.location="http://www.biznet.rs/mts-primljen-zahtev/";
}else
$(".alert-success").fadeIn(); 
}
});
return false;
});

/*****************email prijava *******************/       
$(document).on('click', '.prij', function() {
path=$("#path").attr("href");
var datastring = $("#add_email").serialize();
$.ajax({
type: "POST",
//dataType: "json",
url: path+"/empty.php",
data: datastring,
cache: false,
success: function(datas){
alert(datas);
}
});
return false;
});
});
function print(path)
{
var path;
var xPos;
var yPos;
width=630;
height=800;
xPos = (window.screen.width/2) - (width/2 + 10);
yPos = (window.screen.height/2) - (height/2 + 50);
var win2 = window.open(path,"Window2","status=no,height="+height+",width="+width+",resizable=yes,left=" + xPos + ",top=" + yPos + ",screenX=" + xPos + ",screenY=" + yPos + ",addressbar=no, toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
win2.focus();
}

////////korpa/////////

function displaySubs(idd,vrr){
path=$("#path").attr("href");
$.ajax({
type: "POST",
dataType: "json",
url: path+"/korpaAdd.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){
$('.cart-amunt').html(datas[0]);
$('.product-count').html(datas[1]);
$('.shopping-item').mouseenter().mouseleave();
$(".shopping-item").fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
  $("#modal-name").css({"display":"block"});
  $.ajax({
type: "POST",
url: path+"/modal-pro-get.php",
data: {pro:idd},
cache: false,
success: function(resu){
 $('#resus').html(resu);
}
});

/*setInterval(function(){
  $(".shopping-item").toggleClass("divtoBlink");
  },500)
*/
}
});
}
function displaySubs1(idd,vrr){ 
path=$("#path").attr("href");
prov=$('#val'+idd).val();
if(vrr=="minus")
prov=prov-1;
if(prov>0)
{
 $.ajax({
type: "POST",
dataType: "json",
url: path+"/korpaAdd.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){  
$('.cart-amunt').html(datas[0]);
$('.product-count').html(datas[1]);
if(datas[7]==1) {
$('.ukupno').html('<del>'+datas[4]+'</del>');
$('.ukupno-promo').html(datas[8]);
}
else
$('.ukupno').html(datas[4]);
$('#bzp').html(datas[5]);
$('#pdve').html(datas[6]);
if(vrr!="drop")
{
$('#cen'+idd).html(datas[2]);
$('#val'+idd).val(datas[3]);
}else
{
$('#row'+idd).hide();
}
}
});
}
}

function displaySubs2(idd,vrr){

$.ajax({
type: "POST",
//dataType: "json",
url: path+"korpaAddE.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){  
alert(datas)
}
});

}