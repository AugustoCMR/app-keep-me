<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Routing\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Repositories\Account\AccountRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = $this->repository->all();

        if($accounts->isEmpty())
        {
            return response()->json(['message' => 'No accounts found'], 200);
        }

        return response()->json($accounts, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $account = $this->repository->create($request->all());

        $user = auth('api')->user();

        $user->accounts()->attach($account->id);

        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $account = $this->repository->find($id);

        if(empty($account))
        {
            return response()->json(['message' => 'No account found'], 404);
        }

        return response()->json($account, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $account = $this->repository->find($id);

        if(empty($account))
        {
            return response()->json(['message' => 'No account found'], 404);
        }

        $this->repository->delete($id);

        return response()->noContent();
    }
}
