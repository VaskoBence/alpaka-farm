<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'visit_date',
        'visit_time',
        'guests',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'guests' => 'integer',
        ];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
