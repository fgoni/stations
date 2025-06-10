<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ImageProxyController extends Controller
{
    public function proxy(Request $request)
    {
        $encodedUrl = $request->route('url');
        $url = base64_decode($encodedUrl);

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL');
        }

        // Only allow i.redd.it URLs
        if (!str_contains($url, 'i.redd.it')) {
            abort(403, 'Invalid image source');
        }

        // Cache the image for 1 hour
        $cacheKey = 'image_proxy_' . md5($url);

        return Cache::remember($cacheKey, 3600, function () use ($url) {
            $response = Http::timeout(10)->get($url);

            if (!$response->successful()) {
                abort($response->status());
            }

            return response($response->body())
                ->header('Content-Type', $response->header('Content-Type'))
                ->header('Cache-Control', 'public, max-age=3600');
        });
    }
}
