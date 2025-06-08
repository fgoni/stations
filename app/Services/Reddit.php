<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            return $posts->filter(function ($post) {
                return str_contains($post->url, 'i.redd.it');
            });
        }

        try {
            $query = Http::withToken($this->accessToken)
                ->baseUrl('https://oauth.reddit.com')
                ->acceptJson()
                ->get("/r/{$subreddit}/hot");

            if (!$query->successful()) {
                Log::error('Reddit API error', [
                    'status' => $query->status(),
                    'body' => $query->body()
                ]);
                return collect([]);
            }

            $body = $query->object();

            if (!isset($body->data) || !isset($body->data->children)) {
                Log::error('Unexpected Reddit API response structure', [
                    'body' => $body
                ]);
                return collect([]);
            }

            $posts = collect($body->data->children)
                ->pluck('data')
                ->filter(function ($post) {
                    return str_contains($post->url, 'i.redd.it');
                });

            Cache::put("posts.{$subreddit}", $posts, now()->addHour());

            return $posts;
        } catch (\Exception $e) {
            Log::error('Error fetching Reddit posts', [
                'error' => $e->getMessage(),
                'subreddit' => $subreddit
            ]);
            return collect([]);
        }
    }

    public function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth(config('reddit-api.app_id'), config('reddit-api.app_secret'))
                ->withHeaders([
                    'User-Agent' => 'Stations App by /u/fgoni',
                ])
                ->asForm()
                ->acceptJson()
                ->post('https://www.reddit.com/api/v1/access_token', [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->successful()) {
                Log::error('Reddit auth error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to get Reddit access token');
            }

            return $response->object()->access_token;
        } catch (\Exception $e) {
            Log::error('Error getting Reddit access token', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
