<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view(view: 'chirps.index',data: [
            'chirps'=>Chirp::with(relations: 'user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate(rules: [
            'message' => 'required|string|min:5|max:255',
        ]);
        $request->user()->chirps()->create($validated);
        return redirect(to: route(name: 'chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp): void
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp):View
    {
        Gate::authorize(ability: 'update', arguments: $chirp);
        return view(view: 'chirps.edit',data: [
            'chirp'=>$chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp):RedirectResponse
    {
        Gate::authorize(ability: 'update',arguments: $chirp);
        $validated= $request->validate(rules: [
            'message'=>'required|string|max:255'
        ]);
        $chirp->update(attributes: ($validated));
        return redirect(to: route(name: 'chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp):RedirectResponse
    {
        Gate::authorize(ability: 'update',arguments: $chirp);
        $chirp->delete();
        return redirect(to: route(name: 'chirps.index'));
    }
}
