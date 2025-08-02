<?php
class MP_Social_user{

    public function add_menu_social(){
        add_menu_page( 
            'User xsocial',//$page_title:string, 
            'User Social',//$menu_title:string, 
            'manage_options',//$capability:string, 
            'user_social',//$menu_slug:string, 
            [ $this , 'display_page' ],//$callback:callable, 
            null,//$icon_url:string,             
        );
    }

    public function display_page(){
        ?>
        <h3>Redes Scociales</h3>
        <table class="form-table">
            <tr>
                <th><label for="usuario">Usuario</label></th>
                <td>
                    <?php $this->show_select_user(); ?>
                </td>
            </tr>
            <tr>
                <th><label for="facebook">Facebook</label></th>
                <td><input type="text" name="mp_social[facebook]" value="" id="facebook"></td>
            </tr>
            <tr>
                <th><label for="twitter">twitter</label></th>
                <td><input type="text" name="mp_social[twitter]" value="" id="twitter"></td>
            </tr>
            <tr>
                <th><label for="heartbeat">heartbeat -> </label> <label id='heartbeat_title'></label></th>
                <td><input type="text" name="mp_heartbeat" value="" id="mp_heartbeat"></td>
            </tr>
        </table>
        <button id="btn_update_social">update</button>
        <?php
    }

    public function show_select_user(){
        $args = [
            'order_by' => 'nicename'
        ];
        $users = get_users( $args );//get all users
        ?>
        <select name="usuario" id="usuario">
            <option value="0">seleccione usuario</option>
            <?php
            foreach ($users as $wp_user) {
                ?>
                <option value="<?php echo $wp_user->ID; ?>"><?php echo $wp_user->display_name; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }

    public function getsocialuser(){
        check_ajax_referer( 'mp_seg', 'nonce' );

        if( isset( $_POST['action'] ) ){
            $user_id = $_POST['user_id']; 

            $social_metadata = get_user_meta( $user_id , 'mp_social',true);

            $facebook = '';
            $twitter = '';

            if( isset( $social_metadata ) && is_array( $social_metadata ) ){
                extract( $social_metadata );
            }

            $json = [
                'facebook' => $facebook,
                'twitter'   => $twitter
            ];
            
            echo json_encode( $json );
            wp_die();
        }
    }

    public function updatesocialuser(){
        check_ajax_referer( 'mp_seg', 'nonce' );

        if( isset( $_POST['action'] ) ){
            $user_id = $_POST['user_id']; 
            $facebook = sanitize_text_field( $_POST['facebook'] ) ;
            $twitter = sanitize_text_field( $_POST['twitter'] ) ;

            $mp_social = [
                'facebook' => $facebook,
                'twitter'   => $twitter
            ];

            $resp = update_user_meta( $user_id , 'mp_social', $mp_social);

            if( $resp !== false ){
                $json = [
                    'resultado' => 'correcto!!!'                    
                ];    
            }else{
                $json = [
                    'resultado' => 'error!!!'                    
                ];
            }            
            
            echo json_encode( $json );
            wp_die();
        }
    }

}

$social_user = new MP_Social_user();

//registras menu
add_action( 'admin_menu', [ $social_user , 'add_menu_social' ] );

//asociar funcion a action, ajax.
add_action( 'wp_ajax_getsocialuser', [$social_user , 'getsocialuser'] );//get
add_action( 'wp_ajax_updatesocialuser', [$social_user , 'updatesocialuser'] );//update