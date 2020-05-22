@extends('layouts.home')

@section('title')
    @lang('Course') {{ $p_course->code }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
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
            @auth
                <div class="row">
                    <div class="col-md-3">
                        <h5> @lang('Progress'): </h5>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="js-pie-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <h5> @lang('Actions'): </h5>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <button class="btn btn-success col-md-6">
                                <b> @lang('Start') </b>
                            </button>
                            <button class="btn btn-primary col-md-6">
                                <b> @lang('Resume') </b>
                            </button>
                        </div>
                    </div>
                </div>
            @else

            @endauth
        </fieldset>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Lessons') @lang('In') @lang('Course')</legend>
                    <ul>
                        @foreach ($p_lessons as $lesson)
                            <li>
                                <a href="{{ route('home-lesson-show', ['code' => $p_course->code, 'lesson_number' => $lesson->number]) }}" class="btn btn-outline">
                                    <b class="text-primary">
                                        @lang('Lesson') {{ $lesson->number }}: {{ $lesson->name }}
                                    </b>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </fieldset>
            </div>

            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Related') (@lang('Courses'))</legend>
                    <ul>
                        @foreach ($related_courses as $r_course)
                            <li>
                                <a href="{{ route('home-course-show', ['code' => $r_course->code]) }}" class="btn btn-outline">
                                    <p class="text-primary">
                                        @lang('Course') {{ $r_course->code }}: {{ $r_course->name }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </fieldset>
            </div>
        </div>
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
        var ajax_progress_url = '{!! route('home-user-course-progress', ['code' => $p_course->code]) !!}';
        
        $.ajax({
            url: ajax_progress_url,
            type: 'GET',
            success: function (received_data) {
                Chart.defaults.global.defaultFontColor = '#000000';
                Chart.defaults.global.defaultFontFamily = 'Arial';

                var chart_data = {
                    labels: received_data.labels,
                    datasets: [
                        {
                            data: received_data.data,
                            backgroundColor : ['#0000ff', '#7fffd4'],
                        }
                    ]
                };
                var chart_options = {
                    maintainAspectRatio : false,
                    responsive : true,
                };
                var chart_canvas = $('#js-pie-chart');
                var progress_chart = new Chart(chart_canvas, {
                    type: 'pie',
                    data: chart_data,
                    options: chart_options
                });
            },
            error: function (e) {
                $('#js-pie-chart').text('AJAX REQUEST ERROR');
                console.log(e.message);
            }
        });
    });
</script>
@endsection
