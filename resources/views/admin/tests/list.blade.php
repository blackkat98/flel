@extends('layouts.admin')

@section('title')
    @lang('Tests')
@endsection

@section('header')
@lang('Data Table of all') @lang('Tests')
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#form-create">
                        <i class="fa fa-plus-circle"></i> @lang('Create')
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="js-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td> @lang('Name') </td>
                            <td> @lang('Type') </td>
                            <td> @lang('Time') </td>
                            <td> @lang('Creator') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                            <td> @lang('Status') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tests as $test)
                            <tr>
                                <td> {{ $test->name }} </td>
                                <td> {{ $test->testType->name }} </td>
                                <td> {{ $test->time }} </td>
                                <td> {{ $test->user->name }} </td>
                                <td> {{ $test->created_at }} </td>
                                <td> {{ $test->updated_at }} </td>
                                <td>
                                    <form method="post" action="{{ route('admin-tests-available', ['id' => $test->id]) }}">
                                        @csrf
                                        <button class="btn btn-default">
                                            @if ($test->is_available == 1)
                                                <b class="text-success"> @lang('Shown') </b>
                                            @else
                                                <b class="text-danger"> @lang('Hidden') </b>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin-tests-show', ['id' => $test->id]) }}" class="btn btn-outline">
                                        <i class="far fa-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-tests-store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Tests')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Type')*
                        </label>
                        <select class="form-control" name="test_type_id">
                            @foreach ($test_types as $type)
                                <option value="{{ $type->id }}"> {{ $type->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time">
                            @lang('Time')
                        </label>
                        <input type="number" min="0" max="180" id="time" class="form-control" name="time">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Create')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#js-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });

        if ('{!! session()->get('success') !!}' !== '') {
            toastr.success('{!! session()->get('success') !!}');
        }

        if ('{!! session()->get('error') !!}' !== '') {
            toastr.error('{!! session()->get('error') !!}');
        }

        var form_validation_errors = {!! json_encode($errors->toArray(), JSON_HEX_TAG) !!};
        
        for (var key in form_validation_errors) {
            toastr.warning(form_validation_errors[key][0]);
        }
    });
</script>
@endsection




