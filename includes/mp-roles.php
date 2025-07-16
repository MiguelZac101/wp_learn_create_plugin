<?php
class MP_Roles{

    public function add_custom_rol(){

        $wp_roles = new WP_Roles;
        $capabilities = array(
            'read'         => true,  // true allows this capability
            'edit_posts'   => true,
            'delete_posts' => false, // Use false to explicitly deny
            'mailing_masivos' => true //capacidad personalizada
        );

        //agregas un nuevo rol
        $wp_roles->add_role( 'rolstar', 'Rolstar', $capabilities );

        //consigues un rol
        $rolstar = $wp_roles->get_role( 'rolstar' );

        //validad si el usuario tiene esa capabilities
        if( current_user_can( 'mailing_masivos' )){
            //mostrar page admin
        }

        //eleminar rol
        //$wp_roles->remove_role( 'rolstar' );

        //68. Manipulando el rol de un usuario
        /*
        $user = new WP_User(2);
        $user->add_rol( 'contributor' ); //agrega rol
        $user->set_rol( 'new_rol' ); //reemplaza el rol existente por este nuevo.
        $user->roles //muestra todos los roles asociados al usuario
        $user->allcpas //muestra todas las capacidades del usuario
        */

    }

}

$roles = new MP_Roles();
add_action( 'init', [ $roles , 'add_custom_rol'] );