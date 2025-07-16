<?php
class MP_Capabilities{
    //69. Manipulando las capacidades de un rol
    public function edit_cap_rol(){
        
        //69. Manipulando las capacidades de un rol

        $wp_roles = new WP_Roles();
        $rolstar = $wp_roles->get_rol('rolstar');

        //$wp_roles->add_cap('rolstar','mailing_masivos');
        //$wp_roles->remove_cap('rolstar','mailing_masivos');

        $rolstar->add_cap('mailing_masivos');

        //$rolstar->remove_cap('mailing_masivos');

        var_dump($rolstar->capabilities);
    }

    //70. Manipulando las capacidades de un usuario
    public function edit_cap_user(){
        $user = new WP_User(2);
        $user->add_cap('new_capability');
        $user->remove_cap('new_capability');

        if( $user->has_cap('contributor') ){//tiene esa capacidad?

        }

        //$user->all_caps;  //trae todas las capacidades de ese usuario
    }
}

/*
$cap = new MP_Capabilities();
add_action( 'init', [ $cap , 'edit_cap_rol'] );
*/