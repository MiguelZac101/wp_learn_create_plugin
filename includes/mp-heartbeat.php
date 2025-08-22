<?php
class MP_Heartbeat {

    public function recibir_responder( $response , $data, $screen_id ){

        if( !empty($data['mp_heartbeat']) && isset($data['mp_heartbeat'])){

            $mp_heartbeat = $data['mp_heartbeat'];

            if( $data['mp_heartbeat']['enviando'] == 'true' ){
                update_option( 'mp_text', $data['mp_heartbeat']['text'] );
                
            }else{
                $mp_text = get_option('mp_text' , false);
                $mp_heartbeat['text'] = ( $mp_text != false ) ? $mp_text : '';
            }

            $response['msg'] = $mp_heartbeat;            

        }

        return $response;

    }

    public function notificacion( $response , $data, $screen_id ){

        if( !empty($data['mp_notificacion']) && isset($data['mp_notificacion'])){

            extract( $data , EXTR_OVERWRITE);

            $current_user_id = (int) $mp_notificacion['current_user_id'];
            $actualizado = $mp_notificacion['actualizado'];
            $user_update_id = (int) $mp_notificacion['user_update'];

            //verificar q actualizado sea true para notificar a los usuarios
            if( $actualizado == 'true' ){                
                $args = [
                    'meta_key' => 'mp_online',
                    'exclude' => [
                        $current_user_id
                    ]
                ];
                $usuarios = get_users($args);

                foreach ($usuarios as $usuario) {
                    if( $usuario->mp_online == 'true'){
                        $datos = [
                            'user_actualizador_id' => $current_user_id,
                            'user_update_id' => $user_update_id,
                            'notificar' => true
                        ];

                        update_user_meta( $usuario->ID, 'mp_notificacion', $datos );
                    }
                }
            }elseif ( $actualizado == 'false' ) {

                $current_user = new WP_User( $current_user_id );

                if( $current_user->has_prop('mp_notificacion')){
                    $user_actualizador_id = $current_user->mp_notificacion['user_actualizador_id'];
                    $user_actualizador = new WP_User($user_actualizador_id);
                    $user_update = new WP_User($current_user->mp_notificacion['user_update_id']);
                    $notificar = $current_user->mp_notificacion['notificar'];

                    if($notificar == 'true'){
                        $response['mp_notificacion'] = 'true';
                        $response['actualizador'] = [
                            'display_name' => $user_actualizador->display_name,
                            'avatar' => get_avatar_url( $user_actualizador_id )
                        ];
                        $response['user_updated'] = [
                            'display_name' => $user_update->display_name
                        ];
                        $datos = [
                            'notificar' => 'false'
                        ];
                        update_user_meta( $current_user_id, 'mp_notificacion', $datos );
                    }else{
                        $response['mp_notificacion'] = 'false';
                    }
                }
            }                  
        }
        return $response;
    }    
}

$mp_heartbeat = new MP_Heartbeat();

add_filter( 'heartbeat_received', [ $mp_heartbeat , 'recibir_responder' ], 10, 3 );
add_filter( 'heartbeat_received', [ $mp_heartbeat , 'notificacion' ], 10, 3 );