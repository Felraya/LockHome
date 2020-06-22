<?php

class CapteurModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT DE RECUPERER TOUT LES CAPTEURS
    public function getAll()
    {
        $sql = "SELECT * from Capteur";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function get($id)
    {
        $sql = "SELECT * from Capteur WHERE id = ?";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result()[0];
        }
    }

    public function getWithIP($ip)
    {

        if($ip == ""){
            return false;
        }

        $sql = "SELECT * from Capteur WHERE ip = ?";
        $query = $this->db->query($sql, array($ip));

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result()[0];
        }
    }

    public function edit($id, $nom, $ip, $type)
    {
        $data = array();
        $data["nom"] = $nom;
        $data["ip"] = $ip;
        $data["type"] = $type;

        if ($id == "new") {
            $this->db->insert('Capteur', $data);
        } else {
            $this->db->update('Capteur', $data, array("id" => $id));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->delete('Capteur', array("id" => $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
