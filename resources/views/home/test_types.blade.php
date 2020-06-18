@extends('layouts.home')

@section('title')
    @lang('Test Types') @lang('In') {{ $p_language->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Test Types') @lang('In') {{ $p_language->name }}</legend>
            <ul>
                @foreach ($p_test_types as $test_type)
                    <li>
                        <h3>
                            <a href="{{ route('home-test-type-show', ['slug' => $test_type->slug]) }}">
                                <i class="fa fa-file"></i> {{ $test_type->name }}
                            </a>
                        </h3>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection