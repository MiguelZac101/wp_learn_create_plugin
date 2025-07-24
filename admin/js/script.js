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
    
});

