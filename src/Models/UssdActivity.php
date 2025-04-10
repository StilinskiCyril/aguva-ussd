<?php

declare(strict_types=1);

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Aguva\Ussd\Traits\HasUuid;

class UssdActivity extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected array $guarded = ['id'];

    /**
     * @return HasMany<UssdActivityLog, $this>
     */
    public function ussdActivityLogs(): HasMany
    {
        return $this->hasMany(UssdActivityLog::class);
    }

    /**
     * @return HasMany<UssdMessage, $this>
     */
    public function ussdMessages(): HasMany
    {
        return $this->hasMany(UssdMessage::class, 'session_id', 'session_id');
    }

    /**
     * @return BelongsTo<UssdUser, $this>
     */
    public function ussdUser(): BelongsTo
    {
        return $this->belongsTo(UssdUser::class, 'msisdn', 'msisdn');
    }

    /**
     * @return BelongsTo<UssdSession, $this>
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(UssdSession::class, 'session_id', 'session_id');
    }
}