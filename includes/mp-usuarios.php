<?php
class MP_usuarios {
    public function create(){
        $user_login = 'newuser';
        $user_pass = wp_generate_password( 18, false );
        $user_email = 'newuser@gmail.com';
        $username_exists = username_exists( $user_login );

        if( !$username_exists && email_exists( $user_email ) === false ){
            $user_id = wp_create_user(
                $user_login,
                $user_pass,
                $user_email
            );

            if( !is_wp_error( $user_id ) ){
                //wp_mail( $user_email, 'Bienvenido!', 'Su password es :'.$user_pass );
            }
        }
    }
}