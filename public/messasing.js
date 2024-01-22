jQuery.noConflict();
jQuery(document).ready(function(){

    //Definición de Alerta
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    //Configuración inicial
    var firebaseConfig = {
        apiKey: "AIzaSyCfwO2i_u_kUhFfOS_HSWQI-RYsTf5Ny9k",
        authDomain: "fcmlaravel-c8f4b.firebaseapp.com",
        projectId: "fcmlaravel-c8f4b",
        storageBucket: "fcmlaravel-c8f4b.appspot.com",
        messagingSenderId: "808595646536",
        appId: "1:808595646536:web:c4baa60eaf4ccb8d0f507d",
        measurementId: "G-H9V41V6KQF"
    };
    
    if( !firebase.apps.length ){

        firebase.initializeApp(firebaseConfig);
        
    }

    const messaging = firebase.messaging();

    //Inicio de Requerimiento de Token
    messaging.requestPermission().then(function () {

        return messaging.getToken()

    }).then(function (response) {

        //Inicio de Almacenamiento de Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({

            url: '/usuario/token',
            type: 'POST',
            data: {

                token: response

            },
            dataType: 'JSON',
            success: function (response) {

                console.log('Token Registrado.');

            },
            error: function (error) {

                Toast.fire({

                    icon: 'error',
                    title: error.mensaje

                });

            },

        });

    }).catch(function (error) {

        //Excepción de Token
        Toast.fire({

            icon: 'info',
            title: error

        });

    });
    
    //Creación de Notificación
    messaging.onMessage(function (payload) {
        
        const title = payload.notification.title;
        const options = {

            body: payload.notification.body,
            icon: payload.notification.icon,

        };

        new Notification(title, options);

    });


});