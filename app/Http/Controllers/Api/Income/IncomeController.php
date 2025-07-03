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
     * @OA\Get(
     *     path="/api/incomes",
     *     summary="List incomes",
     *     tags={"Incomes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List incomes"
     *     )
     * )
     */
    public function index()
    {
        $incomes = $this->service->getAll();

        return response()->json($incomes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $income = $this->service->create($request->all());
        return response()->json($income, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $income = $this->service->findById($id);

        return response()->json($income, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $income = $this->service->update($request->all(), $id);

        return response()->json($income, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
