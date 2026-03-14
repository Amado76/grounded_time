<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the application locale for every request.
 *
 * Priority order:
 *   1. 'locale' query parameter (?locale=pt_BR) — useful for one-off switches
 *   2. 'locale' value stored in the user's session (set by UserSettingsController)
 *   3. Authenticated user's locale preference (populated in a later task)
 *   4. config('app.locale') fallback
 *
 * Only locales listed in config('app.supported_locales') are accepted.
 * Unknown values are silently ignored and the next priority is used.
 */
class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('app.supported_locales', ['en']);

        // 1. Query-string override (?locale=es)
        $locale = $request->query('locale');

        if ($locale && $this->isSupported($locale, $supported)) {
            // Persist selection in the session so subsequent requests keep it
            session(['locale' => $locale]);
        } else {
            // 2. Session preference (set by language selector)
            $locale = session('locale');

            // 3. Authenticated user's stored preference (null until T093 adds the column)
            if (! $locale || ! $this->isSupported($locale, $supported)) {
                $locale = $request->user()?->locale;
            }

            // 4. App default
            if (! $locale || ! $this->isSupported($locale, $supported)) {
                $locale = config('app.locale', 'en');
            }
        }

        App::setLocale($locale);

        return $next($request);
    }

    /**
     * Returns true when $locale is in the application's supported locales list.
     *
     * @param string   $locale
     * @param string[] $supported
     */
    private function isSupported(string $locale, array $supported): bool
    {
        return in_array($locale, $supported, strict: true);
    }
}
