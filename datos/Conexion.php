<?php

/**
 * Description of Conexion
 *
 * @author Victor Fernandez Briones
 */
class Conexion {

    private $server = "localhost";
    private $user = "respaldo";
    private $pass = "respaldo";
    private $db = "respaldos";
    public $ConexionId;
    public $Error;

    //funcion para realizar la conexion con al base de datos
    public function conectar() {

        $this->ConexionId = mysqli_connect($this->server, $this->user, $this->pass, $this->db); //Asignando el link de conexion a
        //preguntando si es que la conexion es exitosa
        if (!$this->ConexionId) {
            $this->Error = "Error, no se ha podido realizar la conexion";

            return -1; //devolver un -1 en caso de error
        }

        return $this->ConexionId; //devuelvo el link de la conexion
    }

    public function cerrarConexion() {

        mysqli_close($this->ConexionId); //funcion para cerrar la conexion con la base de datos

        return 1; //valor en caso de exito
    }

}
