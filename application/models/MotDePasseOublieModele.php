<?php

class MotDePasseOublieModele extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }

    private function getIdUser($email)
    {

        $sql = "SELECT id FROM Authentification WHERE email = ? LIMIT 1";

        $query = $this->db->query($sql, array($email));

        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->id;
        }
        else
        {
            return false; //Aucun id trouvé.
        }
    }

    public function verify($email, $token)
    {
        $user = $this->getIdUser($email);

        if($user)
        {
            $sql = "SELECT * FROM MotDePasseOublie WHERE user = ? AND token = ? LIMIT 1";

            $query = $this->db->query($sql, array($user, $token));
    
            if($this->db->affected_rows() > 0)
            {
                return true;
            } else {
                return false;
            }
        } else {
            echo "<br> L'idUser n'est pas définis";
        }
    }

    public function delete($email, $token)//Un fois le changement fait
    {
        $id = $this->getIdUser($email);

        if($id)
        {
            $this->db->delete('MotDePasseOublie', array("user" => $id));

            return $this->db->affected_rows();
        } else {
            echo "<br> L'idUser n'est pas définis";
        }
    }

    public function add($email, $token) //mdp oublié premier form
    {
        $id = $this->getIdUser($email);

        if($id)
        {
            $data = array();
            $data["user"] = $id;
            $data["token"] = $token;

            $this->db->insert('MotDePasseOublie', $data);

            return $this->db->affected_rows();
        } else {
            echo "<br> L'idUser n'est pas définis";
        }
    }

    //METHODE PERMETTANT LE CHANGEMENT DE MOT DE PASSE
    public function resetPassword($password, $email)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $data = array();
        $data["password"] = $password;

        $this->db->update('Authentification', $data, array("email" => $email));

        return $this->db->affected_rows();
    }
}

?>