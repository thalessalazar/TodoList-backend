<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function getAllByUserId(int $user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function getTotalExpensesByUserId(int $user_id): float
    {
        return $this->model->where([['user_id', $user_id], ['type', 'EXPENSE']])->sum('value') / 100;
    }

    public function getTotalRevenuesByUserId(int $user_id): float
    {
        return $this->model->where([['user_id', $user_id], ['type', 'REVENUE']])->sum('value') / 100;
    }

    public function getBalanceByUserId(int $user_id): float
    {
        $transactions = $this->getAllByUserId($user_id);

        $balance = 0;

        foreach ($transactions as $transaction) {
            $balance += $transaction->type === 'REVENUE' ? $transaction->value : -$transaction->value;
        }

        return $balance / 100;
    }
}
