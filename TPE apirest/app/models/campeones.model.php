<?php
require_once 'app/models/model.php';

class Campeones_model extends Model {
    public function getAllChamp( $queryParams) {
        $sql = "SELECT * FROM campeones";

        // Filtro
        if (!empty($queryParams['filter']) && !empty($queryParams['value']))
            $sql .= ' WHERE ' . $queryParams['filter'] . ' LIKE \'%' . $queryParams['value'] . '%\'';

        // Ordenamiento
        if (!empty($queryParams['sort'])) {
            $sql .= ' ORDER BY '. $queryParams['sort'];

            // Orden ascendente y descendente
            if (!empty($queryParams['order']))
                $sql .= ' ' . $queryParams['order'];
        }

        // Paginación
        if (!empty($queryParams['limit']))
            $sql .= ' LIMIT ' . $queryParams['limit'] . ' OFFSET ' . $queryParams['offset'];

        // No hace falta sanitizar consulta (datos ingresados ya fueron verificados por el controlador)
        $query = $this->db->prepare($sql);        
        $query->execute();

        $champ = $query->fetchAll(PDO::FETCH_OBJ);
        return $champ;
    }

    public function getColumnNames() {
        $query = $this->db->query('DESCRIBE campeones');
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
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