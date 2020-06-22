<?php

class AuthentificationModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT LINSCRIPTION
    public function inscription($nom, $prenom, $email, $password)
    {
        $sql = "SELECT * from Authentification WHERE email = ? LIMIT 1";

        $query = $this->db->query($sql, array($email));

        if ($query->num_rows() == 0) {
            $data = array();
            $data["nom"] = $nom;
            $data["prenom"] = $prenom;
            $data["email"] = $email;
            $data["password"] = password_hash($password, PASSWORD_DEFAULT);
            $data["role"] = "admin";

            $this->db->insert('Authentification', $data);

            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    // METHODE PERMETTANT LA CONNEXION
    public function connexion($email, $password)
    {
        $sql = "SELECT * FROM Authentification WHERE email = ? LIMIT 1";

        $query = $this->db->query($sql, array($email));

        if ($query->num_rows() > 0) {

            $resultat = $query->result()[0];

            if (password_verify($password, $resultat->password)) {
                return $resultat->role;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    // METHODE PERMETTANT LA RECUPERATION DE MOT DE PASSE
    public function mot_de_passe_oublie($email)
    {
        $sql = "SELECT * FROM Authentification WHERE email = ? LIMIT 1";

        $query = $this->db->query($sql, array($email));

        return $query->num_rows();
    }
    
    // METHODE PERMETTANT DE RECUPERER LES USERS ACCEPTANT LES NOTIFS
    public function users_accepting_notification()
    {
        $sql = "SELECT id, nom, prenom, email FROM Authentification WHERE notification = 1";

        $query = $this->db->query($sql);
        
        return $query->result();
    }
}
