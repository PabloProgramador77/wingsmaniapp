jQuery.noConflict();
jQuery(document).ready(function(){

    var salsas = new Array();

    $("input[name=salsa]").on('click', function(){
        
        if( $(this).is(':checked') ){
        
            console.log( 'Salsa elegida.' );
            
            salsas.push( $(this).attr('data-id') );

            if( salsas.length > $("#salsas").val() ){

                Swal.fire({
                    icon: 'info',
                    title: 'Este paquete solo permite elegir' + $("#salsas").val() + ' salsa(s).',
                    allowOutsideClick: false,
                    showConfirmButton: true
                });
    
            }

        }

    });

});