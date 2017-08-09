<?php

namespace App\Http\Controllers\Auth\OAuth;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaravelApiAuthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.laravel-api.client_id'),
            'redirect_uri' => config('services.laravel-api.redirect_uri'),
            'response_type' => 'code',
            'scope' => '*',
        ]);
        return redirect('http://laravel-api.app/oauth/authorize?'.$query);
    }
    
    public function callback(Request $request)
    {
        $http = new Guzzle;
    
        $response = $http->post('http://laravel-api.app/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.laravel-api.client_id'),
                'client_secret' => config('services.laravel-api.secret'),
                'redirect_uri' => config('services.laravel-api.redirect_uri'),
                'code' => request('code'),
            ],
        ]);
    
        return json_decode((string) $response->getBody(), true);
    }
}
