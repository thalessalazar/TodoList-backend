<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;

class FinanceService
{
    private TransactionRepository $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function balance(int $user_id)
    {
        $transactions = $this->transactionRepository->getAllByUserId($user_id);

        $balance = 0;

        foreach ($transactions as $transaction) {
            $balance += $transaction->type === 'REVENUE' ? $transaction->value : -$transaction->value;
        }

        return $balance / 100;
    }
}
