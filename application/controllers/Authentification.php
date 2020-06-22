<?php
class Authentification extends CI_Controller {
  
    public function __construct(){
        parent::__construct();
        $this->load->model("AuthentificationModele");
        $this->load->model("MotDePasseOublieModele");
        $this->load->helper("url_helper");
    }

    
    // Controleur pour la page "Connexion"
    public function connexion(){

        // Si l'utilisateur est connecté
        if($this->session->has_userdata("email")){
            header("Location: ./");
        }

        if($this->input->server('REQUEST_METHOD') == 'POST') {
            //REQUETE HTTP POST

            // Si 
            if($this->input->post('email') != null and $this->input->post('mot_de_passe') != null){

                $email = $this->input->post('email');
                $password = $this->input->post('mot_de_passe');

                $connection = $this->AuthentificationModele->connexion($email, $password);

                if($connection !== false){

                    //On regarde si l'utilisateur est en waiting ou non
                    if($connection == "admin" || $connection == "member"){
                        $this->session->set_userdata("email", $email);
                        header("Location: ./");
                    } else {
                        $msg = array("warning" => "Ce compte n'est pas validé.");
                        $this->load->view('auth/connexion', $msg);
                    }

                } else {
                    $msg = array("error" => "Email ou mot de passe non reconnu.");
                    $this->load->view('auth/connexion', $msg);
                }
            } else {
                $msg = array("error" => "Vous n'avez pas envoyé le formulaire correctement.");
                $this->load->view('auth/connexion', $msg);
            }

        } else {

            //REQUETE HTTP GET OU AUTRE
            $this->load->view('auth/connexion');

        }

    }

    public function inscription(){

        if($this->session->has_userdata("email")){
            header("Location: ./");
        }

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            //REQUETE HTTP POST
            if($this->input->post('prenom') != null && $this->input->post('nom') != null && $this->input->post('email') != null && $this->input->post('mot_de_passe') != null){

                $prenom = $this->input->post('prenom');
                $nom = $this->input->post('nom');
                $email = $this->input->post('email');
                $password = $this->input->post('mot_de_passe');

                $inscription = $this->AuthentificationModele->inscription($nom, $prenom, $email, $password);

                if($inscription == true){

                    $msg = array("warning" => "Vous pouvez maintenant vous connecter.");
                    $this->load->view('auth/inscription', $msg);

                } else {
                    $msg = array("error" => "Cet utilisateur existe déjà.");
                    $this->load->view('auth/inscription', $msg);
                }
            } else {
                $msg = array("error" => "Vous n'avez pas envoyé le formulaire correctement.");
                $this->load->view('auth/inscription', $msg);
            }
        } else {

            //REQUETE HTTP GET OU AUTRE
            $this->load->view('auth/inscription');

        }

    }

    public function deconnexion(){
        $this->session->sess_destroy();
            header("Location: ./");
    }

    public function mot_de_passe_oublie(){

        if($this->session->has_userdata("email")){
            header("Location: ./");
        }

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            //REQUETE HTTP POST
            if($this->input->post('email') != null){

                $email = $this->input->post('email');

                $mdpoublie = $this->AuthentificationModele->mot_de_passe_oublie($email);

                if($mdpoublie == true){
                    $token = uniqid();
                    
                    //Si il y a un déjà un toke, nous le détruisons
                    if($this->MotDePasseOublieModele->verify($email, $token))
                    {
                        $this->MotDePasseOublieModele->delete($email, $token);
                    }
                    
                    $this->MotDePasseOublieModele->add($email, $token);
                    $this->send_email($email, $token);

                    $msg = array("envoye" => true);
                    $this->load->view('auth/mot_de_passe_oublie', $msg);

                } else {
                    $msg = array("error" => "Cet utilisateur n'existe pas.");
                    $this->load->view('auth/mot_de_passe_oublie', $msg);
                }
            } else {
                $msg = array("error" => "Vous n'avez pas envoyé le formulaire correctement.");
                $this->load->view('auth/mot_de_passe_oublie', $msg);
            }
        } else {

            //REQUETE HTTP GET OU AUTRE
            $this->load->view('auth/mot_de_passe_oublie');

        }
    }

    private function send_email($email, $token){

        $subject = "[LOCKHOME] Demande de changement de mot de passe.";
        $message = file_get_contents("./application/email/mot_passe_oublie.html");
        $message = str_replace('$$_TOKEN_$$', $token, $message);
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: lockhome@lockhome.nrocher.fr' . "\r\n";
        $headers .= 'Reply-To: lockhome@lockhome.nrocher.fr' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        
        return mail($email, $subject, $message, $headers);
    }

    public function nouveau_mot_de_passe($token)
    {

        // Envoit du formulaire
        if($this->input->server('REQUEST_METHOD') == 'POST') 
        {
    
            // Vérification du formulaire
            if(isset($_POST["email"]) && isset($_POST["mot_de_passe"]) && $token != '')
            {
                // On vérifie si il a bien demandé une réinitialisation du mot de passe
                if($this->MotDePasseOublieModele->verify($_POST["email"], $token))
                {
                    // On chnage le mot de passe avec le nouveau
                    $this->MotDePasseOublieModele->resetPassword($_POST["mot_de_passe"], $_POST["email"]);
                    // On supprime la demande
                    $this->MotDePasseOublieModele->delete($_POST["email"], $token);

                    //On affiche une vue pour montrer à l'utilisateur que le mot de passe a été changé
                    $msg = array("nouveauMotDePasse" => true);
                    $this->load->view('auth/nouveau_mot_de_passe', $msg);
                } else {
                    $msg = array("error" => "Aucune demande de réinitialisation de mot de passe n'a été faite.");
                    $this->load->view('auth/nouveau_mot_de_passe', $msg);
                }

            // Si il a pas envoyé toutes les informations, on affiche une erreur
            } else {
                $msg = array("error" => "Il n'y a pas d'email, mot de passe ou de token initialisé.");
                $this->load->view('auth/nouveau_mot_de_passe', $msg);
            }

        // Sinon nous sommes en GET, donc en renvoit la vue
        } else {
            $this->load->view('auth/nouveau_mot_de_passe');
        }
    }

}