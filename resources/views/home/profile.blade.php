@extends('layouts.home')

@section('title')
    @lang('Profile')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Info')</legend>
            <div class="row">
                <img class="img-thumbnail" src="{{ asset(Auth::user()->image) }}" alt="">
                <h3 class="text-center">{{ Auth::user()->name }}</h3>
                <p><i class="fa fa-commenting"></i> {{ Auth::user()->email }}</p>
                <h4>@lang('Role'):</h4>
                <ul>
                    @foreach (Auth::user()->getRoleNames() as $role)
                        <li>&bull; {{ $role }}</li>
                    @endforeach
                </ul>
            </div>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Edit') @lang('Profile')</legend>
            <form  class="form-horizontal" method="post" action="{{ route('home-me-profile-update') }}" enctype="multipart/form-data">
                @csrf
                <input class="hidden" name="id" value="{{ Auth::user()->id }}" readonly>
                <div class="form-group row">
                    <label for="name" class="col-md-12 col-form-label text-md-right">@lang('Name')*</label>
                    <div class="col-md-12">
                        <input id="name" class="form-control" name="name" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Email" class="col-md-12 col-form-label text-md-right">@lang('Email')*</label>
                    <div class="col-md-12">
                        <input id="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-md-12 col-form-label text-md-right">@lang('Image')</label>
                    <div class="col-md-12">
                        <input type="file" id="image" class="form-control" name="image">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success col-md-12">
                            @lang('Update')
                        </button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Edit') @lang('Password')</legend>
            <form  class="form-horizontal" method="post" action="{{ route('home-me-password-update') }}">
                @csrf
                <input class="hidden" name="id" value="{{ Auth::user()->id }}" readonly>
                <div class="form-group row">
                    <label for="password" class="col-md-12 col-form-label text-md-right">@lang('Password')*</label>
                    <div class="col-md-12">
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_password" class="col-md-12 col-form-label text-md-right">@lang('Confirm Password')*</label>
                    <div class="col-md-12">
                        <input type="password" id="c_password" class="form-control" name="c_password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success col-md-12">
                            @lang('Update')
                        </button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection