<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Log;
use Throwable;

class HtmlSanitizer
{
    private HTMLPurifier $purifier;

    public function __construct()
    {
        $cachePath = storage_path('app/htmlpurifier');
        if (! is_dir($cachePath)) {
            @mkdir($cachePath, 0777, true);
        }
        if (is_dir($cachePath) && ! is_writable($cachePath)) {
            @chmod($cachePath, 0777);
        }

        $config = HTMLPurifier_Config::createDefault();
        if (is_dir($cachePath) && is_writable($cachePath)) {
            $config->set('Cache.SerializerPath', $cachePath);
        } else {
            $config->set('Cache.DefinitionImpl', null);
        }

        $config->set('HTML.DefinitionID', 's54-html5-definitions');
        $config->set('HTML.DefinitionRev', 2);
        $config->set('HTML.Allowed', 'p[class|style],br,hr,b,strong,i,em,u,s,del,ins,small,sub,sup,ul,ol,li,blockquote,h1,h2,h3,h4,h5,h6,a[href|title|rel|target|class],img[src|alt|title|width|height|class|style|loading],figure[class|style],figcaption[class|style],table[class|style|border|cellspacing|cellpadding],thead,tbody,tfoot,tr,th[colspan|rowspan|scope|class|style],td[colspan|rowspan|class|style],pre,code,span[class|style],div[class|style]');
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('AutoFormat.RemoveEmpty', false);

        $def = $config->maybeGetRawHTMLDefinition();
        if ($def) {
            $def->addElement('figure', 'Block', 'Flow', 'Common');
            $def->addElement('figcaption', 'Inline', 'Flow', 'Common');
        }

        $this->purifier = new HTMLPurifier($config);
    }

    public function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        try {
            $cleaned = $this->purifier->purify((string) $html);
            return MediaUrl::relativizeHtmlSources($cleaned);
        } catch (Throwable $e) {
            Log::warning('HtmlPurifier error: ' . $e->getMessage());
            return MediaUrl::relativizeHtmlSources((string) $html);
        }
    }
}
