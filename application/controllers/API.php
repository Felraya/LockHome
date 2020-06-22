<?php
class API extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("LogCapteurModele");
        $this->load->model("MaisonModele");
        $this->load->model("LogEmailModele");
        $this->load->model("AuthentificationModele");
        $this->load->model("CapteurModele");
        $this->load->model("ProfilModele");
        $this->load->model("CameraModele");
        $this->load->helper("url_helper");

    }

    // Controleur pour l'API
    public function init() {

        // On récupère les segments dans l'URL
        // Format de l'url : http://[IP_RPI]/api/[IP_CAPTEUR]/[TYPE_DE_LOG]
        
        // IP_RPI = Ip du serveur de l'application web
        // IP_CAPTEUR = Ip du capteurs ( le capteur doit en premier être ajouté via l'interface )
        // TYPE_DE_LOG = Type du log envoyé par le capteur

        $ip =  $this->uri->segment(2); // Permet de récupérer l'ip du capteur
        $type =  $this->uri->segment(3); // Permet de récupérer le type de log

        // On récupère les informations du capteur grace a son ip
        $capteur = $this->CapteurModele->getWithIP($ip);

        // Si le capteur n'existe pas on affiche un message d'erreur
        if($capteur === false){
            echo "Capteur inexistant";
        } else {

            // Sinon on va ajouter le log dans la base de donnée

            // On définit le type d'action possible
            // intrusion = Une intrusion a été détecté
            // batterie = Un capteur avec une batterie pourrait tomber en panne de batterie donc il peut emmettre ce type de log pour avertir les utilisateurs
            // caméra = non branché ou mal branché
            // capteur = problème de branchement de capteurs
            $actionDisponible = array("intrusion", "batterie", "camera");

            // On vérifie que notre type de log envoyé par le capteur est correct
            if(in_array($type, $actionDisponible)) {

                // On récupère le profil actif
                $profil = $this->ProfilModele->getActive();

                // On récupere la date de début et de fin
                $debut  = explode(":", $profil->debut);
                $fin    = explode(":", $profil->fin);

                // On convertit les heures en milliseconde
                $now    = mktime(date("H"), date("i"),  0, 0,0,0);
                $debut  = mktime($debut[0], $debut[1],  0, 0,0,0);
                $fin    = mktime($fin[0],   $fin[1],    0, 0,0,0);

                // Si le profil est activé a l'heure actuelle
                if( ($now >= $debut AND $now <= $fin) OR ($profil->debut == $profil->fin) ) {

                    $capteurs_actives = $this->ProfilModele->getCapteurDesactive($profil->id);

                    if(!in_array($capteur->id, $capteurs_actives)){
                        // On ajoute le log dans la base de donnée
                        if($this->LogCapteurModele->add($capteur->id, $type)){

                            /*
                                LANCER LE RECORD SUR TOUTES LES CAMERAS
                            */
                            $cameras = $this->CameraModele->getAll();
                            $dureeCamera = $this->MaisonModele->getRecordCamera();

                            foreach($cameras as $camera){
                                $this->fast_request(base_url("/camera/stream/$camera->ip/record/$dureeCamera"));
                            }

                            echo "ok";

                            // Si le type est une intrusion
                            $email_type = $type === "intrusion" ? $type : "warning";

                            // On vérifie dans les logs qu'aucun mail n'a été envoyé
                            $mail_send = $this->LogEmailModele->getAllDay();

                            // Si le type de mail envoyé est différent de "intrusion"   
                            if($mail_send == false OR !in_array($email_type, array_column($mail_send["raw"], "type"))){
                                // On envoit un mail
                                $this->send_email($email_type);
                            }

                        } else {
                            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                            echo "Erreur lors de l'enregistrement de l'évènement.";
                        }
                    } else {
                        echo "Capteur désactivé";
                    }
                } else {
                    echo "Sécu non active";
                }
            } else {
                echo "Action inexistante";
            }
        }
    }


    // Méthode permettant d'envoyer un mail
    private function send_email($type){

        // On récupère les utilisateurs qui acceptent de recevoir les notifications
        $users = $this->AuthentificationModele->users_accepting_notification();

        // On listes les emails
        $users_email = array_column($users, "email");
        $to      = implode(",", $users_email);

        // On définit toutes les infos pour le mail
        $subject = $type === "intrusion" ? "[LOCKHOME] Intrusion dans votre maison" : "[LOCKHOME] Notification a lire concernant votre système de sécurité";
        $message = file_get_contents("./application/email/$type.html");
      
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: lockhome@lockhome.nrocher.fr' . "\r\n";
        $headers .= 'Reply-To: lockhome@lockhome.nrocher.fr' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        
        // On envoit le mail
        if(mail($to, $subject, $message, $headers)) {
            echo "<br>Email accepted by server";
            // On ajoute dans la base de donnée a qui ont a envoyé le mail
            $this->LogEmailModele->add($type);
        } else {
            echo "<br>Error: Email not accepted by server";
        }
    }


    // Méthode permettant de générer un GET pour les caméras sans attendre la réponse 
    function fast_request($url) {
        $cmd = "curl $url > /dev/null 2>&1 &";
        exec($cmd);
        return 1;
    }

}



?>