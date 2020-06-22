<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="<?= base_url("/static/commun.css") ?>">
     <link rel="stylesheet" href="<?= base_url("/static/style_general_commun.css") ?>">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.0.1/css/unicons.css">
     <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	    crossorigin="anonymous">
	</script>
     <script src="<?= base_url("/static/script.js") ?>"></script>
     <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
     <title>Accueil</title>
</head>

<body>
     <header class="l_r">
          <div class="left">
               <i class='uil uil-home-alt'></i>
               <div class="title"><?= $nom ?></div>
          </div>
          <div class="right">
               <a href="<?= base_url("/edit") ?>">
                    <i class='uil uil-cog'></i>
               </a>
               <a href="<?= base_url("/deconnexion") ?>">
                    <i class='uil uil-sign-out-alt'></i>
               </a>
          </div>
     </header>
     <main>
          <div class="container">  
               <?php if($capteur_log == false) { ?>

               <div class="bloc green_b white">
                    <div class="container_bloc one_line_bloc l_r">
                         <div class="left">
                              <i class='uil uil-shield-check'></i>
                              <p>Aucune intrusion détectée</p>
                         </div>
                         <div class="right">
                              <i class='uil uil-angle-right'></i>
                         </div>
                    </div>
               </div>

               <?php } else { ?>

               <div class="bloc white_b black">
                    <div class="container_bloc severals_lines_bloc l_r red_b white">
                         <div class="left title_bloc">
                              <i class='uil uil-shield-exclamation'></i>
                              <p>Une intrusion a été détectée</p>
                         </div>
                         <div class="left">
                              <p class="spacing_bottom">Intrusion le <?= date_format($capteur_log->date, "d/m/Y") ?> à <?= date_format($capteur_log->date, "H:i") ?>, détectée via le capteur "<?= $capteur_log->nom ?>".</p>
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

                         <a class="link_in_bloc white l_r" href="<?= base_url("/camera") ?>">
                              <div class="left">
                                   <i class='uil uil-camera'></i>
                                   <p>Voir les caméras</p>
                              </div>
                              <div class="right">
                                   <i class='uil uil-angle-right'></i>  
                              </div>
                         </a>
                    </div>
               </div>

               <?php } ?>

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
                                   Dans la première partie vous pourrez visualiser la dernière notification émise, 
                                   cette section est en vert si il n'y a pas de notification et en rouge si il y en a.
                              </p>
                              <p class="text">
                                   Dans le seconde partie vous pouvez choisir quel profil activer et voir la plage horaire
                                   de ce profil.
                              </p>
                              <p class="text">
                                   La dernière partie est un menu afin d'accèder aux différentes partie du site. 
                              </p>
                              <p class="text">
                                   Le premier bouton permet d'accèder aux profils afin de les gérers
                              </p> 
                              <p class="text">
                                   Le deuxième bouton permet accèder aux notifications afin de les visualiser
                                   et de les supprimer.
                              </p>
                              <p class="text">
                                   Le troisième bouton permet d'accèder aux capteurs afin de les gérers
                              </p>       
                              <p class="text">      
                                   Le premier bouton permet d'accèder aux caméras afin de les gérers.
                              </p>
                              <p class="text">
                                   Pour les profils, capteurs et caméras vous aurez la possibilité d'en ajouter, de modifier
                                   les existants et d'en supprimer.
                              </p> 
                         </div>
                    </div>
               </section>

               <section class="bloc white_b black">
                    <div class="container_bloc severals_lines_bloc l_r">
                         <img src="static/ressources/background.jpg">
                         <div class="content_bloc">
                              <?php if($securise) { ?>
                              <div class="l_r">
                                   <div class="title_bloc left blue">
                                        <i class='uil uil-shield-check'></i>
                                        <p class="">Maison protégé</p>            
                                   </div>
                              </div>
                              <?php } else { ?>
                              <div class="l_r">
                                   <div class="title_bloc left yellow">
                                        <i class='uil uil-shield-slash'></i>
                                        <p class="">Maison non protégé</p>            
                                   </div>
                              </div>
                              <?php } ?>
                         
                              <div class="l_r">
                                   <div class="left spacing_bottom">
                                        <p class="content_title">Profil actif :</p>
                                        <form action="<?= base_url("/edit_profil")?>" method="post">
                                             <select class="profilActif" name="profilActif" onchange="this.parentElement.submit()">
                                                  <?php
                                                       foreach($listes_profils as $profil){
                                                            $selected = "";

                                                            if($profil_actif->id == $profil->id) {
                                                                 $selected = "selected";
                                                            }
                                                            echo '<option '.$selected.' value="'.$profil->id.'">'.$profil->nom.'</option>';
                                                       }
                                                  ?>
                                             </select>
                                        </form>
                                   </div>
                              </div>
                              <div class="l_r">
                                   <div class="left spacing_bottom">
                                        <p class="content_title">Plage horaire :</p>
                                        <p><?=$profil_actif->debut ?> - <?=$profil_actif->fin ?></p>
                                   </div>
                              </div>
                         </div>
                    </div>
               </section>

               <h6 class="big">Menu</h6>
               <div class="bloc white_b blue">
                    <a href="<?= base_url("/profil/list") ?>" class="container_bloc one_line_bloc l_r blue">
                         <div class="left">
                              <i class='uil uil-label-alt'></i>
                              <p class="title">Gestion des profils</p>
                         </div>
                         <div class="right">
                              <i class='uil uil-angle-right'></i>
                         </div>
                    </a>
               </div>
               <div class="bloc white_b blue">
                    <a href="<?= base_url("/resume") ?>" class="container_bloc one_line_bloc l_r blue">
                         <div class="left">
                              <i class='uil uil-clipboard-alt'></i>
                              <p class="title">Gestion des notifications</p>
                         </div>
                         <div class="right">
                              <i class='uil uil-angle-right'></i>
                         </div>
                    </a>
               </div>
               <div class="bloc white_b blue">
                    <a href="<?= base_url("/capteur/list") ?>" class="container_bloc one_line_bloc l_r blue">
                         <div class="left">
                              <i class='uil uil-processor'></i>
                              <p class="title">Gestion des capteurs</p>
                         </div>
                         <div class="right">
                              <i class='uil uil-angle-right'></i>
                         </div>
                    </a>
               </div>
               <div class="bloc white_b blue">
                    <a href="<?= base_url("/camera") ?>" class="container_bloc one_line_bloc l_r blue">
                         <div class="left">
                              <i class='uil uil-camera'></i>
                              <p class="title">Gestion des caméras</p>
                         </div>
                         <div class="right">
                              <i class='uil uil-angle-right'></i>
                         </div>
                    </a>
               </div>
          </div>
     </main>
</body>

</html>
