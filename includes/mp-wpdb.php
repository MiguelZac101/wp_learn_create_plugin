<?php
class MP_Wpdb{

    public function show(){
        echo "<h1>Sección 19: Interactuando con la base de datos ( \$wpdb - Instancia Objeto global )</h1>";
        
        global $wpdb;
        $tabla = "{$wpdb->prefix}users";
        $sql = "select * from $tabla";

        //106. Consulta de variable, fila y columna específica
        //$resultado = $wpdb->get_var($sql,1,2);//(consulta, columna , fila) . empieza en cero. devuelve una celda.
        //$resultado = $wpdb->get_row($sql);//devuelve una fila. (consulta, tipo columna, fila)
        //$resultado = $wpdb->get_col($sql,2);//devuelve la columna entera, (sonsulta, columna)

        //107. Consultas predefinidas
        //OBTENER RESULTADOS
        //$resultado = $wpdb->get_results($sql, OBJECT);//OBJECT, OBJECT_K, ARRAY_A, ARRAY_N. OBJECT_K:indice empieza en 1.

        //INSERTAR (ejemplo)
        /*
        $data = [
            'id' => null,
            'nombre' => 'John',
            'apellido' => 'Doe',
            'telefono'  => 123456789
        ];
        %f -> float, %s -> string, %d -> integer (formato de celda)
        $format = [
            %d,
            %s,
            %s,
            %s
        ];
        $wpdb->insert($table_name,$data,$format);
        */

        //REEMPLAZAR (inserta o reemplaza dependiendo si encuentra el id)
        //$wpdb->replace($table_name,$data,$format);

        //UPDATE (example)
        /*
        $data = [ 'nombres' => 'Mario' ]; 
        $format = [ %s ];  
        $where = [ 'id' => 5 , 'nombre' => 'Pedro' ]; // WHERE clause.
        $where_format = [ %d , %s ];  
        $wpdb->update( $wpdb->prefix . 'users', $data, $where, $format, $where_format );
        */

        //DELETE
        /*
        $where = [ 'id' => 5 , 'nombre' => 'Pedro' ]; // WHERE clause.
        $where_format = [ %d , %s ]; 
        $wpdb->delete( $wpdb->prefix . 'users',  $where,  $where_format )
        */

        //108. Consultas generales
        /*
        $resultado = $wpdb->query($sql);
        echo '<pre>';
        var_dump($wpdb->last_result);
        echo '</pre>';
        */

        //109. Preparando consultas ( Protección contra ataques de inyección SQL )
        $data = [ 6, 'miguel'];
        $sql = $wpdb->prepare("select * from $tabla where id=%d or nombre =%s ", $data); echo $sql;        
        $resultado = $wpdb->get_results($sql);

        //110. Mostrando u ocultando errores
        /*
        $wpdb->show_errors();
        $wpdb->hide_errors();
        $wpdb->print_error();
        */

        //111. Obteniendo información de las columnas y limpiando la caché de resultados
        //$wpdb->get_col_info('type', offset);
        //$wpdb->flush(); -> Esto borra $wpdb->last_result, $wpdb->last_query y $wpdb->col_info.

        //112. Propiedades del objeto
        /*
        La instancia global $ wpdb puede acceder a las siguientes variables:

        $show_errors Indica si la repetición de errores está activada o no. El valor predeterminado es VERDADERO.
        $num_queries El número de consultas que se han ejecutado.
        $last_query La consulta más reciente que se ha ejecutado.
        $last_error El texto de error más reciente generado por MySQL.
        $queries : Puede guardar todas las consultas ejecutadas en la base de datos y sus tiempos de detención estableciendo la constante SAVEQUERIES en VERDADERO (el valor predeterminado es FALSO). Si SAVEQUERIES es VERDADERO, sus consultas se almacenarán en esta variable como una matriz.
        $last_result Los resultados de la consulta más reciente.
        $col_info: Información de la columna correspondiente a los resultados de la consulta más reciente. Consulte Obtener información de columnas.
        $insert_id ID generado para una columna AUTO_INCREMENT por la consulta INSERT más reciente.
        $num_rows El número de filas devueltas por la última consulta.
        $prefix El prefijo de tabla de WordPress asignado para el sitio.
        $base_prefix El prefijo original, tal como se define en wp-config.php. Para sitios múltiples: Úselo si desea obtener el prefijo sin el número de blog.
        */

        echo '<pre>';
        var_dump($resultado);
        echo '</pre>';
    }
}

$mp_wpdb = new MP_Wpdb();

add_action( 'admin_notices', [ $mp_wpdb , 'show'] );