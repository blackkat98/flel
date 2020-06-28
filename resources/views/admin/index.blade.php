@extends('layouts.admin')

@section('title')
    @lang('Welcome')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">

            </div>
            <div class="card-body">
                <h1>@lang('Welcome to FLEL Administration site')</h1>
                <h3><i class="fa fa-anchor"></i> @lang('Here you can'):</h3>
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <h5><i class="fa fa-asterisk"></i> @lang('Create anything')</h5>
                        <h5><i class="fa fa-asterisk"></i> @lang('Read anything')</h5>
                        <h5><i class="fa fa-asterisk"></i> @lang('Update any changes')</h5>
                        <h5><i class="fa fa-asterisk"></i> @lang('Delete any leftover')</h5>
                    </div>
                </div>
                <h3><i class="fa fa-anchor"></i> @lang('Here you should'):</h3>
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <h5><i class="fa fa-asterisk"></i> @lang('Be responsible with your given Role')</h5>
                        <h5><i class="fa fa-asterisk"></i> @lang('Take care all Data with your heart')</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection

