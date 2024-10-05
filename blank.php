<?php include("header.php") ?>
<?php include("sidebar.php") ?>

<!-- Main Content Wrapper -->
<div class="content-wrapper" style="background-image: url('/Lab01/fondo.jpg'); background-size: cover; background-position: center; background-attachment: fixed; color: white;">


    <!-- Hero Section -->
    <section class="hero" style="padding: 150px 0; background-color: rgba(0, 0, 0, 0.7); text-align: center;">
        <h1 style="color: #FFA500; font-size: 50px;">Fitness Center</h1>
        <p style="font-size: 24px;">"La distancia entre los sueños y la realidad es la disciplina"</p>
        <a href="#services" class="btn" style="background-color: #FFA500; color: white; padding: 10px 20px; border-radius: 5px;">Ver Planes</a>
    </section>

    <!-- Sección de Servicios -->
    <section id="services" style="padding: 50px 0; background-color: rgba(255, 255, 255, 0.9); color: black;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h2 style="color: #FFA500;">Entrenamientos Personalizados</h2>
                    <p>Entrena de forma individual con nuestros profesionales en parques o locales equipados.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h2 style="color: #FFA500;">Reservas y Programación</h2>
                    <p>Haz tu reserva online y consulta la programación semanal de entrenamientos.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h2 style="color: #FFA500;">Gestión de Planes</h2>
                    <p>Selecciona tu plan, gestiona pagos y renueva tu membresía directamente en línea.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Planes y Precios -->
    <section id="pricing" style="padding: 50px 0; background-color: #333; color: white;">
        <div class="container text-center">
            <h2 style="color: #FFA500;">Nuestros Planes</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="pricing-box" style="background-color: black; border: 2px solid #FFA500; padding: 30px; border-radius: 10px;">
                        <h3 style="color: #FFA500;">Básico</h3>
                        <p>20 sesiones al mes - S/80.00</p>
                        <a href="#" class="btn" style="background-color: #FFA500; color: white;">Comprar</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-box" style="background-color: black; border: 2px solid #FFA500; padding: 30px; border-radius: 10px;">
                        <h3 style="color: #FFA500;">Premium</h3>
                        <p>30 sesiones al mes - S/120.00</p>
                        <a href="#" class="btn" style="background-color: #FFA500; color: white;">Comprar</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-box" style="background-color: black; border: 2px solid #FFA500; padding: 30px; border-radius: 10px;">
                        <h3 style="color: #FFA500;">Elite</h3>
                        <p>Entrenamiento ilimitado - S/200.00</p>
                        <a href="#" class="btn" style="background-color: #FFA500; color: white;">Comprar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto -->
    <section id="contact" style="padding: 50px 0; background-color: rgba(255, 255, 255, 0.9); color: black;">
        <div class="container text-center">
            <h2 style="color: #FFA500;">Contáctanos</h2>
            <p>¿Tienes alguna consulta o quieres más información? ¡Escríbenos!</p>
            <a href="mailto:info@fitness-sac.com" class="btn" style="background-color: #FFA500; color: white;">Enviar Correo</a>
        </div>
    </section>

</div>

<!-- Footer -->
<?php include("footer.php") ?>

<!-- Scripts -->
<script src="../Lab01/plugins/jquery/jquery.min.js"></script>
<script src="../Lab01/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../Lab01/dist/js/adminlte.min.js"></script>

