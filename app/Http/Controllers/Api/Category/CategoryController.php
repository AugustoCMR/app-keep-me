<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->middleware('auth:api');

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->service->getAll();

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->service->createCategoryAndAttachToUser($request->all());
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     * @throws Exception
     */
    public function show(string $id)
    {
        $category = $this->service->findById($id);

        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->service->update($request->all(), $id);

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $this->service->detachCategoryFromUser($id);

        return response()->noContent();
    }
}
