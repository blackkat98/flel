@extends('layouts.admin')

@section('title')
    @lang('Details of') {{ $test->name }}
@endsection

@section('header')
@lang('Details of') {{ $test->name }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <a href="{{ route('admin-tests-list') }}" class="btn btn-default col-2">
                        <i class="fa fa-arrow-left"></i> @lang('Back to') @lang('List')
                    </a>
                    <button class="btn btn-success col-2" data-toggle="modal" data-target="#form-edit-test-{{ $test->id }}">
                        <i class="fa fa-edit"></i> @lang('Edit')
                    </button>
                    <button class="btn btn-danger col-2" data-toggle="modal" data-target="#">
                        <i class="fa fa-trash"></i> @lang('Delete')
                    </button>
                    <button class="btn btn-primary col-2" data-toggle="modal" data-target="#form-create-test-part">
                        <i class="fa fa-plus"></i> @lang('Create') @lang('Test Part')
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td> @lang('Type') </td>
                            <td> @lang('Time') </td>
                            <td> @lang('Creator') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ $test->testType->name }} </td>
                            <td> {{ $test->time }} </td>
                            <td> {{ $test->user->name }} </td>
                            <td> {{ $test->created_at }} </td>
                            <td> {{ $test->updated_at }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Forms for Test Model -->
<div class="modal fade" id="form-edit-test-{{ $test->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-tests-update', ['id' => $test->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit') {{ $test->name }}?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name" value="{{ $test->name }}">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Type')*
                        </label>
                        <select class="form-control" name="test_type_id">
                            @foreach ($test_types as $type)
                                @if ($test->test_type_id == $type->id)
                                    <option value="{{ $type->id }}" selected> {{ $type->name }} </option>
                                @else
                                    <option value="{{ $type->id }}"> {{ $type->name }} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time">
                            @lang('Time')
                        </label>
                        <input type="number" min="0" max="180" id="time" class="form-control" name="time" value="{{ $test->time }}">
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

<div class="modal fade" id="form-delete-test-{{ $test->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-tests-delete', ['id' => $test->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete') {{ $test->name }}?</h4>
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

<!-- Forms for Test Part Model -->
<div class="modal fade" id="form-create-test-part">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-tests-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create') @lang('Test Part')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="test_id" value="{{ $test->id }}">
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description">
                            @lang('Description')
                        </label>
                        <textarea id="description" class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Image')
                        </label>
                        <input type="file" class="form-control js-input-img" name="image-1">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('More images')
                        </label>
                        <div class="btn-group">
                            <button id="js-more-img" type="button" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button id="js-less-img" type="button" class="btn btn-primary">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sound">
                            @lang('Sound')
                        </label>
                        <input type="file" id="sound" class="form-control" name="sound">
                    </div>
                    <div class="form-group">
                        <label for="video">
                            @lang('Video')
                        </label>
                        <input type="file" id="video" class="form-control" name="video">
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

        $('#js-more-img').on('click', function () {
            var index = $('.js-input-img').length;

            if (index >= 3) {
                return;
            }

            $('.js-input-img').last().after(`<input type="file" class="form-control js-input-img" name="image-${index + 1}">`);
        });
    });
</script>
@endsection
