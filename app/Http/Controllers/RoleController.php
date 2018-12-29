<?php

namespace App\Http\Controllers;

use Silber\Bouncer\Database\{Ability, Role};
use App\Http\Requests\{StoreRoleRequest, UpdateRoleRequest};

class RoleController extends Controller
{

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Role::class);

        $roles = Role::paginate();

        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $abilities = Ability::all()->groupBy('entity_type');

        $role = new Role;

        return view('role.create', compact('abilities', 'role'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        return redirect()->route('roles.index')->with(['flash_success' => $request->createRole()]);
    }

    /**
     * Show the form for editing Role.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        abort_if($role->id === 1, 403);

        $abilities = Ability::all()->groupBy('entity_type');

        return view('role.edit', compact('role', 'abilities'));
    }

    /**
     * Update Role in storage.
     *
     * @param \App\Http\Requests\UpdateRoleRequest $request
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        abort_if($role->id === 1, 403);

        return redirect()
            ->route('roles.index')
            ->with(['flash_success' => $request->updateRole($role)]);
    }

    /**
     * Remove Role from storage.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        abort_if($role->id === 1, 403);

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with(['flash_success' => "Rol {$role->title} eliminado correctamente."]);
    }

}
