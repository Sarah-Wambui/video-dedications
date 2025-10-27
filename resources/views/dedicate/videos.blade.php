@extends('layouts.app')

@section('content')
<div class="container videos-page">
    <h1>Published Videos</h1>
    <div class="video-grid">
        @foreach($videos as $video)
            <div class="video-card">
                <div class="video-wrapper">
                    @if(str_contains($video['url'], 'youtube'))
                        <iframe src="https://www.youtube.com/embed/{{ getYoutubeId($video['url']) }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    @elseif(str_contains($video['url'], 'vimeo'))
                        <iframe src="https://player.vimeo.com/video/{{ getVimeoId($video['url']) }}?title=0&byline=0&portrait=0" 
                                frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    @endif
                </div>

                <div class="video-info">
                    <div class="video-title">{{ $video['title'] }}</div>
                    <div class="video-description">{{ $video['description'] }}</div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection
