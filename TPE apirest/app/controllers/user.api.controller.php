<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/helpers/auth.api.helper.php';
require_once 'app/models/user.model.php';
//require_once 'app/models/user.model.php';

class UserApiController extends ApiController {
    private $model;
    private $authHelper;

    function __construct() {
        parent::__construct();
        $this->authHelper = new AuthHelper();
        $this->model = new UserModel();
    }

    function getToken(){
        $basic = $this->authHelper->getAuthHeaders(); //Me da el header de la forma
                                                      //'Authorization:' 'Basic: base64(usr:pass)'
        if(empty($basic)){  //Verifico que el header no este vacio
            $this->view->response('No envió encabezados de autenticación.', 401);
            return;
        }

        $basic = explode(" ", $basic); // Separa el header en ["Basic", "base64(usr:pass)"]

        if($basic[0]!="Basic") {    //Verifica que el header sea de tipo basic
            $this->view->response('Los encabezados de autenticación son incorrectos.', 401);
            return;
        }

        $userpass = base64_decode($basic[1]); //Decodifico el "base64(usr:pass)", quedando usr:pass
        $userpass = explode(":", $userpass); //Separo usr y pass, quedando ["usr", "pass"]

        $user = $userpass[0];
        
        $pass = $userpass[1];
        
        $userData = $this->model->getUserByUsername($user); //Obtengo el usuario de la base de datos
        var_dump($userData);
        // Se verifica usuario y contraseña
        if ($user == $userData->user_name && password_verify($pass, $userData->password)) {
            $token = $this->authHelper->createToken($userData);
            $this->view->response($token, 200);
        } else{
            $this->view->response('Contraseña o usuario incorrecto', 401);
        }
    }
}

    
                                              