<x-adminlte-modal id="modalVideos" title="WingsVideos" size="xl" theme="purple" icon="fab fa-youtube" static-backdrop scrollable>
    
    <div class="container-fluid row">
        <div class="col-lg-12 col-md-12 col-sm-12 m-auto p-1">
            <figcaption class="bg-warning p-1 fw-bold"><i class="fab fa-youtube"></i> <b>Datos de Perfil</b></figcaption>
            <figcaption class="bg-light p-1 fw-semibold text-center"><i class="fas fa-info-circle"></i> Aprende fácil y rápido a actualizar tus datos de cliente. <i class="fas fa-info-circle"></i></figcaption>
            <video src="{{ asset('/video/WingsManiApp-Perfil_1.mp4') }}" controls width="1024px" height="auto" class="col-lg-12 col-md-12 col-sm-12 border"></video>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 m-1 p-1">
            <figcaption class="bg-warning p-1 fw-bold"><i class="fab fa-youtube"></i> <b>Ordenar Platillos</b></figcaption>
            <figcaption class="bg-light p-1 fw-semibold text-center"><i class="fas fa-info-circle"></i> Aprende fácil y rápido a enviar tu pedido al restaurante con tus platillos favoritos. <i class="fas fa-info-circle"></i></figcaption>
            <video src="{{ asset('/video/WingsManiApp-OrdenarPlatillo_0.mp4') }}" controls width="768px" height="auto" class="col-lg-12 col-md-12 col-sm-12 border"></video>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 m-1 p-1">
            <figcaption class="bg-warning p-1 fw-bold"><i class="fab fa-youtube"></i> <b>Ordenar Paquetes/Promociones</b></figcaption>
            <figcaption class="bg-light p-1 fw-semibold text-center"><i class="fas fa-info-circle"></i> Aprende fácil y rápido a enviar tu pedido al restaurante con tus paquetes o promociones favoritas. <i class="fas fa-info-circle"></i></figcaption>
            <video src="{{ asset('/video/WingsManiApp-OrdenarPaquete_1.mp4') }}" controls width="768px" height="auto" class="col-lg-12 col-md-12 col-sm-12 border"></video>
        </div>
    </div>
</x-adminlte-modal>