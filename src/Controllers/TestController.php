<?php

namespace Aguva\Ussd\Controllers;

use Aguva\Ussd\Repositories\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Aguva\Ussd\Rules\ValidateMsisdn;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
    // Show the simulator
    public function showSimulator(){
        return view('ussd-views::simulator', ['input' => ['session_id' => Str::uuid()]]);
    }


    // Process the payload
    public function processPayload(Request $request)
    {
        $request->validate([
            'msisdn' => ['required', new ValidateMsisdn(false)],
            'text' => ['nullable'],
            'sessionId' => ['required']
        ]);

        $input = $request->text;
        $originalUssdString = $input;
        $msisdn = $request->msisdn;
        $sessionId = $request->sessionId;

        if (str_contains($msisdn, '+')){
            $newMsisdn = explode('+', $msisdn)[1];
        } else {
            $newMsisdn = $msisdn;
        }

        // Whitelist msisdns
        if (config('ussd.restrict_to_whitelist') && !in_array($newMsisdn, explode(',', config('ussd.whitelist_msisdns')))){
            return "END AGUVA-USSD";
        }

        $activityLibrary = new Handler($newMsisdn, $sessionId, $input, $originalUssdString);
        $response = $activityLibrary->finalResponse();
        $text = $response['response'];
        $input = request()->except('_token');

        return view('ussd-views::simulator', compact('text', 'input'));
    }

    public function cleanUssd($ussdString){
        if (!$ussdString) {
            return '';
        }
        return collect(explode("*", $ussdString))->last();
    }
}