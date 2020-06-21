@extends('layouts.home')

@section('title')
    @lang('Q&A') @lang('In') {{ $p_language->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Tags')</legend>
        </fieldset>
    </div>
    <div class="col-md-9">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Topics') @lang('In') {{ $p_language->name }}</legend>
            @foreach ($p_topics as $topic)
                <h3>
                    <a href="{{ route('home-topic-show', ['language_slug' => $p_language->slug, 'id' => $topic->id]) }}">
                        <i style="color: {{ $topic->is_open == 1 ? '#ff9900' : '#ff0000' }};" class="fa fa-file"></i> {{ $topic->title }}
                    </a>
                </h3>
            @endforeach
            {{ $p_topics->links() }}
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection