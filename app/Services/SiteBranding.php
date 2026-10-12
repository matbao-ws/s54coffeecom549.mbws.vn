<?php

namespace App\Services;

use App\Models\ProjectSetting;
use App\Support\MediaUrl;

class SiteBranding
{
    private ?array $branding = null;

    /**
     * Return the current website identity with safe local fallbacks.
     *
     * This service is request-scoped, so settings saved in the admin area are
     * picked up on the next page load without leaving stale branding in workers.
     */
    public function current(): array
    {
        if ($this->branding !== null) {
            return $this->branding;
        }

        $settings = ProjectSetting::query()
            ->whereIn('setting_key', ['shop_name', 'logo_url', 'favicon_url', 'contact', 'embed_header', 'embed_body', 'embed_footer'])
            ->pluck('setting_value', 'setting_key');

        $contact = $settings->get('contact');

        return $this->branding = [
            'name' => $this->textValue($settings->get('shop_name')) ?: config('app.name', 'S54 COFFEE'),
            'logo_url' => $this->assetUrl($settings->get('logo_url'), 'client-assets/images/s54/s54_logo.png'),
            'admin_logo_url' => asset('client-assets/images/s54/s54_logo.png'),
            'favicon_url' => $this->assetUrl($settings->get('favicon_url'), 'client-assets/images/s54/s54_favicon_48.png'),
            'contact' => is_array($contact) ? $contact : [],
            'embed_header' => (string) ($settings->get('embed_header') ?? ''),
            'embed_body' => (string) ($settings->get('embed_body') ?? ''),
            'embed_footer' => (string) ($settings->get('embed_footer') ?? ''),
        ];
    }

    private function textValue(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function assetUrl(mixed $value, string $fallback): string
    {
        return (string) MediaUrl::resolve($this->textValue($value), $fallback);
    }
}
