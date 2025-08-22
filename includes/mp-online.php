<?php
 class MP_Online{
    
    public function conectado( $username , $user ){
        if( $user->has_cap( 'administrator' ) ){
            update_user_meta( $user->ID, 'mp_online', 'true');
        }
    }

    public function desconectado( $user_id ){                
        $user = new WP_User($user_id);

        if( $user->has_cap( 'administrator' ) ){
            update_user_meta( $user->ID, 'mp_online', 'false');
        }
    }

 }

 $mp_online = new MP_Online();

 add_action( 'wp_login', [$mp_online , 'conectado'], 10, 2 );
 add_action( 'wp_logout', [$mp_online , 'desconectado'] );
 