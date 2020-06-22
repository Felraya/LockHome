<?php
class Camera extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("CameraModele");
        $this->load->helper("url_helper");

    }

    function list() {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $cameras = $this->CameraModele->getAll();

        if ($cameras == false) {
            $data = array("error" => "Vous n'avez pas ajouté de camera pour le moment.");
        } else {
            $data = array("cameras" => $cameras);
        }

        $this->load->view('camera/list', $data);
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

            if ($nom != "" and $ip != "") {
                // On met a jour le capteur
                $this->CameraModele->edit($id, $nom, $ip);

                redirect("/camera", "refresh");

            } else {

                $data["id"] = $id;
                $data["new"] = $id == "new";
                $data["nom"] = $nom;
                $data["ip"] = $ip;
                $data["contentGuide"] = "Vous pouvez ici créer une nouvelle caméra en indiquant
                 le nom de la caméra et son adresse ip.";

                $this->load->view('camera/edit', $data);
            }

        } else {
            //REQUETE HTTP GET OU AUTRE

            if ($id != "new") {

                $camera = $this->CameraModele->get($id);

                if ($camera !== false) {
                    $data["id"] = $camera->id;
                    $data["nom"] = $camera->nom;
                    $data["ip"] = $camera->ip;
                    $data["new"] = false;
                } else {
                    redirect("/camera", "refresh");
                }

            } else {
                $data["new"] = true;
            }

            $data["contentGuide"] = "Vous pouvez ici modifier les différents éléments d'une caméra";

            $this->load->view('camera/edit', $data);
        }
    }

    public function view($id)
    {
        $camera = $this->CameraModele->get($id);

        if ($camera !== false) {
            $data["id"] = $camera->id;
            $data["nom"] = $camera->nom;
            $data["ip"] = $camera->ip;
            $data["new"] = false;
            /**Fonction qui permet de recuperer la liste des fichiers disponibles sur la camera*/
            //Se connecter au JSON a l'adresse base_url("https://api.coingecko.com/api/v3/ping" -H "accept: application/json")
            //puis le parser et faire un var-dump
            $contenu = file_get_contents(base_url("camera/stream/$camera->ip/files"));
            //convertir json en tableau en php puis passer ce tableau dans $data['files'] = $le tableau
            $data['files'] = json_decode($contenu);
            
            $this->load->view('camera/view', $data);
        } else {
            redirect("/camera", "refresh");
        }
    }

    public function delete($id)
    {

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $this->CameraModele->delete($id);
        echo("Je suis dans le delete");
        redirect("/camera", "refresh");

    }

}
