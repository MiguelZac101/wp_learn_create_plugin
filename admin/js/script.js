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
    $(document).on( 'heartbeat-tick.mp', function( event,data,textStatus,jqXHR ) { 

        if( data.hasOwnProperty( 'msg' )){
            $mp_heartbeat.val( data.msg.text );
            $heartbeat_title.html( data.msg.text );
        }
        
        var datos = {
            'enviando' : 'false'
        };

        wp.heartbeat.enqueue( 'mp_heartbeat', datos, false );

    } );

});

