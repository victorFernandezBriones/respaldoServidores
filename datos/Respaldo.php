<?php

include_once 'Conexion.php';

/**
 * Description of Respaldo
 *
 * @author Victor Fernandez Briones
 */
class Respaldo {

    private $idRespaldo;
    private $fechaRegistro;
    private $codServidor;
    private $codLugarRespaldo;
    private $totalDisco;
    private $usadoDisco;
    private $disponibleDisco;
    private $respaldado;
    private $totalStorage;
    private $usadoEstorage;
    private $libreStorage;
    private $porcentajeUso;

    public function __construct() {
        
    }

    function getPorcentajeUso() {
        return $this->porcentajeUso;
    }

    function setPorcentajeUso($porcentajeUso) {
        $this->porcentajeUso = $porcentajeUso;
    }

    function getIdRespaldo() {
        return $this->idRespaldo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getCodServidor() {
        return $this->codServidor;
    }

    function getCodLugarRespaldo() {
        return $this->codLugarRespaldo;
    }

    function getTotalDisco() {
        return $this->totalDisco;
    }

    function getUsadoDisco() {
        return $this->usadoDisco;
    }

    function getDisponibleDisco() {
        return $this->disponibleDisco;
    }

    function getRespaldado() {
        return $this->respaldado;
    }

    function getTotalStorage() {
        return $this->totalStorage;
    }

    function getUsadoEstorage() {
        return $this->usadoEstorage;
    }

    function getLibreStorage() {
        return $this->libreStorage;
    }

    function setIdRespaldo($idRespaldo) {
        $this->idRespaldo = $idRespaldo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function setCodServidor($codServidor) {
        $this->codServidor = $codServidor;
    }

    function setCodLugarRespaldo($codLugarRespaldo) {
        $this->codLugarRespaldo = $codLugarRespaldo;
    }

    function setTotalDisco($totalDisco) {
        $this->totalDisco = $totalDisco;
    }

    function setUsadoDisco($usadoDisco) {
        $this->usadoDisco = $usadoDisco;
    }

    function setDisponibleDisco($disponibleDisco) {
        $this->disponibleDisco = $disponibleDisco;
    }

    function setRespaldado($respaldado) {
        $this->respaldado = $respaldado;
    }

    function setTotalStorage($totalStorage) {
        $this->totalStorage = $totalStorage;
    }

    function setUsadoEstorage($usadoEstorage) {
        $this->usadoEstorage = $usadoEstorage;
    }

    function setLibreStorage($libreStorage) {
        $this->libreStorage = $libreStorage;
    }

//-----METODOS------//
    public function obtenerTodosLosServidores() {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sqlStorage = "SElECT * FROM respaldos";
            $rs = mysqli_query($cnx, $sqlStorage);
            $servidores = array();

            while ($ser = mysqli_fetch_array($rs)) {
                array_push($servidores, $ser);
            }

            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
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

    public function obtenerServidoresRespaldo($inicio, $limite) {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sql = "SELECT id_server,s.nombre_server,s.ip_server,r.id_respaldo,DATE_FORMAT(r.fecha_registro,'%d-%m-%Y %T')as fecha_registro,r.cod_servidor,r.cod_lugar_respaldo,"
                    . "r.total_disco,r.usado_disco,r.disponible_disco,r.respaldado,r.total_storage,r.usado_estorage,r.libre_storage,r.porcentaje_uso,"
                    . "st.detalle_storage FROM servidores s,respaldos r,storage st WHERE s.id_server=r.cod_servidor AND r.cod_lugar_respaldo=st.id_storage"
                    . " ORDER BY r.fecha_registro DESC LIMIT $inicio,$limite";
            $servRespaldo = array();
            $rs = mysqli_query($cnx, $sql);


            while ($r = mysqli_fetch_array($rs)) {
                array_push($servRespaldo, $r);
            }


            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $servRespaldo;
    }

    public function obtenerRespaldoPorServer($idServer, $inicio, $limite) {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sql = "SELECT s.id_server,s.nombre_server,s.ip_server,r.id_respaldo,DATE_FORMAT(r.fecha_registro,'%d-%m-%Y %T')as fecha_registro,r.cod_servidor,r.cod_lugar_respaldo,"
                    . "r.total_disco,r.usado_disco,r.disponible_disco,r.respaldado,r.total_storage,r.usado_estorage,r.libre_storage,r.porcentaje_uso,"
                    . "st.detalle_storage FROM servidores s,respaldos r,storage st WHERE s.id_server=r.cod_servidor AND r.cod_lugar_respaldo=st.id_storage AND s.id_server='$idServer'"
                    . " ORDER BY r.fecha_registro DESC LIMIT $inicio,$limite";
            $servRespaldo = array();
            $rs = mysqli_query($cnx, $sql);

            while ($r = mysqli_fetch_array($rs)) {
                array_push($servRespaldo, $r);
            }


            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $servRespaldo;
    }

    public function contarRespaldosPorServer($idServer) {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sql = "SELECT COUNT(*) as total FROM respaldos WHERE cod_servidor='$idServer'";
            $totalR = 0;
            $rs = mysqli_query($cnx, $sql);


            while ($r = mysqli_fetch_array($rs)) {
                $totalR = $r['total'];
            }


            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $totalR;
    }

    public function contarRespaldos() {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sql = "SELECT COUNT(*) as total FROM respaldos";
            $totalR = 0;
            $rs = mysqli_query($cnx, $sql);


            while ($r = mysqli_fetch_array($rs)) {
                $totalR = $r['total'];
            }


            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $totalR;
    }

    /**
     * 
     * @param int $idServidor id del servidor
     * @param date $fechaRespaldo fecha para obtener el respaldo
     * @return Respaldo Retorna un objeto respaldo de acuerdo a los parametros ingresados
     * @throws RuntimeException
     */
    public function ultimoRespaldoPorServidor($idServidor, $fechaRespaldo) {
        try {
            $serviceCnx = new Conexion();
            $cnx = $serviceCnx->conectar();
            $sql = "SELECT * FROM respaldos WHERE fecha_registro <= ADDDATE('$fechaRespaldo', INTERVAL 1 DAY)"
                    . " AND cod_servidor='$idServidor' ORDER BY fecha_registro DESC LIMIT 1 ";
            $rs = mysqli_query($cnx, $sql);

            while ($r = mysqli_fetch_array($rs)) {
                $respaldo = new Respaldo();
                $respaldo->setIdRespaldo($r['id_respaldo']);
                $respaldo->setFechaRegistro($r['fecha_registro']);
                $respaldo->setCodServidor($r['cod_servidor']);
                $respaldo->setCodLugarRespaldo($r['cod_lugar_respaldo']);
                $respaldo->setTotalDisco($r['total_disco']);
                $respaldo->setUsadoDisco($r['usado_disco']);
                $respaldo->setPorcentajeUso($r['porcentaje_uso']);
                $respaldo->setDisponibleDisco($r['disponible_disco']);
                $respaldo->setRespaldado($r['respaldado']);
                $respaldo->setTotalStorage($r['total_storage']);
                $respaldo->setUsadoEstorage($r['usado_estorage']);
                $respaldo->setLibreStorage($r['libre_storage']);
            }

            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);

            return $respaldo;
        } catch (Exception $ex) {
            throw new RuntimeException("Error en el metodo ultimoRespaldoPorServidor() en datos/Respaldo.php", $ex->getMessage());
        }
    }

    public function obtenerFechaActual() {
        try {
            $conexion = new Conexion();
            $cnx = $conexion->conectar();
            $sql = "SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') as fecha";

            $rs = mysqli_query($cnx, $sql);


            while ($r = mysqli_fetch_array($rs)) {
                $fecha = $r['fecha'];
            }


            //liberando recursos
            mysqli_free_result($rs);
            mysqli_close($cnx);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $fecha;
    }

    //formato fecha
    function formatoFecha($fecha) {
        $anio = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);

        $fechaFinal = $dia . "-" . $mes . "-" . $anio;

        return $fechaFinal;
    }

    function formatoFechaGuardarDB($fecha) {
        $anio = substr($fecha, 6, 4);
        $mes = substr($fecha, 3, 2);
        $dia = substr($fecha, 0, 2);

        $fechaFinal = $anio . "-" . $mes . "-" . $dia;
        return $fechaFinal;
    }

}
