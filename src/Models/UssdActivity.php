<?php

namespace Aguva\Ussd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Aguva\Ussd\Traits\HasUuid;

class UssdActivity extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = ['id'];

    public function ussdActivityLogs()
    {
        return $this->hasMany(UssdActivityLog::class);
    }

    public function ussdMessages()
    {
        return $this->hasMany(UssdMessage::class, 'session_id', 'session_id');
    }

    public function ussdUser()
    {
        return $this->belongsTo(UssdUser::class, 'msisdn', 'msisdn');
    }

    public function session()
    {
        return $this->belongsTo(UssdSession::class, 'session_id', 'session_id');
    }
}