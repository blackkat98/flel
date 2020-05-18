 @extends('layouts.home')

@section('title')
    @lang('Course') {{ $p_course->code }} - @lang('Lessons') {{ $p_lesson->number }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <fieldset class="form-border">
            <legend class="form-border">{{ $p_course->name }} - @lang('Lessons') {{ $p_lesson->number }}</legend>
            <div class="row">
                <h2 class="text-center">{{ $p_lesson->name }}</h2>
            </div>
            <div class="row">
                @if ($p_lesson->images)
                    <div class="col-md-4">
                        @foreach ($p_lesson->images as $image)
                            <div class="row">
                                <img class="col-md-12" src="{{ asset($image) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-8">
                        <p class="text-justify">{!! $p_lesson->lecture !!}</p>
                    </div>
                @else
                    <div class="col-md-12">
                        <p class="text-justify">{!! $p_lesson->lecture !!}</p>
                    </div>
                @endif
            </div>
            <div class="row">
                @if ($p_lesson->sound)
                    <audio class="col-md-12" controls>
                        <source src="{{ asset($p_lesson->sound) }}">
                    </audio>
                @endif
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">

                </div>
                @if ($p_lesson->video)
                    <video class="col-md-10" controls autoplay>
                        <source src="{{ asset($p_lesson->video) }}">
                    </video>
                @endif
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    @if ($p_lesson->number > 1)
                        <a class="text-success" href="{{ route('home-lesson-show', ['code' => $p_course->code, 'lesson_number' => ($p_lesson->number - 1)]) }}">
                            <i class="fa fa-arrow-left"></i> @lang('Go') @lang('To') @lang('Previous')
                        </a>
                    @endif
                </div>
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-3">
                    @if ($p_lesson->number < count($p_lessons))
                        <a class="text-success" href="{{ route('home-lesson-show', ['code' => $p_course->code, 'lesson_number' => ($p_lesson->number + 1)]) }}">
                            @lang('Go') @lang('To') @lang('Next') <i class="fa fa-arrow-right"></i>
                        </a>
                    @endif
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
                        <a href="{{ route('home-lesson-show', ['code' => $p_course->code, 'lesson_number' => $lesson->number]) }}" class="btn btn-outline">
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

@section('js')
<!-- Bootstrap 4 -->
<script src="{{ asset('bower_components/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('bower_components/adminlte3/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('bower_components/adminlte3/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection
