@extends('layouts.admin')

@section('title')
    @lang('Tutor Contacts') 
@endsection

@section('header')
@lang('Data Table of all') @lang('Tutor Contacts') 
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
                            <td> @lang('Image') </td>
                            <td> @lang('Language') </td>
                            <td> @lang('Email') </td>
                            <td> @lang('Phone') </td>
                            <td> @lang('Extra') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td> {{ $contact->name }} </td>
                                <td>
                                    @if ($contact->image)
                                        <img class="img-size-32" src="{{ $contact->image }}" alt="">
                                    @endif
                                </td>
                                <td> {{ $contact->language->name }} </td>
                                <td> {{ $contact->email }} </td>
                                <td> {{ $contact->phone }} </td>
                                <td> {{ $contact->extra }} </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $contact->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $contact->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-{{ $contact->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-tutor-contacts-update', ['id' => $contact->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') {{ $contact->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">
                                                                @lang('Name')*
                                                            </label>
                                                            <input id="name" class="form-control" name="name" value="{{ $contact->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">
                                                                @lang('Email')*
                                                            </label>
                                                            <input id="email" class="form-control" name="email" value="{{ $contact->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone">
                                                                @lang('Phone')
                                                            </label>
                                                            <input id="phone" class="form-control" name="phone" value="{{ $contact->phone }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="image">
                                                                @lang('Image')
                                                            </label>
                                                            <input type="file" id="image" class="form-control" name="image">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Language')*
                                                            </label>
                                                            <select class="form-control" name="language_id">
                                                                @foreach ($languages as $language)
                                                                    @if ($contact->language_id == $language->id)
                                                                        <option value="{{ $language->id }}" selected> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                    @else
                                                                        <option value="{{ $language->id }}"> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="location">
                                                                @lang('Location')
                                                            </label>
                                                            <input id="location" class="form-control" name="location" value="{{ $contact->location }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="extra">
                                                                @lang('Extra')
                                                            </label>
                                                            <textarea id="extra" class="form-control" name="extra" maxlength="500">
                                                                {{ $contact->extra }}
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
                                    
                                    <div class="modal fade" id="form-delete-{{ $contact->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-tutor-contacts-delete', ['id' => $contact->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $contact->name }}?</h4>
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
            <form method="post" action="{{ route('admin-tutor-contacts-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Tutor Contacts') </h4>
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
                        <label for="email">
                            @lang('Email')*
                        </label>
                        <input id="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">
                            @lang('Phone')
                        </label>
                        <input id="phone" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="image">
                            @lang('Image')
                        </label>
                        <input type="file" id="image" class="form-control" name="image">
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
                        <label for="location">
                            @lang('Location')
                        </label>
                        <input id="location" class="form-control" name="location">
                    </div>
                    <div class="form-group">
                        <label for="extra">
                            @lang('Extra')
                        </label>
                        <textarea id="extra" class="form-control" name="extra" maxlength="500"></textarea>
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




