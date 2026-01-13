<li class="{{request()->is('ventas*')? 'active':''}}">
    <a href="{{route('ventas.index')}}">
    <i class="fa fa-dolly-flatbed"></i> <span>Ventas</span>
    </a>
</li>

<li class="{{request()->is('clientes*')? 'active':''}}">
    <a href="{{route('clientes.index')}}">
    <i class="fa fa-users"></i> <span>Clientes</span>
    </a>
</li>