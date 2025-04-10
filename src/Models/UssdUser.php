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

class UssdUser extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected array $guarded = ['id'];

    /**
     * @return HasMany<UssdActivity, $this>
     */
    public function ussdActivities(): HasMany
    {
        return $this->hasMany(UssdActivity::class, 'msisdn', 'msisdn');
    }

    /**
     * @return HasMany<UssdMessage, $this>
     */
    public function ussdMessages(): HasMany
    {
        return $this->hasMany(UssdMessage::class, 'msisdn', 'msisdn');
    }

    /**
     * @return BelongsTo<UssdMessage, $this>
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(UssdSession::class, 'session_id', 'session_id');
    }
}