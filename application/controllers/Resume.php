<?php
class Resume extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("LogCapteurModele");
        $this->load->model("LogEmailModele");
        $this->load->helper("url_helper");
        
    }

    public function list(){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $data = array("intrusion" => $this->LogCapteurModele->getAll());

        $this->load->view('resume/list', $data);

    }

    
    public function show(){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        $date = $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5);

        $date_parsed = date_parse_from_format("d/m/Y", $date);

        if($date_parsed["error_count"]>0){
            echo "Date invalide";
        } else {
            $date_parsed = DateTime::createFromFormat("d/m/Y", $date);
            $data = array("date" => $date);
         
            $capteur_log = $this->LogCapteurModele->getAllDay($date_parsed);
            $mail_log    = $this->LogEmailModele->getAllDay($date_parsed);

            unset($mail_log["raw"]);

            if($capteur_log == false) {
                $capteur_log = array();
            }

            if($mail_log == false) {
                $mail_log = array();
            }

            $data["list"] = array_merge_recursive($capteur_log, $mail_log);
         
            foreach($data["list"] as $groupe=>$d){
                usort($data["list"][$groupe], function($a1, $a2) {
                    return $a1->date->getTimestamp() - $a2->date->getTimestamp();
                });
            }

            $this->load->view('resume/show', $data);
        }
    }

    public function delete($date){

        //VERIFICATION QUE L'UTILISATEUR EST CONNECTE
        if (!$this->session->has_userdata("email")) {
            redirect('/connexion', 'refresh');
            exit();
        }

        /*On supprime la notification de la base de données*/

        $this->LogCapteurModele->deleteLog($date);
        $this->LogEmailModele->deleteLog($date);

        redirect('/resume', 'refresh');
    }
}

?>