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

});

