<?php

function base64url_encode($data) {  //Codifica la cadena de datos en base64
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); //rtrim elimina espacios a la derecha
}

class AuthHelper {
    function getAuthHeaders() { //Devuelve el header de autenticacion
        $header = "";
        if(isset($_SERVER['HTTP_AUTHORIZATION']))
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']))
            $header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        return $header;
    } //Si no cae en ninguno de los if, retornara un header vacio

    function createToken($payload) {    //La payload o carga util se pasa como parametro
        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'  //Tipo de token
        );
        
        $payload->exp = time() + JWT_EXP; //La fecha de vencimiento del payload es la fecha y hora actual mas una cierta cantidad de segundos

        $header = base64url_encode(json_encode($header));   //hacemos al header y payload json y luego
        $payload = base64url_encode(json_encode($payload)); //codificamos ambos en base64
        
        $signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true); //Creamos la firma
        $signature = base64url_encode($signature);  //Pasamos la firma a base64

        $token = "$header.$payload.$signature"; //Creamos el token concatenando header, payload y signature
        
        return $token; //Devolvemos el token para que se lo envie al usuario
    }

    function verify($token) {
        //El formato del token es $header.$payload.$signature

        $token = explode(".", $token); //Separo los componentes del token en una array [$header, $payload, $signature]
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true); //Creamos una nueva firma
        $new_signature = base64url_encode($new_signature);  //Codificamos la nueva firma en base64

        if($signature!=$new_signature) {    //Comparamos la firma del token con la firma nueva
            return false;
        }

        $payload = json_decode(base64_decode($payload));    //Decodifico la base64 del payload y desarmo el json

        if($payload->exp<time()) { //Si exp es menor a la fecha actual, significa que el token ya vencio
            return false;
        }

        return $payload;    //Devuelvo el payload al controller
    }

    function currentUser() {
        $auth = $this->getAuthHeaders(); //Deberia devolver algo del tipo "Bearer $token"
        $auth = explode(" ", $auth); //Separo los componentes del $auth en un array["Bearer", "$token"]

        if($auth[0] != "Bearer") { //Verifico que el formato de autenticacion sea del tipo bearer
            return false;
        }

        return $this->verify($auth[1]); //Verificamos que el $token sea correcto
    }                                   // y, si está bien, nos devuelve el payload
    

}