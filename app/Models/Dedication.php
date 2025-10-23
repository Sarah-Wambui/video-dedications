<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'dedication_type',
        'other_type',
        'honoree_name',
        'short_note',
        'consent_spelling',
        'status',
        'order_id',
        'metadata',
        'amount_cents',
    ];

    protected $casts = [
        'consent_spelling' => 'boolean',
        'metadata' => 'array',
    ];

    public static function statuses(): array
    {
        return [
            'draft',
            'pending_payment',
            'paid',
            'failed',
        ];
    }
}
