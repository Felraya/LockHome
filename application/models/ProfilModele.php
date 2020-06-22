<?php

class ProfilModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT DE RECUPERER TOUT LES PROFILS
    public function getAll()
    {
        $sql = "SELECT * from Profil";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    
    
    // METHODE PERMETTANT DE DENIFIR LE PROFIL ACTIF
    public function setActive($idActif)
    {
        $data = array();
        $data["profilactif"] = $idActif;

        $this->db->update('Maison', $data, array());

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    
    
    // METHODE PERMETTANT DE RECUPERER LE PROFIL ACTIF
    public function getActive()
    {
        $sql = "SELECT Profil.* from Profil,Maison WHERE Maison.profilactif = Profil.id";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result()[0];
        }
    }

    // METHODE PERMETTANT DE RECUPERER UN PROFIL
    public function get($id)
    {
        $sql = "SELECT * from Profil WHERE id = ?";

        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result()[0];
        }
    }

    // METHODE PERMETTANT DE CREER OU MODIFIER UN PROFIL
    public function edit($id, $nom, $debut, $fin)
    {
        $data = array();
        $data["nom"] = $nom;
        $data["debut"] = $debut;
        $data["fin"] = $fin;

        if ($id == "new") {
            $this->db->insert('Profil', $data);
        } else {
            $this->db->update('Profil', $data, array("id" => $id));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function delete($id)
    {
        $this->db->delete('Profil', array("id" => $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Return true if the capteur is in the table "EtatCapteur" and false if he isn't
    public function capteurStateInDB($idProfil, $idCapteur)
    {
        $sql = "SELECT * FROM EtatCapteur WHERE idProfil=? and idCapteur=?";

        $query = $this->db->query($sql, array($idProfil, $idCapteur));

        $res = array_column($query->result_array(), "idCapteur");

        return count($res) === 1;
    }

    public function deleteCapteurStateDB($idProfil, $idCapteur)
    {
        //if the table contains this profil
        if($this->capteurStateInDB($idProfil, $idCapteur))
        {
            $this->db->delete('EtatCapteur', array("idProfil" => $idProfil, "idCapteur" => $idCapteur));
        }
    }

    public function addCapteurStateDB($idProfil, $idCapteur)
    {
        //if the table do NOT contains this profil
        if(!$this->capteurStateInDB($idProfil, $idCapteur))
        {
            $this->db->insert('EtatCapteur', array("idProfil" => $idProfil, "idCapteur" => $idCapteur));
        }
    }

    public function getDisabledCapteur($enabledCapteurs)
    {
        $sql = "SELECT id FROM Capteur";

        $query = $this->db->query($sql);

        $allCapteurs = array_column($query->result_array(), "id");

        $disabledCapteurs = array();

        foreach($allCapteurs as $key)
        {
            if(!in_array($key, $enabledCapteurs))
            {
                array_push($disabledCapteurs, $key);
            }
        }

        return $disabledCapteurs;
    }

    public function getCapteurActive($idProfil) {

        $sql = "SELECT id FROM Capteur WHERE NOT EXISTS(SELECT idCapteur FROM EtatCapteur WHERE idProfil = ?)";

        $query = $this->db->query($sql, array($idProfil));

        return array_column($query->result_array(), "id");
    }

    public function getCapteurDesactive($idProfil) {
        $sql = "SELECT idCapteur FROM EtatCapteur WHERE idProfil=?";

        $query = $this->db->query($sql, array($idProfil));

        return array_column($query->result_array(), "idCapteur");
    }
    
    public function updateCapteurState($idProfil, $capteurStates) {
        foreach($capteurStates as $key => $value)
        {
            $sql = "SELECT * FROM EtatCapteur WHERE idProfil='".$idProfil."' and idCapteur='".$capteurStates['idCapteur']."'";

            $query = $this->db->query($sql)->result()[0];

            if($query == true)
            {
                $this->db->update();
            }
        }
    }
}
