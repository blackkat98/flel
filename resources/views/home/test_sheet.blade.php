@extends('layouts.home')

@section('title')
    @lang('Test Sheet') @lang('Of') {{ $p_test->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-2">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Actions')</legend>
            <div class="row">
                <button id="js-start-btn" class="btn btn-primary col-md-12">
                    @lang('Start')
                </button>
            </div>
            <br>
            <div class="row">
                <a href="{{ route('home-test-show-overall', ['type_slug' => $p_test->testType->slug, 'code' => $p_test->code]) }}" class="btn btn-success col-md-12">
                    @lang('Back')
                </a>
            </div>
        </fieldset>
    </div>
    <div class="col-md-10">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Test Sheet') @lang('Of') {{ $p_test->name }}</legend>
            
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection