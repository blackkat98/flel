@extends('layouts.admin')

@section('title')
    @lang('Details of') {{ $course->name }}
@endsection

@section('header')
@lang('Details of') {{ $course->name }} (@lang('Code'): {{ $course->code }})
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
                    <a href="{{ route('admin-courses-list') }}" class="btn btn-default col-2">
                        <i class="fa fa-arrow-left"></i> @lang('Back to') @lang('List')
                    </a>
                    <button class="btn btn-success col-2" data-toggle="modal" data-target="#form-edit-course-{{ $course->id }}">
                        <i class="fa fa-edit"></i> @lang('Edit')
                    </button>
                    <button class="btn btn-danger col-2" data-toggle="modal" data-target="#form-delete-course-{{ $course->id }}">
                        <i class="fa fa-trash"></i> @lang('Delete')
                    </button>
                    <button class="btn btn-primary col-2" data-toggle="modal" data-target="#form-create-lesson">
                        <i class="fa fa-plus"></i> @lang('Create') @lang('Lesson')
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td> @lang('Language') </td>
                            <td> @lang('Creator') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ $course->language->name }} </td>
                            <td> {{ $course->user->name }} </td>
                            <td> {{ $course->created_at }} </td>
                            <td> {{ $course->updated_at }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($lessons as $lesson)
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header bg-success">
                <h3 class="card-title md-2"> #{{ $lesson->number }}: {{ $lesson->name }} </h3>
            </div>
            <div class="card-header row">
                <button class="btn btn-outline-success col-1" data-toggle="modal" data-target="#form-edit-lesson-{{ $lesson->id }}">
                    <i class="fa fa-edit"></i> @lang('Edit')
                </button>
                <button class="btn btn-outline-danger col-1" data-toggle="modal" data-target="#form-delete-lesson-{{ $lesson->id }}">
                    <i class="fa fa-trash"></i> @lang('Delete')
                </button>
            </div>
            <div class="card-body">
                <div class="row border-bottom">
                    <div class="col-5 text-left">
                        <h5><b>@lang('Lecture')</b></h5>
                    </div>
                    <div class="col-7">
                        <h5><b>@lang('Images') + @lang('Sound') + @lang('Video')</b></h5>
                    </div>
                </div>
                <div class="row border-top">
                    <div class="col-5 border-right">
                        {!! $lesson->lecture !!}
                    </div>
                    <div class="col-7 border-left">
                        <div class="row"> 
                            @if ($lesson->images)
                                @foreach ($lesson->images as $image)
                                    <img class="w-25" src="{{ asset($image) }}" alt="">
                                @endforeach
                            @endif
                        </div>
                        <br>
                        <div class="row">
                            @if ($lesson->sound)
                                <audio class="w-100" controls>
                                    <source src="{{ asset($lesson->sound) }}">
                                </audio>
                            @endif
                        </div>
                        <br>
                        <div class="row">
                            @if ($lesson->video)
                                <video class="w-100" controls>
                                    <source src="{{ asset($lesson->video) }}">
                                </video>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-edit-lesson-{{ $lesson->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-lessons-update', ['id' => $lesson->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit') {{ $lesson->name }}?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number">
                            @lang('Number')*
                        </label>
                        <input type="number" min="1" max="250" id="number" class="form-control" name="number" value="{{ $lesson->number }}">
                    </div>
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name" value="{{ $lesson->name }}">
                    </div>
                    <div class="form-group">
                        <label for="lecture">
                            @lang('Lecture')*
                        </label>
                        <textarea id="lecture" class="form-control js-editor" name="lecture">{{ $lesson->lecture }}</textarea>
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="form-delete-lesson-{{ $lesson->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-lessons-delete', ['id' => $lesson->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete') {{ $lesson->name }}?</h4>
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
@endforeach

<div class="modal fade" id="form-edit-course-{{ $course->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-courses-update', ['id' => $course->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit') {{ $course->code }}?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name" value="{{ $course->name }}">
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

<div class="modal fade" id="form-delete-course-{{ $course->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-courses-delete', ['id' => $course->id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete') {{ $course->code }}?</h4>
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

<div class="modal fade" id="form-create-lesson">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin-lessons-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create') @lang('Lesson')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="form-group">
                        <label for="number">
                            @lang('Number')*
                        </label>
                        <input type="number" min="1" max="250" id="number" class="form-control" name="number">
                    </div>
                    <div class="form-group">
                        <label for="name">
                            @lang('Name')*
                        </label>
                        <input id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="lecture">
                            @lang('Lecture')*
                        </label>
                        <textarea id="lecture" class="form-control js-editor" name="lecture"></textarea>
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
        $('.js-editor').summernote();
    });
</script>
@endsection