@csrf

@input([
    'label' => 'Nombre del rol',
    'name' => 'name',
    'value' => $role->name,
    'required' => true,
    'autofocus' => true
])

<div class="form-group row">
    <label for="abilities" class="col-sm-4 col-form-label text-md-right">Habiliades</label>
    <div class="col-6">
        <div class="col-12 row">
            @foreach($abilities as $abilitie)
                @if($abilitie->id !== 1)
                    <div class="custom-control custom-checkbox col-6">
                        <input name="abilities[{{ $abilitie->id }}]"
                               class="custom-control-input"
                               type="checkbox"
                               id="role_{{ $abilitie->id }}"
                               value="{{ $abilitie->id }}"
                                {{ old("abilities.{$abilitie->id}") || in_array($abilitie->id, $role->getAbilities()->pluck('id', 'id')->toArray()) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="role_{{ $abilitie->id }}">{{ $abilitie->title }}</label>
                    </div>
                @endif
            @endforeach

            @if ($errors->has('abilities[]'))
                <span class="help-block">{{ $errors->first('abilities[]') }}</span>
            @endif
        </div>
    </div>
</div>