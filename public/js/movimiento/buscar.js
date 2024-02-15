jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/movimiento/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#conceptoEditar").val( respuesta.concepto );
                $("#montoEditar").val( respuesta.monto );

                $("#tipoEditar").prepend('<option value="'+respuesta.tipo+'">'+respuesta.tipo+'</option>');
                $("#tipoEditar").val(respuesta.tipo);
                $("#tipoEditar option[value='"+respuesta.tipo+"']:not(:first)").remove();

                $("#id").val( respuesta.id );

                $("#actualizar").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/movimientos';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});