<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title></title>
    <script type="text/javascript" src="js/script.js">
</script>
  </head>
  <body>
    <form method="post" action="ok.php">
      <fieldset>
        <legend>Coordonnées</legend>
        <label>Code Postal : <input name="cp" id="cp" type="text" value="" maxlength="5"></label>
	<span id="villes"><SELECT name="ville" id="ville" disabled="disabled"><OPTION>Votre ville...</OPTION></SELECT></span>
      </fieldset>
    </form>
  </body>
</html>
