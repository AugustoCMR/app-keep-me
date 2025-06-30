<?php

namespace App\Http\Controllers\Api\Account;

use App\Repositories\Account\AccountRepository;
use App\Services\Account\AccountService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    protected AccountService $service;

    public function __construct(AccountService $service)
    {
        $this->middleware('auth:api');

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = $this->service->getAll();

        return response()->json($accounts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $account = $this->service->createAccountAndAttachToUser($request->all());

        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     * @throws \Exception
     */
    public function show(int $id)
    {
        $account = $this->service->findById($id);

        return response()->json($account, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $account = $this->service->update($request->all(), $id);

        return response()->json($account, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->detachAccountFromUser($id);

        if(empty($account))
        {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->noContent();
    }
}
