<?php

declare(strict_types=1);

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Aguva\Ussd\Traits\HasUuid;

class UssdSession extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected array $guarded = ['id'];

    /**
     * @return BelongsTo<UssdActivity, $this>
     */
    public function ussdActivities(): BelongsTo
    {
        return $this->belongsTo(UssdActivity::class, 'session_id', 'session_id');
    }
}