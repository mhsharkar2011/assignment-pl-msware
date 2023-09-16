<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = DB::table('users AS u')
            ->select(
                'u.id AS user_id',
                'u.name AS user_name',
                'u.account_type',
                't.id AS transaction_id',
                't.amount',
                't.fee',
                't.date',
                DB::raw('SUM(
                            CASE
                                WHEN u.account_type = "Individual" THEN (t.amount - t.fee)
                                WHEN u.account_type = "Business" THEN (t.amount - t.fee)
                                ELSE 0
                            END
                            ) OVER (PARTITION BY u.id ORDER BY t.date) AS balance')
            )
            ->leftJoin('transactions AS t', 'u.id', '=', 't.user_id')
            ->orderBy('u.id')
            ->orderBy('t.date')
            ->get();

        return response()->json($transactions);
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
        $transaction = Transactions::create($request->all());
        return response()->json($transaction, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}
