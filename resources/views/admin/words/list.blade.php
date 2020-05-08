@extends('layouts.admin')

@section('title')
    @lang('Words')
@endsection

@section('header')
@lang('Data Table of all') @lang('Words')
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
                            <td> @lang('Word') </td>
                            <td> @lang('Category') </td>
                            <td> @lang('IPA') </td>
                            <td> @lang('Pronunciation') </td>
                            <td> @lang('Definition') </td>
                            <td> @lang('Example') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($words as $word)
                            <tr>
                                <td> {{ $word->word }} </td>
                                <td> {{ $word->wordCategory->name }} ({{ $word->wordCategory->language->slug }}) </td>
                                <td> {{ $word->ipa }} </td>
                                <td>
                                    @if ($word->pronunciation)
                                        <audio controls>
                                            <source src="{{ $word->pronunciation }}">
                                        </audio>
                                    @endif
                                </td>
                                <td> {{ $word->definition }} </td>
                                <td> {{ $word->example }} </td>
                                <td> {{ $word->created_at }} </td>
                                <td> {{ $word->updated_at }} </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $word->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $word->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>

                                    <div class="modal fade" id="form-edit-{{ $word->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-words-update', ['id' => $word->id]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') {{ $word->word }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Word')
                                                            </label>
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <select style="width: 100%;" class="form-control js-select2" name="word_category_id">
                                                                        @foreach ($word_categories as $word_category)
                                                                            @if ($word->word_category_id == $word_category->id)
                                                                                <option value="{{ $word_category->id }}" selected> {{ $word_category->name }} ({{ $word_category->language->name }}) </option>
                                                                            @else
                                                                                <option value="{{ $word_category->id }}"> {{ $word_category->name }} ({{ $word_category->language->name }}) </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input class="form-control" name="word" placeholder="@lang('Word')" value="{{ $word->word }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <input class="form-control" name="ipa" placeholder="@lang('IPA')*" value="{{ $word->ipa }}">
                                                                </div>
                                                                <div class="col-7">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-music"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="file" class="form-control" name="pronunciation">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <textarea class="form-control" name="definition" placeholder="@lang('Definition')*">{{ $word->definition }}</textarea>
                                                                </div>
                                                                <div class="col-6">
                                                                    <textarea class="form-control" name="example" placeholder="@lang('Example')">{{ $word->example }}</textarea>
                                                                </div>
                                                            </div>
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

                                    <div class="modal fade" id="form-delete-{{ $word->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-words-delete', ['id' => $word->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $word->word }}?</h4>
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
            <form method="post" action="{{ route('admin-words-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Words')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            @lang('Word')
                        </label>
                        <div class="row">
                            <div class="col-5">
                                <select style="width: 100%;" class="form-control js-select2" name="word_category_id">
                                    @foreach ($word_categories as $word_category)
                                        <option value="{{ $word_category->id }}"> {{ $word_category->name }} ({{ $word_category->language->name }}) </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-7">
                                <input class="form-control" name="word" placeholder="@lang('Word')*">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <input class="form-control" name="ipa" placeholder="@lang('IPA')*">
                            </div>
                            <div class="col-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-music"></i>
                                        </span>
                                    </div>
                                    <input type="file" class="form-control" name="pronunciation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <textarea class="form-control" name="definition" placeholder="@lang('Definition')*"></textarea>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control" name="example" placeholder="@lang('Example')"></textarea>
                            </div>
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

        $('.js-select2').select2();
    });
</script>
@endsection


