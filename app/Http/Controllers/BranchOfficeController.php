<?php

namespace App\Http\Controllers;

use App\BranchOffice;
use Illuminate\Http\Request;

class BranchOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('create', BranchOffice::class);

        return view('branch_office.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', BranchOffice::class);

        $branchOffice = new BranchOffice;

        return view('branch_office.create')->with(['branchOffice' => $branchOffice]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', BranchOffice::class);

        request()->validate([
            'name' => 'required|unique:branch_offices'
        ]);

        BranchOffice::create([
            'name' => request()->name,
            'slug' => str_slug(request()->name, '-'),
        ]);

        return back()->with(['flash_success' => "Sucursal ".request()->name." Creada correctamente"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice)
    {
        $this->authorize('update', $branchOffice);

        return view('branch_office.edit')->with(['branchOffice' => $branchOffice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BranchOffice $branchOffice)
    {
        $this->authorize('update', $branchOffice);
    }
}
