<?php
//76. Configurando archivos para el uso de AJAX con jQuery
class MP_Ajax{
    public function peticion(){
        check_ajax_referer( 'mp_seg', 'nonce' );

        if( isset( $_POST['action'] ) ){
            $nombre = $_POST['nombre']; 
            echo json_encode( ['resultado' => 'Hemos recibido el nombre :'.$nombre] );
            wp_die();
        }
    }

    public function show_btn(){
        echo '<h1>76. Configurando archivos para el uso de AJAX con jQuery</h1>'.
            '<table><tr><td><input type="text" class="nombre"></td</tr></table>'.
            '<button class="peticion">Envíar petición Ajax</button>';
    }
}

$mp_ajax = new MP_Ajax();

add_action( 'wp_ajax_mipeticion', [$mp_ajax , 'peticion'] );

//admin_notices (hook) – This hook is used to display notices to the user in the WordPress admin panel.
add_action( 'admin_notices', [ $mp_ajax , 'show_btn'] );