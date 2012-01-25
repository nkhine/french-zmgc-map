<?php
$connect = mysql_connect('localhost', 'root', 'atlantis') or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
$select_db = mysql_select_db('testdonnees', $connect) or die ("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());

$usersQuery = "SELECT id, username FROM jos_users";
$usersResult = mysqli_query($connect, $usersQuery) or die("Selection id, username - jos_users, Query failed:<br>" . mysql_error() . "<br>" . mysql_errno());
$nm = mysqli_num_rows($usersResult);
if ($nm != 0) {
	while (($objUsers = mysqli_fetch_object($usersResult)) != False) {
			
		$id = $objUsers->id;
		$username = $objUsers->username;
		
		//if ($username == 'alexvhsb') {
		
		$comprofilerQuery = "SELECT * FROM jos_comprofiler WHERE user_id = ".$id.";";
		$comprofilerResult =  mysqli_query($connect, $comprofilerQuery) or die("Selection * - jos_comprofiler, Query failed:<br>" . mysql_error() . "<br>" . mysql_errno());
		$nm = mysqli_num_rows($comprofilerResult);
		if ($nm != 0) {
			$objComprofiler = mysqli_fetch_object($comprofilerResult);
			
			$ville = replace_accents(mysqli_real_escape_string($connect, $objComprofiler->cb_ville));
			$region = replace_accents(mysqli_real_escape_string($connect, $objComprofiler->cb_region));
			$pays = replace_accents(mysqli_real_escape_string($connect, $objComprofiler->cb_pays));
			$geoLat = $objComprofiler->geoLat;
			$geoLng = $objComprofiler->geoLng;
			
			if ($geoLat == NULL && $geoLng == NULL) {
				if ($ville != NULL) {
					echo '<font color="red">VILLE</font> - ';
					$location = $ville.', '.$pays;
					$url = 'http://api.geonames.org/search?q='.$location.'&maxRows=1&username=sandjey';
					$xml = new SimpleXMLElement($url, null, true);
					$geoname = $xml->geoname;
	
					$city = $geoname->toponymName;
					//$city = "Nîmes";
					$geoLat = $geoname->lat;
					//$geoLat = 43.83333;
					$geoLng = $geoname->lng;
					//$geoLng = 4.35;
	
					if ($city != null) {
						$geoQuery = "UPDATE jos_comprofiler SET cb_ville = '".$city."', geoLat = '".$geoLat."', geoLng = '".$geoLng."' WHERE user_id = ".$id.";";
						$geoResult = mysqli_query($connect, $geoQuery) or die("Update cb_ville, geoLat, geoLng - jos_comprofiler, Query failed:<br>" . mysqli_error($connect) . "<br>" . mysqli_errno($connect));				
					}
					
				}
			}
			
			echo $username.' - ';
			echo $ville.', ';
			echo $region.', ';
			echo $pays.' - ';
			echo $geoLat.', ';
			echo $geoLng."<br />";
		}
		mysqli_free_result($comprofilerResult);
		//}
	}
}
mysqli_free_result($usersResult);
?>
