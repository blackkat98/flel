@extends('layouts.home')

@section('title')
    @lang('Topics') @lang('In') @lang('Tag'): {{ $p_tag_key }}
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
            <ul>
                <li>
                    &bull; <a href="{{ route('home-topic-list', ['language_slug' => $p_language->slug]) }}">
                        <b class="text-success">@lang('All')</b>
                    </a>
                </li>
                @foreach ($p_tags as $tag)
                    <li>
                        &bull; <a href="{{ route('home-topic-list-by-tag', ['language_slug' => $p_language->slug, 'key' => $tag->key]) }}">{{ $tag->key }}</a>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
    <div class="col-md-9">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Topics') @lang('In') @lang('Tag'): {{ $p_tag_key }}</legend>
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