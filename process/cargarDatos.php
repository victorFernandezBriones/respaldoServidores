<?php

include_once 'datos/Servidor.php';
include_once 'datos/Respaldo.php';
include_once 'process/Zebra_Pagination.php';
$servidorService = new Servidor(); //objeto que servira como servicio conteniendo los metodos 
$respaldoService = new Respaldo(); //objeto que servira como servicio conteniendo los metodos 
////listado de servidores
$servidores = $servidorService->obtenerServidores();
$paginacion = new Zebra_Pagination(); //clase para paginacion
$fechaActual=$respaldoService->formatoFecha($respaldoService->obtenerFechaActual());
$idServer="";
//busqueda pór servidor
if ($_GET['idServidor']) {
    
    $idServer = htmlspecialchars($_GET['idServidor']);
    if ($idServer != "") {
        //paginacion de resultados
        $totalR = $respaldoService->contarRespaldosPorServer($idServer);
        $resultados = 25;

//seteando atributos para el objeto paginacion
        $paginacion->records($totalR); //total de registros en la tabla de la base de datos
        $paginacion->records_per_page($resultados); //registros por pagina
//paginacion dinamica
        $inicio = $paginacion->get_page() - 1; //la pagina que estamos -1
        $inicio*=$resultados; //el resultado lo multiplico por la cantidad de registros, y me da la cantidad de registros a mostrar por hoja


        $respaldosServidores = $respaldoService->obtenerRespaldoPorServer($idServer, $inicio, $resultados);
    } else {
        //paginacion de resultados
        $totalR = $respaldoService->contarRespaldos();
        $resultados = 25;
//seteando atributos para el objeto paginacion
        $paginacion->records($totalR); //total de registros en la tabla de la base de datos
        $paginacion->records_per_page($resultados); //registros por pagina
//paginacion dinamica
        $inicio = $paginacion->get_page() - 1; //la pagina que estamos -1

        $inicio*=$resultados; //el resultado lo multiplico por la cantidad de registros, y me da la cantidad de registros a mostrar por hoja
        $respaldosServidores = $respaldoService->obtenerServidoresRespaldo($inicio, $resultados); //obteniendo resultados
    }
} else {
    //paginacion de resultados
    $totalR = $respaldoService->contarRespaldos();
    $resultados = 25;
//seteando atributos para el objeto paginacion
    $paginacion->records($totalR); //total de registros en la tabla de la base de datos
    $paginacion->records_per_page($resultados); //registros por pagina
//paginacion dinamica
    $inicio = $paginacion->get_page() - 1; //la pagina que estamos -1
    $inicio*=$resultados; //el resultado lo multiplico por la cantidad de registros, y me da la cantidad de registros a mostrar por hoja
    $respaldosServidores = $respaldoService->obtenerServidoresRespaldo($inicio, $resultados); //obteniendo resultados
}







