@extends('layouts.blank')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
            
                <h1>{{ $log->title }}</h1>

                <hr>

                <p>
                    @if ($log->content_type == 'blog')
                        {!! $log->content !!}
                    @elseif ($log->content_type == 'plog')
                        <img class="img-responsive" src="{{ $log_content->secure_url }}" alt="{{ $log_content->name }}">
                    @elseif ($log->content_type == 'vlog')
                        <video src="{{ $log_content->secure_url }}" controls autoplay>
                            您的瀏覽器並不支援預覽影片
                        </video>
                    @endif
                </p>
            
            </div>
        </div>
    </div>

@endsection
