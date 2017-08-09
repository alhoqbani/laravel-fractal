<?php

namespace app\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;

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
        $http = new Guzzle();

        $response = $http->post('http://laravel-api.app/oauth/token',
            [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('services.laravel-api.client_id'),
                    'client_secret' => config('services.laravel-api.secret'),
                    'redirect_uri' => config('services.laravel-api.redirect_uri'),
                    'code' => request('code'),
                ],
            ]);

        $token = $this->createAccessToken(json_decode((string) $response->getBody(), true));
        dd($token);
    }

    private function createAccessToken($response)
    {
        return auth()->user()->token()->create([
            'app' => 'laravel-api',
            'token_type' => $response['token_type'],
            'expires_in' => $response['expires_in'],
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
        ]);
    }
}
