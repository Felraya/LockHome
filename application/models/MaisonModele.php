<?php

class MaisonModele extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get() {
        $sql = "SELECT * from Maison";
        $query = $this->db->query($sql);
        return $query->result()[0];
    }

    public function getRecordCamera() {
        $sql = "SELECT recordCamera from Maison";
        $query = $this->db->query($sql);
        return $query->result()[0]->recordCamera;
    }
    
    public function edit($nom, $adresse, $recordCamera) {
        $data = array();
        $data["nom"] = $nom;
        $data["adresse"] = $adresse;
        $data["recordCamera"] = $recordCamera;

        $this->db->update('Maison', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}