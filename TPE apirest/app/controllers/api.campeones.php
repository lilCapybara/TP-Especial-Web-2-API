<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/campeones.model.php';
require_once 'objetos/Campeon.php';

class ApiCampeones extends ApiController {
    private $model;

    function __construct() {
        parent::__construct();
        $this->model = new Campeones_model();
    }

    function get($params = []) {
        $id = $params[":Champion_id"];
    
        if (empty($id)) {
            $champ = $this->model->getChampOrdeXNombre();
            $this->view->response([
                'data' => $champ,
                'status' => "success"
            ], 200);
        } else {
            $champ = $this->model->getChampById($id);
    
            if (!empty($champ)) {
                $this->view->response([
                    'data' => $champ,
                    'status' => 'success',
                ], 200);
            } else {
                $this->view->response([
                    'data' => 'El campeón solicitado no existe',
                    'status' => 'error'
                ], 404);
            }
        }
    }

    function delete($params = []) {
            $Champion_id = $params[':Champion_id'];
            $campeon = $this->model->getChampById($Champion_id);

            if($campeon) {
                $this->model->deleteChamp($Champion_id);
                $this->view->response('El campeon con id='.$Champion_id.' ha sido borrada.', 200);
            } else {
                $this->view->response('El campeon con id='.$Champion_id.' no existe.', 404);
            }
        }


     function createChamp($params = []) {
        $data = $this->getData();
        if (empty($data->nombre) || empty($data->precio) || empty($data->rol)) {    //Verifico que no esten vacios los campos pedidos
            $this->view->response([
                'data' => 'faltó introducir algun campo',
                'status' => 'error'
            ], 400);
        }
        $champ = new Campeon();
        $champ->setValues($data->nombre, $data->rol, $data->precio);

        $Champion_id = $this->model->insertChamp($champ->getNombre(),$champ->getRol(),$champ->getPrecio()); //insertChamp devuelve el id del
        $Champion_agregado = $this->model->getChampById($Champion_id);                                      //ultimo campeon insertado

        if ($Champion_agregado) {
            $this->view->response([
                'data' => $Champion_agregado,
                'status' => 'success'
            ], 200);
        } else
            $this->view->response([
                'data' => "El campeon no fue creado",
                'status' => 'error'
            ], 500);
    
        }

        function update($params = []) {
            $Champion_id = $params[':Champion_id'];
            $champ = $this->model->getChampById($Champion_id);

            if($champ) {
                $body = $this->getData();
                $nombre = $body->nombre;
                $rol = $body->rol;
                $precio = $body->precio;
                $this->model->updateChamp($nombre, $rol, $precio, $Champion_id);

                $this->view->response('El campeon con id='.$Champion_id.' ha sido modificado.', 200);
            } else {
                $this->view->response('El campeon con id='.$Champion_id.' no existe.', 404);
            }
        }

    }