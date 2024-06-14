jQuery.noConflict();
jQuery(document).ready(function(){

    $("#continuar").on('click', function(e){

        var preparaciones = new Array();

        e.preventDefault();

        let procesamiento;

        $("input[name=preparacion]:checked").each(function(){

            preparaciones.push($(this).attr('data-id'));

        });

        if( preparaciones.length <= 0 ){

            Swal.fire({
                icon: 'info',
                title: 'Elige por lo menos 1 ingrediente (Queso, Aderezo, Sabor)',
                allowOutsideClick: false,
                showConfirmButton: true,
            });

        }else{

            Swal.fire({
    
                title: 'Agregando Preparación',
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
                        url: '/pedido/preparar',
                        data:{
    
                            'id' : $("#id").val(),
                            'preparaciones' : preparaciones,
    
                        },
                        dataType: 'json',
                        encode: true
    
                    }).done(function(respuesta){
    
                        if( respuesta.exito ){
    
                            Swal.fire({
    
                                icon: 'success',
                                title: 'Platillo Preparado',
                                allowOutsideClick: false,
                                showConfirmButton: true
    
                            }).then((resultado)=>{
    
                                if( resultado.isConfirmed ){
    
                                    window.location.href = '/pedido/menu';
    
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
    
            }).then(function(resultado){
    
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

        }

    });

});