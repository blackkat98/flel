@extends('layouts.home')

@section('title')
    @lang('Words') @lang('In') {{ $p_language->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="row">
            @foreach ($p_word_categories as $category)
                <div class="col-md-12">
                    <fieldset class="form-border">
                        <legend class="form-border">{{ $category->name }}</legend>

                        @foreach ($p_words[$category->id] as $word)
                            <div class="row">
                                <div class="col-md-4"><b>{{ $word->word }}</b></div>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <fieldset class="form-border">
            <legend class="form-border"></legend>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection