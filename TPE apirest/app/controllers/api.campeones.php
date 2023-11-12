<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/campeones.model.php';

class ApiCampeones extends ApiController {
    private $model;

    function __construct() {
        parent::__construct();
        $this->model = new Campeones_model();
    }

    function get($params = []) {
        $id = $params[":Champion_id"];
    
        if (empty($id)) {
            $champ = $this->model->getAllChamp();
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

      /*  public function post()  intento de metodo create
    {

        $data = $this->getData();

        if (empty($data->nombre) || empty($data->precio)||empty($data->rol)) {
         
            $this->view->response("Los datos necesarios no están completos.", 400);
            return;
        }

        $res = $this->model->insertChamp($data->nombre, $data->precio, $data->rol);

        if (!$res) {
            $this->view->response("Se produjo un error al intentar agregar.", 404);
            return;
        }

        $this->view->response("Se agregó con éxito el recurso con id = $res.", 201);
    }
*/
     function createChamp($params = []) {
        $data = $this->getData();
        if (empty($data->nombre) || empty($data->precio)) {
            $this->view->response([
                'data' => 'faltó introducir algun campo',
                'status' => 'error'
            ], 400);
        }
        $champ = new Campeon();
        $champ->setValues($data->nombre, $data->rol, $data->precio);

        $Champion_id = $this->model->insertChamp($champ->getNombre(),$champ->getRol(),$champ->getPrecio());
        $Champion_agregado = $this->model->getChampById($Champion_id);

        if ($Champion_agregado) {
            $this->view->response([
                'data' => $Champion_agregado,
                'status' => 'success'
            ], 200);
        } else
            $this->view->response([
                'data' => "La canción no fué creada",
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
                $Precio = $body->Precio;
                $this->model->updateChamp($nombre, $rol, $Precio, $Champion_id);

                $this->view->response('El campeon con id='.$Champion_id.' ha sido modificada.', 200);
            } else {
                $this->view->response('El campeon con id='.$Champion_id.' no existe.', 404);
            }
        }

    }