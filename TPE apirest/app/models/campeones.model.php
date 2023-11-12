<?php
require_once 'app/models/model.php';

class Campeones_model extends Model {
    public function getAllChamp() {
        $query = $this->db->prepare('SELECT * FROM `campeones` ');
        $query->execute();

        $champ = $query->fetchAll(PDO::FETCH_OBJ);

        return $champ;
    }

    public function updateChamp($nombre, $rol, $Precio, $Champion_id) {

        $query = $this->db->prepare('UPDATE campeones SET nombre = ?, rol = ?, precio = ? WHERE Champion_id = ?');
        $query->execute([$nombre, $rol, $Precio, $Champion_id]);
    }

    public   function getChampById($Champion_id) {
        $query = $this->db->prepare('SELECT * FROM `campeones` WHERE Champion_id=?');
        $query->execute([$Champion_id]);

        $champ = $query->fetchAll(PDO::FETCH_OBJ);

        return $champ;
    }

    public  function insertChamp($nombre, $rol, $precio) {
        $query = $this->db->prepare('INSERT INTO campeones (nombre, rol,precio) VALUES(?,?,?)');
        $query->execute([$nombre, $rol, $precio]);

        return $this->db->lastInsertId();
    }

    public function deleteChamp($Champion_id) {
        $query = $this->db->prepare('DELETE FROM campeones WHERE Champion_id =?');
        $query->execute([$Champion_id]);
    }
}