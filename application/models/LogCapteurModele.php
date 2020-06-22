<?php

class LogCapteurModele extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


        // METHODE PERMETTANT DE RECUPERER TOUT LES INTRUSIONS DU JOUR
        // @return : false ou un Objet comprenant les informations de l'intrusion
        public function getIntrusionForToday()
        {
    
            $date = new DateTime();
    
            // Requete SQL permettant de sélectionner la première intrusion de la journée
            $sql = "SELECT LogCapteur.*, Capteur.nom from LogCapteur, Capteur WHERE LogCapteur.capteurId = Capteur.id AND action = 'intrusion' AND `date` BETWEEN '" . date_format($date, "Y-m-d"). " 00:00:01' AND '" . date_format($date, "Y-m-d"). " 23:59:59' LIMIT 1";
            
            // On execute la requete
            $query = $this->db->query($sql);
    
            // Si aucune valeur, on renvoit false
            if ($query->num_rows() == 0) {
                return false;
            } else {
                // Si il y a des données 
                $result = $query->result()[0];
                // On transforme la date en un objet DateTime
                $result->date = DateTime::createFromFormat("Y-m-d H:i:s", $result->date);
                // On renvoit l'objet
                return $result;
            }
        }


    // METHODE PERMETTANT DE RECUPERER TOUT LES LOGS D'UNE JOURNEE
    // @return : false ou un tableau de log
    public function getAllDay($date = "today")
    {

        // On transforme la date en DateTime
        $date = $date === "today" ? new DateTime() : $date;

        // Permet de sélectionner les logs de la journée
        $sql = "SELECT LogCapteur.*, Capteur.nom from LogCapteur, Capteur WHERE LogCapteur.capteurId = Capteur.id AND `date` BETWEEN '" . date_format($date, "Y-m-d"). " 00:00:01' AND '" . date_format($date, "Y-m-d"). " 23:59:59'";
        
        // On execute la requete
        $query = $this->db->query($sql);

        // On renvoit false si aucune donnée
        if ($query->num_rows() == 0) {
            return false;
        } else {

            // Sinon, on va formatter les données

            $result = $query->result();

            $group = [];
            $groupe = "";

            // Pour chaque logs
            // On va grouper les logs par groupe de 30 minutes 
            foreach ($result as $item)  {

                // On formatte la date en objet DateTime
                $dt = DateTime::createFromFormat("Y-m-d H:i:s", $item->date);
                $item->date = $dt;

                /* -------------------------------------- */
                /* On calcule dans quel groupe est le log
                /* -------------------------------------- */
                $time = mktime($dt->format('H'), $dt->format('i'), $dt->format('s'), 1, 1, 1);
                $gr_1 = mktime($dt->format('H'),  0, 0, 1, 1, 1) - $time;
                $gr_2 = mktime($dt->format('H'), 30, 0, 1, 1, 1) - $time;
                $tren = mktime($dt->format('H'), 30, 0, 1, 1, 1);

                if($gr_1 <= $gr_2 and $time < $tren){
                    $groupe = $dt->format("H").":00"; // Groupe H : 00
                } else {
                    $groupe = $dt->format("H").":30"; // Groupe H : 30
                }

                /* -------------------------------------- */

                // On vérifie que le groupe existe 
                if (!isset($group[$groupe])) {
                    $group[$groupe] = [];
                }

                // On ajoute dans le groupe correspondant
                array_push($group[$groupe], $item);
            }

            // On renvoit les groupes
            return $group;
        }
    }

    // METHODE PERMETTANT DE RECUPERER LA PREMIERE INTRUSION D'UN JOUR
    // @return : false ou un tableau de groupe 
    public function getAll($index = 0)
    {

        // $limit et $offset permettent de limiter la réception de log
        $limit = 25; // Ici fixer a 25
        $offset = $index * $limit; // Permet de définir quelle page de log on souhaite consulter

        // Requete permettant de récuperer les logs
        $sql = "SELECT date from LogCapteur ORDER BY date ASC LIMIT $limit OFFSET $index";

        // On execute la requete
        $query = $this->db->query($sql);

        // On renvoit false si pas de donnée
        if ($query->num_rows() == 0) {
            return false;
        } else {

            // On récupère uniquement les dates
            $date = array_column($query->result(), "date");
            $inc_date = array();
            $return = array();
           
            foreach($date as $d){
        
                // On récupère uniquement le premier log pour une journée donnée
                $date_formated = date_format(date_create($d), "Y-m-d");
                if(!in_array($date_formated, $inc_date)){
                    array_push($inc_date, $date_formated);
                    array_push($return, date_create($d));
                }
            }

            return array_reverse($return, TRUE);
        }
    }

    // METHODE PERMETTANT D'AJOUTER UN LOG
    // @return : boolean
    public function add($capteurID, $action)
    {
        // On prépare les données
        $data = array();
        $data["capteurId"] = $capteurID;
        $data["action"] = $action;

        // On envoit les données
        $this->db->insert('LogCapteur', $data);

        return $this->db->affected_rows() > 0;
    }

    // METHODE PERMETTANT DE SUPPRIMER UN LOG
    public function deleteLog($d){
        $this->db->like('date', $d);
        $this->db->delete("LogCapteur");
    }
}
