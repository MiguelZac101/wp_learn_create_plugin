<?php
/*
Plugin Name: Nombre del plugin
Plugin URI: http://miplugin.com/
Description: Éste plugin cambia el título
Version: 1.0
Author: Gilbert Rodríguez
Author URI: https://beziercode.com.co
License: GPL
License URI: http://
Text Domain: miplugin-beziercode
Domain Path: /languages/
*/

function mp_install(){

}

function mp_desactivation(){

}

//botones de activar/desactivar plugin
register_activation_hook( __FILE__, 'mp_install');
register_desactivation_hook( __FILE__, 'mp_desactivation');