<li class="{{ request()->is('ventas*') ? 'active' : '' }}">
    <a href="{{ route('ventas.index') }}">
        <i class="fa fa-dolly-flatbed"></i> <span>Ventas</span>
    </a>
</li>
<li class="{{ request()->is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}">
        <i class="fa fa-users"></i> <span>Usuarios</span>
    </a>
</li>
<li class="{{ request()->is('productos*') ? 'active' : '' }}">
    <a href="{{ route('productos.index') }}">
        <i class="fa fa-wine-bottle"></i> <span>Productos</span>
    </a>
</li>
<li class="{{ request()->is('descuentos*') ? 'active' : '' }}">
    <a href="{{ route('descuentos.index') }}">
        <i class="fa fa-list-alt"></i> <span>Descuentos</span>
    </a>
</li>
<li class="{{ request()->is('promociones*') ? 'active' : '' }}">
    <a href="{{ route('promociones.index') }}">
        <i class="fa fa-clipboard-list"></i> <span>Promociones</span>
    </a>
</li>
<li class="{{ request()->is('clientes*') ? 'active' : '' }}">
    <a href="{{ route('clientes.index') }}">
        <i class="fa fa-users"></i> <span>Clientes</span>
    </a>
</li>
<li class="{{ request()->is('masVendidos*') ? 'active' : '' }}">
    <a href="{{ route('productos.masVendidos') }}">
        <i class="fa fa-chart-bar"></i> <span>Estadisticas</span>
    </a>
</li>

<li class="{{ request()->is('inventario*') ? 'active' : '' }}">
    <a href="{{ route('productos.inventario') }}">
        <i class="fa fa-list-alt"></i> <span>Inventario</span>
    </a>
</li>

<li class="dropdown {{ request()->is('reportes*') ? 'active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
        aria-expanded="false"><i class="fa fa-file-pdf"></i> Reportes <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="{{route('reportes.ventas')}}">Ventas</a></li>
        {{-- <li role="separator" class="divider"></li> --}}
        {{-- <li><a href="#">Separated link</a></li> --}}
    </ul>
</li>

<li class="{{ request()->is('solicitudes*') ? 'active' : '' }}">
    <a href="{{ route('solicitudes.index') }}">
        <i class="fa fa-key"></i> <span>Contraseñas</span>
    </a>
</li>

<li class="{{ request()->is('empresa*') ? 'active' : '' }}">
    <a href="{{ route('empresa.index') }}">
        <i class="fa fa-building"></i> <span>Empresa</span>
    </a>
</li>
