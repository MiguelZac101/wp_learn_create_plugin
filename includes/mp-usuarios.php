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

    public function create_option_array(){

        $userdata = array(
            'user_login'           => 'misha',
            'user_nicename'        => 'misha',
            'nickname'             => 'misha',
            'user_email'           => 'no-reply@rudrastyh.com',
            'user_pass'            =>  wp_generate_password( 18, false ),
            'first_name'           => 'Misha',
            'last_name'            => 'R',
            'display_name'         => 'Misha R',
            'user_url'             => 'https://rudrastyh.com',
            'description'          => 'A couple words about Misha here.',
            'rich_editing'         => 'true',
            'syntax_highlighting'  => 'true', 
            'comment_shortcuts'    => 'false',
            'admin_color'          => 'fresh',
            'use_ssl'              => false, 
            'user_registered'      => '2023-12-31 00:00:00',
            'show_admin_bar_front' => 'true',
            'role'                 => 'subscriber',
            'locale'               => '',
        );
        
        $username_exists = username_exists( $userdata['user_login'] );

        if( !$username_exists && email_exists( $userdata['user_email'] ) === false ){
            $user_id = wp_insert_user( $userdata );

            if( !is_wp_error( $user_id ) ){
                //wp_mail( $user_email, 'Bienvenido!', 'Su password es :'.$user_pass );
            }
        }
    }

    public function actualizar_usuario(){
        $user_id = 2;        
        $user_id = wp_update_user( [ 
            'ID'       => $user_id, 
            'first_name' => 'juan',
            'last_name' => 'perez',
        ] );

        if ( !is_wp_error( $user_id ) ) {            
            echo "el usuario a sido actualizado correctamente";
        } else {
            
        }
    }

}