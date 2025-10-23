<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'uuid',
    ];

    protected $casts = [
        'consent_spelling' => 'boolean',
        'metadata' => 'array',
        'uuid' => 'string',
    ];

    /**
     * Auto-generate uuid for new records.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Use uuid for route model binding by default.
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

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
