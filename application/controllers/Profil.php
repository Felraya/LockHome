<?php
class Profil extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("ProfilModele");
        $this->load->model("CapteurModele");
        $this->load->helper("url_helper");
    }

    public function list(){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if(!$this->session->has_userdata("email")){
            redirect('/connexion', 'refresh');
            exit();
        }

        $profils = $this->ProfilModele->getAll();

        if($profils == false) {
            $data = array("error" => "Il n'existe pas de profil pour le moment.");
        } else {
            $data = array("profils" => $profils);
        }

        $this->load->view('profil/list', $data);
    }

    public function edit($idProfil = "new"){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if(!$this->session->has_userdata("email")){
            redirect('/connexion', 'refresh');
            exit();
        }

        $data = array();


        /***************************************************************** */
        /* PERMET D'AFFICHER CORRECTEMENT LES CAPTEURS ACTIVE / DESACTIVE */
        $data["capteurs"] = $this->CapteurModele->getAll();

        $disabledCapteurs = array();
        if($idProfil != "new") {
            $disabledCapteurs = $this->ProfilModele->getCapteurDesactive($idProfil);
        }

        $listes_capteurs = array();
        foreach($data["capteurs"] as $Capteur) {
            if(in_array($Capteur->id, $disabledCapteurs))
            {
                $Capteur->disabled = true;
            }
            array_push($listes_capteurs, $Capteur);
        }

        $data["capteurs"] = $listes_capteurs;
        /***************************************************************** */


        if($this->input->server('REQUEST_METHOD') == 'POST') {
            //REQUETE HTTP POST

            if($this->input->post('nom') != null and
               $this->input->post('debut') != null and
               $this->input->post('fin') != null
                ){

                $nom = $this->input->post('nom');
                $debut = $this->input->post('debut');
                $fin = $this->input->post('fin');

                // VERIFIER LES INPUTS qui commencent par capteur_

                $enabledCapteurs = array();

                foreach($_POST as $input_name => $input_value){

                    if(strpos($input_name ,"capteur_") !== FALSE) {

                        $idCapteur = substr($input_name, 8);

                        array_push($enabledCapteurs,  $idCapteur);

                    }
                }

                $disabledCapteurs = array();
                $disabledCapteurs = $this->ProfilModele->getDisabledCapteur($enabledCapteurs);

                //update the data base for enabled capteur state
                foreach($enabledCapteurs as $idEnabledCapteur)
                {
                    //if the capteur is in the table EtatState we delete this
                    if($this->ProfilModele->capteurStateInDB($idProfil, $idEnabledCapteur))
                    {
                        $this->ProfilModele->deleteCapteurStateDB($idProfil, $idEnabledCapteur);
                    }
                }

                //update the data base for disabled capteur state
                foreach($disabledCapteurs as $idDisabledCapteur)
                {
                    //if the capteur isn't in the table EtatState we add this
                    if(!$this->ProfilModele->capteurStateInDB($idProfil, $idDisabledCapteur))
                    {
                        $this->ProfilModele->addCapteurStateDB($idProfil, $idDisabledCapteur);
                    }
                }

                
                $this->ProfilModele->edit($idProfil, $nom, $debut, $fin);

                redirect("/profil", "refresh");

            } else {

                $data["id"] = $id;
                $data["new"] = $id == "new";
                $data["nom"] = $this->input->post('nom');
                $data["debut"] = $this->input->post('debut');
                $data["fin"] = $this->input->post('fin');
                $data["state"] = true;
                $data["contentGuide"] = "Vous pouvez ici créer un nouveau profil en indiquant le nom
                                du profil, la plage horaire où les capteurs seront activés et
                                les capteurs que vous voulez utiliser.";

                $this->load->view('profil/edit', $data, $contentGuide);
            }

        } else {
            //REQUETE HTTP GET OU AUTRE

            if($idProfil !== "new") {

                $profil = $this->ProfilModele->get($idProfil);

                if($profil !== false) {
                    $data["id"] = $profil->id;
                    $data["nom"] = $profil->nom;
                    $data["debut"] = $profil->debut;
                    $data["fin"] = $profil->fin;
                    $data["new"] = false;
                    $data["state"] = $this->ProfilModele->getCapteurActive($idProfil);
                } else {
                    redirect("/profil", "refresh");
                }

            } else {
                $data["new"] = true;
            }

            $data["state"] = isset($data["state"]) ? $data["state"] : array();
    
            $data["contentGuide"] = "Vous pouvez ici modifier les différents éléments d'un profil";

            $this->load->view('profil/edit', $data);
        }
    }

    public function delete($id){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if(!$this->session->has_userdata("email")){
            redirect('/connexion', 'refresh');
            exit();
        }

        $this->ProfilModele->delete($id);

        redirect("/profil", "refresh");
        
    }
}

?>