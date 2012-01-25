<?php
$db = mysql_connect('mysql1087.servage.net', 'U8531341', 'P342630');						// Informations de connection
mysql_select_db('U8531341',$db);								// Sélection de la Base
$usersQuery = "SELECT id, username, usertype FROM jos_users";
$usersResult = mysql_query($usersQuery) or die('Erreur SQL !<br>'.$usersQuery.'<br>'.mysql_error());	// Connection à la BDD
$nm = mysql_num_rows($usersResult);

$num = -1;
$ListeUtil = array();
$ListeUtilParVilles = array();

if ($nm != 0)
{
	while (($objUsers = mysql_fetch_object($usersResult)) != False)
	{
		$num = $num+1;
		//$ListeUtil[$num] = new array;
		$ListeUtil[$num]['id'] = $objUsers->id;
		$ListeUtil[$num]['username'] = utf8_encode($objUsers->username);
		$ListeUtil[$num]['usertype'] = utf8_encode($objUsers->usertype);
		$comprofilerQuery = "SELECT * FROM jos_comprofiler WHERE user_id = ".$ListeUtil[$num]['id']."";
		$comprofilerResult =  mysql_query($comprofilerQuery) or die('Erreur SQL !<br>'.$comprofilerQuery.'<br>'.mysql_error());
		$nm = mysql_num_rows($comprofilerResult);
		if ($nm != 0)
		{
			$objComprofiler = mysql_fetch_object($comprofilerResult);

			$ListeUtil[$num]['UserId'] = $objComprofiler->user_id;
			$ListeUtil[$num]['ville'] = utf8_encode($objComprofiler->cb_ville);
			$ListeUtil[$num]['region'] = utf8_encode($objComprofiler->cb_region);
			$ListeUtil[$num]['pays'] = utf8_encode($objComprofiler->cb_pays);
			$ListeUtil[$num]['competences'] = utf8_encode(str_replace('|*|',', ', $objComprofiler->cb_competences));

					$xml = simplexml_load_file('http://maps.google.com/maps/geo?output=xml&q='.$ListeUtil[$num]['ville'].', '.$ListeUtil[$num]['pays']);
					if (strcmp($status, "200") == 0)
					{
						// Successful geocode
						$geocode_pending = false;
						$coordinates = $xml->Response->Placemark->Point->coordinates;
						//$coordinatesSplit = split(",", $coordinates);
						$coordinatesSplit = preg_split('[,]', $coordinates);
	
						$geoQuery = "UPDATE jos_comprofiler SET cb_ville = '".$city."', geoLat = '".$coordinatesSplit[1]."', geoLng = '".$coordinatesSplit[0]."' WHERE user_id = ".$ListeUtil[$num]['id']."";
						$geoResult = mysql_query($geoQuery) or die('Erreur SQL !<br>'.$geoQuery.'<br>'.mysql_error());


			$ListeUtil[$num]['geoLat'] = $coordinatesSplit[1];
			$ListeUtil[$num]['geoLng'] = $coordinatesSplit[0];
					}

			if(is_string($objComprofiler->cb_disponibilite))
			{
				$dispooupas = substr($objComprofiler->cb_disponibilite,0,10);
				if($dispooupas == 'Très dispo')
				{
					$ListeUtil[$num]['disponibilite'] = 'Plus de 10h par semaine';
				}
				elseif($dispooupas == 'Relativeme')
				{
					$ListeUtil[$num]['disponibilite'] = 'Entre 4 et 10h par semaine';
				}
				elseif($dispooupas == 'Peu dispon')
				{
					$ListeUtil[$num]['disponibilite'] = 'Moins de 3h par semaine';
				}
				else
				{
					$ListeUtil[$num]['disponibilite'] = 'Non renseigne';
				}
			}
			else
			{
				$ListeUtil[$num]['disponibilite'] = 'Non renseigne';
			}


		}
	}
}

for($num2=0;$num2<count($ListeUtil)-1;$num2++)
{
	if($ListeUtil[$num2]['ville']!='')
	{
		$ListeUtilParVilles[$ListeUtil[$num2]['ville']][] = $ListeUtil[$num2];
	}
}
$FichierTxt = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
$FichierTxt = '<xml>'."\n";
foreach ($ListeUtilParVilles as $ville => $donnees)
{
	$FichierTxt .= '    <ville nom="'.$ville.'" region="'.$donnees[0]['region'].'" pays="'.$donnees[0]['pays'].'" lat="'.$donnees[0]['geoLat'].'" long="'.$donnees[0]['geoLng'].'">'."\n";

	foreach ($ListeUtilParVilles[$ville] as $NumUtil => $value)
	{
		if($value['competences'] ==''){$competences = 'Non renseigne';}else{$competences = $value['competences'];}
		$FichierTxt .= '      <utilisateur id="'.$value['id'].'">'."\n";
		$FichierTxt .= '        <username>'.$value['username'].'</username>'."\n";
		$FichierTxt .= '        <usertype>'.$value['usertype'].'</usertype>'."\n";
		$FichierTxt .= '        <competences>'.$competences.'</competences>'."\n";
		$FichierTxt .= '        <disponibilite>'.$value['disponibilite'].'</disponibilite>'."\n";
		$FichierTxt .= '      </utilisateur>'."\n";
	}
$FichierTxt .= '  </ville>'."\n";
}
$FichierTxt .= '</xml>'."\n";
if (file_exists("map2.xml")) {unlink("map2.xml");}
touch("map3.xml");
$FichierListeUtil=fopen("map2.xml","w");
fwrite($FichierListeUtil,$FichierTxt);

echo '<pre>';
//print_r($ListeUtil);
print_r($ListeUtilParVilles);
echo '</pre>';
?>
