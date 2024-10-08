<!-- Main Sidebar Container --> 
<aside class="main-sidebar elevation-4" style="background-color: orange;">
    <!-- Brand Logo -->
    <a href="../Lab01/index3.html" class="brand-link" style="background-color: white; padding: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
        <img src="../Lab01/logo.jpg" alt="Fitness Center Logo" class="brand-image" style="max-width: 150px; height: auto; margin-bottom: 10px; background: transparent;">
        <span class="brand-text font-weight-light" style="color: black; font-size: 20px; font-weight: bold;">Fitness Center</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: orange;">
        <!-- SidebarSearch Form -->
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
                <!-- Administración Usuarios (Desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Administración Usuarios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="usuario.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="banco.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Perfiles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Comercial (Desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Comercial
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="planes_entrenamiento.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Planes de Entrenamiento</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="captacion_clientes.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Captación de clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="atencion_reclamos.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Atención de reclamos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="gestion_sancion.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sanciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reportes_gestion.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reportes de gestión</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Clientes (Modificado) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Clientes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="reserva_entrenamientos.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reserva de entrenamientos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="historial_sanciones.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Historial de Sanciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="planes_membresias.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Planes y Membresías</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="consultas_reclamos.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Consultas y Reclamos</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Operaciones (Desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Operaciones
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="operacion1.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Operación 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="operacion2.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Operación 2</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Logística (Desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white;">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Logística
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="logistica1.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logística 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logistica2.php" class="nav-link" style="color: white;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logística 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
