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

@foreach ($test_parts as $test_part)
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title md-2"> {{ $test_part->name }} </h3>
            </div>
            <div class="card-header row">
                <button class="btn btn-outline-success col-1" data-toggle="modal" data-target="#form-edit-test-part-{{ $test_part->id }}">
                    <i class="fa fa-edit"></i> @lang('Edit')
                </button>
                <button class="btn btn-outline-danger col-1" data-toggle="modal" data-target="">
                    <i class="fa fa-trash"></i> @lang('Delete')
                </button>
                <button class="btn btn-outline-primary col-2" data-toggle="modal" data-target="#form-create-test-quiz">
                    <i class="fa fa-plus"></i> @lang('Create') @lang('Test Quiz')
                </button>
            </div>
            <div class="card-body">
                <div class="row border-bottom">
                    <div class="col-2 text-center text-bold">
                        @lang('Description')
                    </div>
                    <div class="col-10">
                        @if ($test_part->description)
                            {{ $test_part->description }}
                        @else
                            <i> @lang('Not provided') </i>
                        @endif
                    </div>
                </div>
                <div class="row border-bottom">
                    <div class="col-2 text-center text-bold">
                        @lang('Images')
                    </div>
                    <div class="col-10">
                        @if (!$test_part->images || count($test_part->images) == 0)
                            <i> @lang('Not provided') </i>
                        @else
                            <div class="row">
                                @foreach ($test_part->images as $image)
                                    <img class="img-bordered col-4" src="{{ asset($image) }}" alt="">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row border-bottom">
                    <div class="col-2 text-center text-bold">
                        @lang('Sound')
                    </div>
                    <div class="col-10">
                        @if ($test_part->sound)
                            <audio class="row" controls>
                                <source src="{{ asset($test_part->sound) }}">
                            </audio>
                        @else
                            <i> @lang('Not provided') </i>
                        @endif
                    </div>
                </div>
                <div class="row border-bottom">
                    <div class="col-2 text-center text-bold">
                        @lang('Video')
                    </div>
                    <div class="col-10">
                        @if ($test_part->video)
                            <video>
                                <source src="{{ asset($test_part->video) }}">
                            </video>
                        @else
                            <i> @lang('Not provided') </i>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-center text-bold">
                        @lang('Quizzes')
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered table-striped col-12">
                        <thead>
                            <tr>
                                <td> @lang('Number') </td>
                                <td> @lang('Type') </td>
                                <td> @lang('Question') </td>
                                <td> @lang('Options') </td>
                                <td> @lang('Answer') </td>
                                <td> @lang('Actions') </td>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forms for Test Part Model -->
<div class="modal fade" id="form-edit-test-part-{{ $test_part->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-test-parts-update', ['id' => $test_part->id]) }}" enctype="multipart/form-data">
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
                        <input id="name" class="form-control" name="name" value="{{ $test_part->name }}">
                    </div>
                    <div class="form-group">
                        <label for="description">
                            @lang('Description')
                        </label>
                        <textarea id="description" class="form-control" name="description">{{ $test_part->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Image')
                        </label>
                        <input type="file" class="form-control" name="image-1">
                        <input type="file" class="form-control" name="image-2">
                        <input type="file" class="form-control" name="image-3">
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
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forms for Test Quiz Model -->
<div class="modal fade" id="form-create-test-quiz">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-test-quizzes-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create') @lang('Test Quiz')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="test_part_id" value="{{ $test_part->id }}">
                    <div class="form-group">
                        <label for="number">
                            @lang('Number')*
                        </label>
                        <input type="number" min="1" max="500" id="number" class="form-control" name="number">
                    </div>
                    <div class="form-group">
                        <label for="quiz_type">
                            @lang('Test Quiz') @lang('Type')*
                        </label>
                        <select class="form-control" name="quiz_type">
                            @foreach ($quiz_types as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="question">
                            @lang('Question')*
                        </label>
                        <textarea id="question" class="form-control" name="question"></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Options')*
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox" name="tick-1">
                                </span>
                            </div>
                            <input type="text" class="form-control" name="option-1">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox" name="tick-2">
                                </span>
                            </div>
                            <input type="text" class="form-control" name="option-2">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox" name="tick-3">
                                </span>
                            </div>
                            <input type="text" class="form-control" name="option-3">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox" name="tick-4">
                                </span>
                            </div>
                            <input type="text" class="form-control" name="option-4">
                        </div>
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
@endforeach

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
            <form method="post" action="{{ route('admin-test-parts-store') }}" enctype="multipart/form-data">
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
                        <input type="file" class="form-control" name="image-1">
                        <input type="file" class="form-control" name="image-2">
                        <input type="file" class="form-control" name="image-3">
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
    });
</script>
@endsection
