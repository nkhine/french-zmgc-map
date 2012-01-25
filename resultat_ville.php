<?php
$liste = '';
$db = mysql_connect('localhost', 'root', 'atlantis');					// Informations de connection
mysql_select_db('villes',$db);								// Sélection de la Base
$requete = "SELECT nom,id_ville FROM `maps_ville` WHERE `cp` LIKE ".$_GET['cp']."";
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$requete.'<br>'.mysql_error());	// Connection à la BDD

$requete_nb = "SELECT COUNT(*) FROM `maps_ville` WHERE `cp` LIKE ".$_GET['cp']."";
$req_nb = mysql_query($requete_nb) or die('Erreur SQL !<br>'.$requete_nb.'<br>'.mysql_error());	// Connection à la BDD
$nb_villes = mysql_fetch_array($req_nb);

if($nb_villes[0]==0)
{
	echo '<input type="text" name="autre_ville" id="autre_ville" onClick="this.value=\'\'" value="Votre ville..."/>';
}
else
{
	while ($ville = mysql_fetch_array($req))
	{
		$liste .= '<OPTION value="'.$ville['id_ville'].'">'.$ville['nom'].'</OPTION>'."\n";
	}
	$liste .= '<OPTION onClick="AutreVille()">Autre...</OPTION>';

	echo '<select name="ville" id="ville">';
	echo $liste;
	echo '</select>';
}
mysql_close();
?>
