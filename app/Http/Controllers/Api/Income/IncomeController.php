<?php

namespace App\Http\Controllers\Api\Income;

use Illuminate\Routing\Controller;
use App\Models\Income;
use App\Services\Income\IncomeService;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected IncomeService $service;

    public function __construct(IncomeService $service)
    {
        $this->middleware('auth:api');

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}
