<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/skins.model.php';

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
            $body = $this->getData();

            $nombre = $body->nombre;
            $Skin_id = $body->Skin_id;
            $precio = $body->precio;

            if (empty($nombre) || empty($Skin_id)) {
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insertSkins($Skin_id,$nombre,$precio);

                //devuelvo el recurso creado
                $tarea = $this->model->getSkinsById($Skin_id);
                $this->view->response($tarea, 201);
            }
    
        }

        function update($params = []) {
            $Skin_id = $params[':Champion_id'];
            $tarea = $this->model->getSkinsById($Skin_id);

            if($tarea) {
                $body = $this->getData();
                $nombre = $body->nombre;
                
                $Precio = $body->Precio;
                $this->model->updateSkins($nombre,  $Precio, $Skin_id);

                $this->view->response('El campeon con id='.$Skin_id.' ha sido modificada.', 200);
            } else {
                $this->view->response('El campeon con id='.$Skin_id.' no existe.', 404);
            }
        }

    }