@csrf

@input([
    'label' => 'Nombre de la sucursal',
    'name' => 'name',
    'value' => old('name', $branchOffice->name),
    'required' => true,
    'autofocus' => true
])