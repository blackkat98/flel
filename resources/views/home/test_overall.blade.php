@extends('layouts.home')

@section('title')
    @lang('Overall') @lang('Of') {{ $p_test->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<style>
    table, th, td, tr {
        border: 1px solid black;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Overall') @lang('Of') {{ $p_test->name }}</legend>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Name'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->name }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Type'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test_type->name }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Code'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->code }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Time'): </h5>
                </div>
                <div class="col-md-9">
                    <h5> {{ $p_test->time }} </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Statistics'): </h5>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <canvas id="js-line-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h5> @lang('Actions'): </h5>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                        <a href="{{ route('home-test-show-sheet', ['type_slug' => $p_test->testType->slug, 'code' => $p_test->code]) }}" class="btn btn-primary col-md-6">
                            @lang('Start') @lang('Attempt')
                        </a>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Attempt')</legend>
                    <table class="col-md-12">
                        <tr>
                            <th class="text-center"> @lang('Number') </th>
                            <th class="text-center"> @lang('Score') </th>
                        </tr>
                        @foreach ($p_user_tests as $user_test)
                            <tr>
                                <td class="text-center"> {{ $user_test->attempt_number }} </td>
                                <td class="text-center"> {{ $user_test->score }} </td>
                            </tr>
                        @endforeach
                    </table>
                </fieldset>
            </div>

            <div class="col-md-12">
                <fieldset class="form-border">
                    <legend class="form-border">@lang('Related') (@lang('Tests'))</legend>
                    <ul>
                        @foreach ($related_tests as $test)
                            <a href="{{ route('home-test-show-overall', ['type_slug' => $test->testType->slug, 'code' => $test->code]) }}">
                                <b>{{ $test->name }}</b>
                            </a>
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
        $.ajax({
            type: 'GET',
            url: '{{ route('home-user-test-attempt-ajax', ['test_id' => $p_test->id]) }}',
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
                var chart_canvas = $('#js-line-chart');
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
    });
</script>
@endsection