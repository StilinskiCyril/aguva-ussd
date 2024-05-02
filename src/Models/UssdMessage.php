<?php

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Aguva\Ussd\Traits\HasUuid;

class UssdMessage extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = ['id'];

    public function ussdActivity()
    {
        return $this->belongsTo(UssdActivity::class);
    }
}