jQuery(document).ready(function($){
    
    $('button.peticion').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: ajax_object.url,
            method: 'POST',
            dataType: 'json',
            data : {
                action : 'mipeticion',
                nonce : ajax_object.nonce,
                nombre : $('input.nombre').val()
            }
            ,
            success: function(data) {
                console.log(data.resultado);
                alert(data.resultado);
            },
            error: function() {
            
            }
        });
    });   

    //para seleccionar el usuario y cargar data via ajax
    $('select#usuario').on('change', function() {    
        $user_id = this.value;

        var $facebook = $('input#facebook'),
        $twitter = $('input#twitter');

        $.ajax({
            url: ajax_object.url,
            method: 'POST',
            dataType: 'json',
            data : {
                action : 'getsocialuser',
                nonce : ajax_object.nonce,                
                user_id : $user_id,
            }
            ,
            success: function(data) {                
                $facebook.val(data.facebook);
                $twitter.val(data.twitter);
                
            },
            error: function() {
            
            }
        });
       
    });

    //update social
    $('#btn_update_social').on('click', function() {    
        $user_id = $('select[name=usuario]').val();        

        var $facebook = $('input#facebook'),
        $twitter = $('input#twitter');

        $.ajax({
            url: ajax_object.url,
            method: 'POST',
            dataType: 'json',
            data : {
                action : 'updatesocialuser',
                nonce : ajax_object.nonce,                
                user_id : $user_id,
                facebook : $facebook.val(),
                twitter : $twitter.val(),
            }
            ,
            success: function(data) {                
                alert(data.resultado);   
                
                //notificacion
                var datos = {
                    'actualizado' : 'true',
                    'current_user_id' : ajax_object.current_user_id,
                    'user_update' : $user_id
                };
                wp.heartbeat.enqueue( 'mp_notificacion', datos, true );
                console.log('presiono boton de actualizar');
                console.log(datos);               

            },
            error: function() {
            
            }
        });
        
       
    });

    //heartbeat API

    wp.heartbeat.interval( 'fast' );

    //envias datos
    /*
    $(document).on( 'heartbeat-send', function( event, data ) { 
        data.nombre = 'miguel';
        console.log('heartbeat-send -> nombre -> '+data.nombre);
    } );
*/
    var $mp_heartbeat = $('#mp_heartbeat');
    var $heartbeat_title = $('#heartbeat_title');

    $mp_heartbeat.on('keyup', function(){
        var datos = {
            'text' : $mp_heartbeat.val(),
            'enviando' : 'true'
        };
        wp.heartbeat.enqueue( 'mp_heartbeat', datos, false );
    });

    //recibes la respuesta del servidor
    /*
    $(document).on( 'heartbeat-tick.mp', function( event,data,textStatus,jqXHR ) { 

        if( data.hasOwnProperty( 'msg' )){
            $mp_heartbeat.val( data.msg.text );
            $heartbeat_title.html( data.msg.text );
        }
        
        var datos = {
            'enviando' : 'false'
        };

        wp.heartbeat.enqueue( 'mp_heartbeat', datos, false );

    });
    */
   $(document).on( 'heartbeat-tick.mp_notificacion', function( event,data,textStatus,jqXHR ) { 
        console.log('data.mp_notificacion -> '+data.mp_notificacion);
        console.log('data.user_updated.display_name -> '+data.user_updated.display_name);

        if( data.hasOwnProperty( 'mp_notificacion' )){
            if(data.mp_notificacion == 'true'){
                alert( 'Ha actualizados las redes sociales de: '+data.user_updated.display_name);
            }
        }
        
        var datos = {
            'actualizado' : 'false',
            'current_user_id' : ajax_object.current_user_id
        };

        wp.heartbeat.enqueue( 'mp_notificacion', datos, false );

    });

});

