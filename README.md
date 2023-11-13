El proposito de la api es poder acceder a los datos contenidos en la base de datos, especificamente los contenidos en las tablas "skins" y "campeones, y
poder trabajar con ellos de la manera que el usuario desee. Tambien se ha utilizado la tabla 'usuarios' para controlar si el usuario esta logueado y que de esta manera pueda crear/editar campeones o skins o no.

Endpoints:

Para trabajar con los datos contenidos en la tabla "campeones" se utilizan los siguientes endpoints:

-GET:/champ
Este endpoint es el encargado de mostrar la lista con todos los campeones y sus respectivos datos.
Al utilizar este endpoint, se obtiene una respuesta del siguiente tipo:

{
    "data": [
        {
            "Champion_id": Champion_id del campeon 1,
            "Nombre": "Nombre del campeon 1",
            "Rol": "Rol del campeon 1",
            "Precio": Precio del campeon 1
        },
        {
            "Champion_id": Champion_id del campeon 2,
            "Nombre": "Nombre del campeon 2",
            "Rol": "Rol del campeon 2",
            "Precio": Precio del campeon 2
        }
    ],
    "status": "success"
}

La cantidad de elementos en el array "data" variara de acuerdo a la cantidad de campeones que haya en la tabla "campeones".


-GET:/champ/:Champion_id

Este endpoint es el encargado de mostrar solamente el campeon (y sus datos) cuya champion_id coincida con la Champion_id de la URL.
Un ejemplo de la respuesta a obtener es el siguiente:

{
    "nombre": "Diana",
    "rol": "Mago",
    "precio": 3800
}

En caso de que la Champion_id de la URL no coincida con ninguna de las almacenadas en la base de datos se mostrara el siguiente error:

{
    "data": "El campeón solicitado no existe",
    "status": "error"
}

Por otra parte, se pueden elegir criterios para ordenar estos campeones y paginarlos. Como ejemplo tenemos la siguiente consulta realizada en postman:

localhost/TPE apirest/api/champ?filter=Champion_id&value=&sort=Precio&order=ASC&limit=3&page=2

Para la key "sort" colocamos el criterio a partir del cual queremos ordenar. En este caso ordenamos por precio.

Para la key "order" elegimos si el orden es ascendente o descendente. En este caso el orden es ascendente.

Para la key "limit" elegimos el limite de campeones que se muestran por pagina. En este caso mostramos 3 campeones por pagina.

Para la key "page" elegimos el numero de pagina que queremos mostrar. En este caso mostramos la pagina 2.

El key "value", que especifica una Champion_id para filtrar los resultados, esta vacia para poder mostrar todos los campeones sin importar su Champion_id.

-POST:/champ
Este endpoint es el encargado de agregar nuevos campeones a la tabla campeones. Para el usuario debe otorgar los siguientes datos:

{
    "nombre": "Nombre del campeon",
    "rol": "Rol del campeon",
    "precio": Precio del campeon
}

Un ejemplo de esto seria:

{
    "nombre": "Diana",
    "rol": "Mago",
    "precio": 3800
}

En caso de que no se hayan completado todos los datos necesarios aparecera el siguiente mensaje de error:

{
    "data": "faltó introducir algun campo",
    "status": "error"
}


-PUT:/champ/:Champion_id

Este endpoint es el encargado de modificar los datos del campeon cuya champion_id coincida con la Champion_id de la URL. Para ello, el usuario debe otorgar los siguientes datos:

{
    "nombre": "Nuevo nombre del campeon",
    "rol": "Nuevo rol del campeon",
    "precio": Nuevo precio del campeon
}

En caso de que la Champion_id de la URL coincida con alguna de las almacenadas en la tabla "campeones" se mostrara el siguiente mensaje:

 "data": [
        {
            "Champion_id": champion_id del campeon editado,
            "Nombre": "Nombre del campeon editado",
            "Rol": "Rol del campeon editado",
            "Precio": Precio del campeon editado
        }
    ],
    "status": "success"

En caso de que la Champion_id de la URL no coincida con ninguna de las almacenadas en la  se mostrara el siguiente error:

{
    "data": "El campeón solicitado no existe",
    "status": "error"
}

-DELETE:/champ/:Champion_id

Este endpoint es el encargado de borrar el campeon cuya champion_id coincida con la Champion_id de la URL.

En caso de que la Champion_id de la URL coincida con alguna de las almacenadas en la tabla "campeones" se mostrara el siguiente mensaje:

