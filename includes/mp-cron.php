<?php
class MP_Cron {

    public function intervalos( $schedules ) {        
        $schedules['cinco_segundos'] = array(
            'interval' => 5,
            'display'  => 'cada 5 segundos'
        );
        return $schedules;
    }

    public function inicializador() {        
        if ( ! wp_next_scheduled( 'mp_cron' ) ) {
            wp_schedule_event( time(), 'cinco_segundos', 'mp_cron' );// intervalo de tiempo -> hook
        }
    }

    public function evento() {
        echo "ejecutando la tarea del evento!";
    }
}

 $mp_cron = new MP_Cron();

add_filter( 'cron_schedules', [ $mp_cron , 'intervalos' ], 10, 1 );//registra intervalo 
add_action( 'mp_cron', [ $mp_cron , 'evento' ] );// registra hook (mp_cron) y le asigna una función
add_action( 'init', [ $mp_cron , 'inicializador' ] );