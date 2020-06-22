<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="static/connexion.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
</head>
<body>
	<div class="contenu">
		<div class="logo">
			<img src="static/ressources/logo.png">
			<h1>Lock Home</h1>
		</div>
		
		<h2>Inscription</h2>

		<form action="./inscription" method="post">
			<?php if(isset($error)) { ?>
				<div class="error"><i class='uil uil-exclamation-triangle'></i> <?= $error; ?></div>
			<?php } ?>

			<?php if(isset($warning)) { ?>
				<div class="warning"><i class='uil uil-user-exclamation'></i> <?= $warning; ?></div>
			<?php } ?>

			<input type="text" name="prenom" placeholder="Prenom" required="required">
			<input type="text" name="nom" placeholder="Nom" required="required">
			<input type="email" name="email" placeholder="Email" required="required">
			<input type="password" name="mot_de_passe" placeholder="Mot de passe" required="required">
			<button type="submit">Inscription</button>
		</form>
		<a href="./connexion"><i class='uil uil-question-circle'></i>Vous avez déja un compte ?</a>
	</div>
</body>
</html>