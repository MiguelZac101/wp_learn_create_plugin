<?php
class MP_add_metadata_user {

    function show_fields( $user ) {
        $social = get_user_meta( $user->ID, 'mp_social' , true );
        if( isset( $social ) && is_array( $social ) ){
            extract( $social , EXTR_OVERWRITE);
        }else{
            $facebook = '';
            $twitter = '';
        }

        ?>
        <h3>Redes Scociales</h3>
        <table class="form-table">
            <tr>
                <th><label for="facebook">Facebook</label></th>
                <td><input type="text" name="mp_social[facebook]" value="<?php echo $facebook;?>"></td>
            </tr>
            <tr>
                <th><label for="twitter">twitter</label></th>
                <td><input type="text" name="mp_social[twitter]" value="<?php echo $twitter;?>"></td>
            </tr>
        </table>
        <?php
    }

    public function save_meta_fields( $user_id ){
        if( !current_user_can( $user_id ) ){
            return ;
        }
        if( isset( $_POST['mp_social'] ) ){
            $_POST['mp_social']['facebook'] = sanitize_text_field( $_POST['mp_social']['facebook'] );
            $_POST['mp_social']['twitter'] = sanitize_text_field( $_POST['mp_social']['twitter'] );

            update_user_meta( $user_id, 'mp_social', $_POST['mp_social'] );
        }
    }

}
/*
Funciones para la manipulación de los metadatos de usuario
user_new_form -> Página de agregar usuario
user_register -> Para guardar desde la página de agregar usuario
show_user_profile -> Página del perfil del usuario activo
personal_options_update -> Guardar desde el perfil de usuario activo
edit_user_profile -> Página de edición de un usuario
edit_user_profile_update -> Guardar desde la página de edición de un usuario
*/

$mp_add_metadata_user = new MP_add_metadata_user();
//show
add_action( 'user_new_form', [$mp_add_metadata_user , 'show_fields'] );//mostrar en el form nuevo usuario
add_action( 'show_user_profile', [$mp_add_metadata_user , 'show_fields'] );//form profile
add_action( 'edit_user_profile', [$mp_add_metadata_user , 'show_fields'] );//form edit user
//save
add_action( 'user_register', [$mp_add_metadata_user , 'save_meta_fields'] );
add_action( 'personal_options_update', [$mp_add_metadata_user , 'save_meta_fields'] );
add_action( 'edit_user_profile_update', [$mp_add_metadata_user , 'save_meta_fields'] );

