jQuery.noConflict();
jQuery(document).ready(function(){

    $("#continuar").on('click', function(e){

        var preparaciones = '';
        var bebidas = new Array();

        e.preventDefault();

        let procesamiento;

        $("input[name=bebida]:checked").each(function(){

            preparaciones += ', ' + $(this).attr('data-id');

            bebidas.push( $(this).attr('data-id') );

        });

        if( bebidas.length <= 0 ){

            Swal.fire({
                icon: 'info',
                title: 'Debes elegir al menos una bebida',
                allowOutsideClick: false,
                showConfirmButton: true,
            });

        }else{
        
            if( bebidas.length > $("#bebidas").val() ){
    
                Swal.fire({
                    icon: 'info',
                    title: 'Máximo ' + $("#bebidas").val() + ' bebida(s).',
                    allowOutsideClick: false,
                    showConfirmButton: true
                });
    
            }else{
    
                Swal.fire({
        
                    title: 'Preparando...',
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
                            url: '/paquete/preparar',
                            data:{
        
                                'id' : $("#idPedidoPaquete").val(),
                                'preparaciones' : preparaciones,
        
                            },
                            dataType: 'json',
                            encode: true
        
                        }).done(function(respuesta){
        
                            if( respuesta.exito ){
        
                                Swal.fire({
        
                                    icon: 'success',
                                    title: 'Paquete Preparado',
                                    allowOutsideClick: false,
                                    showConfirmButton: true
        
                                }).then((resultado)=>{
        
                                    if( resultado.isConfirmed ){
        
                                        window.location.href = '/paquete/ordenar/'+ $("#id").val();
        
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
        
                                        window.location.href = '/paquete/ordenar/' + $("#id").val();
        
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
        
                                window.location.href = '/paquete/ordenar/'+ $("#id").val();
        
                            }
        
                        });
        
                    }
                    
                });
    
            }

        }

    });

});