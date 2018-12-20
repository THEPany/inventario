<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email,'. $this->user->id,
            'password' => 'nullable|min:6|confirmed',
            'branch_office_id' => 'required',
            'role' => 'nullable|String'
        ];
    }

    public function attributes ()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'branch_office_id' => 'sucursal',
            'role' => 'rol'
        ];
    }

    public function updateUser(User $user)
    {
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'branch_office_id' => $this->branch_office_id
        ]);

        if(isset($this->password)) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->roles->each(function ($role) use ($user) {
            $user->retract($role);
        });

        if (isset($this->role)){
            $user->assign($this->role);
        }

        return "Usuario {$user->name} actualizado con exito.";
    }
}