<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return TransactionResource::collection(auth()->user()->transactions()->latest()->get());
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('show', $transaction);
        return new TransactionResource($transaction);
    }

    public function store(CreateTransactionRequest $request)
    {

    }
}
