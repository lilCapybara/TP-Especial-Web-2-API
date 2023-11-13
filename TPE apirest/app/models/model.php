<?php

class Model{
    protected $db;

    public  function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
        $this->deploy();    
    
    }

    function deploy() {
        // Chequear si hay tablas
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
        if(count($tables)==0) {  // Si no hay crearlas
            
            $sql =<<<END
                -- Estructura de tabla para la tabla `campeones`

                CREATE TABLE `campeones` (
                `Champion_id` int(3) NOT NULL,
                `Nombre` varchar(20) NOT NULL,
                `Rol` varchar(10) NOT NULL,
                `Precio` int(5) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `campeones`
                --

                INSERT INTO `campeones` (`Champion_id`, `Nombre`, `Rol`, `Precio`) VALUES
                (13, 'Braum', 'tanque', 1200),
                (16, 'Caitlyn', 'tirador', 1200);


                -- Estructura de tabla para la tabla `skins`
                --

                CREATE TABLE `skins` (
                `Skin_id` int(2) NOT NULL,
                `Nombre` varchar(20) NOT NULL,
                `Champion_id` int(3) NOT NULL,
                `Precio` int(5) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `skins`
                --

                INSERT INTO `skins` (`Skin_id`, `Nombre`, `Champion_id`, `Precio`) VALUES
                (18, 'Veraniega', 16, 1200);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `transacciones`
                --

                CREATE TABLE `transacciones` (
                `Transaction_id` int(10) NOT NULL,
                `User_id` int(10) NOT NULL,
                `Champion_id` int(3) DEFAULT NULL,
                `Skin_id` int(10) DEFAULT NULL,
                `Monto` float NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `transacciones`
                --

                INSERT INTO `transacciones` (`Transaction_id`, `User_id`, `Champion_id`, `Skin_id`, `Monto`) VALUES
                (48, 1, 16, NULL, 1200);

                ALTER TABLE `campeones`
                ADD PRIMARY KEY (`Champion_id`);

                --
                -- Indices de la tabla `skins`
                --
                ALTER TABLE `skins`
                ADD PRIMARY KEY (`Skin_id`),
                ADD KEY `Champion_id` (`Champion_id`);

                --
                -- Indices de la tabla `transacciones`
                --
                ALTER TABLE `transacciones`
                ADD PRIMARY KEY (`Transaction_id`),
                ADD KEY `Product_id` (`Champion_id`),
                ADD KEY `Skin_id` (`Skin_id`),
              
            END;
            $this->db->query($sql);

        }
      



        }

    }