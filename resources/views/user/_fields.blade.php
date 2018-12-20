@csrf

@input([
    'label' => 'Nombre',
    'name' => 'name',
    'value' => $user->name,
    'required' => true,
    'autofocus' => true,
])

@input([
    'label' => 'Correo Electrónico',
    'name' => 'email',
    'type' => 'email',
    'value' => $user->email,
    'required' => true,
])

@input([
    'label' => __('Password'),
    'name' => 'password',
    'type' => 'password',
    'required' => true,
])

@input([
    'label' => __('Confirm Password'),
    'name' => 'password_confirmation',
    'type' => 'password',
    'required' => true,
])

<div class="form-group row {{ $errors->has('role')  ? 'has-error' : '' }}">

    <label class="col-sm-4 col-form-label text-md-right">Rol</label>

    <div class="col-md-6">
        <select class="form-control" id="role" name="role">
            @foreach($roles as $role)
                <option value="{{ old('role', $role->name) }}" {{ in_array($role->id, $user->roles()->pluck('id', 'id')->toArray()) ? 'selected' : ''  }}>{{ $role->title }}</option>
            @endforeach
        </select>

        @if ($errors->has('role'))
            <span class="help-block">{{ $errors->first('role') }}</span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('branch_office_id')  ? 'has-error' : '' }}">
    <label class="col-sm-4 col-form-label text-md-right">Sucursal</label>

    <div class="col-sm-6">
        <select class="form-control" id="branch_office_id" name="branch_office_id">
            <option value="{{ old('branch_office_id', 0) }}" {{ $branchOffice->id === $user->branch_office_id ? 'selected' : ''  }}>Principal</option>
            @foreach($branchOffices as $branchOffice)
                <option value="{{ old('branch_office_id', $branchOffice->id) }}" {{ $branchOffice->id === $user->branch_office_id ? 'selected' : ''  }}>
                    {{ $branchOffice->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('branch_office_id'))
            <span class="help-block">{{ $errors->first('branch_office_id') }}</span>
        @endif
    </div>
</div>