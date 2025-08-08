<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class SmsService
{
    protected $client;
    protected $authEndpoint = 'https://sms.nitext.co.ke/api/auth/get_token';
    protected $messageEndpoint = 'https://sms.nitext.co.ke/api/send-bulk-api';

    protected $sendername = 'TALENTBRDG';

    public function __construct()
    {
        $this->client = new Client();
    }

    protected function getAccessToken()
    {
        return Cache::remember('api_token', 1440, function () {
            try {
                $response = $this->client->post($this->authEndpoint, [
                    'json' => [
                        'email' => 'chrispine.ochieng@royalmedia.co.ke',
                        'password' => '_Qoc:rW198x,'
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                return $data['data']['token'] ?? null;
            } catch (RequestException $e) {
                \Log::error($e);
                throw new \Exception('Failed to fetch access token: ' . $e->getMessage());
            }
        });
    }

    public function sendMessage(string $recipient, string $message): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $this->getAccessToken();
            $payload = [
                'sendername' => $this->sendername,
                'scheduled_time' => now()->addSeconds(30)->format('Y-m-d H:i:s'),
                'message' => [
                    [
                        'recipients' => [$recipient],
                        'body' => $message
                    ]
                ]
            ];

            $response = $this->client->post($this->messageEndpoint, [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            return response()->json([
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true)
            ]);

        } catch (RequestException $e) {
            \Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
