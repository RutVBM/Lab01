<!-- Main Sidebar Container --> 
<aside class="main-sidebar elevation-4" style="background-color: orange;">
    <!-- Brand Logo -->
    <a href="../Lab01/index3.html" class="brand-link" style="background-color: white; padding: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
        <img src="../Lab01/logo.jpg" alt="Fitness Center Logo" class="brand-image" style="max-width: 150px; height: auto; margin-bottom: 10px; background: transparent;">
        <span class="brand-text font-weight-light" style="color: black; font-size: 20px; font-weight: bold;">Fitness Center</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: orange;">
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" style="background-color: #f8f9fa; color: black;">
                <div class="input-group-append">
                    <button class="btn btn-sidebar" style="background-color: white; color: orange;">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Administración Usuarios -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <img src="../Lab01/admin-users.png" class="nav-icon" style="width: 20px; height: 20px;"> <!-- Custom icon -->
                        <p>Administración Usuarios<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 15px;">
                        <li class="nav-item">
                            <a href="usuario.php" class="nav-link" style="color: white;">
                                <i class="far fa-user nav-icon"></i><p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="banco.php" class="nav-link" style="color: white;">
                                <i class="fas fa-id-card nav-icon"></i><p>Perfiles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Comercial -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <img src="../Lab01/commercial.png" class="nav-icon" style="width: 20px; height: 20px;"> <!-- Custom icon -->
                        <p>Comercial<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 15px;">
                        <li class="nav-item">
                            <a href="planes_entrenamiento.php" class="nav-link" style="color: white;">
                                <i class="fas fa-dumbbell nav-icon"></i><p>Planes de Entrenamiento</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="captacion_clientes.php" class="nav-link" style="color: white;">
                                <i class="fas fa-users nav-icon"></i><p>Captación de clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="atencion_reclamos.php" class="nav-link" style="color: white;">
                                <i class="fas fa-headset nav-icon"></i><p>Atención de consultas y reclamos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="gestion_sanciones.php" class="nav-link" style="color: white;">
                                <i class="fas fa-ban nav-icon"></i><p>Gestión de sanciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reportes_gestion.php" class="nav-link" style="color: white;">
                                <i class="fas fa-chart-line nav-icon"></i><p>Reportes de gestión</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Clientes -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <img src="../Lab01/clients.png" class="nav-icon" style="width: 20px; height: 20px;"> <!-- Custom icon -->
                        <p>Clientes<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 15px;">
                        <li class="nav-item">
                            <a href="cliente.php" class="nav-link" style="color: white;">
                                <i class="fas fa-user-friends nav-icon"></i><p>Clientes</p>
                            </a>
                        </li>
    
                        <li class="nav-item">
                            <a href="reserva_entrenamientos.php" class="nav-link" style="color: white;">
                                <i class="fas fa-calendar-check nav-icon"></i><p>Reserva de Entrenamientos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pagos_planes.php" class="nav-link" style="color: white;">
                                <i class="fas fa-credit-card nav-icon"></i><p>Pagos y Planes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="historico_sanciones.php" class="nav-link" style="color: white;">
                                <i class="fas fa-history nav-icon"></i><p>Histórico de Sanciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reclamo_cliente.php" class="nav-link" style="color: white;">
                                <i class="fas fa-comment-dots nav-icon"></i><p>Consultas y Reclamos</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Operaciones -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <img src="../Lab01/operations.png" class="nav-icon" style="width: 20px; height: 20px;"> <!-- Custom icon -->
                        <p>Operaciones<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 15px;">
                        <li class="nav-item">
                            <a href="operacion1.php" class="nav-link" style="color: white;">
                                <i class="fas fa-cogs nav-icon"></i><p>Operación 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="operacion2.php" class="nav-link" style="color: white;">
                                <i class="fas fa-cog nav-icon"></i><p>Operación 2</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Logística -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <img src="../Lab01/logistics.png" class="nav-icon" style="width: 20px; height: 20px;"> <!-- Custom icon -->
                        <p>Logística<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 15px;">
                        <li class="nav-item">
                            <a href="logistica1.php" class="nav-link" style="color: white;">
                                <i class="fas fa-truck-loading nav-icon"></i><p>Logística 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logistica2.php" class="nav-link" style="color: white;">
                                <i class="fas fa-warehouse nav-icon"></i><p>Logística 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
