@extends('layouts.home')

@section('title')
    @lang('Tests') @lang('In') {{ $p_test_type->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Tests') @lang('In') {{ $p_test_type->name }}</legend>
            <ul>
                @foreach ($p_tests as $test)
                    <li>
                        <h3>
                            <a href="#">
                                <i class="fa fa-file"></i> {{ $test->name }}
                            </a>
                        </h3>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Related') (@lang('Test Types'))</legend>
            <ul>
                @foreach ($related_types as $r_type)
                    <li>
                        <h3>
                            <a href="{{ route('home-test-type-show', ['id' => $r_type]) }}">
                                <i class="fa fa-certificate"></i> {{ $r_type->name }}
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