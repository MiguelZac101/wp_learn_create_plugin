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

}

$mp_heartbeat = new MP_Heartbeat();

add_filter( 'heartbeat_received', [ $mp_heartbeat , 'recibir_responder' ], 10, 3 );