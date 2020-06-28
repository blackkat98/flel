@extends('layouts.home')

@section('title')
    @lang('Welcome')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-6">
        <fieldset class="form-border">
            <legend class="form-border">@lang('User number')</legend>
            <div style="font-size: 70px;" class="row text-center">
            	{{ $user_number }}
            </div>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Online number')</legend>
            <div style="font-size: 70px;" class="row text-center">
            	{{ $online_number }}
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Language number')</legend>
            <div style="font-size: 70px;" class="row text-center">
            	{{ $language_number }}
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Course number')</legend>
            <div style="font-size: 70px;" class="row text-center">
            	{{ $course_number }}
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Test Type number')</legend>
            <div style="font-size: 70px;" class="row text-center">
            	{{ $test_type_number }}
            </div>
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<!-- Bootstrap 4 -->
<script src="{{ asset('bower_components/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('bower_components/adminlte3/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection
