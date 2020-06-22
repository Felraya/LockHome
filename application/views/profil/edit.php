<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil - LockHome</title>
    <link rel="stylesheet" href="<?= base_url("/static/commun.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/style_general_commun.css") ?>">
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
            <a href="<?= base_url("/profil/") ?>">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title"><?= $new ? "Créer un profil" : "Profil : ".$nom ?></div>
        </div>
        
        <div class="right">
            <p>Valider</P>
            <button type="submit" form="EditProfil" class="validation">
                <i class='uil uil-check'></i>
            </button>

            <p>Annuler</P>
            <a href="<?= base_url("/profil/") ?>" class="annulation">
                <i class='uil uil-times'></i>
            </a>
        </div>
    </header>
    <main>
        <form class="container" id="EditProfil" action="<?= base_url("/profil/edit/" . (!$new ? $id : "new")) ?>" method="post">
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
                <label class="container_bloc one_line_bloc l_r">
                    <div class="left">
                        <i class='uil uil-label-alt'></i>
                        <input id="NOM" required type="text" name="nom" value="<?= !$new ? $nom : "" ?>" placeholder="Vacance..." />
                    </div>
                </label>
            </div>

            <h6 class="big">Plage horaire</h6>
            <div class="timer_input_bloc">
                <div>
                    <p class="spacing_bottom">Debut</p>
                    <input class="white_b" id="time" required type="time" name="debut" value="<?= !$new ? $debut : "08:00"?>">
                </div>
                <div>
                    <p class="spacing_bottom">Fin</p>
                    <input class="white_b" id="time" required type="time" name="fin" value="<?= !$new ? $fin : "18:00"?>">
                </div>     
            </div>

            <h6 class="big">Etat des capteurs pour ce profil :</h6>
            <section class="bloc white_b">
                <?php
                    if($capteurs){

                        foreach($capteurs as $capteur){  ?>
                            <label for="capteur_<?= $capteur->id ?>" class="l_r element">
                                <div class="left"><?= $capteur->nom; ?></div>
                                <div class="right">
                                    <input id="capteur_<?= $capteur->id ?>" name="capteur_<?= $capteur->id ?>" <?= isset($capteur->disabled) && $capteur->disabled == true ? "" : "checked" ?> value="1" type="checkbox">
                                    <div class="switch"></div>
                                </div>
                            </label>
                    <?php  }
                    } else echo "Aucun capteur disponible.";
                ?>
            </section>

            <?php if (!$new) {?>
                <div class="bloc white_b bottom">
                    <a href="<?=base_url("/profil/delete/".$id)?>" class="redHover container_bloc one_line_bloc l_r red">
                        <div class="left">
                            <i class='uil uil-trash-alt'></i>
                            <div>Supprimer ce profil</div>
                        </div>
                    </a>
                </div>
            <?php }?>
                
        </form>
    </main>
</body>

</html>
