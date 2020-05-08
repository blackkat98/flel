@extends('layouts.admin')

@section('title')
    @lang('Details of') {{ $test->name }}
@endsection

@section('header')
@lang('Details of') {{ $test->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
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
                    <form class="col-2" method="post" action="{{ route('admin-tests-available', ['id' => $test->id]) }}">
                        @csrf
                        <button class="btn btn-default col-12">
                            @if ($test->is_available == 1)
                                <b class="text-success"> @lang('Shown') </b>
                            @else
                                <b class="text-danger"> @lang('Hidden') </b>
                            @endif
                        </button>
                    </form>
                    <button class="btn btn-danger col-2" data-toggle="modal" data-target="#form-delete-test-{{ $test->id }}">
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

@for ($i = 0; $i < count($test_parts); $i++)
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header bg-success">
                <h3 class="card-title md-2"> {{ $test_parts[$i]->name }} </h3>
            </div>
            <div class="card-header row">
                <button class="btn btn-outline-success col-1" data-toggle="modal" data-target="#form-edit-test-part-{{ $test_parts[$i]->id }}">
                    <i class="fa fa-edit"></i> @lang('Edit')
                </button>
                <button class="btn btn-outline-danger col-1" data-toggle="modal" data-target="#form-delete-test-part-{{ $test_parts[$i]->id }}">
                    <i class="fa fa-trash"></i> @lang('Delete')
                </button>
                <button class="btn btn-outline-primary col-2" data-toggle="modal" data-target="#form-create-test-quiz-{{ $test_parts[$i]->id }}">
                    <i class="fa fa-plus"></i> @lang('Create') @lang('Test Quiz')
                </button>
            </div>
            <div class="card-body">
                <div class="row border-bottom">
                    <div class="col-2 text-center text-bold">
                        @lang('Description')
                    </div>
                    <div class="col-10">
                        @if ($test_parts[$i]->description)
                            {{ $test_parts[$i]->description }}
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
                        @if (!$test_parts[$i]->images || count($test_parts[$i]->images) == 0)
                            <i> @lang('Not provided') </i>
                        @else
                            <div class="row">
                                @foreach ($test_parts[$i]->images as $image)
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
                        @if ($test_parts[$i]->sound)
                            <audio class="w-100" controls>
                                <source src="{{ asset($test_parts[$i]->sound) }}">
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
                        @if ($test_parts[$i]->video)
                            <video class="w-100" controls>
                                <source src="{{ asset($test_parts[$i]->video) }}">
                            </video>
                        @else
                            <i> @lang('Not provided') </i>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-striped js-quizzes">
                            <thead>
                                <tr>
                                    <td> @lang('Number') </td>
                                    <td> @lang('Associated with') </td>
                                    <td> @lang('Type') </td>
                                    <td> @lang('Question') + @lang('Essay') </td>
                                    <td> @lang('Images') + @lang('Sound') + @lang('Video') </td>
                                    <td> @lang('Options') </td>
                                    <td> @lang('Answer') </td>
                                    <td> @lang('Actions') </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes_in_parts[$i] as $quiz)
                                    <tr>
                                        <td> {{ $quiz->number }} </td>
                                        <td> {{ $quiz->getAssociatedNumber() }} </td>
                                        <td>
                                            @foreach ($quiz_types as $key => $value)
                                                @if ($key == $quiz->quiz_type)
                                                    {{ $value }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <b class="text-success"> (Q:) {{ $quiz->question }} </b>
                                            {!! $quiz->essay !!}
                                        </td>
                                        <td>
                                            @if ($quiz->images)
                                                @foreach ($quiz->images as $image)
                                                    <img style="width: 128px;" src="{{ asset($image) }}" alt=""><br>
                                                @endforeach
                                            @endif

                                            @if ($quiz->sound)
                                                <audio class="w-100" controls>
                                                    <source src="{{ asset($quiz->sound) }}">
                                                </audio>
                                            @endif
                                            <br>
                                            @if ($quiz->video)
                                                <video class="w-100" controls>
                                                    <source src="{{ asset($quiz->video) }}">
                                                </video>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($quiz->options)
                                                @foreach ($quiz->options as $key => $value)
                                                    <b> {{ $key }} </b>: {{ $value }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($quiz->answer as $key => $value)
                                                &bull; <b> {{ $value }} </b><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-test-quiz-{{ $quiz->id }}">
                                                <i class="far fa-edit text-success"></i>
                                            </button>
                                            <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-test-quiz-{{ $quiz->id }}">
                                                <i class="far fa-trash-alt text-danger"></i>
                                            </button>

                                            <div class="modal fade" id="form-edit-test-quiz-{{ $quiz->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="{{ route('admin-test-quizzes-update', ['id' => $quiz->id]) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('Edit') @lang('Test Quiz') ({{ $quiz->number }})</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="number">
                                                                        @lang('Number')*
                                                                    </label>
                                                                    <input type="number" min="1" max="250" id="number" class="form-control" name="number" value="{{ $quiz->number }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        @lang('Associated with')*
                                                                    </label>
                                                                    <select class="form-control" name="associated_quiz_id">
                                                                        <option value="0"> @lang('No quiz') </option>
                                                                        @foreach ($quizzes_in_parts[$i] as $t_quiz)
                                                                            @if ($quiz->associated_quiz_id == $t_quiz->id)
                                                                                <option value="{{ $t_quiz->id }}" selected> {{ $t_quiz->number }} </option>
                                                                            @else
                                                                                <option value="{{ $t_quiz->id }}"> {{ $t_quiz->number }} </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        @lang('Type')*
                                                                    </label>
                                                                    <select class="form-control" name="quiz_type">
                                                                        @foreach ($quiz_types as $key => $value)
                                                                            @if ($quiz->quiz_type == $key)
                                                                                <option value="{{ $key }}" selected> {{ $value }} </option>
                                                                            @else
                                                                                <option value="{{ $key }}"> {{ $value }} </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="question">
                                                                        @lang('Question')*
                                                                    </label>
                                                                    <textarea class="form-control" rows="2" name="question">{{ $quiz->question }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="essay">
                                                                        @lang('Essay')
                                                                    </label>
                                                                    <textarea class="form-control js-editor" name="essay">{{ $quiz->essay }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        @lang('Images')
                                                                    </label>
                                                                    <input type="file" class="form-control" name="image-1">
                                                                    <input type="file" class="form-control" name="image-2">
                                                                    <input type="file" class="form-control" name="image-3">
                                                                    <input type="file" class="form-control" name="image-4">
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
                                                                <div class="form-group">
                                                                    <label>
                                                                        @lang('Options')/@lang('Answer') (Max 10)
                                                                    </label>
                                                                    @for ($j = 1; $j < 11; $j++)
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <input type="checkbox" name="check-{{ $j }}">
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="opt-{{ $j }}">
                                                                        </div>
                                                                    @endfor
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

                                            <div class="modal fade" id="form-delete-test-quiz-{{ $quiz->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="{{ route('admin-test-quizzes-delete', ['id' => $quiz->id]) }}">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('Delete') {{ $quiz->number }}?</h4>
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
    </div>
</div>

<div class="modal fade" id="form-create-test-quiz-{{ $test_parts[$i]->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-test-quizzes-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create') @lang('Test Quiz') ({{ $test_parts[$i]->name }})</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="test_part_id" value="{{ $test_parts[$i]->id }}">
                    <div class="form-group">
                        <label for="number">
                            @lang('Number')*
                        </label>
                        <input type="number" min="1" max="250" id="number" class="form-control" name="number">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Associated with')*
                        </label>
                        <select class="form-control" name="associated_quiz_id">
                            <option value="0"> @lang('No quiz') </option>
                            @foreach ($quizzes_in_parts[$i] as $quiz)
                                <option value="{{ $quiz->id }}"> {{ $quiz->number }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Type')*
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
                        <textarea class="form-control" rows="2" name="question"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="essay">
                            @lang('Essay')
                        </label>
                        <textarea class="form-control js-editor" name="essay"></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Images')
                        </label>
                        <input type="file" class="form-control" name="image-1">
                        <input type="file" class="form-control" name="image-2">
                        <input type="file" class="form-control" name="image-3">
                        <input type="file" class="form-control" name="image-4">
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
                    <div class="form-group">
                        <label>
                            @lang('Options')/@lang('Answer') (Max 10)
                        </label>
                        @for ($j = 1; $j < 11; $j++)
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <input type="checkbox" name="check-{{ $j }}">
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="opt-{{ $j }}">
                            </div>
                        @endfor
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

<div class="modal fade" id="form-edit-test-part-{{ $test_parts[$i]->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-test-parts-update', ['id' => $test_parts[$i]->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit') @lang('Test Part') ({{ $test_parts[$i]->name }})</h4>
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
                        <input id="name" class="form-control" name="name" value="{{ $test_parts[$i]->name }}">
                    </div>
                    <div class="form-group">
                        <label for="description">
                            @lang('Description')
                        </label>
                        <textarea id="description" class="form-control" name="description">{{ $test_parts[$i]->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Images')
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

<div class="modal fade" id="form-delete-test-part-{{ $test_parts[$i]->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-test-parts-delete', ['id' => $test_parts[$i]->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete') @lang('Test Part') ({{ $test_parts[$i]->name }})</h4>
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
@endfor

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
<script src="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.table.table-bordered.table-striped.js-quizzes').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });

        $('.js-editor').summernote();
    });
</script>
@endsection
