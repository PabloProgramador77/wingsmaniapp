jQuery.noConflict();
jQuery(document).ready(function(){

    $("#ordenarPedido").on('click', function(e){

        e.preventDefault();

        Swal.fire({

            title: 'Finalizando Pedido',
            html: 'Un momento por favor: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/pedido/pedir',
                    data:{

                        'id' : $("#idPedido").val(),
                        'nombre' : $("#nombreCliente").val(),
                        'telefono' : $("#telefonoCliente").val(),
                        'domicilio' : $("#domicilioCliente").val(),

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = respuesta.url;

                            }

                        });


                    }else{

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/pedido/menu';

                            }

                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/pedido/menu';

                    }

                });

            }

        });

    });

    $("#pedir").on('click', function(){

        document.getElementById('modalPedido').style.display = 'none';
        document.getElementById('modalPedido').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove );

        document.getElementById('modalCliente').style.display = 'block';
        document.getElementById('modalCliente').classList.add('show');

    });

    $("#cancelarCliente").on('click', function(){

        document.getElementById('modalCliente').style.display = 'none';
        document.getElementById('modalCliente').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove );

        document.getElementById('modalPedido').style.display = 'block';
        document.getElementById('modalPedido').classList.add('show');

    });

});