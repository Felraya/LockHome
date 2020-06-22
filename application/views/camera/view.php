<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Caméra : <?=$nom?> - LockHome</title>
    <link rel="stylesheet" href="<?= base_url("/static/commun.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/style_general_commun.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/static/camera_view.css") ?>">
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
        	<a href="<?=base_url("/camera/list")?>">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title">Caméra : <?=$nom?></div>
        </div>
		<div class="right">
            <a class="blue" href="<?=base_url("/camera/edit/" . $id)?>">
                <i class='uil uil-pen'></i>
            </a>
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
                            Cette page vous permet de visualiser la caméra en temps réel ainsi que de visionner
                            les vidéos enregistrées lors d'une intrusion.
                        </p>
                    </div>
                </div>
            </section>

            <h6 class="big">En temps réel</h6>

            <img class="IMG_STREAM" src="<?= base_url("/camera/stream/$ip/stream.mjpg") ?>" />

            <h6 class="big">Vidéos</h6>

            <table>
            <!-- Boucle qui va créer un nouveau tr ,je prends le titre + ajouter un lien qui permet de visualiser la video = base_url(/camera/stream/$ip/stream-file/letitre) 
            + ajouter un bouton telechargement (trouver un icon : unicons) : lien vesr la page base_url("/camera/stream/$ip/download-file/letitre)
            -->
                <thead>
                    <td class="columnUn">Filmé le</td>
                    <td class="columnTrois">Action</td>
                </thead>
                <tbody>
                <?php
                foreach($files as $item){ 
                ?>
                    <tr>
                        <td class="columnUn"><?php echo str_replace("_"," à ", str_replace(".mp4","", $item)); ?></td>
                        <td class="columnTrois">
                            <a href="<?= base_url("/camera/stream/$ip/stream-file/$item") ?>">
                                <i class='uil uil-play black'></i>
                            </a>
                            <a href="<?= base_url("/camera/stream/$ip/download-file/$item") ?>">
                                <i class='uil uil-cloud-download black'></i>
                            </a>
                            <a href="<?= base_url("/camera/stream/$ip/delete-file/$item") ?>">
                                <i class='uil uil-trash black'></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>

        </div>
    </main>
</body>
</html>
