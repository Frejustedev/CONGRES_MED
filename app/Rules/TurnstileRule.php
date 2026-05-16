<?php

namespace App\Rules;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class TurnstileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('payments.turnstile_secret') ?: env('TURNSTILE_SECRET');

        // Mode dev : pas de clé configurée = on bypass
        if (! $secret) {
            return;
        }

        if (! $value) {
            $fail('Captcha manquant.');
            return;
        }

        try {
            $client = new Client(['timeout' => 5]);
            $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ],
            ]);
            $data = json_decode((string) $response->getBody(), true);
            if (! ($data['success'] ?? false)) {
                $fail('Captcha invalide.');
            }
        } catch (\Throwable $e) {
            // En cas d'erreur réseau on laisse passer pour ne pas bloquer l'utilisateur
            logger()->warning('Turnstile verification failed', ['error' => $e->getMessage()]);
        }
    }
}
