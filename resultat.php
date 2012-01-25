<html>
<head>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script>
var geocoder;
var coord;
function coordonnees()
{
	geocoder = new google.maps.Geocoder();
	var address = document.getElementById("cp").value+' '+document.getElementById("adresse").value+', '+document.getElementById("pays").value;
	geocoder.geocode(
	{
		'address': address
	},
	function(results, status)
	{
		coord = results[0].geometry.location;
		if (status == google.maps.GeocoderStatus.OK)
		{
			document.getElementById("coordonnees").value = coord;
		}
		else
		{
			document.getElementById("coordonnees").value = 'Erreur';
		}
	});
}

</script>
</head>
<body>
<input id="pays" type="text" onkeyup="coordonnees();" /><input id="cp" type="text" onkeyup="coordonnees();" /><input id="adresse" type="text" onkeyup="coordonnees();" /> <input id="coordonnees" type="text" />
</body>
</html>
