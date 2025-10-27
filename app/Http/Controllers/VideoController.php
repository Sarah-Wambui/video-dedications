<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        // Example videos (replace with real URLs)
        $videos = [
             [
                'url' => 'https://www.youtube.com/watch?v=2OEL4P1Rz04',
                'title' => 'Relaxing Music',
                'description' => 'A relaxing music video that allows embedding.',
            ],
            [
                'url' => 'https://vimeo.com/76979871',
                'title' => 'Vimeo Video Example',
                'description' => 'This is an example of a Vimeo video.',
            ],
            [
                'url' => 'https://www.youtube.com/watch?v=5qap5aO4i9A',
                'title' => 'Nature Documentary Clip',
                'description' => 'A short nature documentary clip.',
            ],          
            [
                'url' => 'https://vimeo.com/76979871',
                'title' => 'Vimeo Video Example',
                'description' => 'This is an example of a Vimeo video.',
            ],
            [
                'url' => 'https://www.youtube.com/watch?v=5qap5aO4i9A',
                'title' => 'Nature Documentary Clip',
                'description' => 'A short nature documentary clip.',
            ],          
            [
                'url' => 'https://vimeo.com/76979871',
                'title' => 'Vimeo Video Example',
                'description' => 'This is an example of a Vimeo video.',
            ],
            
        ];

        return view('dedicate.videos', compact('videos'));
    }
}
