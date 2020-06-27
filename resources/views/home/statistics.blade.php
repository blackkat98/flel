@extends('layouts.home')

@section('title')
    @lang('Statistics')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Statistics')</legend>
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-border">
                        <legend class="form-border">@lang('Courses')</legend>

                        <table class="col-md-12">
                            <tr>
                                <th class="col-md-5 text-center">
                                    @lang('Course')
                                </th>
                                <th class="col-md-5 text-center">
                                    @lang('Lesson')
                                </th>
                                <th class="col-md-2 text-center">
                                    @lang('Progress')
                                </th>
                            </tr>
                            @foreach ($user_courses as $u_course)
                                <tr>
                                    <td class="text-justify">
                                        <a href="{{ route('home-course-show', ['code' => $u_course->course->code]) }}">
                                            {{ $u_course->course->name }}
                                            <br>({{ $u_course->course->language->name }})
                                        </a>
                                    </td>
                                    <td class="text-justify">
                                        <a href="{{ route('home-lesson-show', ['code' => $u_course->course->code, 'lesson_number' => $u_course->saved_lesson->number]) }}">
                                            #{{ $u_course->saved_lesson->number }}: {{ $u_course->saved_lesson->name }}
                                        </a>
                                    </td>
                                    <td class="text-center text-success">
                                        {{ round(100 * $u_course->saved_lesson->number / count($u_course->course->lessons), 2) }} % 
                                        <br>({{ $u_course->saved_lesson->number }}/{{ count($u_course->course->lessons) }})
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </fieldset>
                </div>

                <div class="col-md-6">
                    <fieldset class="form-border">
                        <legend class="form-border">@lang('Tests')</legend>

                        @foreach ($p_tests as $test)
                            <fieldset class="form-border">
                                <legend class="form-border">
                                    <a href="{{ route('home-test-show-overall', ['type_slug' => $test->testType->slug, 'code' => $test->code]) }}">
                                        {{ $test->name }} ({{ $test->testType->name }})
                                    </a>
                                </legend>
                                <div class="row">
                                    <canvas id="js-line-chart-{{ $test->id }}"></canvas>
                                </div>
                            </fieldset>
                        @endforeach
                    </fieldset>
                </div>
            </div>
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
@foreach ($p_tests as $test)
    <script>
        $.ajax({
            type: 'GET',
            url: '{{ route('home-user-test-attempt-ajax', ['test_id' => $test->id]) }}',
            success: function (received_data) {
                console.log(received_data);
                Chart.defaults.global.defaultFontColor = '#000000';
                Chart.defaults.global.defaultFontFamily = 'Arial';

                var chart_data = {
                    labels: received_data.numbers,
                    datasets: [
                        {
                            label: '{{ __('Score') }}',
                            data: received_data.scores,
                            lineTension: 0,
                            backgroundColor: '#99ffff',
                            borderColor: '#2e6da4',
                            borderWidth: 1
                        }
                    ]
                };
                var chart_options = {
                    maintainAspectRatio : false,
                    responsive : true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                callback: function (value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                },
                                stepSize: 1
                            }
                        }]
                    },
                };
                var chart_canvas = $('#js-line-chart-' + '{{ $test->id }}');
                var progress_chart = new Chart(chart_canvas, {
                    type: 'line',
                    data: chart_data,
                    options: chart_options
                });
            },
            error: function (e) {
                console.log(e);
            }
        });
    </script>
@endforeach
@endsection