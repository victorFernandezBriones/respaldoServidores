<?php

include_once 'Conexion.php';

/**
 * Description of Servidor
 *
 * @author Victor Fernandez Briones
 */
class Servidor {

    private $idServer;
    private $nombreServer;
    private $ipServer;

    public function __construct() {
        
    }

//accesadores
    function getIdServer() {
        return $this->idServer;
    }

    function getNombreServer() {
        return $this->nombreServer;
    }

    function getIpServer() {
        return $this->ipServer;
    }

    function setIdServer($idServer) {
        $this->idServer = $idServer;
    }

    function setNombreServer($nombreServer) {
        $this->nombreServer = $nombreServer;
    }

    function setIpServer($ipServer) {
        $this->ipServer = $ipServer;
    }

    public function obtenerServidores() {
        try {
            $conexion = new Conexion(); //objeto de la conexion
            $cnx = $conexion->conectar(); //asignando el link de la conexion
            $servidores = array(); //var para almacenar servidores
            $sql = "SELECT * FROM servidores";
            $rs = mysqli_query($cnx, $sql);

            while ($s = mysqli_fetch_array($rs)) {
                array_push($servidores, $s);
            }

            //liberando recursos
            mysqli_free_result($rs);
            //cerrando conexion
            mysqli_close($cnx);
            
        } catch (Exception $e) {
            //control de excepciones
            try {
                mysqli_free_result($rs);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            try {
                mysqli_close($cnx);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        return $servidores;
    }

}
