<?php

namespace App\Http\Traits;

use App\Models\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait mpesa
{
    private \GuzzleHttp\Client $client;
    private string $timestamp;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private string $ip;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $weego_base_url;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $stk_transaction_query;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $register_url;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $generate_token_url;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $mpesa_base_url;

    public function __construct()
    {
        $this->client = new Client();
        $this->timestamp = date('YmdHis');
        $this->ip = $_SERVER['REMOTE_ADDR'] ?? '';

        $this->mpesa_base_url = "https://api.safaricom.co.ke/";
        $this->generate_token_url = "oauth/v1/generate?grant_type=client_credentials";
        $this->register_url = "mpesa/c2b/v2/registerurl";
        $this->stk_push_url = "mpesa/stkpush/v1/processrequest";
        $this->stk_transaction_query = "mpesa/stkpushquery/v1/query";

        $this->weego_base_url = url('/');

        $this->short_code = config('mpesa.short_code');
        $this->consumer_secret = config('mpesa.consumer_secret');
        $this->pass_key = config('mpesa.pass_key');
        $this->consumer_key = config('mpesa.consumer_key');
    }

    /**
     * @param $end_url
     * @param $requestBody
     * @param $consumer_secret
     * @param $consumer_key
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function post($end_url, $requestBody, $consumer_secret, $consumer_key): mixed
    {
        try {
            $response = $this->client->post($this->mpesa_base_url . $end_url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generateToken($consumer_secret, $consumer_key),
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestBody
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (BadResponseException $exception) {
            return json_decode((string)$exception->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * @param $pass_key
     * @param $shortcode
     * @return string
     *
     */
    public function getPassword($pass_key, $shortcode): string
    {
        return base64_encode($shortcode . $pass_key . $this->timestamp);
    }

    /**
     * @param $consumer_secret
     * @param $consumer_key
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateToken($consumer_secret, $consumer_key): mixed
    {
        try {
            $response = $this->client->get($this->mpesa_base_url . $this->generate_token_url, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
                    'Content-Type' => 'application/json',
                ]
            ]);

            $access_token = json_decode((string)$response->getBody(), true);

            return $access_token['access_token'];
        } catch (BadResponseException $exception) {
            return json_decode((string)$exception->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stkPushRequest($data): mixed
    {
        $user = $data['user'];
        $consumer_secret = $this->consumer_secret;
        $consumer_key = $this->consumer_key;
        $stk_url = $this->stk_push_url;
        $pass_key = $this->pass_key;
        $shortcode = $this->short_code;
        $call_back_url = $this->weego_base_url . '/api/stk-push-response';
        $phone = $data['for'] == "USER" ? $user->UserPhone : $user->phoneNumber;

        $requestBody = [
            'BusinessShortCode' => $shortcode,
            'Password' => $this->getPassword($pass_key, $shortcode),
            'Timestamp' => $this->timestamp,
            'TransactionType' => "CustomerPayBillOnline",
            'Amount' => $data['amount'],
            'PartyA' =>  str_replace("+", "", sanitizePhoneNumber($phone)),
            "PartyB" => $shortcode,
            "PhoneNumber" =>  str_replace("+", "", sanitizePhoneNumber($phone)),
            "CallBackURL" => $call_back_url,
            "AccountReference" => $data['booking_code'],
            "TransactionDesc" => 'ride payment'
        ];

        return $this->post($stk_url, $requestBody, $consumer_secret, $consumer_key);
    }

    public function stkPushResponse($request): bool
    {
        $call_back = $request['Body']['stkCallback'];
        $merchant_request_id = $call_back['MerchantRequestID'];
        $checkout_request_id = $call_back['CheckoutRequestID'];
        $request_code = $call_back['ResultCode'];
        $result_desc = $call_back['ResultDesc'];

        $payment = Payment::where('merchant_request_id', $merchant_request_id)
            ->where('checkout_request_id', $checkout_request_id)
            ->first();

        try {

            if ($request_code == 0) {
                $callback_metadata = $call_back['CallbackMetadata']['Item'];

                $count = count($callback_metadata);

                $transaction_reference = '';

                if ($count == 5) {
                    if ($callback_metadata[2]['Name'] == 'Balance') {
                        $amount = $callback_metadata[0]['Value'];
                        $transaction_reference = $callback_metadata[1]['Value'];
                        $payment_date = $callback_metadata[3]['Value'];
                        $phone_number = $callback_metadata[4]['Value'];
                    } else {
                        Log::info($callback_metadata[2]['Name']);
                    }
                } elseif ($count == 4){
                    $amount = $callback_metadata[0]['Value'];
                    $transaction_reference = $callback_metadata[1]['Value'];
                    $payment_date = $callback_metadata[2]['Value'];
                    $phone_number = $callback_metadata[3]['Value'];
                }

                $lock = Cache::lock("call_back_data_{$transaction_reference}", 300);

                if ($lock->get()) {
                    // LOGIC
                    return true;
                } else {
                    return false;
                }
            } else {
                //SEND SMS
                return false;
            }

                return true;

        } catch (\Exception $exception) {
            return false;
        }
    }

}
