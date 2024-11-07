jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-id');
        var nombre = $(this).attr('data-value').split(',')[0];
        var descripcion = $(this).attr('data-value').split(',')[1];

        if( id === 0 || id === null || id === '' || id === undefined ){

            Swal.fire({

                title: 'Error de lectura',
                icon: 'fas fa-exclamation-circle',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

            $("#actualizar").attr('disabled', true);

        }else{

            $("#id").val( id );
            $("#nombreEditar").val( nombre );
            $("#descripcionEditar").val( descripcion );

            $("#actualizar").attr('disabled', false);
            
        }

    });

});