<?php
    header("Content-type: text/css; charset: UTF-8");
	include("../../Connections/conn.php");
	if($settingsc['poz_akcija']!="") $pozboja_akcija=" style='background:".$settingsc['poz_akcija']."'"; else $pozboja_akcija="";
	if($settingsc['site_bg']!="") $site_bg=$settingsc['site_bg']; else $site_bg="#ffffff";
	if($settingsc['gb_poz_elemenata']!="") $zuto=$settingsc['gb_poz_elemenata']; else $zuto="#eedc19";
	if($settingsc['gb_teksta']!="") $textboja=$settingsc['gb_teksta']; else $textboja="#444";
	if($settingsc['boja_elemenata_1']!="") $elementi1=$settingsc['boja_elemenata_1']; else $elementi1="#fff";
	if($settingsc['boja_elemenata_2']!="") $elementi2=$settingsc['boja_elemenata_2']; else $elementi2="#111";
	if($settingsc['boja_elemenata_3']!="") $elementi3=$settingsc['boja_elemenata_3']; else $elementi3="#f0f0f0";
	if($settingsc['boja_elemenata_4']!="") $elementi4=$settingsc['boja_elemenata_4']; else $elementi4="#333";
	if($settingsc['boja_linka']!="") $blink=$settingsc['boja_linka']; else $blink="#f00";
	if($settingsc['boja_linka1']!="") $blink1=$settingsc['boja_linka1']; else $blink1="#76b100";
	if($settingsc['pb_menu_kategorije']!="") $pbkat=$settingsc['pb_menu_kategorije']; else $pbkat="#111";
	if($settingsc['b_tekst_kategorije']!="") $btkat=$settingsc['b_tekst_kategorije']; else $btkat="#fff";
	if($settingsc['pb_menu_podkategorije1']!="") $pbkat1=$settingsc['pb_menu_podkategorije1']; else $pbkat1="#fff";
	if($settingsc['b_menu_podkategorije1']!="") $pbmt1=$settingsc['b_menu_podkategorije1']; else $pbmt1="#111";
	if($settingsc['call_sekcija']!="") $callsec=$settingsc['call_sekcija']; else $callsec="#111";
	if($settingsc['mendrophov']!="") $mendrophov=$settingsc['mendrophov']; else $mendrophov="#eedc19";
	if($settingsc['boja_cart_icon']!="") $boja_cart_icon=$settingsc['boja_cart_icon']; else $boja_cart_icon="#00a000";
?>
:root {
--sitebg:<?php echo $site_bg?>;
--zuto:<?php echo $zuto?>;
--textboja:<?php echo $textboja?>;
--blink:<?php echo $blink?>;
--blink1:<?php echo $blink1?>;
--element1:<?php echo $elementi1?>;
--element2:<?php echo $boja_cart_icon?>;
--element3:<?php echo $elementi3?>;
--element4:<?php echo $elementi4?>;
--boja1:<?php echo $elementi2?>;
--boja-4d:#4d4d4d;
--pbkat:<?php echo $pbkat?>;
--btkat:<?php echo $btkat?>;
--pbkat1:<?php echo $pbkat1?>;
--pbmt1:<?php echo $pbmt1?>;
--callsec:<?php echo $callsec?>;
--mendrophov:<?php echo $mendrophov?>;
--sprice:#fe4f19;
}