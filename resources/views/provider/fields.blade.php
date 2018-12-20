@csrf

@input([
    'label' => 'Nombre del proveedor',
    'name' => 'name',
    'value' => old('name', $provider->name),
    'required' => true,
    'autofocus' => true
])

@input([
    'label' => 'Teléfono',
    'name' => 'phone',
    'value' => old('phone', $provider->phone),
    'required' => true,
    'phonemask' => true,
])

@textarea([
    'label' => 'Dirección',
    'name' => 'address',
    'value' => $provider->address,
    'required' => true,
])