@extends('layouts.home')

@section('title')
    @lang('Course') {{ $p_course->code }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <fieldset class="form-border">
            <legend class="form-border">{{ $p_course->name }}</legend>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Language'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_course->language->name }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Description'): </h5>
                </div>
                <div class="col-md-9">
                    @if ($p_course->description)
                        {!! $p_course->description !!}
                    @else
                        @lang('No description')
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Code'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_course->code }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Length'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ count($p_lessons) }} </h5>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Lessons') @lang('In') @lang('Course')</legend>
            <ul>
                @foreach ($p_lessons as $lesson)
                    <li>
                        <a class="btn btn-outline">
                            <p class="text-primary">
                                @lang('Lesson') {{ $lesson->number }}: {{ $lesson->name }}
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
</div>
@endsection