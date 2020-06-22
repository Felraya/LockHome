<?php
class Capteur extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("CapteurModele");
        $this->load->helper("url_helper");
    }

    function list() {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $capteurs = $this->CapteurModele->getAll();

        if ($capteurs == false) {
            $data = array("error" => "Vous n'avez pas ajouté de capteur pour le moment.");
        } else {
            $data = array("capteurs" => $capteurs);
        }

        $this->load->view('capteur/list', $data);
    }

    public function edit($id = "new")
    {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //REQUETE HTTP POST

            $nom = $this->input->post('nom');
            $ip = $this->input->post('ip');
            $type = $this->input->post('type');

            if ($nom != null and $ip != null and $type != null) {

                // On met a jour le capteur
                $this->CapteurModele->edit($id, $nom, $ip, $type);

                redirect("/capteur", "refresh");

            } else {

                $data["id"] = $id;
                $data["new"] = $id == "new";
                $data["nom"] = $nom;
                $data["ip"] = $ip;
                $data["type"] = $type;
                $data["contentGuide"] = "Vous pouvez ici créer un nouveau capteur en indiquant le nom du capteur, son adresse ip et son type.";
                $this->load->view('capteur/edit', $data);
            }

        } else {
            //REQUETE HTTP GET OU AUTRE

            if ($id != "new") {

                $capteur = $this->CapteurModele->get($id);

                if ($capteur !== false) {
                    $data["id"] = $capteur->id;
                    $data["nom"] = $capteur->nom;
                    $data["type"] = $capteur->type;
                    $data["ip"] = $capteur->ip;
                    $data["new"] = false;
                } else {
                    redirect("/capteur", "refresh");
                }

            } else {
                $data["new"] = true;
            }

            $data["contentGuide"] = "Vous pouvez ici modifier les différents éléments d'un capteur";

            $this->load->view('capteur/edit', $data);
        }
    }

    public function delete($id)
    {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $this->CapteurModele->delete($id);

        redirect("/capteur", "refresh");

    }

}
