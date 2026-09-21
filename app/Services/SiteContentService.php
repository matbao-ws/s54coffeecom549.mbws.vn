<?php

namespace App\Services;

use App\Models\SiteBlock;
use App\Support\HtmlSanitizer;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Reads and writes overrides for static storefront regions.
 *
 * Registered scoped: a page renders dozens of regions and must not issue a
 * query per region.
 */
class SiteContentService
{
    /** @var array<string, SiteBlock>|null */
    private ?array $blocks = null;

    public function __construct(
        private readonly LanguageRegistry $languages,
        private readonly HtmlSanitizer $htmlSanitizer,
    ) {}

    /**
     * The stored override, or null when the Blade default should win.
     *
     * Null covers both "never edited" and "deliberately emptied"; those mean
     * opposite things, so {@see isCleared()} tells them apart.
     */
    public function value(string $key, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $block = $this->all()[$key] ?? null;

        if (! $block) {
            return null;
        }

        $translations = $block->rawTranslations();
        $stored = $translations[$locale]
            ?? $translations[$this->languages->fallbackLocale()]
            ?? null;

        if (! is_string($stored) || $stored === '') {
            return null;
        }

        return $block->type === SiteBlock::TYPE_IMAGE ? MediaUrl::resolve($stored) : $stored;
    }

    /**
     * Retrieve resolved image URL or default if empty.
     */
    public function image(string $key, ?string $defaultUrl = null, ?string $locale = null): string
    {
        $val = $this->value($key, $locale);

        return ($val !== null && $val !== '') ? $val : ($defaultUrl ?? '');
    }

    /**
     * Retrieve parsed video data (url, poster, is_youtube, youtube_id, embed_url, etc.)
     *
     * @return array{key: string, raw: ?string, url: string, poster: ?string, custom_poster: ?string, is_youtube: bool, youtube_id: ?string, embed_url: ?string}
     */
    public function video(string $key, ?string $defaultUrl = null, ?string $defaultPoster = null, ?string $locale = null): array
    {
        $raw = $this->value($key, $locale);
        $url = $defaultUrl ?? '';
        $poster = $defaultPoster;

        if ($raw !== null && $raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $url = $decoded['url'] ?? $decoded['video_url'] ?? $url;
                if (! empty($decoded['poster']) || ! empty($decoded['poster_url'])) {
                    $poster = $decoded['poster'] ?? $decoded['poster_url'];
                }
            } else {
                $url = $raw;
            }
        }

        // Support separate poster block key if set (e.g. key . '.poster')
        $posterOverride = $this->value($key . '.poster', $locale);
        if ($posterOverride) {
            $poster = $posterOverride;
        }

        // Clean and parse URL
        $url = trim($url);
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $url, $m)) {
            $url = $m[1];
        }

        $youtubeId = null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches)) {
            $youtubeId = $matches[1];
        }

        $isYoutube = ! empty($youtubeId);
        $embedUrl = $isYoutube ? "https://www.youtube.com/embed/{$youtubeId}" : null;
        $youtubeThumbnail = $isYoutube ? "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg" : null;

        if ($poster) {
            $poster = MediaUrl::resolve($poster);
        }

        return [
            'key' => $key,
            'raw' => $raw,
            'url' => $url,
            'poster' => $poster ?: $youtubeThumbnail,
            'custom_poster' => $poster,
            'is_youtube' => $isYoutube,
            'youtube_id' => $youtubeId,
            'embed_url' => $embedUrl,
        ];
    }

    /**
     * True when an admin emptied this region on purpose, so it renders nothing.
     *
     * The signal is the presence of the locale key, not its contents.
     */
    public function isCleared(string $key, ?string $locale = null): bool
    {
        $locale ??= app()->getLocale();
        $block = $this->all()[$key] ?? null;

        if (! $block) {
            return false;
        }

        $translations = $block->rawTranslations();

        return array_key_exists($locale, $translations) && $translations[$locale] === '';
    }

    /**
     * The stored content type, or null when the region has never been saved.
     *
     * A region authored as plain text becomes HTML the moment the inline toolbar
     * formats it, and must keep rendering as HTML on later requests.
     */
    public function type(string $key): ?string
    {
        $type = $this->all()[$key]->type ?? null;

        return in_array($type, SiteBlock::TYPES, true) ? $type : null;
    }

    /**
     * The semantic wrapper an editor chose, or null to keep the Blade tag.
     */
    public function format(string $key): ?string
    {
        $format = $this->all()[$key]->format ?? null;

        return in_array($format, SiteBlock::FORMATS, true) ? $format : null;
    }

    /**
     * Store an override for one locale.
     *
     * `$format` is nullable and defaults to null so the existing callers — the
     * admin block screens, which have no heading control — keep working unchanged.
     *
     * @throws ValidationException
     */
    public function updateLocale(string $key, string $type, string $locale, string $value, ?int $userId, ?string $format = null): SiteBlock
    {
        $this->assertSupported($type, $locale);

        if ($format !== null && ! in_array($format, SiteBlock::FORMATS, true)) {
            throw ValidationException::withMessages(['format' => 'Định dạng tiêu đề không hợp lệ.']);
        }

        // A heading wrapper only means something around rich text; forcing it on a
        // plain label would silently promote that label to HTML.
        if ($format !== null && $type !== SiteBlock::TYPE_HTML) {
            throw ValidationException::withMessages(['format' => 'Định dạng tiêu đề chỉ áp dụng cho nội dung HTML.']);
        }

        $format = $type === SiteBlock::TYPE_HTML ? $format : null;
        $clean = $this->clean($type, $value);

        return DB::transaction(function () use ($key, $type, $locale, $clean, $userId, $format): SiteBlock {
            $block = SiteBlock::query()->lockForUpdate()->firstOrNew(['key' => $key]);
            $translations = $block->exists ? $block->rawTranslations() : [];

            // Inline editors fire on every blur; an unchanged value must not
            // create a write or a revision. The format counts as part of "value":
            // switching a saved paragraph to H2 changes nothing else.
            if ($block->exists
                && array_key_exists($locale, $translations)
                && $translations[$locale] === $clean
                && $block->format === $format
            ) {
                return $block;
            }

            $this->snapshot($block, $userId);

            $translations[$locale] = $clean;
            $block->key = $key;
            $block->type = $type;
            $block->format = $format;
            $block->setRawAttributes(array_merge($block->getAttributes(), [
                'content' => json_encode($translations, JSON_UNESCAPED_UNICODE),
            ]));
            $block->save();

            $this->forget();

            return $block;
        });
    }

    /**
     * Drop the override for one locale so the template's own text returns.
     *
     * Clearing and restoring are different operations: clearing stores an empty
     * string, restoring removes the locale entirely and deletes the row once no
     * locale is left — the row *is* the override.
     */
    public function restoreLocale(string $key, string $locale, ?int $userId): ?SiteBlock
    {
        $this->assertSupported(SiteBlock::TYPE_TEXT, $locale);

        return DB::transaction(function () use ($key, $locale, $userId): ?SiteBlock {
            $block = SiteBlock::query()->lockForUpdate()->firstWhere('key', $key);

            if (! $block) {
                return null;
            }

            $translations = $block->rawTranslations();
            if (! array_key_exists($locale, $translations)) {
                return $block;
            }

            $this->snapshot($block, $userId);
            unset($translations[$locale]);

            if ($translations === []) {
                $block->delete();
                $this->forget();

                return null;
            }

            $block->setRawAttributes(array_merge($block->getAttributes(), [
                'content' => json_encode($translations, JSON_UNESCAPED_UNICODE),
            ]));
            $block->save();

            $this->forget();

            return $block;
        });
    }

    /** Drop the request-level cache so later renders in this request see the write. */
    public function forget(): void
    {
        $this->blocks = null;
    }

    /** @return array<string, SiteBlock> */
    private function all(): array
    {
        return $this->blocks ??= SiteBlock::query()->get()->keyBy('key')->all();
    }

    private function clean(string $type, string $value): string
    {
        return match ($type) {
            // A single-line label has no business holding markup.
            SiteBlock::TYPE_TEXT => trim(strip_tags($value)),
            SiteBlock::TYPE_HTML => $this->htmlSanitizer->clean(trim($value)),
            // Stored relative so the reference survives an APP_URL change.
            SiteBlock::TYPE_IMAGE => (string) MediaUrl::toStorable(trim($value)),
            SiteBlock::TYPE_VIDEO => trim($value),
            default => trim($value),
        };
    }

    /**
     * Coalesce revisions: inline editing saves constantly and one revision per
     * keystroke is noise, not history.
     */
    private function snapshot(SiteBlock $block, ?int $userId): void
    {
        if (! $block->exists) {
            // A brand-new block has nothing to snapshot.
            return;
        }

        if ($block->revisions()->where('created_at', '>=', now()->subMinutes(10))->exists()) {
            return;
        }

        $block->revisions()->create([
            'created_by' => $userId,
            'content' => $block->rawTranslations(),
            'created_at' => now(),
        ]);
    }

    private function assertSupported(string $type, string $locale): void
    {
        if (! in_array($type, SiteBlock::TYPES, true)) {
            throw ValidationException::withMessages(['type' => 'Loại nội dung không hợp lệ.']);
        }

        if (! $this->languages->supports($locale)) {
            throw ValidationException::withMessages(['content_locale' => 'Ngôn ngữ không được hỗ trợ.']);
        }
    }
}
