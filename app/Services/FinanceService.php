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

    public function stats(int $user_id): array
    {
        return [
            'balance' => $this->transactionRepository->getBalanceByUserId($user_id),
            'expenses' => $this->transactionRepository->getTotalExpensesByUserId($user_id),
            'revenues' => $this->transactionRepository->getTotalRevenuesByUserId($user_id),
        ];
    }
}
