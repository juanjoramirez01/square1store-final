<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        //Set locale (route > cookie > lang > 'en')
        app()->setLocale(
            $request->route('locale', $request->cookie('lang', $this->lang($request)))
        );

        $locale = app()->currentLocale();

        //Redirect '/en/' route
        if ($request->route('locale') == 'en') {
            return $this->redirect($request, 'en');
        }

        //Redirect from '/' to correct locale route e.g. /fr/
        if ($request->route('locale') === null && $locale != 'en') {
            return $this->redirect($request, $locale);
        }

        return $this->next($request, $next, $locale);
    }

    /**
     * Continues on setting locale if required
     */
    protected function next(Request $request, Closure $next, string $locale): Response
    {
        if ($locale != 'en') {
            URL::defaults(['locale' => $locale]);
        }

        return $next($request)->withCookie(
            Cookie::make('lang', $locale)
        );
    }

    /**
     * Redirects to given page with locale and cookie
     */
    protected function redirect(Request $request, string $locale): Response
    {
        if ($locale != 'en') {
            URL::defaults(['locale' => $locale]);
        }

        return redirect()->route($request->route()->getName())->withCookie(
            Cookie::make('lang', $locale)
        );
    }

    /**
     * Get the preferred browser language, defaults to default locale 'en'
     */
    protected function lang(Request $request): ?string
    {
        return $request->getPreferredLanguage(
            array_keys(config('app.available_locales'))
        );
    }
}
