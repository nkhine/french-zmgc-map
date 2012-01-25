
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
	xml2js('map2.xml');
}

function addMarker(location,texte,couleurimage,num)
{
	var image = new google.maps.MarkerImage(couleurimage,
	new google.maps.Size(36, 34),
	new google.maps.Point(0,0),
	new google.maps.Point(5, 30));

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
function htmlToAccent(str) {
var spec = new Array("é", "É", "è", "È", "ê", "Ê", "ë", "Ë", "à", "À", "ù", "Ù", "ç", "Ç", " ");
var norm = new Array("é", "É", "è", "È", "ê", "Ê", "ë", "Ë", "à", "À", "ù", "Ù", "ç", "Ç", " ");
for (var i = 0; i < spec.length; i++)
str = replaceAll(str, norm[i], spec[i]);
return str;
}
function replaceAll(str, search, repl) {
while (str.indexOf(search) != -1)
str = str.replace(search, repl);
return str;
} 
function xml2js(xml)
{
	// XML file
	var url = xml;

	// AJAX request
	var xhr = (window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"));
	xhr.onreadystatechange = XHRhandler;
	xhr.open("GET", url, true);
	xhr.send(null);

	// handle response
	function XHRhandler()
	{
		if (xhr.readyState == 4)
		{
			var obj = XML2jsobj(xhr.responseXML.documentElement);
			Display(obj);
			xhr = null;
		}
	}
}
function Display(data)
{	
	var numFonction = 0;
	var fonction;
	
	if (data && data.ville)
	{
		if (data.ville.length)
		{
			//alert(data.ville[0].utilisateur.length);
			// multiple statuses
			for (i=0; i < data.ville.length; i++)
			{
				var location = new google.maps.LatLng(data.ville[i].lat,data.ville[i].long);
				var texte = 'Les Zeitgeisters de '+data.ville[i].nom+' :<br /><br />';
				if (data.ville[i].utilisateur.length)
				{
					for (j=0; j < data.ville[i].utilisateur.length; j++)
					{
						fonction = data.ville[i].utilisateur[j].usertype;
						switch (fonction)
						{
		 					case 'Coordinateurs':
							numFonction++;
							fonction = 'Coordinateur';
		 					break;
		 					case 'Super Users':
							numFonction++;
							fonction = 'Coordinateur';
		 					break;
							default:
							fonction = 'Activiste';
							break;
						}
						texte += '- Pseudo : '+data.ville[i].utilisateur[j].username+'<br />';
						texte += '  Fonction : '+fonction+'<br />';
						texte += '  Comp&eacute;tences : '+data.ville[i].utilisateur[j].competences+'<br />';
						texte += '  Disponibilit&eacute; : '+data.ville[i].utilisateur[j].disponibilite+'<br /><br />';
					}
					texte += '<br />';
				}
				else
				{
					Fonction = data.ville[i].utilisateur.usertype;
					switch (Fonction)
					{
		 				case 'Coordinateurs':
						fonction = 'Coordinateur';
						numFonction++;
		 				break;
		 				case 'Super Users':
						fonction = 'Coordinateur';
						numFonction++;
		 				break;
						default: 
						fonction = 'Activiste';
						break;
					}

					texte += '- Pseudo : '+data.ville[i].utilisateur.username+'<br />';
					texte += '  Fonction : '+fonction+'<br />';
					texte += '  Comp&eacute;tences : '+data.ville[i].utilisateur.competences+'<br />';
					texte += '  Disponibilit&eacute; : '+data.ville[i].utilisateur.disponibilite+'<br /><br />';
				}
				if(numFonction>0){image='img/marqueur_vert.png';}else{image='img/marqueur_bleu.png';}
				//texte = texte.replace(texte);
				addMarker(location,texte,image,i);
				numFonction = 0;
			}
		}
		else
		{
			var location = new google.maps.LatLng(data.ville.lat,data.ville.long);
			// single status
			texte += 'Les Zeitgeisters de '+data.ville.nom+' :<br /><br />';

			texte += '- Pseudo : '+data.ville.utilisateur.username+'<br />';
			texte += '  Fonction : '+data.ville.utilisateur.usertype+'<br />';
			texte += '  Comp&eacute;tences : '+data.ville.utilisateur.competences+'<br />';
			texte += '  Disponibilit&eacute; : '+data.ville.utilisateur.disponibilite+'<br />';
		}
	}
}

function XML2jsobj(node) {

	var	data = {};

	// append a value
	function Add(name, value) {
		if (data[name]) {
			if (data[name].constructor != Array) {
				data[name] = [data[name]];
			}
			data[name][data[name].length] = value;
		}
		else {
			data[name] = value;
		}
	};
	
	// element attributes
	var c, cn;
	for (c = 0; cn = node.attributes[c]; c++) {
		Add(cn.name, cn.value);
	}
	
	// child elements
	for (c = 0; cn = node.childNodes[c]; c++) {
		if (cn.nodeType == 1) {
			if (cn.childNodes.length == 1 && cn.firstChild.nodeType == 3) {
				// text value
				Add(cn.nodeName, cn.firstChild.nodeValue);
			}
			else {
				// sub-object
				Add(cn.nodeName, XML2jsobj(cn));
			}
		}
	}

	return data;
}
