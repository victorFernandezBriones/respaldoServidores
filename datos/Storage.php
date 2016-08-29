<?php

include_once 'Conexion.php';

/**
 * Description of Storage
 *
 * @author GLOBAL TALAGANTE
 */
class Storage {

    private $idStorage;
    private $detalleStorage;

    public function __construct() {
        
    }

    function getIdStorage() {
        return $this->idStorage;
    }

    function getDetalleStorage() {
        return $this->detalleStorage;
    }

    function setIdStorage($idStorage) {
        $this->idStorage = $idStorage;
    }

    function setDetalleStorage($detalleStorage) {
        $this->detalleStorage = $detalleStorage;
    }

    public function obtenerTodosLosStorage() {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar(); //link de la conexion            
            $sqlStorage = "SELECT * FROM storage"; //query para obtener todos los storages
            $rs = mysqli_query($cnx, $sqlStorage); //resultado de la query           
            $storages = array(); //array para guardar los datos obtenidos
            while ($s = mysqli_fetch_array($rs)) {//vaciando los resultados
                array_push($storages, $s);
            }
            //liberando recursos
            mysqli_close($cnx);
            mysqli_free_result($rs);
        } catch (Exception $e) {

            try {
                mysqli_close($cnx);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            try {
                mysqli_free_result($rs);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }

        return $storages;
    }

    public function obtenerStoragePorId($idStorage) {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar(); //link de la conexion            
            $sqlStorage = "SELECT * FROM storage WHERE id_storage='$idStorage'"; //query para obtener todos los storages
            $rs = mysqli_query($cnx, $sqlStorage); //resultado de la query           

            while ($s = mysqli_fetch_array($rs)) {//vaciando los resultados
                $storage = new Storage();
                $storage->setIdStorage($s['id_storage']);
                $storage->setDetalleStorage($s['detalle_storage']);
            }
            //liberando recursos
            mysqli_close($cnx);
            mysqli_free_result($rs);
            
        } catch (Exception $ex) {

            try {
                mysqli_close($cnx);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            try {
                mysqli_free_result($rs);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }

        return $storage;
    }

}
