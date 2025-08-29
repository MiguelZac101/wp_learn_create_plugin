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
/*
$_POST['email'] = 'test@testcom';
$email = $_POST['email'];

if( is_email( $email ) ){
    echo "Este email es correcto";
}else{
    echo "No es correcto";
}
*/
//asegurando entrada de datos
/*
$input = "blabla <?php echo 'hace algo';?>bla bla";
echo sanitize_text_field($input);
*/
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
//echo wp_kses( $output,$html_permitido,$protocolos);

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
/*
if( shortcode_exists( 'mp_shortcode_texto' )){
    echo "shortcode existe";
}else{
    echo "shortcode NO existe";
}
*/
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

//35.- Uso de la API Options
//permite guardar/actualizar/eliminar campos personalizados en la tabla [wpdb->prefix]_options -> wp_options

$value = "custom value plugin";
$value_update = "update value plugin";
//add_option registra el campo y valor, solo registra una vez.
add_option('option_custom',$value);
//update_option permite actualizar el valor del campo
update_option('option_custom',$value_update);
//delete_option elimina el campo
//delete_option('option_custom');

//36.- Página de configuración personalizada (Renderizando el formulario)
//crear menú
if ( ! function_exists( 'mp_menu_custom_form' ) ) {
    add_action( 'admin_menu', 'mp_menu_custom_form');
    function mp_menu_custom_form(){
        add_menu_page( 
            'Custom Form',//$page_title:string, 
            'Custom Form',//$menu_title:string, 
            'manage_options',//$capability:string, 
            'custom_form',//$menu_slug:string, 
            'mp_custom_form_display',//$callback:callable, 
            null,//$icon_url:string, 
            13//$position:integer|float|null 
        );        
    }
}
//function callback de su menú
function mp_custom_form_display(){
    ?>
    <?php 
    if(current_user_can( 'manage_options' )){ 
        
        if( isset( $_GET['settings-updated'] ) ){
            //agrega mensaje
            add_settings_error( 'mp_message_updated', 'mp_message_updated', 'Esta configuración se ha guardado correctamente', 'updated' );
        }
        //muestra mensaje 
        settings_errors( 'mp_message_updated' );
        //muestra los datos del error, se puede utilizar para personalizar los mensajes
        echo "<pre>";
        var_dump( get_settings_errors( 'mp_message_updated' ) );
        echo "<pre>";
    ?>
    <div class="wrap">        
        <form action="options.php" method="post">
            <?php 
            //agrega campos necesarios para que wp guarde la información
            settings_fields( 'general' );

            //agrega los campos asignados a page general (realmente no es una página como tal)
            // en el punto 34. Uso de la API Settings, hay una sección registrada sobre la page general, estoy usando esa sección.
            do_settings_sections( 'general' );
            
            submit_button( 'Guardar cambios' ); 
            
            //muestra los campos simples, se puede utilizar para personalizar el formulario
            //los datos son el page y el id de la sección
            //do_settings_fields( 'general', 'mp_config_seccion' );
            ?>
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

//Sección 9 : Custom Post Types
//referencia : https://developer.wordpress.org/reference/functions/register_post_type/

//CPT : son entradas personalizadas, sirven para extender la funcionalidad de wp, por ejemplo puedes agregar un cpt movie para que soporte la carga de peliculas.

/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wpdocs_codex_book_init() {
	$labels = array(
		'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Book', 'textdomain' ),
		'new_item'              => __( 'New Book', 'textdomain' ),
		'edit_item'             => __( 'Edit Book', 'textdomain' ),
		'view_item'             => __( 'View Book', 'textdomain' ),
		'all_items'             => __( 'All Books', 'textdomain' ),
		'search_items'          => __( 'Search Books', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
		'not_found'             => __( 'No books found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'book', $args );
}

add_action( 'init', 'wpdocs_codex_book_init' );

//41.- Gestión de metadatos de una publicación (post)
// metadatos son campos que se agregan en le tabla [wpdb->prefix]->postmeta y estan asociados a un post
//para este ejemplo hay un CPT con id 7
/*
add_post_meta(
    int $post_id,
    string $meta_key,
    mixed $meta_value,
    bool $unique = false // si es true registra varios valores con el mismo campo color->rojo, color->azul, etc
);
*/
add_post_meta( 7, 'color', 'rojo', true  );
/*
update_post_meta(
    int $post_id,
    string $meta_key,
    mixed $meta_value,
    mixed $prev_value = ‘’//este valor tiene que coincidir con el anterior, es como un buscar reemplazar.
);
*/
update_post_meta( 7, 'color', 'azul' );
/*
get_post_meta(
    int $post_id,
    string $meta_key = ‘’,
    bool $single = false// false -> array, true -> single
);
get_post_meta( 7, 'color' );
*/
/*
delete_post_meta(
    int $post_id,
    string $meta_key,
    mixed $meta_value
);
delete_post_meta( 7, 'color', 'azul' );
 */

 /*
 42.- Custom Fields (Campos Personalizados)
	get_post_custom( int $post_id ) -> Retrieves post meta fields, based on post ID.
	get_post_meta( int $post_id, string $key = '', bool $single = false ): mixed -> Retrieves a post meta field for the given post ID.
  */

// 43.- Metaboxes personalizados
//los metaboxes son las cajas que contienen a los customfield cuando registras/editas un cpt
//ejem 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' (la caja que los contiene)
/*
function mp_add_meta_box(){
    add_meta_box(
        'custom_meta_box',//id
        'Datos extra del book',//titulo
        'meta_box_html',//callback
        'book', //name cpt, que esta caja aparesca para estos CPT, puede ser un array de CTP si quieres que aparesca en varios [ post , book]
        'side', //'normal', 'side', and 'advanced'
        'high', //Accepts 'high', 'core', 'default', or 'low'. Default 'default'
        [ 'uno', 'dos' => 1, 2 ] //argumentos que se pueden pasar
    );
}

add_action( 'add_meta_boxes', 'mp_add_meta_box');

function meta_box_html($post, $medatabox){

    var_dump($medatabox); //$medatabox['args'] : argumentos pasados

    $book_detalle = get_post_meta( $post->ID, 'book_detalle' , true );
    $precio = '';
    if( isset( $book_detalle['precio'] ) ){
        $precio = $book_detalle['precio'];
    }
    
    ?>
    <div>
        <label for="precio">Precio</label>
        <input type="text" name="book_detalle[precio]" value="<?php echo $precio; ?>">
    </div>
    <?php

}

function save_meta_box( $post_id ){
    if( array_key_exists( 'book_detalle' , $_POST ) ){
        update_post_meta( $post_id, 'book_detalle', $_POST['book_detalle'] );
    }
}

add_action( 'save_post', 'save_meta_box' );
*/

//44. Agregando un metabox orientado a objetos

abstract class MP_metabox{

    public static function add(){

        add_meta_box(
            'custom_meta_box',//id
            'Datos extra del book',//titulo
            [self::class , 'html'],//callback
            'book', //name cpt, que esta caja aparesca para estos CPT, puede ser un array de CTP si quieres que aparesca en varios [ post , book]
            'side', //'normal', 'side', and 'advanced'
            'high', //Accepts 'high', 'core', 'default', or 'low'. Default 'default'
            [ 'uno', 'dos' => 1, 2 ] //argumentos que se pueden pasar
        );

    }

    public static function html( $post, $metabox ){

        var_dump($metabox); //$metabox['args'] : argumentos pasados

        $book_detalle = get_post_meta( $post->ID, 'book_detalle' , true );
        $precio = '';
        if( isset( $book_detalle['precio'] ) ){
            $precio = $book_detalle['precio'];
        }

        $editor = '';
        if( isset( $book_detalle['editor'] ) ){
            $editor = $book_detalle['editor'];
        }
        
        ?>
        <div>
            <label for="precio">Precio</label>
            <input type="text" name="book_detalle[precio]" value="<?php echo $precio; ?>">
        </div>
        <?php

        wp_editor( $editor, 'book_detalle[editor]', ['media_buttons' => true] );

    }

    public static function save( $post_id ){
        if( array_key_exists( 'book_detalle' , $_POST ) ){
            update_post_meta( $post_id, 'book_detalle', $_POST['book_detalle'] );
        }
    }
}

add_action( 'add_meta_boxes', ['MP_metabox', 'add'] );
add_action( 'save_post', ['MP_metabox', 'save'] );

//46. Encolando un archivo de estilos (.css)
function register_libraries( $hook ) {
    //toplevel_page_[page]
    /*
    if( $hook != 'toplevel_page_custom_form'){
        return;
    }
    */
    wp_register_style( 
        'estilos', 
        plugins_url('admin/css/styles.css',__FILE__), 
        array(), 
        '1.0', 
        'all' 
    );

    //47. Encolando un archivo de Javascript (.js)
    wp_register_script( 
        'script', 
        plugins_url('admin/js/script.js',__FILE__), 
        array('jquery'), //dependencias
        '1.0', 
        true //true en footer 
    );    

}
add_action( 'admin_enqueue_scripts', 'register_libraries' );

//48. Registrando archivos css y javascript
function load_libraries($hook){
    //toplevel_page_custom_form -> toplevel_page_[page] -> page = custom_form    
    /*
    if( $hook != 'toplevel_page_custom_form'){
        return;
    }
    */
    wp_enqueue_style('estilos');
    wp_enqueue_script('script');

    //76. Configurando archivos para el uso de AJAX con jQuery
    wp_localize_script(
        'script', 
        'ajax_object', 
        array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'mp_seg' ),
            'current_user_id' => get_current_user_id()
        )
    );

    //49. Quitando de la cola y de un registro los archivos css y js
    //quitando de la cola
    //wp_dequeue_style('estilos');
    //wp_dequeue_script('script');

    //desregistrando jquery
    //wp_deregister_script( 'jquery' );

    //registrando y encolando nueva version de jQuery
    /*
    wp_register_script( 
        'jquery', 
        'https://code.jquery.com/jquery-3.7.1.min.js'        
    );
    wp_enqueue_script('jquery');
    */

    //desregistrando los estilos
    //wp_deregister_style( 'estilos' );

}
add_action( 'admin_enqueue_scripts', 'load_libraries' );

//51. Registrando una taxonomía para las entradas
define( 'PLUGIN_DIR_PATH' , plugin_dir_path( __FILE__ ) );

require_once PLUGIN_DIR_PATH . 'includes/taxonomias.php';

//57. Agregando un campo de meta para los términos de una taxonomía
//ejem -> https://fullstackdigital.io/blog/add-custom-metadata-to-taxonomy-terms-in-wordpress-without-plugins/
//Mostrar el campo en el formulario de la taxonimia.(Create)
//do_action( “{$taxonomy}_add_form_fields”, string $taxonomy )

add_action('writer_add_form_fields', 'mp_writer_add_form_fields');

function mp_writer_add_form_fields(){
  ?>

  <div class="form-field">
    <label for="mp_pseudonimo">Pseudonimo</label>
    <input name="mp_pseudonimo" id="mp_pseudonimo" type="text" value="">   
    <p id="mp_pseudonimo-description">Pseudonimo del escritor.</p> 
  </div>

<?php }

//Guardar meta-data
add_action('create_writer', 'mp_save_writer_meta');
function mp_save_writer_meta($term_id){
  if(!isset($_POST['mp_pseudonimo'])){
    return;
  }

  update_term_meta( $term_id, 'mp_pseudonimo', sanitize_text_field( $_POST['mp_pseudonimo'] ));
}

//Agregar campo a la vista de edición (Edit)

add_action('writer_edit_form_fields', 'mp_writer_edit_form_fields');

function mp_writer_edit_form_fields($term) { 
  
  $pseudonimo = get_term_meta( $term->term_id, 'mp_pseudonimo', true );
  // The third argument is whether it is singular: true tells it not to return an array, just the one value
  
  ?>
    <tr class="form-field">
			<th scope="row">
                <label for="mp_pseudonimo">Pseudonimo</label>
            </th>
			<td>
                <input name="mp_pseudonimo" id="mp_pseudonimo" type="text" value="<?php echo $pseudonimo ?>">                 
			    <p id="mp_pseudonimo-description">Pseudonimo del escritor.</p>
            </td>
		</tr>
<?php }

//Guardar en el formulario de edición
add_action('edited_writer', 'mp_save_writer_meta');

//59. Creando usuarios - Forma básica
require_once PLUGIN_DIR_PATH . 'includes/mp-usuarios.php';
$mp_usuarios = new MP_usuarios();
add_action( 'init', [$mp_usuarios , 'create'] );

//60. Creando usuarios - Forma compleja
add_action( 'init', [$mp_usuarios , 'create_option_array'] );

//61. Obteniendo información de un usuario
function mp_info_user(){
    $user_id = 3;
    $misha_user = get_userdata( $user_id );
    //echo "<pre>";
    //var_dump($misha_user);
    //echo "</pre>";
    /*
    echo '----Nombre de usuario:'.$misha_user->first_name;
    
    $current_user = wp_get_current_user();//usuario actual
    echo 'Username: ' . $current_user->user_login . '<br />';
    echo 'User email: ' . $current_user->user_email . '<br />';
    echo 'User first name: ' . $current_user->user_firstname . '<br />';
    echo 'User last name: ' . $current_user->user_lastname . '<br />';
    echo 'User display name: ' . $current_user->display_name . '<br />';
    echo 'User ID: ' . $current_user->ID . '<br />';
*/
}

add_action( 'init', 'mp_info_user');

//63. Actualizando usuarios
add_action( 'init', [$mp_usuarios , 'actualizar_usuario'] );

//65. Metadatos de usuarios - Agregando un campo
require_once PLUGIN_DIR_PATH . 'includes/mp-add-metadata-user.php';

//67. Manipulando los roles
require_once PLUGIN_DIR_PATH . 'includes/mp-roles.php';

//73. Funciones para el uso de las peticiones (Parte 1)
//require_once PLUGIN_DIR_PATH . 'includes/mp-http.php';

//76. Configurando archivos para el uso de AJAX con jQuery
//require_once PLUGIN_DIR_PATH . 'includes/mp-ajax.php';

//77. Guardando y obteniendo Metadatos de usuarios en tiempo real
require_once PLUGIN_DIR_PATH . 'includes/mp-social-user.php';

//79. Ejemplo básico del uso del Heartbeat API
require_once PLUGIN_DIR_PATH . 'includes/mp-heartbeat.php';

//80-82. Creando notificación de guardado en tiempo casi real
require_once PLUGIN_DIR_PATH . 'admin/mp-admin.php';
require_once PLUGIN_DIR_PATH . 'includes/mp-online.php';


require_once PLUGIN_DIR_PATH . 'includes/mp-widget.php';