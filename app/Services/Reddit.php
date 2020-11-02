<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Reddit
{
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    public function posts($subreddit = 'battlestations')
    {
        if (Cache::has("posts.{$subreddit}")) {
            $posts = Cache::get("posts.{$subreddit}");

            return $posts;
        }

        $query = Http::withToken($this->accessToken)
            ->baseUrl('https://oauth.reddit.com')
            ->acceptJson()
            ->get("/r/{$subreddit}/hot");
        $body = $query->object();
        $posts = collect($body->data->children)->pluck('data');
        Cache::put("posts.{$subreddit}", $posts, now()->addHour());

        return $posts;
    }

    public function getAccessToken()
    {
        $response = Http::withBasicAuth(config('reddit-api.app_id'), config('reddit-api.app_secret'))
            ->withHeaders([
                'User-Agent' => 'Stations App by /u/fgoni',
            ])
            ->asForm()
            ->acceptJson()
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'client_credentials',
            ]);

        return $response->object()->access_token;
    }
}
