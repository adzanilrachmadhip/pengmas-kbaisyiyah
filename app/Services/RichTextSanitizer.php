<?php

namespace App\Services;

use Mews\Purifier\Facades\Purifier;

/**
 * Sanitizes every admin-authored richtext value (article bodies, richtext
 * single-instance fields) against config('purifier.settings.default')
 * before it's persisted — see that config for why img/style/iframe are
 * deliberately excluded. Plain 'text' fields don't need this: Blade's
 * {{ }} already escapes them on output.
 */
class RichTextSanitizer
{
    public function sanitize(string $html): string
    {
        return Purifier::clean($html);
    }
}
