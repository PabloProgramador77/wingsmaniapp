jQuery.noConflict();
jQuery(document).ready( function(){

    $("#portada, #portadaEditar").on('change', function(){

        var archivo = $(this)[0].files[0];
        var mime_type = ['image/jpeg', 'image/jpg', 'image/png'];

        if( archivo && mime_type.includes( archivo.type ) ){

            console.log('Archivo permitido');

        }else{

            Swal.fire({

                icon: 'warning',
                title: 'Archivo no valido. Intenta con otro.',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

        }

    });

});