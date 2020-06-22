<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Résumé - LockHome</title>
    <link rel="stylesheet" href="<?= base_url("/static/resume_show.css") ?>">
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
            <a href="<?= base_url("/resume/list") ?>">
                <i class='uil uil-angle-left'></i>
            </a>
            <div class="title">Résumé du <?= $date ?></div>
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
							Cette page vous permet de visualiser et de supprimer les notifications d'évènements
							d'une journée.
						</p>
                    </div>
                </div>
            </section>
			<div class="timeline">

			<?php if(!empty($list)) { ?>
				<ul>
				<?php foreach($list as $key => $log){ ?>
					<li>
						<div class="cont">
							<?php foreach($log as $row){ ?>

								<?php if(isset($row->action)) { ?>
									
									<div class="itm <?= $row->action === "intrusion" ? "red" : "yellow" ?>">
										<div class="type"><?=ucfirst($row->action)?></div>
										<div class="info"><?=ucfirst($row->action)?> via le capteur <b><?=ucfirst($row->nom)?></b>.</div>
										<div class="date"><?=$row->date->format("H:i:s")?></div>
									</div>
									
								<?php } else { ?>
									
								<div class="itm">
									<div class="type">Email</div>
									<div class="info">Email de type <?= $row->type ?> envoyé.</div>
									<div class="date"><?=$row->date->format("H:i:s")?></div>
								</div>
								<?php } ?>

							<?php } ?>
						</div>
						<span class="number">
							<span><?=$key?></span>

							<?php
								$e = explode(":", $key);
								$h = intval($e[0]);
								$m = intval($e[1]);

								$h = intval($m)+30 === 60 ? $h + 1 : $h;
								$h = ($h < 10 ? "0$h" : "$h") == "24" ? "00" : $h;
								$m = $m == "00" ? "30" : "00";
							?>

							<span><?= $h.":".$m ?></span>
						</span>
					</li>
				<?php } ?>
				</ul>
			</div>

			<?php  } else {?>
				Aucun log a rapporter.
			<?php } ?>

		</div>
    </main>
</body>
</html>