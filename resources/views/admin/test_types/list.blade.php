@extends('layouts.admin')

@section('title')
    @lang('Test Types')
@endsection

@section('header')
@lang('Data Table of all') @lang('Test Types')
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
                            <td> @lang('Language') </td>
                            <td> @lang('Description') </td>
                            <td> @lang('Number of') @lang('Quizzes') </td>
                            <td> @lang('Time') </td>
                            <td> @lang('Rules') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($test_types as $type)
                            <tr>
                                <td> {{ $type->name }} </td>
                                <td> {{ $type->language->name }} </td>
                                <td> {{ $type->description }} </td>
                                <td>
                                    @if ($type->fixed_quiz_quantity > 0)
                                        {{ $type->fixed_quiz_quantity }}
                                    @else
                                        @lang('No default')
                                    @endif
                                </td>
                                <td>
                                    @if ($type->fixed_time > 0)
                                        {{ $type->fixed_time }}
                                    @else
                                        @lang('No default')
                                    @endif
                                </td>
                                <td>

                                </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $type->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $type->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-{{ $type->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-test-types-update', ['id' => $type->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') {{ $type->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">
                                                                @lang('Name')*
                                                            </label>
                                                            <input id="name" class="form-control" name="name" value="{{ $type->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Language')*
                                                            </label>
                                                            <select class="form-control" name="language_id">
                                                                @foreach ($languages as $language)
                                                                    @if ($type->language_id == $language->id)
                                                                        <option value="{{ $language->id }}" selected> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                    @else
                                                                        <option value="{{ $language->id }}"> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Number of') @lang('Quizzes')
                                                            </label>
                                                            <input type="number" min="0" max="250" class="form-control" name="fixed_quiz_quantity" value="{{ $type->fixed_quiz_quantity }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Time')
                                                            </label>
                                                            <input type="number" min="0" max="250" class="form-control" name="fixed_time" value="{{ $type->fixed_time }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">
                                                                @lang('Description')
                                                            </label>
                                                            <textarea id="description" class="form-control" name="description" maxlength="500">
                                                                {{ $type->description }}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                                                        <button type="submit" class="btn btn-success">@lang('Update')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="form-delete-{{ $type->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-test-types-delete', ['id' => $type->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $type->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @lang('Just to make sure you did not misclick.')
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                                                        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
            <form method="post" action="{{ route('admin-test-types-store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Test Types')</h4>
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
                            @lang('Language')*
                        </label>
                        <select class="form-control" name="language_id">
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}"> {{ $language->name }} ({{ $language->slug }}) </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Number of') @lang('Quizzes')
                        </label>
                        <input type="number" min="0" max="250" class="form-control" name="fixed_quiz_quantity" value="0">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Time')
                        </label>
                        <input type="number" min="0" max="250" class="form-control" name="fixed_time" value="0">
                    </div>
                    <div class="form-group">
                        <label for="description">
                            @lang('Description')
                        </label>
                        <textarea id="description" class="form-control" name="description" maxlength="500"></textarea>
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
    });
</script>
@endsection




