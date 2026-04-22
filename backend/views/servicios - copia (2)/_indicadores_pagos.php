<?php

 $fecha_actual= date('Y-m-d');
 $fecha_actual_f= date('d-m-Y');
 $year_actual= date('Y');
 $connection = \Yii::$app->db;

      //Cantidad de Servicios por agendar
      $command = $connection->createCommand("select count(*) as agendar from servicios where id_estatus=8 
      and EXTRACT(YEAR FROM fecha_registro) = ".$year_actual.";");
      $row = $command->queryone(); 

      // Total de la deuda exigible

      $command = $connection->createCommand("select count(*) as agendar from servicios where id_estatus=4
      and tipo_servicio=".$tipo);
      $agendar = $command->queryOne(); 

 //var_dump("SELECT codigo_credito, PRIMER_FONGAR FROM vsw_edo_cuenta WHERE codigo_credito=". $serial_credito);
      $muestra=1;
    // Total de pagos para la fecha

    $command = $connection->createCommand("select count(*) as cancelados, sum(monto) as monto 
    from servicios where id_estatus=7 and tipo_servicio=".$tipo);
      $monto_pagado = $command->queryOne(); 

?>

    <div class="box-body">
      <div class="row">
        <?php if ($muestra==1){ ?>
          <div class="col-lg-4 col-xs-10">
            <div class="small-box bg-yellow">
              <!-- <div class="small-box bg-aqua"> -->
                <div class="inner">
                  <h4> Record de Servicios (<?=date('Y')?>)</h4>
                  <h3><?php
                  echo number_format($row['agendar'], 0, ',', '.');?>
                </h3>

              </div>
              <div class="icon">
                <i class="icofont-megaphone-alt"></i>
              </div>
            </div>
          </div>
      <?php } ?>
        <div class="col-lg-4 col-xs-10">
          <div class="small-box bg-red">
          <!-- <div class="small-box bg-aqua"> -->
            <div class="inner">
              <h4> Servicios por agendar </h4>
              <h3><?php
                echo number_format($agendar['agendar'], 0, ',', '.');?>
              </h3>
             
            </div>
            <div class="icon">
              <i class="icofont-listing-box"></i>
            </div>
          </div>
        </div>
    
        <div class="col-lg-4 col-xs-10">
          <div class="small-box bg-green">
            <div class="inner">
              <h4> Pagos confirmado para la fecha: <?=date('d-m-Y');?></h4>
              <h3><?php
                echo number_format($monto_pagado['monto'], 2, ',', '.')." $.";?>
              </h3>
              
            </div>
            <div class="icon">
              <i class="icofont-pay"></i>
            </div>
          </div>
        </div>
      </div>
    </div>