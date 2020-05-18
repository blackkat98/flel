@extends('layouts.admin')

@section('title')
    @lang('Word Categories')
@endsection

@section('header')
@lang('Data Table of all') @lang('Word Categories')
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
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($word_categories as $cate)
                            <tr>
                                <td> {{ $cate->name }} </td>
                                <td> {{ $cate->language->name }} </td>
                                <td> {{ $cate->created_at }} </td>
                                <td> {{ $cate->updated_at }} </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $cate->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $cate->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-{{ $cate->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-word-categories-update', ['id' => $cate->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') {{ $cate->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">
                                                                @lang('Name')*
                                                            </label>
                                                            <input id="name" class="form-control" name="name" value="{{ $cate->name }}">
                                                        </div>
                                                        <select class="form-control" name="language_id">
                                                            @foreach ($languages as $language)
                                                                @if ($cate->language_id == $language->id)
                                                                    <option value="{{ $language->id }}" selected> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                @else
                                                                    <option value="{{ $language->id }}"> {{ $language->name }} ({{ $language->slug }}) </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                                                        <button type="submit" class="btn btn-success">@lang('Update')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="form-delete-{{ $cate->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-word-categories-delete', ['id' => $cate->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $cate->name }}?</h4>
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
            <form method="post" action="{{ route('admin-word-categories-store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Word Categories')</h4>
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


