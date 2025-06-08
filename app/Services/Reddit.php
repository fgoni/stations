<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Reddit
{
    private $accessToken;
    private const CACHE_TTL = 3600; // 1 hour in seconds
    private const MAX_RETRIES = 3;
    private const RETRY_DELAY = 1000; // 1 second in milliseconds

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    public function posts($subreddit = 'battlestations')
    {
        $cacheKey = "posts.{$subreddit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($subreddit) {
            return $this->fetchPosts($subreddit);
        });
    }

    private function fetchPosts($subreddit)
    {
        $retryCount = 0;

        while ($retryCount < self::MAX_RETRIES) {
            try {
                $query = Http::withToken($this->accessToken)
                    ->baseUrl('https://oauth.reddit.com')
                    ->acceptJson()
                    ->timeout(10) // Add timeout
                    ->get("/r/{$subreddit}/hot");

                if (!$query->successful()) {
                    Log::error('Reddit API error', [
                        'status' => $query->status(),
                        'body' => $query->body(),
                        'subreddit' => $subreddit
                    ]);

                    if ($query->status() === 429) { // Rate limit
                        $retryCount++;
                        usleep(self::RETRY_DELAY * 1000); // Convert to microseconds
                        continue;
                    }

                    return collect([]);
                }

                $body = $query->object();

                if (!isset($body->data) || !isset($body->data->children)) {
                    Log::error('Unexpected Reddit API response structure', [
                        'body' => $body,
                        'subreddit' => $subreddit
                    ]);
                    return collect([]);
                }

                return collect($body->data->children)
                    ->pluck('data')
                    ->filter(function ($post) {
                        return str_contains($post->url, 'i.redd.it');
                    })
                    ->map(function ($post) {
                        // Add image dimensions to reduce layout shifts
                        $post->image_width = 800; // Default width
                        $post->image_height = 600; // Default height
                        return $post;
                    });
            } catch (\Exception $e) {
                Log::error('Error fetching Reddit posts', [
                    'error' => $e->getMessage(),
                    'subreddit' => $subreddit,
                    'retry_count' => $retryCount
                ]);

                $retryCount++;
                if ($retryCount < self::MAX_RETRIES) {
                    usleep(self::RETRY_DELAY * 1000);
                    continue;
                }

                return collect([]);
            }
        }

        return collect([]);
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
