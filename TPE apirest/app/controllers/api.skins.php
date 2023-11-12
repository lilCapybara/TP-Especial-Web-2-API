<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/skins.model.php';
require_once 'objetos/Skin.php';

class ApiSkins extends ApiController{
    private $model;

    function __construct() {
        parent::__construct();
        $this->model = new Skins_model();
    }

    function get($params = []) {
        $id = $params[":Skin_id"];
        $skin = $this->model->getSkinsById($id);
    
        if (empty($id)) {
            $skins = $this->model->getAllSkins();
            $this->view->response([
                'data' => $skins,
                'status' => "success"
            ], 200);
        } else if (!empty($skin)) {
            $this->view->response([
                'data' => $skin,
                'status' => 'success',
            ], 200);
        } else {
            $this->view->response([
                'data' => 'La skin solicitada no existe',
                'status' => 'error'
            ], 404);
        }
    }
    
    


    function delete($params = []) {
            $Skin_id = $params[':Skin_id'];
            $Skins = $this->model->getSkinsById($Skin_id);

            if($Skins) {
                $this->model->deleteSkins($Skin_id);
                $this->view->response('La Skins con id='.$Skin_id.' ha sido borrada.', 200);
            } else {
                $this->view->response('La Skins con id='.$Skin_id.' no existe.', 404);
            }
        }

        function createSkins($params = []) {
            $data = $this->getData();
    
            if (empty($data->nombre) || empty($data->champion_id) || empty($data->precio)) {
                $this->view->response([
                    'data' => 'faltó introducir algun campo',
                    'status' => 'error'
                ], 400);
            } 
            $skin = new Skin();
            $skin->setValues($data->nombre, $data->precio, $data->champion_id);
    
            $Skin_id = $this->model->insertSkins($skin->getChampionId(), $skin->getNombre() ,$skin->getPrecio()); //insertSkins devuelve el id del
            $Skin_agregado = $this->model->getSkinsById($Skin_id);                                                //ultimo skin insertado
    
            if ($Skin_agregado) {
                $this->view->response([
                    'data' => $Skin_agregado,
                    'status' => 'success'
                ], 200);
            } else
                $this->view->response([
                    'data' => "El skin no fue creado",
                    'status' => 'error'
                ], 500);
        }

        function update($params = []) {
            $Skin_id = $params[':Skin_id'];
            $skin = $this->model->getSkinsById($Skin_id);

            if($skin) {
                $body = $this->getData();
                $nombre = $body->nombre;
                $precio = $body->precio;
                $this->model->updateSkins($Skin_id, $nombre, $precio);

                $this->view->response('El skin con id='.$Skin_id.' ha sido modificado.', 200);
            } else {
                $this->view->response('El skin con id='.$Skin_id.' no existe.', 404);
            }
        }

    }