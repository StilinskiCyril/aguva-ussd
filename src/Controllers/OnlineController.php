<?php

namespace Aguva\Ussd\Controllers;

use Aguva\Ussd\Repositories\Handler;
use Illuminate\Http\Request;
use Aguva\Ussd\Rules\ValidateMsisdn;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class OnlineController extends Controller
{
    // Validate and process payload from provider
    function processPayload(Request $request){
        $this->validate($request, [
            'msisdn' => ['required', 'string', new ValidateMsisdn(false)],
            'sessionId' => ['required', 'string'],
            'text' => ['nullable', 'string']
        ]);

        // Log the payload
        if (config('ussd.restrict_to_whitelist')){
            Log::info(json_encode($request->all()));
        }

        $input = $this->cleanUssd($request->text);
        $originalUssdString = '*'.config('ussd.ussd_code').'*'.$request->text.'#';
        $msisdn = $request->msisdn;
        $sessionId = $request->sessionId;

        if (str_contains($msisdn, '+')){
            $newMsisdn = explode('+', $msisdn)[1];
        } else {
            $newMsisdn = $msisdn;
        }

        // Whitelist msisdns that can access the USSD
        if (config('ussd.restrict_to_whitelist') && !in_array($newMsisdn, explode(',', config('ussd.whitelist_msisdns')))){
            return "END AGUVA-USSD";
        }

        $activityLibrary = new Handler($newMsisdn, $sessionId, $input, $originalUssdString);
        $response = $activityLibrary->finalResponse();

        // Delay session end to give stk time to arrive (in case your app has an m-pesa stk feature).
        if ($response['endSession']) {
            sleep(config('ussd.end_session_sleep_seconds'));
        }

        return $response['endSession'] ? "END " . $response['response'] : "CON " . $response['response'];
    }

    public function cleanUssd($ussdString)
    {
        if (!$ussdString) {
            return '';
        }

        return collect(explode("*", $ussdString))->last();
    }
}