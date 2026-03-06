<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resident extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'address',
        'birthdate',
        'gender',
        'civil_status',
        'occupation',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
        ];
    }

    /**
     * Get the user associated with the resident.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
