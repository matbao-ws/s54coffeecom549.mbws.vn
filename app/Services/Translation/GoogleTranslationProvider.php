<?php

namespace App\Services\Translation;

use App\Contracts\TranslationProvider;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class GoogleTranslationProvider implements TranslationProvider
{
    public function translate(array $texts, string $sourceLocale, string $targetLocale, string $format = 'text'): array
    {
        if (! $this->configured()) {
            throw new RuntimeException('translation_provider_not_configured');
        }

        $endpoint = config('multilingual.translation.google.endpoint', 'https://translate.googleapis.com/translate_a/single');
        $timeout = (int) config('multilingual.translation.google.timeout', 12);
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';

        foreach (array_values($texts) as $text) {
            if ($text === '') {
                $translations[] = '';

                continue;
            }

            $translatedText = null;

            // Strategy 1: Primary translate_a/single with client=dict-chrome-ex
            try {
                $response = Http::acceptJson()
                    ->asForm()
                    ->timeout($timeout)
                    ->retry(2, 250, throw: false)
                    ->withHeaders([
                        'User-Agent' => $userAgent,
                        'Accept' => '*/*',
                    ])
                    ->withQueryParameters([
                        'client' => 'dict-chrome-ex',
                        'dt' => 't',
                        'ie' => 'UTF-8',
                        'oe' => 'UTF-8',
                        'sl' => $sourceLocale,
                        'tl' => $targetLocale,
                    ])
                    ->post($endpoint, [
                        'q' => $text,
                    ]);

                if ($response->successful()) {
                    $segments = $response->json('0');
                    if (is_array($segments)) {
                        $translated = collect($segments)
                            ->filter(fn ($segment) => is_array($segment) && array_key_exists(0, $segment))
                            ->map(fn (array $segment) => (string) $segment[0])
                            ->implode('');

                        if (filled($translated)) {
                            $translatedText = $translated;
                        }
                    }
                }
            } catch (Throwable) {
                // proceed to fallback
            }

            // Strategy 2: Fallback to clients5.google.com/translate_a/t
            if ($translatedText === null) {
                try {
                    $response = Http::asForm()
                        ->timeout($timeout)
                        ->retry(2, 250, throw: false)
                        ->withHeaders([
                            'User-Agent' => $userAgent,
                            'Accept' => '*/*',
                        ])
                        ->withQueryParameters([
                            'client' => 'dict-chrome-ex',
                            'sl' => $sourceLocale,
                            'tl' => $targetLocale,
                        ])
                        ->post('https://clients5.google.com/translate_a/t', [
                            'q' => $text,
                        ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        if (is_array($data) && !empty($data)) {
                            $first = $data[0];
                            if (is_string($first) && filled($first)) {
                                $translatedText = $first;
                            } elseif (is_array($first) && isset($first[0]) && is_string($first[0]) && filled($first[0])) {
                                $translatedText = $first[0];
                            }
                        }
                    }
                } catch (Throwable) {
                    // proceed to fallback
                }
            }

            // Strategy 3: Legacy fallback with client=gtx
            if ($translatedText === null) {
                try {
                    $response = Http::acceptJson()
                        ->asForm()
                        ->timeout($timeout)
                        ->withHeaders([
                            'User-Agent' => $userAgent,
                        ])
                        ->withQueryParameters([
                            'client' => 'gtx',
                            'dt' => 't',
                            'ie' => 'UTF-8',
                            'oe' => 'UTF-8',
                            'sl' => $sourceLocale,
                            'tl' => $targetLocale,
                        ])
                        ->post($endpoint, [
                            'q' => $text,
                        ]);

                    if ($response->successful()) {
                        $segments = $response->json('0');
                        if (is_array($segments)) {
                            $translated = collect($segments)
                                ->filter(fn ($segment) => is_array($segment) && array_key_exists(0, $segment))
                                ->map(fn (array $segment) => (string) $segment[0])
                                ->implode('');

                            if (filled($translated)) {
                                $translatedText = $translated;
                            }
                        }
                    }
                } catch (Throwable) {
                    // all strategies exhausted
                }
            }

            if ($translatedText === null || $translatedText === '') {
                throw new RuntimeException('translation_provider_failed_all_strategies');
            }

            $translations[] = $translatedText;
        }

        return $translations;
    }

    public function configured(): bool
    {
        return filled(config('multilingual.translation.google.endpoint'));
    }

    public function name(): string
    {
        return 'google-unofficial';
    }
}
