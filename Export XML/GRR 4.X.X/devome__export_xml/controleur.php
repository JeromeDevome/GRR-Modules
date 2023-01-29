<?php

if($identifiant_hook == "hookHeader1"){
	
	if (@file_exists('./admin_access_area.php')){
		$adm = 1;
	} else{
		$adm = 0;
	}

	if($adm == 0 && isset($_GET['area'])){
		include "xml.class.php";
		XML::Generation($_GET['area']);
	}


}elseif($identifiant_hook == "hookEditRoom1"){

	$lien = str_replace("http://", "", Settings::get("grr_url"));
	$lien = str_replace("https://", "", $lien);
	$lien = "webcal://".$lien."export/".TABLE_PREFIX.$_GET['room'].".xml";

	$CtnHook['hookEditRoom1'] .= "<h3>Module Export XML</h3>\n";
	$CtnHook['hookEditRoom1'] .=  "<table><tr>";
	$CtnHook['hookEditRoom1'] .=  "<td width='250'>Lien du calendrier </td>";
	$CtnHook['hookEditRoom1'] .=  "<td> ".$lien."</td>\n";
	$CtnHook['hookEditRoom1'] .=  "</tr></table>";

}


?>