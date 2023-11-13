<?php
require_once 'app/models/model.php';

class Skins_model extends Model {
    
    public   function getAllSkins( $queryParams) {
        $sql = "SELECT * FROM skins";

        // Filtro
        if (!empty($queryParams['filter']) && !empty($queryParams['value']))
            $sql .= ' WHERE ' . $queryParams['filter'] . ' LIKE \'%' . $queryParams['value'] . '%\'';

        // Ordenamiento
        if (!empty($queryParams['sort'])) {
            $sql .= ' ORDER BY '. $queryParams['sort'];

            // Orden ascendente y descendente
            if (!empty($queryParams['order']))
                $sql .= ' ' . $queryParams['order'];}

                if (!empty($queryParams['limit']))
                $sql .= ' LIMIT ' . $queryParams['limit'] . ' OFFSET ' . $queryParams['offset'];
    
            // No hace falta sanitizar consulta (datos ingresados ya fueron verificados por el controlador)
            $query = $this->db->prepare($sql);        
            $query->execute();
    
            $skin = $query->fetchAll(PDO::FETCH_OBJ);
            return $skin;
    }

    public function getColumnNames() {
        $query = $this->db->query('DESCRIBE skins');
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    public   function getSkinsById($Skin_id) {
        $query = $this->db->prepare('SELECT *, skins.Nombre AS SkinName FROM skins JOIN campeones ON campeones.Champion_id = skins.Champion_id WHERE skin_id = ?');
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