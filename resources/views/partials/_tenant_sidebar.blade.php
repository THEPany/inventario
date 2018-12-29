<a href="{{ url("/{$branchOffice->slug}/dashboard") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold  pt-0 pb-1">
    <i class="fas fa-tachometer-alt"></i>
    Dashboard
</a>

{{-- PROVIDER --}}

@if(auth()->user()->can('tenat-view', \App\Provider::class) || auth()->user()->can('tenat-create', \App\Provider::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">PROVEDOR</a>
@endif

@can('tenat-view', \App\Provider::class)
    <a href="{{ url("/{$branchOffice->slug}/providers/create") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-users"></i>
        Crear provedor
    </a>
@endcan

@can('tenat-create', \App\Provider::class)
    <a href="{{ url("/{$branchOffice->slug}/providers") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de provedores
    </a>
@endcan

{{-- END PROVIDER --}}

{{-- PRODUCTOS --}}

@if(auth()->user()->can('tenat-view', \App\Product::class) || auth()->user()->can('tenat-create', \App\Product::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">PRODUCTOS</a>
@endif

@can('tenat-create', \App\Product::class)
    <a href="{{ url("/{$branchOffice->slug}/products/create") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-box"></i>
        Crear producto
    </a>
@endcan

@can('tenat-view', \App\Product::class)
    <a href="{{ url("/{$branchOffice->slug}/products") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de productos
    </a>
@endcan

{{-- END PRODUCTOS --}}

{{-- COMPRAS --}}

@if(auth()->user()->can('tenant-view', \App\Purchase::class) || auth()->user()->can('tenant-create', \App\Purchase::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">COMPRAS</a>
@endif

@can('tenant-create', \App\Purchase::class)
    <a href="{{ url("/{$branchOffice->slug}/purchases/create") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-cart-plus"></i>
        Registrar compra
    </a>
@endcan

@can('tenant-view', \App\Purchase::class)
    <a href="{{ url("/{$branchOffice->slug}/purchases") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de compras
    </a>
@endcan

{{-- END COMPRAS --}}

{{-- TRANSACCIONES --}}

@if(auth()->user()->can('tenant-view', \App\Transaction::class) || auth()->user()->can('tenant-create', \App\Transaction::class))
    <a class="list-group-item border-0 bg-transparent font-weight-bold" style="color: #8795a1;">TRANSACCIONES</a>
@endif

@can('tenant-create', \App\Transaction::class)
    <a href="{{ url("/{$branchOffice->slug}/transactions/create") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0 pb-1">
        <i class="fas fa-cart-plus"></i>
        Registrar transacción
    </a>
@endcan

@can('tenant-view', \App\Transaction::class)
    <a href="{{ url("/{$branchOffice->slug}/transactions") }}" class="list-group-item border-0 bg-transparent text-dark font-weight-bold pt-0">
        <i class="fas fa-dot-circle"></i>
        Lista de transacciónes
    </a>
@endcan

{{-- END TRANSACCIONES --}}