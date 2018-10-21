<?php
/**
 * Created by PhpStorm.
 * User: wamil
 * Date: 20-Oct-18
 * Time: 12:53
 */

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $rules = [
            'phone' => 'required|numeric',
            'criteria' => 'required|string'
        ];

        $check = $this->checkFields($request->all(), $rules);

        if ($check != 200)
        {
            return response()->json($check, 402);
        }


        $client = new Client();
        $result = $client->request('POST', env('NOKIA_SUBSCRIBE_URL') . "callnotification/v1/subscriptions/callDirection",
            [
                'form_params' => [
                    'callDirectionSubscription' => [
                        'callbackReference' => [
                            'notifyURL' => "http://junction.shamilomarov.com/api/notifications/{$request->get('criteria')}"
                        ],
                        'filter' => [
                            'address' => [
                                "sip:+{$request->get('phone')}@ims8.wirelessfuture.com"
                            ],
                            'criteria' => [
                                $request->get('criteria')
                            ],
                            'addressDirection' => 'Calling'
                        ],
                        'clientCorrelator' => "calling_{$request->get('phone')}"
                    ]
                ],
                'headers' => [
                    'Authorization' => "Bearer ". env('NOKIA_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]

            ]);

        return response()->json([], 200);

    }

    public function notificationReceiver($action, Request $request)
    {

        $responseBody = [
            'action' => [
                'actionToPerform' => 'Continue',
                'digitCapture' => [
                    'playingConfiguration' => [
                        'playFileLocation' => "https://junctionx-nbsp.s3.amazonaws.com/pollyfb7696c7b5f651d15b17dd062d710814.wav",
                        'messageFormat' => 'Audio',
                        'mediaType' => 'audio/wav',
                        'interruptMedia' => 'true'
                    ]
                ]
            ]
        ];
        return response()->json($responseBody, 200);

        return response()->json([], 200);

    }
}