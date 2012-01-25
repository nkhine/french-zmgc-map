<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

var markersArray = new Array;
var marker = new Array;
var infowindow = new Array;
// Initialisation de la Carte
function initialize()
{
	// Coordonnées du centre de la France
	var latlng = new google.maps.LatLng(47.010226,1.710205);
	// Options de la carte
	var myOptions =
	{
		zoom: 6,						// Le zoom
		center: latlng,						// Les coordonnées du centre de la Carte
		mapTypeId: google.maps.MapTypeId.ROADMAP,		// Type de carte
		panControl: false,					// Contrôle du déplacement
		zoomControl: true,					// Contrôle du zoom
		scaleControl: false,					// Affichage de l'échelle de la carte
		streetViewControl: false,				// Contrôle du StreetView
		mapTypeControl: false,					// Contrôle du type de carte
		zoomControlOptions:
		{
			style: google.maps.ZoomControlStyle.SMALL	// Type de curseur de zoom
		}
	};
	// La carte sera intégrée à l'élément ayant l'ID map_canvas
	map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
	// Lancement de l'affichage des utilisateurs
	ListeUtil();
}

function addMarker(location,texte,image,num)
{
	marker[num] = new google.maps.Marker(
	{
		position: location,
		map: map,
		icon: image
	});

	infowindow[num] = new google.maps.InfoWindow(
	{
		content: texte,
		maxWidth: 300
	});

	google.maps.event.addListener(marker[num], 'click', function()
	{
		infowindow[num].open(map,marker[num]);
	});

	markersArray.push(marker[num]);
}
function ListeUtil()
{
// Détection de la méthode AJAX compatible avec le navigateur ////////////////////
	var xhr; 								//
	try									//
	{									//
		xhr = new ActiveXObject('Msxml2.XMLHTTP');			//
	}									//
	catch (e) 								//
	{									//
		try								//
		{								//
			xhr = new ActiveXObject('Microsoft.XMLHTTP');		//
		}								//
		catch (e2) 							//
		{								//
			try							//
			{							//
				xhr = new XMLHttpRequest();			//
			}							//
			catch (e3)						//
			{							//
				xhr = false;					//
			}							//
		}								//
	}									//
//////////////////////////////////////////////////////////////////////////////////
	xhr.onreadystatechange = function() 
	{ 
		if(xhr.readyState  == 4)
		{
			// Si tout s'est bien passé
			if(xhr.status  == 200)
			{
				var Liste = xhr.responseText;			// On récupère la liste des utilisateurs dans le fichier Txt
				var ListeUtils = new Array;
				
				Liste = Liste.split('#');			// Mise en tableau de chaque utilisateur
				var i=0;
				for (Val in Liste)
				{
					ListeUtils[i] = Liste[Val].split('|');	// Mise en tableau des valeurs par utilisateur
					i++;
				}
				var num = 0;
				for (Val in ListeUtils)
				{
					// Si la ville est rensignée
					if(ListeUtils[Val][0]!='')
					{
						var Fonction = ListeUtils[Val][3];
						// Coordonnées géographique de chaque utilisateur
						var location = new google.maps.LatLng(ListeUtils[Val][0],ListeUtils[Val][1]);

						// Marqueur en fonction de la fonction de l'utilisateur
						switch (ListeUtils[Val][3])
						{
	 						case 'Coordinateurs':
	 						image = 'img/marqueur_vert.png';
							Fonction = 'Coordinateur';
	 						break;
	 						case 'Super Users':
							image = 'img/marqueur_vert.png';
							Fonction = 'Coordinateur';
	 						break;
							default: 
							image = 'img/marqueur_bleu.png';
							Fonction = 'Activiste';
							break;
						}

						// Texte à afficher dans l'info-bulle de chaque utilisateur
						texte = 'Pseudo : '+ListeUtils[Val][2]+'<br />';
						texte += 'Fonction : '+Fonction+'<br />';
						texte += 'Comp&eacute;tences : '+ListeUtils[Val][7]+'<br />';
						texte += 'Disponibilit&eacute; : '+ListeUtils[Val][8];

						// On appelle la fonction qui place le Marqueur sur la carte
						addMarker(location,texte,image,num);
						num++;
					}
				}
			}
			// Sinon
			else
			// On affiche une alerte avec le code erreur
			alert("Error code " + xhr.status);
		}
	}; 
	// Récupération de la liste d'utilisateurs
	xhr.open( "GET", "map.txt",  true); 
	xhr.send(null);
}
</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:600px; height:600px"></div>
</body>
</html>
