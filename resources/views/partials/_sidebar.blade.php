@can('view-dashboard')
    <a href="{{ url('/dashboard') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold  pt-0 pb-1">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
@endcan

{{-- PROVIDER --}}

@if(auth()->user()->can('view', \App\Provider::class) || auth()->user()->can('create', \App\Provider::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">PROVEDOR</a>
@endif

@can('view', \App\Provider::class)
    <a href="{{ url('/providers/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-users"></i>
        Crear provedor
    </a>
@endcan

@can('create', \App\Provider::class)
<a href="{{ url('/providers') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
    <i class="fas fa-dot-circle"></i>
    Lista de provedores
</a>
@endcan

{{-- END PROVIDER --}}


{{-- PRODUCTOS --}}

@if(auth()->user()->can('view', \App\Product::class) || auth()->user()->can('create', \App\Product::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">PRODUCTOS</a>
@endif

@can('create', \App\Product::class)
    <a href="{{ url('/products/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-box"></i>
        Crear producto
    </a>
@endcan

@can('view', \App\Product::class)
    <a href="{{ url('/products') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de productos
    </a>
@endcan

{{-- END PRODUCTOS --}}

{{-- COMPRAS --}}

@if(auth()->user()->can('view', \App\Purchase::class) || auth()->user()->can('create', \App\Purchase::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">COMPRAS</a>
@endif

@can('create', \App\Purchase::class)
    <a href="{{ url('/purchases/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-cart-plus"></i>
        Registrar compra
    </a>
@endcan

@can('view', \App\Purchase::class)
    <a href="{{ url('/purchases') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de compras
    </a>
@endcan

{{-- END COMPRAS --}}

{{-- TRANSACCIONES --}}

@if(auth()->user()->can('view', \App\Transaction::class) || auth()->user()->can('create', \App\Transaction::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">TRANSACCIONES</a>
@endif

@can('create', \App\Transaction::class)
    <a href="{{ url('/transactions/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-cart-plus"></i>
        Registrar transacción
    </a>
@endcan

@can('view', \App\Transaction::class)
    <a href="{{ url('/transactions') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de transacciónes
    </a>
@endcan

{{-- END TRANSACCIONES --}}


{{-- SUCURSAL --}}

@if(auth()->user()->can('view', \App\BranchOffice::class) || auth()->user()->can('create', \App\BranchOffice::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">SUCURSALES</a>
@endif

@can('create', \App\BranchOffice::class)
    <a href="{{ url('/branch/office/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="far fa-building"></i>
        Registrar sucursal
    </a>
@endcan

@can('view', \App\BranchOffice::class)
    <a href="{{ url('/branch/office') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de sucursales
    </a>
@endcan

{{-- END SUCURSAL --}}

<a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">GESTION Y ADMINISTRACION DE USUARIOS</a>

@can('create', \App\User::class)
    <a href="{{ url('/users/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-user"></i>
        Crear usuario
    </a>
@endcan

@can('view', \App\User::class)
    <a href="{{ url('/users') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-dot-circle"></i>
        Lista de usuarios
    </a>
@endcan

@can('create', \Silber\Bouncer\Database\Role::class)
    <a href="{{ url('/roles/create') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-lock"></i>
        Crear rol
    </a>
@endcan

@can('view', \Silber\Bouncer\Database\Role::class)
    <a href="{{ url('/roles') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-dot-circle"></i>
        Lista de roles
    </a>
@endcan

<a href="{{ url('/abilities') }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
    <i class="fas fa-lock"></i>
    Lista de habilidades
</a>

