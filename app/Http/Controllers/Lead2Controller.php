<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLead2Request;
use App\Http\Requests\UpdateLead2Request;
use App\Models\Lead2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class Lead2Controller extends Controller
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
    public function store(StoreLead2Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead2 $lead2): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead2 $lead2): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLead2Request $request, Lead2 $lead2): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead2 $lead2): RedirectResponse
    {
        //
    }
}
