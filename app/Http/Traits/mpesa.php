<?php

namespace App\Http\Traits;

use App\Models\Application;
use App\Models\ApplicationPayment;
use App\Models\Payment;
use Carbon\Carbon;
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
    private mixed $consumer_secret;
    private mixed $pass_key;
    private mixed $consumer_key;
    private mixed $short_code;

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

        $this->skyworld_base_url= "https://talentbridge.co.ke";
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
            $client = new Client();
            $mpesa_base_url = "https://api.safaricom.co.ke/";
            $response = $client->post($mpesa_base_url . $end_url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generateToken($consumer_secret, $consumer_key),
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestBody
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (BadResponseException $exception) {
            \Log::info($exception);
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
        return base64_encode($shortcode . $pass_key . date('YmdHis'));
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
            $client = new Client();

            $response = $client->get('https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
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
        try {
            $consumer_secret = config('mpesa.consumer_secret');
            $consumer_key = config('mpesa.consumer_key');
            $stk_url =  "mpesa/stkpush/v1/processrequest";
            $pass_key = config('mpesa.pass_key');
            $shortcode = config('mpesa.short_code');
            $call_back_url = 'https://talentbridge.co.ke/api/stk-push-response';

            $requestBody = [
                'BusinessShortCode' => $shortcode,
                'Password' => $this->getPassword($pass_key, $shortcode),
                'Timestamp' => date('YmdHis'),
                'TransactionType' => "CustomerPayBillOnline",
                'Amount' => $data['amount'],
                'PartyA' =>  str_replace("+", "", formatPhoneNumber($data['phone_number'])),
                "PartyB" => $shortcode,
                "PhoneNumber" =>  str_replace("+", "", formatPhoneNumber($data['phone_number'])),
                "CallBackURL" => $call_back_url,
                "AccountReference" => $data['application_code'],
                "TransactionDesc" => 'job application payment'
            ];

            return $this->post($stk_url, $requestBody, $consumer_secret, $consumer_key);
        } catch (\Exception $exception) {
            \Log::info($exception);
        }
    }

    public function stkPushResponse($request): bool
    {
        $call_back = $request['Body']['stkCallback'];
        $merchant_request_id = $call_back['MerchantRequestID'];
        $checkout_request_id = $call_back['CheckoutRequestID'];
        $request_code = $call_back['ResultCode'];
        $result_desc = $call_back['ResultDesc'];
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

                $payment = Payment::where('merchant_request_id', $merchant_request_id)
                    ->where('checkout_request_id', $checkout_request_id)
                    ->first();

                if (!$payment) {
                    return false;
                }

                $lock = Cache::lock("call_back_data_{$transaction_reference}", 300);

                if ($lock->get()) {
                    $payment->update([
                        'status_id' => loadStatusId('Draft'),
                        'additional_information' => $phone_number,
                        'payload' => json_encode($request),
                        'transaction_reference' =>$transaction_reference,
                        'transaction_date' => Carbon::now()->getTimestamp()
                    ]);
                    ApplicationPayment::where('payment_id', $payment->id)->first()->update([
                        'amount' => 1000,
                        'balance' => 0
                    ]);
                    return true;
                } else {
                    return false;
                }
            } else {
                //SEND SMS
                return false;
            }
        } catch (\Exception $exception) {
            Log::info($exception);
            return false;
        }
    }


    public function amountsAreEqual($amount1, $amount2, $precision = 2): bool {
        return round($amount1, $precision) === round($amount2, $precision);
    }

    public function validation($request): \Illuminate\Http\JsonResponse
    {
        $Amount = $request['TransAmount'];
        $BillRefNumber = normalizeToUpper($request['BillRefNumber']);

        try {
            // Check if BillRefNumber matches a booking
            $application = Application::where('application_code', $BillRefNumber)->first();

            if ($application) {

                if ($this->amountsAreEqual(1000, $Amount)) {
                    return response()->json([
                        'ResultCode' => "0",
                        'ResultDesc' => "Accepted"
                    ]);
                } else {
                    return response()->json([
                        'ResultCode' => "C2B00013",
                        'ResultDesc' => "Rejected"
                    ]);
                }

            } else {
                return response()->json([
                    'ResultCode' => "C2B00016",
                    'ResultDesc' => "Rejected"
                ]);
            }


        } catch (\Exception $exception) {
            Log::error($exception);
            return response()->json([
                'ResultCode' => "C2B00016",
                'ResultDesc' => "Rejected"
            ]);
        }
    }

    public function c2bConfirmation ($request): bool
    {
        $trans_reference = $request['TransID'];
        $amount = $request['TransAmount'];
        $booking_code = normalizeToUpper($request['BillRefNumber']);
    }
}
