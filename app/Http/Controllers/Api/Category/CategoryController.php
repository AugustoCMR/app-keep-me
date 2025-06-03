<?php

namespace App\Http\Controllers\Api\Category;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    protected CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->all();

        if($categories->isEmpty())
        {
            return response()->json(['message' => 'Categories not found'], 200);
        }

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->repository->create($request->all());

        $user = auth('api')->user();

        $user->categories()->attach($category->id);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->repository->find($id);

        if (empty($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->update($request->all());

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $userId = auth('api')->id();

        $category->users()->detach($userId);

        return response()->noContent();
    }
}
