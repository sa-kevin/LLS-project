<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {    
        $sessionLocale = Session::get('locale');
        App::setlocale($sessionLocale);
    
        return [
            ...parent::share($request),
            'flash' => $request->session()->get('flash'),
            'auth' => [
                'user' => $request->user(),
            ],
            'trans' => [
                 'navigation' => trans('navigation'),
            ],
        ];
    }
}
