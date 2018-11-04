<?php

namespace App\Http\Controllers;

use App\{BranchOffice, User};
use Silber\Bouncer\Database\Role;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', User::class);

        $users = User::paginate();

        return view('user.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $branchOffices = BranchOffice::all();
        $roles = Role::all();
        $user = new User;

        return view('user.create', compact('user', 'branchOffices', 'roles'));
    }

    /**
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        return redirect()
            ->route('users.index')
            ->with(['flash_success' => $request->createUser()]);
    }

    /**
     * @param \App\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', User::class);

        $branchOffices = BranchOffice::all();
        $roles = Role::all();

        return view('user.edit', compact('user', 'branchOffices', 'roles'));
    }

    /**
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        return redirect()
            ->route('users.index')
            ->with(['flash_success' => $request->updateUser($user)]);
    }

    /**
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        abort_if($user->id === auth()->id(), Response::HTTP_FORBIDDEN);

        abort_if($user->branchOffice()->exists(),
            Response::HTTP_BAD_REQUEST, "No puedes eliminar el usuario {$user->name}, hay informacion que depende de esta");


        $user->delete();

        return back()
            ->with(['flash_success' => "Usuario {$user->name} eliminado con éxito."]);
    }
}
