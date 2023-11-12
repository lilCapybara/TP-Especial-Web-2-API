<?php

class Campeon{

    private $nombre;
    private $rol;
    private $precio;
    public $champion_id;

    public function setValues($nombre, $rol, $precio){
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->precio = $precio;
        $this->champion_id = null;

    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getRol(){
        return $this->rol;}


    public function getPrecio(){
        return $this->precio;
    }

    public function setRol($Rol){
        $this->rol = $Rol;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function setChampionId($champion_id){
        $this->champion_id = $champion_id;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}
?>