<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SmsService
{
    protected string $tokenCacheKey;
    protected string $apiUrl;
    protected string $authUrl;
    protected string $username;
    protected string $password;

    public function __construct()
    {
        $this->tokenCacheKey = config('sms.cache_key', 'sms_api_token');
        $this->apiUrl = 'https://sms.nitext.co.ke/api/send-bulk-api';
        $this->authUrl = config('sms.auth_url', env('SMS_AUTH_URL'));
        $this->username = env('SMS_USERNAME');
        $this->password = env('SMS_PASSWORD');
    }

    public function sendMessage(array $payload): array
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->post($this->apiUrl, $payload);

        if ($response->unauthorized()) {
            // Invalidate token & retry
            Cache::forget($this->tokenCacheKey);
            $token = $this->getToken();

            $response = Http::withToken($token)
                ->post($this->apiUrl, $payload);
        }

        return $response->json();
    }

    protected function getToken(): string
    {
        return Cache::remember($this->tokenCacheKey, now()->addMinutes(), function () {
            return $this->fetchToken();
        });
    }

    protected function fetchToken(): string
    {
        $response = Http::post($this->authUrl, [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        if ($response->successful() && isset($response['access_token'])) {
            return $response['access_token'];
        }

        throw new \Exception('Unable to fetch SMS API token.');
    }
}
