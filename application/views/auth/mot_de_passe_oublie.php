<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mot de passe oublié</title>
	<link rel="stylesheet" type="text/css" href="static/connexion.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
</head>
<body>
	<div class="contenu">
		<div class="logo">
			<img src="static/ressources/logo.png">
			<h1>Lock Home</h1>
		</div>
		<h2>Mot de passe oublié</h2>

		<form action="./mot_de_passe_oublie" method="post">
	
		<?php if(isset($envoye) && $envoye == true) { ?>
			<div class="okay"><i class='uil uil-envelope-send'></i> Le mail vient d'être envoyé.</div>
		<?php }  else { ?>
		
				<?php if(isset($error)) { ?>
					<div class="error"><i class='uil uil-exclamation-triangle'></i> <?= $error; ?></div>
				<?php } ?>

				<input type="email" name="email" placeholder="Email" required="required">
				<button type="submit">Renvoyer mon mot de passe</button>
		<?php } ?>
		</form>
		<a href="./connexion"><i class='uil uil-question-circle'></i>Vous avez un compte ?</a>
	</div>
</body>
</html>
