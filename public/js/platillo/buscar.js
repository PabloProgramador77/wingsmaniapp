jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/platillo/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
                $("#precioEditar").val(respuesta.precio);
                
                $("#categoriaEditar").prepend('<option value="'+respuesta.idCategoria+'">'+respuesta.categoria+'</option>');
                $("#categoriaEditar").val(respuesta.idCategoria);
                $("#categoriaEditar option[value='"+respuesta.idCategoria+"']:not(:first)").remove();

                $("#descripcionEditar").val(respuesta.descripcion); 
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

                        window.location.href = '/platillos';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});