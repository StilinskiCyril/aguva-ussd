<?php

declare(strict_types=1);

use Aguva\Ussd\Models\UssdUser;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

function validateMsisdn($msisdn, $region): array
{
    $phoneUtil = PhoneNumberUtil::getInstance();
    try {
        $kenyaNumberProto = $phoneUtil->parse($msisdn, $region);
        $isValid = $phoneUtil->isValidNumber($kenyaNumberProto);
        if ($isValid) {
            $msisdn = $phoneUtil->format($kenyaNumberProto, PhoneNumberFormat::E164);
            return [
                'isValid' => $isValid,
                'msisdn' => substr($msisdn, 1),
            ];
        }
        return [
            'isValid' => $isValid,
            'msisdn' => $msisdn,
        ];
    } catch (NumberParseException $e) {
        return [
            'isValid' => false,
            'msisdn' => $msisdn,
        ];
    }
}

if (!function_exists('generateRandomInteger')){
    function generateRandomInteger($noOfDigits = 6): string
    {
        $i = 0;
        $result = "";

        while($i < $noOfDigits){
            $result .= mt_rand(0, 9);
            $i++;
        }

        return $result;
    }
}

if (!function_exists('saveUser')){
    function saveUser($userData): void
    {
        UssdUser::create([
            'msisdn' => $userData['msisdn'],
        ]);
    }
}
