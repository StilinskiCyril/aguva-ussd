<?php

namespace Aguva\Ussd\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateMsisdn implements ValidationRule
{
    public mixed $uniqueCheck;
    public mixed $model;
    public mixed $region;
    public mixed $column;
    public mixed $sourceParam;


    public function __construct($uniqueCheck = true, $model = 'User', $region = 'KE', $column = 'msisdn', $sourceParam = 'msisdn')
    {
        $this->uniqueCheck = $uniqueCheck;
        $this->model = $model;
        $this->region = $region;
        $this->column = $column;
        $this->sourceParam = $sourceParam;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $validation = validateMsisdn($value, $this->region);

        if (!$validation['isValid']) {
            $fail('Phone number '.$validation['msisdn']. ' is invalid.');
        }

        if ($this->uniqueCheck){
            $record = $this->model::where($this->column, $validation['msisdn'])->first();
            if ($record) {
                $fail('Phone number '.$validation['msisdn']. ' already taken.');
            }
        }

        request()->merge([$this->sourceParam => $validation['msisdn']]);
    }
}
