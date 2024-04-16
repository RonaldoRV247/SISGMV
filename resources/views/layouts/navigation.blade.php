<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <style>
    a {
        text-decoration: none !important;
    }
</style>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block d-flex"><i class="fas fa-user-shield nav-item"></i>&nbsp; <p>{{ Auth::user()->name }}</p></a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="mantenimientos" class="nav-link">
                    <i class="nav-icon fas fa-wrench"></i>
                    <p>
                        {{ __('Registro de Mantenimiento') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-plus nav-icon"></i>
                    <p>
                        Gestión de datos
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none; margin-left: 8px">
                    <li class="nav-item">
                        <a href="personas" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                            <p>Operarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="proveedores" class="nav-link">
                        <i class="fas fa-user-tie nav-icon"></i>
                            <p>Proveedores</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reparaciones" class="nav-link">
                            <i class="fas fa-solid fa-cogs nav-icon"></i>
                            <p>Reparaciones</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vehiculos" class="nav-link">
                            <i class="fas fa-shuttle-van nav-icon"></i>
                            <p>Vehiculos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="maquinarias" class="nav-link">
                            <i class="fas fa-tractor nav-icon"></i>
                            <p>Maquinarias</p>
                        </a>
                    </li>
                    <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('Usuarios') }}
                    </p>
                </a>
            </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->