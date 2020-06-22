<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Caméras - LockHome</title>
    <link rel="stylesheet" href="<?=base_url("/static/commun.css")?>">
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
          <a href="<?=base_url("/accueil")?>">
               <i class='uil uil-angle-left'></i>
            </a>
            <div class="title">Gestion des caméras</div>
        </div>
    </header>
    <main>
        <div class="container">
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
                            Cette page vous permet de visualiser les différentes caméras existantes
                            et d'en créer de nouvelle en cliquant sur le "+".
                        </p>
                    </div>
                </div>
            </section>

            <h6 class="big">Vous souhaitez ajouter une caméra ?</h6>
            <div class="bloc white_b blue">
                <a href="<?= base_url("/camera/edit") ?>" class="container_bloc one_line_bloc l_r blue">
                    <div class="left">
                    <i class='uil uil-plus-circle'></i>
                    <p class="title">Ajouter une caméra</p>
                    </div>
                    <div class="right">
                        <i class='uil uil-angle-right'></i>
                    </div>
                </a>
            </div>

            <h6 class="big">Liste des caméras</h6>
            <?php
            if(isset($error)) {
                echo $error;
            } else {
                    if(sizeof($cameras)<1){
                        echo "Vide";
                    }
                    else{
                        foreach($cameras as $camera){ ?>

                        <div class="bloc white_b">
                            <a href="<?=base_url("/camera/view/" . $camera->id)?>" class="container_bloc l_r black">
                                <img src="<?= base_url("/camera/stream/$camera->ip/stream.mjpg") ?>" />
                                <div class="container_bloc one_line_bloc l_r">
                                    <div class="left">
                                        <i class='uil uil-camera'></i>
                                        <p class="title"><?= $camera->nom ?></p>
                                    </div>
                                    <div class="right">
                                        <i class='uil uil-angle-right'></i>
                                    </div>
                                </div>
                            </a>
                        </div>
        
            <?php }} } ?>
        </div>
    </main>
</body>
</html>
