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
}
