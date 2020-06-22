<?php

class CameraModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT DE RECUPERER TOUTES LES CAMERAS
    public function getAll()
    {
        $sql = "SELECT * from Camera";
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    // METHODE PERMETTANT DE RECUPERER UNE CAMERA
    public function get($id)
    {
        $sql = "SELECT * from Camera WHERE id = ?";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result()[0];
        }
    }

    // METHODE PERMETTANT D'EDITER UNE CAMERA
    public function edit($id, $nom, $ip)
    {
        $data = array();
        $data["nom"] = $nom;
        $data["ip"] = $ip;

        if ($id == "new") {
            $this->db->insert('Camera', $data);
        } else {
            $this->db->update('Camera', $data, array("id" => $id));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // METHODE PERMETTANT DE SUPPRIMER UNE CAMERA
    public function delete($id)
    {
        $this->db->delete('Camera', array("id" => $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
