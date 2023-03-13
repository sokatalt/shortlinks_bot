<?php

namespace App\Http\Controllers;

use App\Models\Compain;
use App\Http\Requests\StoreCompainRequest;
use App\Http\Requests\UpdateCompainRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class CompainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompainRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Compain $compain): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compain $compain): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompainRequest $request, Compain $compain): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compain $compain): RedirectResponse
    {
        //
    }
}
