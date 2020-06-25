@extends('layouts.home')

@section('title')
    @lang('Search Results')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Search Results')</legend>
            
            <fieldset class="form-border">
                <legend class="form-border">@lang('Test Types')</legend>
                @foreach ($p_test_types as $type)
                    <h4>
                        <i class="fa fa-certificate"></i>
                        <a href="{{ route('home-test-type-show', ['slug' => $type->slug]) }}">
                            {{ $type->name }}
                        </a>
                    </h4>
                @endforeach
            </fieldset>

            <fieldset class="form-border">
                <legend class="form-border">@lang('Tests')</legend>
                @foreach ($p_tests as $test)
                    <h4>
                        <i class="fa fa-file"></i>
                        <a href="{{ route('home-test-show-overall', ['type_slug' => $test->testType->slug, 'code' => $test->code]) }}">
                            {{ $test->name }}
                        </a>
                    </h4>
                @endforeach
            </fieldset>

            <fieldset class="form-border">
                <legend class="form-border">@lang('Courses')</legend>
                @foreach ($p_courses as $course)
                    <h4>
                        <i class="fa fa-book"></i>
                        <a href="{{ route('home-course-show', ['code' => $course->code]) }}">
                            {{ $course->name }}
                        </a>
                    </h4>
                @endforeach
            </fieldset>

            <fieldset class="form-border">
                <legend class="form-border">@lang('Lessons')</legend>
                @foreach ($p_lessons as $lesson)
                    <h4>
                        <i class="fa fa-space-shuttle"></i>
                        <a href="{{ route('home-lesson-show', ['code' => $p_course->code, 'lesson_number' => $lesson->number]) }}">
                            {{ $lesson->name }} (@lang('Lesson') #{{ $lesson->number }} @lang('In') @lang('Course') {{ $lesson->course->name }})
                        </a>
                    </h4>
                @endforeach
            </fieldset>

            <fieldset class="form-border">
                <legend class="form-border">@lang('Topics')</legend>
                @foreach ($p_topics as $topic)
                    <h4>
                        <i class="fa fa-star"></i>
                        <a href="{{ route('home-topic-show', ['language_slug' => $topic->language->slug, 'id' => $topic->id]) }}">
                            {{ $topic->title }}
                        </a>
                    </h4>
                @endforeach
            </fieldset>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection