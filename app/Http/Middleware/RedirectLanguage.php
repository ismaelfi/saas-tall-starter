<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectLanguage
{
    /**
     * Supported locales for the agency subdomain.
     */
    protected array $supportedLocales = ['en', 'fr', 'es'];

    protected string $defaultLocale = 'en';

    /**
     * Handle an incoming request.
     *
     * If the user lands on the agency subdomain root (no locale prefix),
     * detect their preferred language from the Accept-Language header
     * and redirect to the matching locale prefix.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        // If a valid locale prefix is already in the URL, set it and continue
        if ($locale && in_array($locale, $this->supportedLocales)) {
            app()->setLocale($locale);

            return $next($request);
        }

        // Detect preferred locale from Accept-Language header
        $preferred = $this->detectLocale($request);

        // English is the default — no prefix needed
        if ($preferred === $this->defaultLocale) {
            app()->setLocale($this->defaultLocale);

            return $next($request);
        }

        // Redirect to the locale-prefixed version
        $path = $request->getPathInfo();
        $target = '/'.$preferred.($path === '/' ? '' : $path);

        return redirect($target, 302);
    }

    /**
     * Parse the Accept-Language header and return the best matching locale.
     */
    protected function detectLocale(Request $request): string
    {
        $acceptLanguage = $request->header('Accept-Language', '');

        if (empty($acceptLanguage)) {
            return $this->defaultLocale;
        }

        // Parse Accept-Language header into weighted list
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $part) {
            $part = trim($part);
            if (str_contains($part, ';q=')) {
                [$lang, $q] = explode(';q=', $part);
                $languages[trim($lang)] = (float) $q;
            } else {
                $languages[$part] = 1.0;
            }
        }

        // Sort by quality factor descending
        arsort($languages);

        // Match against supported locales (check primary language tag)
        foreach ($languages as $lang => $quality) {
            $primary = strtolower(substr($lang, 0, 2));
            if (in_array($primary, $this->supportedLocales)) {
                return $primary;
            }
        }

        return $this->defaultLocale;
    }
}
