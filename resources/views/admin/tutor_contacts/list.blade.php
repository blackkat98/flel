@extends('layouts.admin')

@section('title')
    @lang('Tutor Contacts') 
@endsection

@section('header')
@lang('Data Table of all') @lang('Tutor Contacts') 
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/select2/css/select2.min.css') }}">
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
                            <td> @lang('Name') (@lang('Real Name')) </td>
                            <td> @lang('Image') </td>
                            <td> @lang('Language') </td>
                            <td> @lang('Email') + @lang('Phone') </td>
                            <td> @lang('Social Networks') </td>
                            <td> @lang('Experiences') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>
                                    {{ $contact->user->name }} ({{ $contact->real_name }})
                                </td>
                                <td>
                                    <img class="img-size-32" src="{{ asset($contact->user->image) }}" alt="">
                                </td>
                                <td> {{ $contact->language->name }} </td>
                                <td>
                                    {{ $contact->user->email }} <br> {{ $contact->phone }}
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($contact->social_networks as $key => $value)
                                            <li>
                                                <b>{{ $key }}</b>: <a href="{{ $value }}">{{ $value }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td> {{ $contact->experiences }} </td>
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
                                                            <label>
                                                                @lang('User')*
                                                            </label>
                                                            <select class="form-control row js-select2" style="width: 100%;" name="user_id">
                                                                @foreach ($users as $user)
                                                                    @if ($contact->user_id == $user->id)
                                                                        <option value="{{ $user->id }}" selected>
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">
                                                                @lang('Real Name')*
                                                            </label>
                                                            <input id="real_name" class="form-control" name="real_name" value="{{ $contact->real_name }}">
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
                                                            <label for="phone">
                                                                @lang('Phone')
                                                            </label>
                                                            <input id="phone" class="form-control" name="phone" value="{{ $contact->phone }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Social Networks')
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <img class="img-size-32" src="{{ asset('img/facebook.png') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <input class="form-control" name="socnet_fb" value="{{ $contact->social_networks['facebook'] }}">
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <img class="img-size-32" src="{{ asset('img/twitter.png') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <input class="form-control" name="socnet_tw" value="{{ $contact->social_networks['twitter'] }}">
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <img class="img-size-32" src="{{ asset('img/google_plus.png') }}" alt="">
                                                                    </span>
                                                                </div>
                                                                <input class="form-control" name="socnet_gp" value="{{ $contact->social_networks['google_plus'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="experiences">
                                                                @lang('Experiences')
                                                            </label>
                                                            <textarea id="experiences" class="form-control" name="experiences" maxlength="500">{{ $contact->experiences }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="location">
                                                                @lang('Location')
                                                            </label>
                                                            <input id="location" class="form-control" name="location" value="{{ $contact->location }}">
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
                        <label>
                            @lang('User')*
                        </label>
                        <select class="form-control row js-select2" style="width: 100%;" name="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">
                            @lang('Real Name')*
                        </label>
                        <input id="real_name" class="form-control" name="real_name">
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
                        <label for="phone">
                            @lang('Phone')
                        </label>
                        <input id="phone" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Social Networks')
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <img class="img-size-32" src="{{ asset('img/facebook.png') }}" alt="">
                                </span>
                            </div>
                            <input class="form-control" name="socnet_fb">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <img class="img-size-32" src="{{ asset('img/twitter.png') }}" alt="">
                                </span>
                            </div>
                            <input class="form-control" name="socnet_tw">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <img class="img-size-32" src="{{ asset('img/google_plus.png') }}" alt="">
                                </span>
                            </div>
                            <input class="form-control" name="socnet_gp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="experiences">
                            @lang('Experiences')
                        </label>
                        <textarea id="experiences" class="form-control" name="experiences" maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">
                            @lang('Location')
                        </label>
                        <input id="location" class="form-control" name="location">
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
<script src="{{ asset('bower_components/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
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

        $('.js-select2').select2({
            theme: 'bootstrap4'
        });

        if ('{!! session()->get('success') !!}' !== '') {
            toastr.success('{!! session()->get('success') !!}');
        }

        if ('{!! session()->get('error') !!}' !== '') {
            toastr.error('{!! session()->get('error') !!}');
        }

        if ('{!! session()->get('warning') !!}' !== '') {
            toastr.warning('{!! session()->get('warning') !!}');
        }

        var form_validation_errors = {!! json_encode($errors->toArray(), JSON_HEX_TAG) !!};
        
        for (var key in form_validation_errors) {
            toastr.warning(form_validation_errors[key][0]);
        }
    });
</script>
@endsection




