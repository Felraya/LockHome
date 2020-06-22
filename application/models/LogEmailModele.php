<?php

class LogEmailModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    // METHODE PERMETTANT DE RECUPERER TOUT LES LOGS D'UNE JOURNEE
    public function getAllDay($date = "today") {

        $date = $date == "today" ? DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s")) : $date;

        $sql = "SELECT * from LogEmail WHERE `date` BETWEEN '" . date_format($date, "Y-m-d"). " 00:00:01' AND '" . date_format($date, "Y-m-d"). " 23:59:59'";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            return false;
        } else {

            $result = $query->result();

            if($result !== false){

                $group = [];
                $groupe = "";

                foreach ($result as $item)  {
                    $dt = DateTime::createFromFormat("Y-m-d H:i:s", $item->date);

                    $time = mktime($dt->format('H'), $dt->format('i'), $dt->format('s'), 1, 1, 1);

                    $gr_1 = mktime($dt->format('H'),  0, 0, 1, 1, 1) - $time;
                    $gr_2 = mktime($dt->format('H'), 30, 0, 1, 1, 1) - $time;
                    $tren = mktime($dt->format('H'), 30, 0, 1, 1, 1);

                    if($gr_1 <= $gr_2 and $time < $tren){
                        // RENTRE DANS LE GROUPE 1
                        $groupe = $dt->format("H").":00";
                    } else {
                        // RENTRE DANS LE GROUPE 2
                        $groupe = $dt->format("H").":30";
                    }

                    if (!isset($group[$groupe])) {
                        $group[$groupe] = [];
                    }

                    $item->date = $dt;

                    array_push($group[$groupe], $item);
                }

                foreach($group as $groupe=>$d){
                    usort($group[$groupe], function($a1, $a2) {
                        return $a1->date->getTimestamp() - $a2->date->getTimestamp();
                    });
                }

                $group["raw"] = $result;
                
                $result = $group;
            }

            return $result;
        }
    }

    // METHODE PERMETTANT D'AJOUTER UN LOG POUR CHAQUE EMAIL ENVOYE
    public function add($type)
    {

        $now = date('Y-m-d H:i:s');

        $data = array();
        $data["type"] = $type;
        $data["date"] = $now;

        $this->db->insert('LogEmail', $data);

        return true;
    }

     // METHODE PERMETTANT DE SUPPRIMER UN LOG POUR CHAQUE EMAIL ENVOYE
    public function deleteLog($d){
        $this->db->like('date', $d);
        $this->db->delete("LogEmail");
    }
}
