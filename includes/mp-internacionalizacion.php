<?php
class MP_Internacionalizacion{

    public function example(){
        echo "<h1>MP_Internacionalizacion</h1>";

        //echo __('mi ciudad','miprimerplugin');
        //_e('mi ciudad','miprimerplugin');//con echo

        $ciudad1 = 'lima'; $ciudad2 = 'cuzco';
        //%2$s : %2 posición 2, $s variable
        printf( __('mi ciudad es %2$s y %1$s','miprimerplugin') , $ciudad1, $ciudad2);echo '<br/>';        
        
        //plurales básicos
        $conteo = 1;
        printf( _n('%s mensaje','%s mensajes',$conteo,'miprimerplugin'), $conteo);echo '<br/>';

        //94. desambiguación por contexto (traducción para lo mismo según el contexto)
        _ex('post link', 'a link to the post','miprimerplugin');echo '<br/>';
        _ex('post link', 'submit a link','miprimerplugin');echo '<br/>';

        //95. Agregando comentarios a las traducciones (/* Translators: */)
        /* translators: formato de fecha guardado */
        __('l jS F y','miprimerplugin');

        //con un plugin como locotranslate se puede generar el pot po mo
    }

}

$mp_inter = new MP_Internacionalizacion();


add_action( 'admin_notices', [ $mp_inter , 'example'] );