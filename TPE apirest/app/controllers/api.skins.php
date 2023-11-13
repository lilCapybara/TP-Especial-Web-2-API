<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/skins.model.php';
require_once 'objetos/Skin.php';
require_once 'app/helpers/auth.api.helper.php';

class ApiSkins extends ApiController{
    private $model;
    private $AuthHelper;

    function __construct() {
        parent::__construct();
        $this->model = new Skins_model();
        $this->AuthHelper=new AuthHelper();
    }

    public function getById($params = []) {
        $id = $params[":Skin_id"];
        $champ = $this->model->getSkinsById($id);
        if (!empty($champ)) {
            $this->view->response([
                'data' => $champ,
                'status' => 'success',
            ], 200);
        } else {
            $this->view->response([
                'data' => 'La Skin solicitada no existe',
                'status' => 'error'
            ], 404);
        }
  


    }
   public function get($params = []) {
    
        $columns = $this->model->getColumnNames();
        

        // Arreglo donde se almacenarán los parámetros de consulta
        $queryParams = array();

        // Filtro
        $queryParams += $this->handleFilter($columns);
        
        // Ordenamiento
        $queryParams += $this->handleSort($columns);

        // Paginación
        $queryParams += $this->handlePagination();
        
        // Se obtienen los álbumes y se devuelven en formato JSON
        $Skins = $this->model->getAllSkins($queryParams);
        return $this->view->response($Skins, 200);
    }
    
    


    function delete($params = []) {
            $Skin_id = $params[':Skin_id'];
            $Skins = $this->model->getSkinsById($Skin_id);

            if($Skins) {
                $this->model->deleteSkins($Skin_id);
                $this->view->response('La Skin con id='.$Skin_id.' ha sido borrada.', 200);
            } else {
                $this->view->response('La Skin con id='.$Skin_id.' no existe.', 404);
            }
        }

        function createSkins($params = []) {

            $user = $this->AuthHelper->currentUser();   //Verifico que el usuario este logueado
            if (!$user) {
                $this->view->response('El usuario no esta autorizado para realizar esta accion', 401);
                return;
            }

            $data = $this->getData();
    
            if (empty($data->nombre) || empty($data->champion_id) || empty($data->precio)) {
                $this->view->response([
                    'data' => 'faltó introducir algun campo',
                    'status' => 'error'
                ], 400);
            }else{
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
        }

        function update($params = []) {

            $user = $this->AuthHelper->currentUser();   //Verifico que el usuario este logueado
            if (!$user) {
                $this->view->response('El usuario no esta autorizado para realizar esta accion', 401);
                return;
            }

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

        private function handleFilter($columns) {
            // Valores por defecto
            $filterData = [
                'filter' => "", // Campo de filtrado
                'value' => ""   // Valor de filtrado
            ];
    
            if (!empty($_GET['filter']) && !empty($_GET['value'])) {
                $filter = $_GET['filter'];
                $value = $_GET['value'];

          var_dump($filter);
          var_dump($value);
    
                // Si el campo no existe se produce un error
                if (!in_array($filter, $columns)) {
                    $this->view->response("Invalid filter parameter (field '$filter' does not exist)", 400);
                    die();
                }
               
                $filterData['filter'] = $filter;
                $filterData['value'] = $value;
           
            }
            
            return $filterData;
        }
    
        /**
         * Método de ordenamiento de resultados según campo y orden dados
         */
        private function handleSort($columns) {
            // Valores por defecto
            $sortData = [
                'sort' => "", // Campo de ordenamiento
                'order' => "" // Orden ascendente o descendente
            ];
    
            if (!empty($_GET['sort'])) {
                $sort = $_GET['sort'];

              
    
                // Si el campo de ordenamiento no existe se produce un error
                if (!in_array($sort, $columns)) {
                    $this->view->response("Invalid sort parameter (field '$sort' does not exist)", 400);
                    die();
                }
    
                // Orden ascendente o descendente
                if (!empty($_GET['order'])) {
                    $order = strtoupper($_GET['order']);
                    $allowedOrders = ['ASC', 'DESC'];
    
                    // Si el campo de ordenamiento no existe se produce un error
                    if (!in_array($order, $allowedOrders)) {
                        $this->view->response("Invalid order parameter (only 'ASC' or 'DESC' allowed)", 400);
                        die();
                    }
                }
    
                $sortData['sort'] = $sort;
                $sortData['order'] = $order;
            }
    
            return $sortData;
        }
    
        /**
         * Método de paginación de resultados según número de página y límite dados
         */
        private function handlePagination() {
            // Valores por defecto
            $paginationData = [
                'limit' => 0,    // Límite de resultados
                'offset' => 0    // Desplazamiento
            ];
  
    
            if (!empty($_GET['page']) && !empty($_GET['limit'])) {
                $page = $_GET['page'];
                $limit = $_GET['limit'];

                
              
    
                // Si alguno de los valores no es un número natural se produce un error
                if (!is_numeric($page) || $page < 0 || !is_numeric($limit) || $limit < 0) {
                    $this->view->response("Page and limit parameters must be positive integers", 400);
                    die();
                }
    
                $offset = ($page - 1) * $limit;
    
                $paginationData['limit'] = $limit;
                $paginationData['offset'] = $offset;
            }
           
            return $paginationData;
        }

    }