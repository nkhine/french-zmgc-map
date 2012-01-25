<?php
$db = mysql_connect('mysql1087.servage.net', 'U8531341', 'P342630');						// Informations de connection
mysql_select_db('U8531341',$db);								// Sélection de la Base
$usersQuery = "SELECT id, username, usertype FROM jos_users";
$usersResult = mysql_query($usersQuery) or die('Erreur SQL !<br>'.$usersQuery.'<br>'.mysql_error());	// Connection à la BDD
$nm = mysql_num_rows($usersResult);

$ListeUtil = '';

if ($nm != 0)
{
	while (($objUsers = mysql_fetch_object($usersResult)) != False)
	{
			
		$id = $objUsers->id;
		$username = $objUsers->username;
		$usertype = $objUsers->usertype;
		$comprofilerQuery = "SELECT * FROM jos_comprofiler WHERE user_id = ".$id."";
		$comprofilerResult =  mysql_query($comprofilerQuery) or die('Erreur SQL !<br>'.$comprofilerQuery.'<br>'.mysql_error());
		$nm = mysql_num_rows($comprofilerResult);
		if ($nm != 0)
		{
			$objComprofiler = mysql_fetch_object($comprofilerResult);

			$UserId = $objComprofiler->user_id;
			$ville = $objComprofiler->cb_ville;
			$region = $objComprofiler->cb_region;
			$pays = $objComprofiler->cb_pays;
			$competences = str_replace('|*|',', ', $objComprofiler->cb_competences);
			$geoLat = $objComprofiler->geoLat;
			$geoLng = $objComprofiler->geoLng;
			if(substr($objComprofiler->cb_disponibilite,0,9) == 'Très dispo')
			{
				$disponibilite = '>10h/semaine';
			}
			if(substr($objComprofiler->cb_disponibilite,0,9) == 'Très dispo')
			{
				$disponibilite = 'plus de 10h par semaine';
			}
			elseif(substr($objComprofiler->cb_disponibilite,0,9) == 'Relativeme')
			{
				$disponibilite = 'Entre 4 et 10h par semaine';
			}
			else
			{
				$disponibilite = 'Non renseigné';
			}

			if ($geoLat == NULL && $geoLng == NULL)
			{
				if ($ville != NULL)
				{
					$location = $ville.', '.$pays;
					$url = 'http://api.geonames.org/search?q='.$location.'&maxRows=1&username=sandjey';
					$xml = new SimpleXMLElement($url, null, true);
					$geoname = $xml->geoname;
	
					$city = $geoname->toponymName;
					$city = str_replace("'", " ", $city);
					//$city = "Nîmes";
					$geoLat = $geoname->lat;
					//$geoLat = 43.83333;
					$geoLng = $geoname->lng;
					//$geoLng = 4.35;
					$geoQuery = "UPDATE jos_comprofiler SET cb_ville = '".$city."', geoLat = '".$geoLat."', geoLng = '".$geoLng."' WHERE user_id = ".$id."";
					$geoResult = mysql_query($geoQuery) or die('Erreur SQL !<br>'.$geoQuery.'<br>'.mysql_error());
				}
			}

			$ListeUtil .= '#'.$geoLat.'|'.$geoLng.'|'.$username.'|'.$usertype.'|'.$pays.'|'.$region.'|'.$ville.'|'.$competences.'|'.utf8_decode($disponibilite)."\n";
		}
	}
}

if (file_exists("map.txt")) {unlink("map.txt");}
touch("map.txt");
$FichierListeUtil=fopen("map.txt","w"); // Ouverture du fichier avec le mode criture
fwrite($FichierListeUtil,htmlentities($ListeUtil)); // Ceci ajoutera ou crira le contenu "texte ..." dans le fichier "le_fichier.txt"
?>
