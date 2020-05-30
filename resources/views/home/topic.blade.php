@extends('layouts.home')

@section('title')
    @lang('Topic'): {{ $p_topic->title }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border"></legend>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="form-border">
                        <legend class="form-border"></legend>
                        <div class="col-md-2">
                            <img class="img-thumbnail" src="{{ asset($p_topic->user->image) }}" alt="">
                            <h5 class="text-center">{{ $p_topic->user->name }}</h5>
                        </div>
                        <div class="col-md-10">
                            <h3>{{ $p_topic->title }}</h3>
                            <p class="text-justify">{!! $p_topic->content !!}</p>
                        </div>
                    </fieldset>
                </div>
        </fieldset>
    </div>

    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border"></legend>
            <div class="row" id="page-replies">
                @foreach ($p_replies as $reply)
                    <div class="col-md-12">
                        <fieldset class="form-border">
                            <legend class="form-border"></legend>
                            <div class="col-md-2">
                                <img class="img-thumbnail" src="{{ asset($reply->user->image) }}" alt="">
                                <h5 class="text-center">{{ $reply->user->name }}</h5>
                            </div>
                            <div class="col-md-10">
                                <p class="text-justify">{!! $reply->content !!}</p>
                            </div>
                        </fieldset>
                    </div>
                @endforeach
            </div>
        </fieldset>
    </div>

    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border"></legend>
            <form class="form-horizon" method="post" action="{{ route('home-reply-store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_id" value="{{ $p_topic->id }}">

                <input type="hidden" name="reply_id" value="0">
            </form>
        </fieldset>
    </div>

    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Your Reply')</legend>
            <form class="form-horizontal" method="post" action="{{ route('home-reply-store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_id" value="{{ $p_topic->id }}">

                <input type="hidden" name="reply_id" value="0">

                <div class="form-group row">
                    <textarea class="js-editor form-control" name="content"></textarea>
                </div>

                <div class="form-group row">
                    <i class="col-md-12 text-muted">@lang('Add a File')</i>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="attachment">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary col-md-12">
                            @lang('Create')
                        </button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/socket.io.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.js-editor').summernote();
    });
</script>
<script>
    var socket = io('http://localhost:6001')
</script>
@endsection