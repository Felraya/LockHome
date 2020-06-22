<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des notifications - LockHome</title>
    <link rel="stylesheet" href="<?= base_url("/static/resume_liste.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/style_general_commun.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/commun.css") ?>">
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
            <a href="../accueil">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title">Gestion des notifications</div>
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
                            Cette page vous permet de visualiser et de supprimer les notifications d'évènements,
                            ici ils sont regroupés par jour. En cliquant sur "voir les évènements" vous aurrez le
                            détail d'un journée.
                        </p>
                    </div>
                </div>
            </section>

            <?php
        if(is_array($intrusion)){
            foreach($intrusion as $date) { ?>

            <div class="bloc white_b black">
                <div class="container_bloc severals_lines_bloc l_r red_b white">
                    <div class="l_r">
                        <div class="content_in_column">
                            <div class="title_bloc">
                                <i class='uil uil-shield-exclamation'></i>
                                <p>Une intrusion a été détectée</p>
                            </div>
                            <div>
                                <p class="spacing_bottom spacing_left">Une intrusion a été détecté à <?= date_format($date, "H:i") ?>.</p>
                            </div>
                        </div>
                        <a class="right poubelle_lien white" href="<?= base_url("/resume/delete/" . date("Y-m-d")) ?>">
                            <div class="right poubelle">
                                <i class="uil uil-trash-alt"></i>
                            </div>
                        </a>
                    </div>

                    <a class="link_in_bloc white l_r" href="<?= base_url("/resume/show/".date("d/m/Y")) ?>">
                        <div class="left">
                            <i class='uil uil-clock'></i>
                            <p>Voir les évènements</p>
                        </div>
                        <div class="right">
                            <i class='uil uil-angle-right'></i>  
                        </div>
                    </a>
                </div>
            </div>  

            <?php } } else { ?>

                Aucune notification à afficher.

            <?php }  ?>

        </div>
    </main>
</body>
</html>