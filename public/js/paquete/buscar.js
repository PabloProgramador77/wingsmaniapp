jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);
    $("#agregar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/paquete/buscar',
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

                $("#salsasEditar").val( respuesta.salsas );
                $("#bebidasEditar").val( respuesta.bebidas );
                $("#editablesEditar").val( respuesta.editables );

                $("#diaEditar").prepend('<option value="'+respuesta.dia+'">'+respuesta.dia+'</option>');
                $("#diaEditar").val(respuesta.dia);
                $("#diaEditar option[value='"+respuesta.dia+"']:not(:first)").remove();

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

                        window.location.href = '/paquetes';

                    }

                });

            }

        });

    });

    $(".platillos").on('click', function(e){

        e.preventDefault();

        $("input[name=platillo]").prop('checked', false);
        $("#nombrePaquete").val('');

        $.ajax({

            type: 'POST',
            url: '/paquete/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.platillos.length > 0 ){

                    $.each( respuesta.platillos, function(i, platillo){

                        $('input[type=checkbox][id='+ platillo.id +']').prop('checked', true);

                    });
                    
                    $("#nombrePaquete").val( respuesta.nombre ); 
                    $("#id").val( respuesta.id );

                    $("#agregar").attr('disabled', false);

                }else{

                    $("#nombrePaquete").val( respuesta.nombre ); 
                    $("#id").val( respuesta.id );

                    $("#agregar").attr('disabled', false);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/paquetes';

                    }

                });

                $("#agregar").attr('disabled', true);

            }

        });

    });

    $(".bebidas").on('click', function(e){

        e.preventDefault();

        $("input[name=bebida]").prop('checked', false);
        $("#nombrePaqueteBeb").val('');

        $.ajax({

            type: 'POST',
            url: '/paquetes/bebidas',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.platillos.length > 0 ){

                    $("input[name=bebida]").prop('checked', false);

                    $.each( respuesta.platillos, function(i, platillo){

                        $('input[name=bebida][id='+ platillo.id +']').prop('checked', true);

                    });
                    
                    $("#nombrePaqueteBeb").val( respuesta.nombre ); 
                    $("#idPaquete").val( respuesta.id );

                    $("#agregarBebida").attr('disabled', false);

                }else{

                    $("#nombrePaqueteBeb").val( respuesta.nombre ); 
                    $("#idPaquete").val( respuesta.id );

                    $("#agregarBebida").attr('disabled', false);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/paquetes';

                    }

                });

                $("#agregarBebida").attr('disabled', true);

            }

        });

    });

});