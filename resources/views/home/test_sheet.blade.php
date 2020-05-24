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
            @foreach ($p_test_parts as $test_part)
                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="form-border">
                            <legend class="form-border text-primary">@lang('Part'): {{ $test_part->name }}</legend>
                            @foreach($p_test_quizzes[$test_part->id] as $quiz)
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset class="form-border">
                                            <legend class="form-border">#{{ $quiz->number }}:</legend>
                                            <div class="row">
                                                <b>{{ $quiz->question }}</b>
                                            </div>
                                            @if ($quiz->essay)
                                                <div class="row">
                                                    <p>{{ $quiz->essay }}</p>
                                                </div>
                                            @endif
                                            @if ($quiz->images)
                                                <div class="row">
                                                    @foreach ($quiz->images as $image)
                                                        <img class="col-md-3" src="{{ asset($image) }}" alt="">
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-5">
                                                    @if ($quiz->sound)
                                                        <audio class="row" controls>
                                                            <source src="{{ asset($quiz->sound) }}">
                                                        </audio>
                                                    @endif

                                                    @if ($quiz->video)
                                                        <video class="row" controls>
                                                            <source src="{{ asset($quiz->video) }}">
                                                        </video>
                                                    @endif
                                                </div>
                                                <div class="col-md-7">
                                                    @if ($quiz->quiz_type == $test_quiz_types['multiple_choice'])
                                                        @foreach ($quiz->options as $key => $value)
                                                            <div class="form-check">
                                                                <input type="checkbox" id="answer-{{ $quiz->number }}-{{ $key }}" class="form-check-input" name="answer-{{ $quiz->number }}-{{ $key }}">
                                                                <label for="answer-{{ $quiz->number }}-{{ $key }}" class="form-check-label text-bold">
                                                                    {{ $key }} .  {{ $value }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if ($quiz->quiz_type == $test_quiz_types['writing'])
                                                        @for ($i = 1; $i <= count($quiz->answer); $i++)
                                                            <input class="form-control" name="answer-{{ $quiz->number }}-{{ $i }}">
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                    </div>
                </div>
            @endforeach
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