<?php
/*
Plugin Name: Nombre del plugin
Plugin URI: http://miplugin.com/
Description: Éste plugin cambia el título
Version: 1.0
Author: Miguel Zack
Author URI: https://beziercode.com.co
License: GPL
License URI: http://
Text Domain: miplugin-beziercode
Domain Path: /languages/
*/

if( ! function_exists( 'mp_install' )){
    function mp_install(){

    }
}

if( ! class_exists( 'MP_Mi_Class' ) ){
    class MP_Mi_Class{

    }
}

function mp_desactivation(){

}

function mp_desinstall(){
    //borrar tablas de DB
    //quitar configuraciones
    //+ opciones
}

//botones de activar/desactivar plugin
register_activation_hook( __FILE__, 'mp_install');
register_deactivation_hook( __FILE__, 'mp_desactivation');

//boton borrar (después de desactivar)
register_uninstall_hook( __FILE__, 'mp_desinstall');

//se agrega durante la carga de plugins
//tienes q esperar a q "edit_pages" se cargue
if( !function_exists('mp_plugins_cargados')){
    add_action('plugins_loaded','mp_plugins_cargados');
    function mp_plugins_cargados(){

        if( current_user_can('edit_pages') ){    
            if( !function_exists('add_meta_descripction')){
                add_action( 'wp_head','add_meta_description');
                function add_meta_description(){
                    echo "<meta name='description' content='Creación de plugin WP'>";
                }
            }
        }

    }
}

//prueba
add_action("wp_footer", "mfp_Add_Text"); 
// Define 'mfp_Add_Text'
function mfp_Add_Text()
{
  echo "<p style='color: black;'>After the footer is loaded, my text is added!</p>";
}

//validación de datos
$_POST['email'] = 'test@testcom';
$email = $_POST['email'];

if( is_email( $email ) ){
    echo "Este email es correcto";
}else{
    echo "No es correcto";
}

//asegurando entrada de datos
$input = "blabla <?php echo 'hace algo';?>bla bla";
echo sanitize_text_field($input);

//18 dalida de datos
$output = "<a href='".esc_url('file://google.co',['file'])."' title='Google title'> Google</a>";
$html_permitido = [
    'a' => [
        'href' => [],
        'title' => []
    ],
    'p' => [],
    'h3' => []
];
$protocolos = [
    'file'
];
echo wp_kses( $output,$html_permitido,$protocolos);