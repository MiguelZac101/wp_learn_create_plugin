<?php
class MP_Http {
    public function show(){
        echo "MP_Http<br>";
        $response = wp_remote_get( 'https://api.github.com/users/wordpress' );

        //$response = wp_remote_retrieve_body( $response );// selecciona solo el body

        $response = wp_remote_retrieve_response_code( $response );// selecciona el response 

        //echo "<pre>";
        var_dump($response);
        //echo "</pre>";
    }
}

$mp_http = new MP_Http();
//$mp_http->show();

//admin_notices (hook) – This hook is used to display notices to the user in the WordPress admin panel.
add_action( 'admin_notices', [ $mp_http , 'show'] );