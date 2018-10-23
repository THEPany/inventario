<?php

namespace App\Http\Controllers;

use App\Provider;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::paginate();
        return view('provider/index')->with(['providers' => $providers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provider = new Provider;
        return view('provider/create')->with(['provider' => $provider]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|min:14|max:14|unique:providers',
            'address' => 'required|min:15',
        ]);

        Provider::create([
            'name' => request()->name,
            'phone' => request()->phone,
            'address' => request()->address
        ]);

        return back()->with(['flash_success' => "Proveedor ".request()->name." creado exitosamente"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        return view('provider/edit')->with(['provider' => $provider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Provider $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Provider $provider)
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|min:14|max:14|unique:providers,phone,'. $provider->id,
            'address' => 'required|min:15',
        ]);

        $provider->update([
            'name' => request()->name,
            'phone' => request()->phone,
            'address' => request()->address
        ]);

        return back()->with(['flash_success' => "Proveedor ".request()->name." actualizado exitosamente"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
