<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edition maison - LockHome</title>
    <link rel="stylesheet" href="<?= base_url("static/accueil_edition.css")?>">
    <link rel="stylesheet" href="<?= base_url("/static/style_general_commun.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/commun.css")?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	    crossorigin="anonymous">
	</script>
    <script src="<?= base_url("/static/script.js") ?>"></script>
</head>

<body>
    <header class="l_r">
        <div class="left">
            <a href="<?=base_url("/")?>">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title">Modifier les paramètres</div>
        </div>
        <div class="right">
            <p>Valider</P>
            <button type="submit" form="EditHouse" class="validation">
                <i class='uil uil-check'></i>
            </button>

            <p>Annuler</P>
            <a href="<?= base_url("/")?>" class="annulation">
                <i class='uil uil-times'></i>
            </a>
        </div>
    </header>
    <main>
        <form class="container" id="EditHouse" action="<?= base_url("/edit")?>" enctype="multipart/form-data" method="post">
            <section class="bloc white_b black">
                <div class="container_bloc severals_lines_bloc">
                    <div class="l_r">
                        <div class="title_bloc left blue">
                            <i class='uil uil-comment-info-alt'></i>  
                            <p>Guide d'utilisation de cette page</p>
                        </div>
                        <a onclick="forAside()">
                                <div class="right"><i class='uil uil-angle-down'></i></div>
                            </a>
                    </div>
                    <div id="guide" class="content_bloc">
                        <p class="text">
                            Vous pouvez ici changer le nom de votre maison, votre adresse postale, ainsi que l'image sur la page
                            d'accueil
                        </p>
                    </div>
                </div>
            </section>

            <h6 class="big">Nom</h6>
            <div class="bloc white_b black">
                <label for="nom" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-home-alt'></i>
                        <input name="nom" id="nom" required type="text" value="<?=isset($nom) ? $nom : ""?>" placeholder="Nom de la maison" />
                    </div>
                </label>
            </div>

            <h6 class="big">Adresse</h6>
            <div class="bloc white_b black">
                <label for="adresse" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-location-point'></i>
                        <input name="adresse" id="adresse" required type="text" value="<?=isset($adresse) ? $adresse : ""?>" placeholder="84 rue du Président Roosevelt" />
                    </div>
                </label>
            </div>

            <h6 class="big">Image de la maison</h6>
            <div class="bloc white_b black">
                <label for="image" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-image-upload'></i>
                        <input id="image" name="image" type="file" accept="image/jpeg" />
                    </div>
                </label>
            </div>

            <h6 class="big">Durée d'enregistrement caméra</h6>
            <div class="bloc white_b black">
                <label for="recordCamera" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                    <i class='uil uil-webcam'></i>
                        <input name="recordCamera" id="recordCamera" required type="number" value="<?=isset($recordCamera) ? $recordCamera : ""?>" /> secondes
                    </div>
                </label>
            </div>

            <p class="version">Lockhome v1.0.0</p>

        </form>
    </main>
</body>

</html>
