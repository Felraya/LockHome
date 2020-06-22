<?php

class ResumeModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT DE RECUPERER TOUT LES LOGS D'UNE JOURNEE
    public function getAllDay($date = "today")
    {

        $date == "today" ? date("Y-m-d H:i:s") : $date;

        $sql = "SELECT * from LogCapteur WHERE `date` BETWEEN '" . date("Y-m-d"). " 00:00:01' AND '" . date("Y-m-d"). " 23:59:59'";
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    // METHODE PERMETTANT DE RECUPERER TOUT LES LOGS D'UNE JOURNEE
    public function getForDay($date = "today", $idCapteur)
    {

        $date == "today" ? date("Y-m-d H:i:s") : $date;

        $sql = "SELECT * from LogCapteur WHERE `idCapteur` = '" . $idCapteur . "'  `date` BETWEEN '" . date("Y-m-d"). " 00:00:01' AND '" . date("Y-m-d"). " 23:59:59'";
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }


    //A COMPLETER REQUETE NON CONFORME 
    public function getLog($idCapteurs, $actions, $date)
    {
        $sql = "SELECT * FROM LogCapteur WHERE capteurId = ? AND action = ? AND BETWEEN aujourdhui AND ?";

        $query = $this->db->query($sql, array($idCapteurs, $actions, $date));

        if($query->num_rows() == 0){
            return false;
        } else {
            return $query->result();
        }
    }

  
}
