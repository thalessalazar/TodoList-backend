<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoTask extends Model
{
    use HasFactory;

    protected $table = 'todos_tasks';

    protected $fillable = [
        'title',
        'completed'
    ];

    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }
}
