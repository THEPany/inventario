<?php

namespace App\Http\Controllers\Tenant;

use App\Provider;
use App\BranchOffice;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenat-view', Provider::class);

        $providers = Provider::where('branch_office_id', $branchOffice->id)->paginate();

        return view('tenant.provider.index', compact('branchOffice', 'providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Provider::class);

        $provider = new Provider;

        return view('tenant.provider.create', compact('branchOffice', 'provider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(BranchOffice $branchOffice)
    {
        $this->authorize('tenat-create', Provider::class);

        request()->validate([
            'name' => 'required',
            'phone' => [
                'required',
                'min:14',
                'max:14',
                Rule::unique('providers')->where(function ($query) use ($branchOffice) {
                    $query->where([
                            ['phone', request()->phone],
                            ['branch_office_id', $branchOffice->id]
                    ]);
                })
            ],
            'address' => 'required|min:15',
        ]);

        $branchOffice->providers()->create([
            'name' => request()->name,
            'phone' => request()->phone,
            'address' => request()->address
        ]);

        return back()->with(['flash_success' => "Proveedor ".request()->name." creado exitosamente"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Provider $provider
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Provider $provider)
    {
        $this->authorize('tenant-update', $provider);

        abort_unless($provider->branch_office_id == $branchOffice->id, 403);

        return view('tenant.provider.edit', compact('branchOffice', 'provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Provider $provider
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BranchOffice $branchOffice, Provider $provider)
    {
        $this->authorize('tenant-update', $provider);

        abort_unless($provider->branch_office_id == $branchOffice->id, 403);

        request()->validate([
            'name' => 'required',
            'phone' => [
                'required',
                'min:14',
                'max:14',
                Rule::unique('providers')->ignore($provider->id)->where(function ($query) use ($branchOffice) {
                    $query->where([
                        ['phone', request()->phone],
                        ['branch_office_id', $branchOffice->id]
                    ]);
                }),
            ],
            'address' => 'required|min:15',
        ]);

        $provider->update([
            'name' => request()->name,
            'phone' => request()->phone,
            'address' => request()->address
        ]);

        return back()->with(['flash_success' => "Proveedor ".request()->name." actualizado exitosamente"]);
    }
}
