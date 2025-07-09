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
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="No incomes",
     *          @OA\JsonContent (
     *              @OA\Property(property="message", type="string", example="Incomes not found")
     *          )
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent (
     *               @OA\Property(property="message", type="string", example="Unauthenticated.")
     *           )
     *       )
     * )
     */
    public function index()
    {
        $incomes = $this->service->getAll();

        return response()->json($incomes, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/incomes",
     *     summary="Create income",
     *     tags={"Incomes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "amount", "account_id", "user_id", "category_id"},
     *             @OA\Property(property="description", type="string", example="wallet"),
     *             @OA\Property(property="amount", type="numeric", example=500),
     *             @OA\Property(property="account_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Income created successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="description", type="string", example="salary"),
     *             @OA\Property(property="amount", type="numeric", example="5000"),
     *             @OA\Property(property="account_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
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
