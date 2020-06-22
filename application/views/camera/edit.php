<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edition caméra - LockHome</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url("/static/style_general_commun.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url("/static/commun.css") ?>">
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
            <a href="<?=base_url("/camera")?>">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title"><?=($new ? "Ajouter une caméra" : ("Caméra : " . $nom))?></div>
        </div>
        <div class="right">
            <p>Valider</P>
            <button type="submit" form="EditCamera" class="validation">
                <i class='uil uil-check'></i>
            </button>

            <p>Annuler</P>
            <a href="<?=base_url("/camera")?>" class="annulation">
                <i class='uil uil-times'></i>
            </a>
        </div>
    </header>
    <main>
        <form class="container" id="EditCamera" action="<?=base_url("/camera/edit/" . ($new ? "new" : $id))?>" method="post">
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
                        <p class="text"><?php echo $contentGuide; ?></p>
                    </div>
                </div>
            </section>

            <h6 class="big">Nom</h6>
            <div class="bloc white_b black">
                <label for="IP" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-webcam'></i>
                        <input name="nom" required type="text" value="<?=isset($nom) ? $nom : ""?>" placeholder="Nom de la caméra" />
                    </div>
                </label>
            </div>

            <h6 class="big">Adresse IP locale</h6>
            <div class="bloc white_b black">
                <label for="IP" class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-wifi'></i>
                        <input name="ip" required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" type="text" value="<?=isset($ip) ? $ip : ""?>" placeholder="192.168.4..." />
                    </div>
                </label>
            </div>

            <?php if (!$new) {?>
                <div class="bloc white_b bottom">
                    <a href="<?=base_url("/camera/delete/" . $id)?>" class="redHover container_bloc one_line_bloc l_r red">
                        <div class="left">
                            <i class='uil uil-trash-alt'></i>
                            <div>Supprimer cette camera</div>
                        </div>
                    </a>
                </div>
            <?php }?>
        </form>
    </main>
</body>

</html>
