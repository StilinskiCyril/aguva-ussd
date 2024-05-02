<?php

namespace Aguva\Ussd\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model){
            $model->uuid = Str::orderedUuid()->toString();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}