<?php

namespace App\Repositories;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class BaseApiRepository
{

    private PendingRequest $http;
    private string $url = 'http://support.prod:8080';

    public function __construct()
    {
        $this->http = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withOptions([
            'debug' => true,
        ]);
    }

    public function setHeaderToken(): void
    {
        $this->http = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . auth()->user()->getRememberToken()
        ]);
    }

    public function setFileHeaderToken(): void
    {
        $this->http = Http::withHeaders([
            'Content-Type' => 'multipart/form-data',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . auth()->user()->getRememberToken()
        ]);
    }

    public function post($url, $data)
    {
        $url = $this->url . $url;
        $response = $this->http->post($url, $data);
        return $this->response($response);
    }

    public function put($url, $data)
    {
        $url = $this->url . $url;
        $response = $this->http->put($url, $data);
        return $this->response($response);
    }

    public function delete($url)
    {
        $url = $this->url . $url;
        $response = $this->http->delete($url);
        if ($response->successful()) {
            return [];
        } else if ($response->failed() || $response->clientError()) {
            return $response->json();
        }
    }

    public function get($url)
    {
        $url = $this->url . $url;
        $response = $this->http->get($url);

        return $this->response($response);
    }

    protected function response($response)
    {
        if ($response->serverError()) {
            $response->throw();
        }
        if ($response->successful() || $response->failed() || $response->clientError()) {
            return $response->json();
        }
    }
}
