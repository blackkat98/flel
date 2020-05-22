@extends('layouts.home')

@section('title')
    @lang('Overall') @lang('Of') {{ $p_test->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Overall') @lang('Of') {{ $p_test->name }}</legend>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Name'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->name }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Type'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test_type->name }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Code'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->code }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Time'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->time }} </h5>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Attempt')</legend>
                </fieldset>
            </div>

            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Related') (@lang('Tests'))</legend>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection