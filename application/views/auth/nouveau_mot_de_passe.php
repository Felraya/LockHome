<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Nouveau mot de passe</title>
	<link rel="stylesheet" type="text/css" href="/static/connexion.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
</head>
<body>
	<div class="contenu">
		<div class="logo">
			<img src="/static/ressources/logo.png">
			<h1>Lock Home</h1>
		</div>
		
		<h2>Changement de mot de passe</h2>

		<form action="<?= base_url(uri_string()) ?>" method="post">

			<?php if(isset($nouveauMotDePasse) && $nouveauMotDePasse == true) { ?>
			<div class="okay"><i class='uil uil-envelope-send'></i>Votre mot de passe a bien été changé.</div>
			<a href="/accueil" class="okay_retour"><i class='uil uil-envelope-send'></i>Retour à l'accueil.</a>
			
			<?php }  else { ?>
		
			<?php if(isset($error)) { ?>
				<div class="error"><i class='uil uil-exclamation-triangle'></i> <?= $error; ?></div>
			<?php } ?>

			<input type="email" name="email" placeholder="Email" required="required">
			<input type="password" name="mot_de_passe" placeholder="Mot de passe" required="required">
			<button type="submit">Mettre à jour</button>
		<?php } ?>
		</form>
	</div>
</body>
</html>