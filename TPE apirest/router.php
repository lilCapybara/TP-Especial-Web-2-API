<?php
    require_once 'config.php';
    require_once 'router/route.php';

    require_once 'app/controllers/api.campeones.php';
    require_once 'app/controllers/api.controller.php';
    require_once 'app/controllers/api.Skins.php';

    $router = new Router();

    #                 endpoint      verbo     controller      método
    $router->addRoute('champ',     'GET',    'ApiCampeones', 'get'); # Apicampeones->get($params)treae todos los campeones
    $router->addRoute('champ',     'POST',   'ApiCampeones', 'createChamp');
    $router->addRoute('champ/:Champion_id', 'GET',    'ApiCampeones', 'get');#trae el campeon que coincida con el id numerico ingresado
    $router->addRoute('champ/:Champion_id', 'PUT',    'ApiCampeones', 'update');
    $router->addRoute('champ/:Champion_id', 'DELETE', 'ApiCampeones', 'delete');


    $router->addRoute('Skins',     'GET',    'ApiSkins', 'get'); # ApiSkins->get($params) trae todas las skins
    $router->addRoute('Skins',     'POST',   'ApiSkins', 'create');#trae la skin que coincida con el id numerico ingresado
    $router->addRoute('Skins/:Skin_id', 'GET',    'ApiSkins', 'get');
    $router->addRoute('Skins/:Skin_id', 'PUT',    'ApiSkins', 'update');
    $router->addRoute('Skins/:Skin_id', 'DELETE', 'ApiSkins', 'delete');
    
    
    $router->addRoute('user/token', 'GET',    'UserApiController', 'getToken'   ); # UserApiController->getToken()
    
    #               del htaccess resource=(), verbo con el que llamo GET/POST/PUT/etc
    $router->route($_GET['resource']        , $_SERVER['REQUEST_METHOD']);