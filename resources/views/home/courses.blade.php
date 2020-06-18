@extends('layouts.home')

@section('title')
    @lang('Courses') @lang('In') {{ $p_language->name }}
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
                @foreach ($p_courses as $course)
                    <li>
                        <h3>
                            <a href="{{ route('home-course-show', ['code' => $course->code]) }}">
                                <i class="fa fa-file"></i> {{ $course->name }}
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