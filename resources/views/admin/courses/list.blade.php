@extends('layouts.admin')

@section('title')
    @lang('Courses')
@endsection

@section('header')
@lang('Data Table of all') @lang('Courses')
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
                            <td> @lang('Code') </td>
                            <td> @lang('Language') </td>
                            <td> @lang('Creator') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                            <td> @lang('Status') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td> {{ $course->name }} </td>
                                <td> {{ $course->code }} </td>
                                <td> {{ $course->language->name }} </td>
                                <td> {{ $course->user->name }} </td>
                                <td> {{ $course->created_at }} </td>
                                <td> {{ $course->updated_at }} </td>
                                <td>
                                    <form method="post" action="{{ route('admin-courses-available', ['id' => $course->id]) }}">
                                        @csrf
                                        <button class="btn btn-default">
                                            @if ($course->is_available == 1)
                                                <b class="text-success"> @lang('Shown') </b>
                                            @else
                                                <b class="text-danger"> @lang('Hidden') </b>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin-courses-show', ['id' => $course->id]) }}" class="btn btn-outline">
                                        <i class="far fa-eye text-primary"></i>
                                    </a>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $course->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $course->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-{{ $course->id }}">
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
                                                        <div class="form-group">
                                                            <label for="description">
                                                                @lang('Description')
                                                            </label>
                                                            <textarea id="description" class="form-control" name="description">
                                                                {{ $course->description }}
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
                                    
                                    <div class="modal fade" id="form-delete-{{ $course->id }}">
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
            <form method="post" action="{{ route('admin-courses-store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Courses')</h4>
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
                                <option value="{{ $language->id }}"> {{ $language->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">
                            @lang('Description')
                        </label>
                        <textarea id="description" class="form-control" name="description"></textarea>
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
        $('#js-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        $('textarea').summernote();

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




