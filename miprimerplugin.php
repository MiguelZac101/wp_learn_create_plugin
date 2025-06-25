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

//20.- Nonces
if( !function_exists('mp_menu_nonce') ){
    add_action( 'admin_menu', 'mp_menu_nonce');
    function mp_menu_nonce() {
        add_menu_page( 
            'Page title -> nonce',//$page_title:string, 
            'Menu -> nonce',//$menu_title:string, 
            'manage_options',//$capability:string, 
            'menu_slug_nonce',//$menu_slug:string, 
            'mp_form_nonce',//$callback:callable, 
            null,//'plugin_dir_url( __FILE__).'img/instagram.svg',//$icon_url:string, 
            14//$position:integer|float|null 
        );
    }
}

if( !function_exists('mp_form_nonce') ) {
    function mp_form_nonce(){
        if( current_user_can( 'edit_others_posts' )){
            $nonce = wp_create_nonce( 'mi_nonce' );
            //echo $nonce;
            if( isset($_POST['nonce']) && !empty($_POST['nonce'])){
                if( wp_verify_nonce( $_POST['nonce'], 'mi_nonce' )){
                    echo "nonce verificado!";
                }else{
                    echo "el nonce no fue recibido o no es correcto";
                }
            }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="nonce" value="<?php echo $nonce; ?>">
            <input type="text" name="eliminar" value="eliminar">
            <button type="submit">eliminar</button>
        </form>
        <?php
        
    }
}

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

//30.- Shortcode básicos
function mp_shortcode_basic(){
    return "Mi primer shortcode";
}
add_shortcode( 'mp_shortcode_texto', 'mp_shortcode_basic' );

//remove_shortcode( 'mp_shortcode_texto' );

if( shortcode_exists( 'mp_shortcode_texto' )){
    echo "shortcode existe";
}else{
    echo "shortcode NO existe";
}

//31.- shortcode con contenido
function mp_shortcode_contenido($attr,$contenido){
    //return "<p>$contenido</p>";
    //rederizar shortcode dentro de otro
    return "<p>".do_shortcode($contenido)."</p>";
}
add_shortcode( 'mp_shortcode_p', 'mp_shortcode_contenido' );
//[mp_shortcode_p] texto ejemplo [/mp_shortcode_p]

//32.- shortcode con parámetros
function mp_button( $attr_new, $contenido ){
    $attr_default = [
        'texto' => 'Por favor coloca algún texto',
        'url'   => '#'
    ];
    $attr_new = array_change_key_case( (array)$attr_new, CASE_LOWER );
    $attr_new = shortcode_atts( $attr_default, $attr_new );

    return "<a href='{$attr_new['url']}'>{$attr_new['texto']}</a>";
}
/*
[mi_shortcode atributo1='valor' atributo2='valor']
Contenido
[/mi_shortcode]
*/

//34. Uso de la API Settings
// la idea es agregar campos dentro de los formularios de ajustes.

function mp_settings_init(){
    //registrando una nueva configuración en la página "general"
    register_setting('general','mp_miprimera_configuracion');// es el nombre de un nuevo campo

    //registrando una nueva sección en la página "general"
    add_settings_section(
        'mp_config_seccion',//id
        'M primera configuración',//titulo
        'mp_config_seccion_cb',//callback
        'general'//page
    );

    add_settings_field(
        'mp_config_campo1',//id
        'Configuración 1',//titulo
        'mp_config_campo_cb',//callback
        'general',//page
        'mp_config_seccion',//callable section -> id section
        [
            'label_for' => 'mp_campo_1',
            'class' => 'class_field',
            'mp_dato_personalizado' => 'valor personalizado 1'
        ]
    );

    add_settings_field(
        'mp_config_campo2',//id
        'Configuración 2',//titulo
        'mp_config_campo_cb',//callback
        'general',//page
        'mp_config_seccion',//callable section -> id section
        [
            'label_for' => 'mp_campo_2',
            'class' => 'class_field',
            'mp_dato_personalizado' => 'valor personalizado 2'
        ]
    );

}

add_action( 'admin_init', 'mp_settings_init' );

function mp_config_seccion_cb(){
    echo "<p>Sección mi primera configuración</p>";
}

function mp_config_campo_cb($args){
    $mpconfig = get_option('mp_miprimera_configuracion');

    $valor = isset($mpconfig[$args['label_for']])? esc_attr($mpconfig[$args['label_for']]):'';

    $html = "<input class='{$args['class']}' data-custom='{$args['mp_dato_personalizado']}' type='text' name='mp_miprimera_configuracion[{$args['label_for']}]' value='$valor'>";
    echo $html;
}