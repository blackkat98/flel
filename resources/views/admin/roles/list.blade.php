@extends('layouts.admin')

@section('title')
    @lang('Roles')
@endsection

@section('header')
@lang('Data Table of all') @lang('Roles')
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
                            <td> @lang('Guard Name') </td>
                            <td> @lang('Permissions') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Last update') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td> {{ $role->name }} </td>
                                <td> {{ $role->guard_name }} </td>
                                <td>
                                    <ul>
                                        @foreach ($role->permissions as $permission)
                                            <li> {{ $permission->name }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td> {{ $role->created_at }} </td>
                                <td> {{ $role->updated_at }} </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-{{ $role->id }}">
                                        <i class="far fa-edit text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $role->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-{{ $role->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-roles-update', ['id' => $role->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') {{ $role->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">
                                                                @lang('Name')*
                                                            </label>
                                                            <input id="name" class="form-control" name="name" value="{{ $role->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                @foreach ($permissions as $permission)
                                                                    @if (in_array($permission->id, $role->permissions->pluck('id')->toArray()))
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="perm-on-edit-{{ $permission->id }}-{{ $role->id }}" class="form-check-input" name="permission-{{ $permission->id }}" checked>
                                                                                <label for="perm-on-edit-{{ $permission->id }}-{{ $role->id }}" class="form-check-label text-bold"> {{ $permission->name }} </label>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="perm-on-edit-{{ $permission->id }}-{{ $role->id }}" class="form-check-input" name="permission-{{ $permission->id }}">
                                                                                <label for="perm-on-edit-{{ $permission->id }}-{{ $role->id }}" class="form-check-label text-bold"> {{ $permission->name }} </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
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
                                    
                                    <div class="modal fade" id="form-delete-{{ $role->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-roles-delete', ['id' => $role->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $role->name }}?</h4>
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
            <form method="post" action="{{ route('admin-roles-store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Roles')</h4>
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
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="perm-on-create-{{ $permission->id }}" class="form-check-input" name="permission-{{ $permission->id }}">
                                        <label for="perm-on-create-{{ $permission->id }}" class="form-check-label text-bold"> {{ $permission->name }} </label>
                                    </div>
                                </div>
                            @endforeach
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


