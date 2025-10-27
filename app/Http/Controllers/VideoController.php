<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index()
    {
        // --------- YouTube Videos ---------
        $youtubeApiKey = env('YOUTUBE_API_KEY');
        $youtubeChannelId = env('YOUTUBE_CHANNEL_ID');
        $maxResults = 10;

        $youtubeResponse = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'key' => $youtubeApiKey,
            'channelId' => $youtubeChannelId,
            'part' => 'snippet',
            'order' => 'date',
            'maxResults' => $maxResults,
        ]);

        $youtubeVideos = collect($youtubeResponse->json()['items'] ?? [])->map(function($item) {
            if (!isset($item['id']['videoId'])) return null;
            return [
                'platform' => 'youtube',
                'url' => 'https://www.youtube.com/watch?v=' . $item['id']['videoId'],
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
            ];
        })->filter()->values(); // remove nulls

        // --------- Vimeo Videos ---------
        // $vimeoAccessToken = env('VIMEO_ACCESS_TOKEN');
        // $vimeoUserId = env('VIMEO_USER_ID');

        // $vimeoResponse = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $vimeoAccessToken
        // ])->get("https://api.vimeo.com/users/{$vimeoUserId}/videos", [
        //     'per_page' => 10,
        //     'sort' => 'date',
        //     'direction' => 'desc',
        // ]);

        // $vimeoVideos = collect($vimeoResponse->json()['data'] ?? [])->map(function($item) {
        //     return [
        //         'platform' => 'vimeo',
        //         'url' => $item['link'],
        //         'title' => $item['name'],
        //         'description' => $item['description'] ?? '',
        //     ];
        // });

        // Combine videos (YouTube first, Vimeo next)
        // $videos = $youtubeVideos->concat($vimeoVideos)->toArray();
        $videos = $youtubeVideos->toArray();

        return view('dedicate.videos', compact('videos'));
    }
}
