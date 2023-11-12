<?php
require_once 'app/models/model.php';

class Skins_model extends Model {
    public   function getAllSkins() {
        $query = $this->db->prepare('SELECT * FROM `skins` ');
        $query->execute();

        $skins = $query->fetchAll(PDO::FETCH_OBJ);

        return $skins;
    }

    public function getSkinsOrderByName() {

        $query = $this->db->prepare('SELECT * FROM skins ORDER BY precio ASC');
        $query->execute();
        $skins = $query->fetchAll(PDO::FETCH_OBJ);
        return $skins;
    }

    
    public   function getSkinsById($Skin_id) {
        $query = $this->db->prepare('SELECT *, campeones.Nombre AS ChampionName, skins.Nombre AS SkinName FROM skins JOIN campeones ON campeones.Champion_id = skins.Champion_id WHERE skin_id = ?');
        $query->execute([$Skin_id]);


        $Skins = $query->fetchAll(PDO::FETCH_OBJ);

        return $Skins;
    }

    public  function insertSkins($Champion_id, $nombre, $precio) {
        $query = $this->db->prepare('INSERT INTO skins (Champion_id, Nombre, Precio) VALUES(?,?,?)');
        $query->execute([$Champion_id, $nombre, $precio]);

        return $this->db->lastInsertId();
    }


    public function deleteSkins($Skin_id) {
        $query = $this->db->prepare('DELETE FROM Skins WHERE Skin_id = ?');
        $query->execute([$Skin_id]);
    }

    public function updateSkins($Skin_id, $nombre, $Precio) {
        $query = $this->db->prepare('UPDATE skins SET Nombre = ?, Precio = ? WHERE Skin_id = ?');
        $query->execute([$nombre, $Precio, $Skin_id]);
    }
}