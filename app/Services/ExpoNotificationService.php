<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExpoNotificationService
{
    public function send(
        string $expoPushToken,
        string $title,
        string $body,
        array $data = []
    ): void {
        try {
            $response = Http::post(
                'https://exp.host/--/api/v2/push/send',
                [
                    'to' => $expoPushToken,

                    'title' => $title,

                    'body' => $body,

                    'sound' => 'default',

                    'priority' => 'high',

                    'data' => $data,
                ]
            );

            Log::info(
                'Expo notification response',
                [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error(
                'Expo notification failed',
                [
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
}