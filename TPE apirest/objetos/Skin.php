<?php

class Skin{
    private $nombre;
    private $precio;
    private $champion_id;
    public $skin_id;

    public function setValues($nombre, $precio, $champion_id){
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->champion_id = $champion_id;
        $this->skin_id= null;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getChampionId(){
        return $this->champion_id;
    }

    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function setChampionId($champion_id){
        $this->champion_id = $champion_id;
    }

    public function setSkinId($skin_id){
        $this->skin_id = $skin_id;
    }
    

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

}
?>