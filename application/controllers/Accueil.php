<?php
class Accueil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("MaisonModele");
        $this->load->model("ProfilModele");
        $this->load->model("LogCapteurModele");
        $this->load->model("LogEmailModele");

        $this->load->helper("url_helper");
    }

    // Controleur pour la page "Accueil"
    public function home()
    {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }


        // On récupère les informations de la table Maison
        $data = $this->MaisonModele->get();
    
        // On récupère les logs des capteurs pour ce jour
        $data->capteur_log = $this->LogCapteurModele->getIntrusionForToday();

        // On récupère la listes des profils existants
        $data->listes_profils = $this->ProfilModele->getAll();

        // On récupère le profil actif
        $data->profil_actif = $this->ProfilModele->getActive();
          // On récupere la date de début et de fin
          $debut  = explode(":", $data->profil_actif->debut);
          $fin    = explode(":", $data->profil_actif->fin);

          // On convertit les heures en milliseconde
          $now    = mktime(date("H"), date("i"),  0, 0,0,0);
          $debut  = mktime($debut[0], $debut[1],  0, 0,0,0);
          $fin    = mktime($fin[0],   $fin[1],    0, 0,0,0);

          // Si le profil est activé a l'heure actuelle
          if( ($now >= $debut AND $now <= $fin) OR ($data->profil_actif->debut == $data->profil_actif->fin) ) {
          $data->securise = true;
           }
           else{
               $data->securise = false;
           }

        // On affiche la vue avec toutes les informations
        $this->load->view('accueil/accueil', $data);

    }


    // Controleur pour la page "Modifier les paramètres de la maison"
    public function edit()
    {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //REQUETE HTTP POST

            // Si toutes les données sont correctement remplis
            if ($this->input->post('nom') != null &&
                $this->input->post('adresse') != null &&
                $this->input->post('recordCamera') != null) {
                $nom = $this->input->post('nom');
                $adresse = $this->input->post('adresse');
                $recordCamera = $this->input->post('recordCamera'); 

                // On met a jour les paramètres de la maison
                $this->MaisonModele->edit($nom, $adresse, $recordCamera);

            }

            // Si une image est envoyé
            if (isset($_FILES["image"]["tmp_name"]) && $_FILES["image"]["tmp_name"] != "") {

                // On définit ou elle sera stocké
                $target_file = "./static/ressources/background.jpg";
                $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));

                // On vérifie que c'est bien une image
                $check = getimagesize($_FILES["image"]["tmp_name"]);

                // Si c'est bien une image et que la taille est inférieur à 500Ko et que c'est un type jpg
                if ($check !== false && $_FILES["image"]["size"] < 500000 && ($imageFileType == "jpg" || $imageFileType == "jpeg")) {

                    //On remplace le fichier statique par notre image
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                }
            }

            // On redirige vers l'accueil
            redirect("/", "refresh");

        } else {
            //REQUETE HTTP GET OU AUTRE

            // On récupère les paramètres
            $data = $this->MaisonModele->get();

            // On affiche la vue
            $this->load->view('accueil/edit', $data);
        }

    }

    // Controleur pour la page "Accueil" -> "Modifier le profil actif"
    public function edit_profil(){

        // On vérifie que c'est bien une requete de type post et que la valeur du nouveau profil actif n'est pas vide
        if ($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('profilActif') != null) {

            // On met a jour le profil
            $this->ProfilModele->setActive($this->input->post('profilActif'));

        }

        // On redirige vers l'accueil
        redirect("/", "refresh");

    }

}
