@extends('layouts.home')

@section('title')
    @lang('Create') @lang('Topic')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Create') @lang('Topic')</legend>
            <form class="form-horizontal" method="post" action="{{ route('home-topic-store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="language_id" value="{{ $p_language->id }}">
                <div class="form-group row">
                    <label for="title" class="col-md-12 col-form-label text-md-right">@lang('Title')*</label>
                    <i class="col-md-12 text-muted">@lang('Be general and short')</i>
                    <div class="col-md-12">
                        <input id="title" class="form-control" name="title" value="{{ old('title') }}" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-12 col-form-label text-md-right">@lang('Content')*</label>
                    <i class="col-md-12 text-muted">@lang('Make your problem clear to others')</i>
                    <div class="col-md-12">
                        <textarea id="content" class="form-control" name="content">{{ old('content') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tags" class="col-md-12 col-form-label text-md-right">@lang('Tags')*</label>
                    <i class="col-md-12 text-muted">@lang('Add tags and separate them with spaces')</i>
                    <div class="col-md-12">
                        <input id="tags" class="form-control" autocomplete="off">
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

    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Create') @lang('Topic')</legend>
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#content').summernote();

        $('#tags').on('keypress', function (event) {
            if ($('.js-tag').length == 5) {
                return;
            }

            if (event.keyCode == 32) {
                var new_tag = $(this).val().trim();

                $(this).after(`
                    <mark class="js-tag col-md-2" style="background-color: yellow;  border-radius: 10px; cursor: pointer;">
                        <input style="background-color: transparent; border: 0; cursor: pointer;" value="${ new_tag }" name="tag-${ Date.now() }">
                    </mark>`);
                $(this).val('');
            }
        });

        $(document).on('click', '.js-tag', function () {
            $(this).remove();
        });
    });
</script>
@endsection