"El campeon con id=25 ha sido borrada." (Para este caso la Champion_id utilizada en la URL fue 25).

En caso de que la Champion_id de la URL no coincida con ninguna de las almacenadas en la tabla "campeones" se mostrara el siguiente error:

"El campeon con id=252 no existe." (Para este caso la Champion_id utilizada en la URL fue 252).



Para trabajar con los datos contenidos en la tabla "skins" se utilizan los siguientes endpoints:

-GET:/Skins

Este endpoint es el encargado de mostrar la lista con todos los skins y sus respectivos datos.
Al utilizar este endpoint, se obtiene una respuesta del siguiente tipo:

{
    "data": [
        {
            "Skin_id": Skin_id de la skin 1,
            "Nombre": "Nombre de la skin 1",
            "Champion_id": Champion_id del campeon de la skin 1,
            "Precio": Precio de la skin 1
        },
        {
            "Skin_id": Skin_id de la skin 2,
            "Nombre": "Nombre de la skin 2",
            "Champion_id": Champion_id del campeon de la skin 2,
            "Precio": Precio de la skin 2
        }
    ],
    "status": "success"
}

La cantidad de elementos en el array "data" variara de acuerdo a la cantidad de skins que haya en la tabla "skins".


Por otra parte, se pueden elegir criterios para ordenar estas skins y paginarlas. Como ejemplo tenemos la siguiente consulta realizada en postman:

localhost/TPE apirest/api/Skins?filter=Champion_id&value=&sort=Precio&order=ASC&limit=3&page=2

Para la key "sort" colocamos el criterio a partir del cual queremos ordenar. En este caso ordenamos por precio.

Para la key "order" elegimos si el orden es ascendente o descendente. En este caso el orden es ascendente.

Para la key "limit" elegimos el limite de skins que se muestran por pagina. En este caso mostramos 3 skins por pagina.

Para la key "page" elegimos el numero de pagina que queremos mostrar. En este caso mostramos la pagina 2.

Podemos ademas filtrar este orden y mostrar solo los campeones con una determinada Champion_id, la cual se debe especificar en la key "value".


-GET:/Skins/:Skin_id

Este endpoint es el encargado de mostrar solamente el skin (y sus datos) cuya skin_id coincida con la Skin_id de la URL.
Un ejemplo de la respuesta a obtener es el siguiente:

{
    "data": [
        {
            "Skin_id": Skin_id de la skin,
            "Nombre": "Nombre del campeon poseedor de la skin",
            "Champion_id": Champion_id del campeon poseedor de la skin,
            "Precio": 1200,
            "Rol": "Rol del campeon poseedor de la skin",
            "ChampionName": "Nombre del campeon poseedor de la skin",
            "SkinName": "Nombre de la skin"
        }
    ],
    "status": "success"
}

En caso de que la Skin_id de la URL no coincida con ninguna de las almacenadas en la base de datos se mostrara el siguiente error:

{
    "data": "La skin solicitada no existe",
    "status": "error"
}


-POST:/Skins

Este endpoint es el encargado de agregar nuevos campeones a la tabla campeones. Para el usuario debe otorgar los siguientes datos:

{
    "nombre": "Nombre del skin",
    "rol": champion_id del campeon poseedor de la skin,
    "precio": Precio de la skin
}

Un ejemplo de esto seria:

{
      "nombre": "Congelada",
      "champion_id": 19,
      "precio": 1200
}

Si se completaron los datos correctamente, se mostrara un mensaje como el siguiente:

{
    "data": [
        {
            "Skin_id": Skin_id de la skin agregada,
            "Nombre": "Nombre del campeon poseedor de la skin agregada",
            "Champion_id": Champion_id del campeon poseedor de la skin agregada,
            "Precio": Precio de la skin agregada,
            "Rol": "Rol del campeon poseedor de la skin agregada",
            "SkinName": "Nombre de la skin agregada"
        }
    ],
    "status": "success"
}

Un ejemplo de esto seria:

{
    "data": [
        {
            "Skin_id": 35,
            "Nombre": "Caitlyn",
            "Champion_id": 19,
            "Precio": 1200,
            "Rol": "tirador",
            "SkinName": "Congelada"
        }
    ],
    "status": "success"
}

En caso de que no se hayan completado todos los datos necesarios aparecera el siguiente mensaje de error:

{
    "data": "faltó introducir algun campo",
    "status": "error"
}


-PUT:/Skins/:Skin_id

Este endpoint es el encargado de modificar los datos de la skin cuya Skin_id coincida con la Skin_id de la URL. Para ello, el usuario debe otorgar los siguientes datos:

{           
     "nombre": "Nuevo nombre de la skin",
     "precio": Nuevo precio de la skin
}

Un ejemplo de esto seria:

{
      "nombre": "Congelada",
      "precio": 1200
}


En caso de que la Skin_id de la URL coincida con alguna de las almacenadas en la tabla "skins" se mostrara el siguiente mensaje:

{
    "data": [
        {
            "Skin_id": Skin_id de la skin agregada,
            "Nombre": "Nombre del campeon poseedor de la skin agregada",
            "Champion_id": Champion_id del campeon poseedor de la skin agregada,
            "Precio": Precio de la skin agregada,
            "Rol": "Rol del campeon poseedor de la skin agregada",
            "SkinName": "Nombre de la skin agregada"
        }
    ],
    "status": "success"
}

Un ejemplo de esto seria:
{
    "data": [
        {
            "Skin_id": 35,
            "Nombre": "Caitlyn",
            "Champion_id": 19,
            "Precio": 1200,
            "Rol": "tirador",
            "SkinName": "Congelada"
        }
    ],
    "status": "success"
}

En caso de que la Skin_id de la URL no coincida con ninguna de las almacenadas en la tabla "skins" se mostrara el siguiente error:

{
    "data": "La skin solicitada no existe",
    "status": "error"
}

-DELETE:/Skins/:Skin_id

Este endpoint es el encargado de borrar el campeon cuya champion_id coincida con la Champion_id de la URL.

En caso de que la Champion_id de la URL coincida con alguna de las almacenadas en la tabla "skins" se mostrara el siguiente mensaje:

"La Skin con id=33 ha sido borrada." (Para este caso la Skin_id utilizada en la URL fue 33).

En caso de que la Skin_id de la URL no coincida con ninguna de las almacenadas en la  tabla "skins" se mostrara el siguiente error:

"La Skin con id=332 no existe." (Para este caso la Champion_id utilizada en la URL fue 332).


En lo referido a la autenticacion del usuario tenemos el siguiente endpoint:

-GET:/user:/token

Este endpoint es el encargado de obtener el token de autorizacion para realizar las acciones de crear y editar campeones y skins

En nuestro caso utilizamos a la hora de testear el user:webadmin, con contraseña:admin (Almacenados en la tabla "usuarios") para obtener el token, el cual es:

eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJ1c2VyX25hbWUiOiJ3ZWJhZG1pbiIsInBhc3N3b3JkIjoiJDJ5JDEwJGRINUN3QVZPTXhLV09oanpLbW5EZS5kY000MnVvYmxlWS5uYWN1S0xqMGFkN0hmc1RmVnBhIiwiZXhwIjoxNjk5ODk4ODE2fQ.kWjzIo9k5E4q5kJY8Ex4UpotuWSfB5M4jlHp-6vTl3g

Este token esta compuesto de tres partes:

+Header:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9

Este contiene los datos del algoritmo y el tipo de token utilizado:
{
  "alg": "HS256",
  "typ": "JWT"
}

+Payload:eyJ1c2VyX2lkIjoxLCJ1c2VyX25hbWUiOiJ3ZWJhZG1pbiIsInBhc3N3b3JkIjoiJDJ5JDEwJGRINUN3QVZPTXhLV09oanpLbW5EZS5kY000MnVvYmxlWS5uYWN1S0xqMGFkN0hmc1RmVnBhIiwiZXhwIjoxNjk5ODkwODE2fQ

este contiene la id del usuario, su nombre y contraseña y en que momento expirara el token:
{
  "user_id": 1,
  "user_name": "webadmin",
  "password": "$2y$10$dH5CwAVOMxKWOhjzKmnDe.dcM42uobleY.nacuKLj0ad7HfsTfVpa",
  "exp": 1699890816
}

+Signature:kMjUtCelc5PzGXwhGKKlBQX2Z8AO1jREPiUaDUYW1U8

Tambien llamada firma, verifica que el token no haya sido alterado desde que se genero y contiene los siguientes datos:

HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  
your-256-bit-secret

)

Dado el caso de que el token utilizado no sea el correcto o haya expirado, se mostrara el siguiente error:

"El usuario no esta autorizado para realizar esta accion". Con el error 401 Unauthorized.
