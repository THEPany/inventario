<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'branch_office_id' => 'required',
            'role' => 'nullable|String'
        ];
    }
    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'branch_office_id' => 'sucursal',
            'role' => 'rol'
        ];
    }
    public function createUser()
    {
        $user = User::forceCreate([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'branch_office_id' => $this->branch_office_id,
        ]);

        if (isset($this->role)){
            $user->assign($this->role);
        }

        return "Usuario {$user->name} creado con éxito.";
    }
}