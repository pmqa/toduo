<?php

$data_inicio = new DateTime( "2016-01-01" );
$data_fim = new DateTime( "2017-01-01" );
$intervalo = new DateInterval( "P1D" );
$periodo = new DatePeriod( $data_inicio, $intervalo, $data_fim );

$calendario = array();
$semana_atual = 0;
$i = 0;

foreach ( $periodo as $data ) {
    $dia_mes = $data->format( "Ymd" );
    $dia_semana = $data->format( "w" );

    if ( $dia_semana != 0 ) {
    $calendario[$semana_atual][$i]['dia_mes'] = $dia_mes;
    $calendario[$semana_atual][$i]['dia_semana'] = $dia_semana;
    $calendario[$semana_atual][$i]['eventos'] = array();
    $i++;
    } else {
    $calendario[$semana_atual][$i]['dia_mes'] = $dia_mes;
    $calendario[$semana_atual][$i]['dia_semana'] = $dia_semana;
    $calendario[$semana_atual][$i]['eventos'] = array();
    $semana_atual++;
    $i = 0;
    }
}
echo json_encode($calendario);
