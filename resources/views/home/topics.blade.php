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
    <div class="col-md-7">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Topics') @lang('In') {{ $p_language->name }}</legend>
        </fieldset>
    </div>
    <div class="col-md-2">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Other') @lang('Languages')</legend>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection