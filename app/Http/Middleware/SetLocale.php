<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
   
    public function handle(Request $request, Closure $next): Response
    {
        $sessionLocale = Session::get('locale');
        $currentLocale = App::getLocale();
        
        if ($sessionLocale && $sessionLocale !== $currentLocale) {
            App::setLocale($sessionLocale);
        }
        
        return $next($request);
    }
}
