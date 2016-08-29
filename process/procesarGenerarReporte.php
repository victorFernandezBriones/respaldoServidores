<?php

require_once '../datos/Servidor.php';
require_once '../datos/Respaldo.php';
require_once '../datos/Storage.php';
require_once '../datos/MPDF57/mpdf.php';

$servidorService = new Servidor(); //objeto que servira como servicio conteniendo los metodos 
$respaldoService = new Respaldo(); //objeto que servira como servicio conteniendo los metodos 
$storageService = new Storage();

$fechaReporte = $respaldoService->formatoFechaGuardarDB($_GET['fechaReporte']);
//imprimir reporte
if (isset($_GET)) {

    $html = '<header>
            <br/>
            <div class="row">
                <div class="col-sm-8">
                    <div id="divImagen">
                        <img alt="Imagen logo axioma" src="../presentacion/media/logoAxiomaOficial.png">
                    </div>
                    <div id="fechaRegistro">
                    <label >Fecha:__/__/____ </label>
               
                    </div>
                </div>
               
                   
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!--banner -->
                    <div class="canvasLogo">                
                        <h3 class="textBanner">
                            REGISTRO RESPALDO SERVIDORES - AXIOMA INGENIEROS CONSULTORES <br/> RP-120-42                  
                        </h3>
                    </div>
                </div>
            </div>
        </header>
        <div id="divTablaResult" class="table-responsive">
             <table class="tabla table-hover">
              <thead>
               <tr>
               <th>Nombre Host</th>
               <th>Direcci&oacute;n</th>
               <th>Fecha respaldo</th>
               <th>Disco local total</th>
               <th>Porcentaje uso</th>
               <th>Disco local usado</th>
               <th>Disco local libre</th>
               <th>Respaldado</th>
               <th>Total Storage</th>                               
               <th>Usado storage</th>
               <th>Libre storage</th>
               <th>Lugar Respaldo</th>
              </tr>
             </thead>
             <tbody>
            ';


    $servidores = $servidorService->obtenerServidores();
    foreach ($servidores as $s) {
        $respaldo = new Respaldo();
        $respaldo = $respaldoService->ultimoRespaldoPorServidor($s['id_server'], $fechaReporte);

        if ($respaldo != NULL) {
            $storage = $storageService->obtenerStoragePorId($respaldo->getCodLugarRespaldo());
            $html.= "<tr>"
                    . "<td>"
                    . $s['nombre_server']
                    . "</td>"
                    . "<td>"
                    . $s['ip_server']
                    . "</td>"
                    . "<td>"
                    . $respaldo->getFechaRegistro()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getTotalDisco()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getPorcentajeUso()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getUsadoDisco()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getDisponibleDisco()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getRespaldado()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getTotalStorage()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getUsadoEstorage()
                    . "</td>"
                    . "<td>"
                    . $respaldo->getLibreStorage()
                    . "</td>"
                    . "<td>"
                    . $storage->getDetalleStorage()
                    . "</td>"
                    . "</tr>";
        }
    }

    $html.="</tbody>"
            . "</table>"
            . "<table style='margin-left:20%;margin-top:20%;'>"
            . "<tr>"
            . "<td colspan='2'>"
            . "___________________"
            . "</td>"
            . "<td class='colorBlanco' colspan='4'>"
            . "___________________"
            . "</td>"
            . "<td colspan='2'>"
            . "___________________"
            . "</td>"
            . "</tr>"
            . "<tr>"
            . "<td colspan='2'>"
            . "Revisado:"
            . "</td>"
            . "<td class='colorBlanco' colspan='4'>"
            . "___________________"
            . "</td>"
            . "<td colspan='2'>"
            . "Validado:"
            . "</td>"
            . "</tr>"
            . "</table>"
            . "</div>";

    $pdf = new mPDF();
    $css = file_get_contents("../presentacion/estiloApp.css");
    $pdf->WriteHTML($css, 1);
    $pdf->WriteHTML($html);

    $pdf->Output("reporte.pdf", 'I');
}

