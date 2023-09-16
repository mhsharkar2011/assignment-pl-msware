<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        if (request()->is('api*')) {
            return response()->json($user, 200);
        } else {
            return back()->with('status', 'User Added successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Deposit ------------------------------------------------------------
    public function showDeposit()
    {
        $deposits = DB::table('transactions')
            ->where('amount', '>', 0)
            ->get();
        return response()->json($deposits);
    }

    public function deposit(Request $request)
    {
        $userId = $request->input('user_id');
        $amount = $request->input('amount');

        // Validate the user ID and amount as needed

        // Retrieve the user by ID
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user's balance
        $user->balance += $amount;
        $user->save();

        return response()->json(['message' => 'Deposit successful']);
    }

// withdrawal -----------------------------------------------------------------------
    public function withdrawal(Request $request)
    {
        $userId = $request->input('user_id');
        $amount = $request->input('amount');
    
        // Validate the user ID, amount, and check if the user has sufficient balance
    
        // Retrieve the user by ID
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        // Check if the user has sufficient balance
        if ($user->balance < $amount) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }
    
        // Get the user's account type
        $accountType = $user->account_type;
    
        // Get the withdrawal rate based on the account type
        $withdrawalRate = Config::get("withdrawal_rates.$accountType", 0);
    
        // Calculate the withdrawal fee
        $withdrawalFee = ($withdrawalRate / 100) * $amount;
    
        // Deduct the withdrawn amount and fee from the user's balance
        $user->balance -= ($amount + $withdrawalFee);
        $user->save();
    
        return response()->json(['message' => 'Withdrawal successful']);
    }
}
