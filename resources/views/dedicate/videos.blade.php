@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Dedicated Videos</h1>
        <div class="row">
            @foreach($videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <video width="100%" controls>
                            <source src="{{ asset('storage/videos/' . $video->filename) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            <p class="card-text">{{ $video->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>  
@endsection
    