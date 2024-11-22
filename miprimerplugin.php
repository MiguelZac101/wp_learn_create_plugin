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

//21. Menús de nivel superios
if ( ! function_exists( 'mp_options_page' ) ) {
    add_action( 'admin_menu', 'mp_option_page');
    function mp_option_page(){
        add_menu_page( 
            'Page title',//$page_title:string, 
            'Menu title',//$menu_title:string, 
            'manage_options',//$capability:string, 
            'menu_slug',//$menu_slug:string, 
            'mp_pruebas_page_display',//$callback:callable, 
            null,//'plugin_dir_url( __FILE__).'img/instagram.svg',//$icon_url:string, 
            15//$position:integer|float|null 
        );

        //option ruta a archivo
        add_menu_page( 
            'Page title 2',//$page_title:string, 
            'Menu title 2',//$menu_title:string, 
            'manage_options',//$capability:string, 
            plugin_dir_path( __FILE__ ).'admin/vista.php',//$menu_slug:string, 
            null,//$callback:callable, 
            null,//plugin_dir_url( __FILE__).'img/instagram.svg',//$icon_url:string, 
            15//$position:integer|float|null 
        );

        //22. submenus
        add_submenu_page( 
            'menu_slug',//$parent_slug:string, 
            'page titulo',//$page_title:string, 
            'submenu title',//$menu_title:string, 
            'manage_options',//$capability:string, 
            'submenu_slug',//$menu_slug:string, 
            'mp_submenu_page_display',//$callback:callable, 
            1//$position:integer|float|null 
        );
    }
}

function mp_pruebas_page_display(){
    ?>
    <?php if(current_user_can( 'manage_options' )){ ?>
    <div class="wrap">
        <form action="">
            <input type="text">
            <?php submit_button( 'Enviar' ); ?>
        </form>
    </div>
    <?php }else{
    ?>
    <p>
        No tiene acceso a esta sección.
    </p>
    <?php
    } ?>

    <?php
}

function mp_submenu_page_display(){
    ?>
    <?php if(current_user_can( 'manage_options' )){ ?>
    <div class="wrap">
        <?php 
        $titulo = apply_filters( 'mp_custom_filter', 'ESTAS EN SUBMENU' );
        echo $titulo;
        ?>
        
        <?php do_action( 'mp_custom_hook', 'miguel', 101 ); ?>
    </div>
    <?php }else{
    ?>
    <p>
        No tiene acceso a esta sección.
    </p>
    <?php
    } ?>

    <?php
}

//25.- custom hook
function mp_ch($name,$num){
    echo $name.'-'.$num;
}
add_action( 'mp_custom_hook', 'mp_ch', 10, 2 );

//custom filter
function mp_cf($title){
    return '<h1>'.$title.'</h1>';
}
add_filter( 'mp_custom_filter', 'mp_cf' );