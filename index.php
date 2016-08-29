<!DOCTYPE html>
<?php include_once 'process/cargarDatos.php' ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="SHORTCUT ICON" href="presentacion/media/LogoAxioma.jpg" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="presentacion/bootstrap-3.3.6-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="presentacion/estiloApp.css" />
        <title>Respaldo Servidor</title>
    </head>
    <body>
        <header>
            <br/>
            <div class="row">
                <div class="col-sm-8">
                    <div id="divImagen">
                        <img alt="Imagen logo axioma" src="presentacion/media/logoAxiomaOficial.png">
                    </div> 
                </div>               
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!--banner -->
                    <div class="canvasLogo">                
                        <h3 class="textBanner">
                            REGISTRO RESPALDO SERVIDORES - AXIOMA INGENIEROS CONSULTORES                    
                        </h3>
                    </div>
                </div>
            </div>
        </header>
        <div id="divReporte">
            <div class="row">
                <div class="col-md-6 col-md-offset-4">
                    <form method="GET" action="process/procesarGenerarReporte.php" target="_blank" class="form-inline">
                        <div class="form-group">
                            <label for="fechaReporte">Fecha Reporte</label>
                            <input type="text" class="form-control" id="fechaReporte" name="fechaReporte" value="<?php echo $fechaActual; ?>">
                        </div>
                        <div class="form-group">                       
                            <input id="btnGenerarReporte" type="submit" value="Generar reporte" class="btn btn-success">
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-4 col-md-offset-4">
                <form id="formFiltroServer" action="index.php" method="GET">
                    <h4>Filtro por servidor</h4>
                    <select class="form-control" id="idServidor" name="idServidor" onchange="document.forms['formFiltroServer'].submit();">
                        <option value="">Seleccione</option>
                        <?php foreach ($servidores as $s) : ?>
                            <option value="<?php echo $s['id_server'] ?>"  <?php echo $idServer == $s['id_server'] ? "selected" : "" ?>><?php echo $s['nombre_server'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
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
                            <?php foreach ($respaldosServidores as $r): ?>
                                <tr>                                    
                                    <td>
                                        <?php echo $r['nombre_server']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['ip_server']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['fecha_registro']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['total_disco']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['porcentaje_uso']; ?>
                                    </td>

                                    <td>
                                        <?php echo $r['usado_disco']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['disponible_disco']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['respaldado']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['total_storage']; ?>
                                    </td>                                   
                                    <td>
                                        <?php echo $r['usado_estorage']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['libre_storage']; ?>
                                    </td>
                                    <td>
                                        <?php echo $r['detalle_storage']; ?>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?> 
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-offset-5">
                <?php $paginacion->render(); ?>
            </div>
        </div>

        <script src="presentacion/jquery/jquery-1.12.0.min.js"></script>
        <script src="presentacion/jquery/jquery-ui.js"></script>
        <script src="presentacion/jquery/cargarCalendario.js"></script>
   
    </body>

</html>
