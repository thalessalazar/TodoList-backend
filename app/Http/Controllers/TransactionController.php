<?php

namespace App\Http\Controllers;

use App\Enums\TransactionEnum;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\FinanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected FinanceService $financeService;
    protected TransactionRepository $transactionRepository;

    public function __construct(FinanceService $financeService, TransactionRepository $transactionRepository)
    {
        $this->financeService = $financeService;
        $this->transactionRepository = $transactionRepository;
    }

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
        $input = $request->validated();
        $transaction = auth()->user()->transactions()->create([
            'title' => $input['title'],
            'value' => $input['value'] * 100,
            'date' => $input['date'],
            'type' => $input['type'],
        ]);
        return new TransactionResource($transaction);
    }

    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->authorize('update', $transaction);
        $input = $request->validated();

        if (isset($input['value'])) {
            $input['value'] *= 100;
        }

        $transaction->fill($input)->save();
        return new TransactionResource($transaction->fresh());
    }

    public function stats()
    {
        return $this->financeService->stats(auth()->id());
    }

    public function destroy(Transaction $transaction): void
    {
        $this->authorize('destroy', $transaction);
        $this->transactionRepository->delete($transaction->id);
        return;
    }
}
