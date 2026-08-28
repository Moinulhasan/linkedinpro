<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProfileAudit extends Model
{
    protected $fillable = [
        'user_id',
        'uuid',
        'original_filename',
        'pdf_path',
        'status',
        'result',
        'score',
        'verdict',
        'recommendations',
        'sections',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'recommendations' => 'array',
            'sections' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ProfileAudit $audit) {
            $audit->uuid ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
