<?php

/**
 * xml.class.php
 * Permet l'exportation des ressources au format ics
 * Dernière modification : $Date: 2023-01-29 17:00$
 * @author    JeromeB
 * @copyright Copyright 2003-2018 Team DEVOME - JeromeB
 * @link      http://www.gnu.org/licenses/licenses.html
 *
 * Module sous licence
 *
 * Code licence : 74a2caebedf707ae091745198a9d47ed
 */

class XML{


	public static function Generation ($domaine, $ressource = 0) {

		$temp = time();
		$result = grr_sql_query("SELECT * FROM ".TABLE_PREFIX."_entry WHERE end_time > '{$temp}';");
		
		$export = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"; 
		$export.="<versionModule>1.0</versionModule>";
		$export.="<RESERVATIONS>";
		
		while($row = mysqli_fetch_array($result)){
		
		
			$beneficiaire = grr_sql_query("SELECT * FROM ".TABLE_PREFIX."_utilisateurs WHERE login = '".$row['beneficiaire']."';");
			$beneficiaire = mysqli_fetch_array($beneficiaire);
		
			$salle = grr_sql_query("SELECT * FROM ".TABLE_PREFIX."_room WHERE id = '".$row['room_id']."' LIMIT 1;");
			$salle = mysqli_fetch_array($salle);
		
				$export.="<RESERVATION>";
		
					$groupe = $row['beneficiaire'];
					$nom = $beneficiaire['nom'];
					$prenom = $beneficiaire['prenom'];
					$arrive = date('d/m/Y', $row['start_time']).' '.date('H:i', $row['start_time']);
					$depart = date('d/m/Y', $row['end_time']).' '.date('H:i', $row['end_time']);
		
					$export.="<groupe>{$groupe}</groupe>";
					$export.="<ressource>{$salle['room_name']}</ressource>";
					$export.="<description>{$row['description']}</description>";
					$export.="<nom>{$nom}</nom>";
					$export.="<prenom>{$prenom}</prenom>";
					$export.="<arrivee>{$arrive}</arrivee>";
					$export.="<depart>{$depart}</depart>";
		
				$export.="</RESERVATION>";
			
		}
		$export.="</RESERVATIONS>";
		
		//file_put_contents("export.xml", $export);
		//echo "<a href='export.xml' target='_blank'>Export database as XML</a>";
		
		$txt_file = "./export/export".TABLE_PREFIX.".xml";
		
		$create_xml = fopen($txt_file,"w"); 
		
		fwrite($create_xml, $export);
		
		fclose ($create_xml);
	}


}

?>