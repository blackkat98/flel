@extends('layouts.admin')

@section('title')
    @lang('Users')
@endsection

@section('header')
@lang('Data Table of all') @lang('Users')
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
                            <td> @lang('Email') </td>
                            <td> @lang('Roles') </td>
                            <td> (@lang('Additional')) @lang('Permissions') </td>
                            <td> @lang('Image') </td>
                            <td> @lang('Since') </td>
                            <td> @lang('Actions') </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td>
                                    <ul>
                                        @foreach ($user->roles as $role)
                                            <li> {{ $role->name }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($user->permissions as $permission)
                                            <li> {{ $permission->name }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <img class="img-size-64" src="{{ asset($user->image) }}" alt="">
                                </td>
                                <td> {{ $user->created_at }} </td>
                                <td>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-roles-{{ $user->id }}">
                                        <i class="fa fa-smile text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-edit-permissions-{{ $user->id }}">
                                        <i class="fa fa-wheelchair text-success"></i>
                                    </button>
                                    <button class="btn btn-outline" data-toggle="modal" data-target="#form-delete-{{ $user->id }}">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="form-edit-roles-{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-users-update-roles', ['id' => $user->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') @lang('Roles'): {{ $user->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>
                                                                @lang('Roles')
                                                            </label>
                                                            <div class="row">
                                                                @foreach ($roles as $role)
                                                                    @if (in_array($role->id, $user->roles->pluck('id')->toArray()))
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="role-on-update-{{ $role->id }}-{{ $user->id }}" class="form-check-input" name="role-{{ $role->id }}" checked>
                                                                                <label for="role-on-update-{{ $role->id }}-{{ $user->id }}" class="form-check-label text-bold"> {{ $role->name }} </label>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="role-on-update-{{ $role->id }}-{{ $user->id }}" class="form-check-input" name="role-{{ $role->id }}">
                                                                                <label for="role-on-update-{{ $role->id }}-{{ $user->id }}" class="form-check-label text-bold"> {{ $role->name }} </label>
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

                                    <div class="modal fade" id="form-edit-permissions-{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-users-update-permissions', ['id' => $user->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Edit') (@lang('Additional')) @lang('Permissions'): {{ $user->name }}?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group border-bottom">
                                                            <label>
                                                                (@lang('Existing')) @lang('Permissions') @lang('In') @lang('Roles')
                                                            </label>
                                                            <div class="row">
                                                                @foreach ($user->getPermissionsViaRoles()->unique('name') as $perm)
                                                                    <div class="col-4 text-bold">
                                                                        &bull; {{ $perm->name }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="form-group border-top">
                                                            <label>
                                                                @lang('Permissions')
                                                            </label>
                                                            <div class="row">
                                                                @foreach ($permissions as $permission)
                                                                    @if (in_array($permission->id, $user->permissions->pluck('id')->toArray()))
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="permission-on-update-{{ $permission->id }}-{{ $user->id }}" class="form-check-input" name="permission-{{ $permission->id }}" checked>
                                                                                <label for="permission-on-update-{{ $permission->id }}-{{ $user->id }}" class="form-check-label text-bold"> {{ $permission->name }} </label>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" id="permission-on-update-{{ $permission->id }}-{{ $user->id }}" class="form-check-input" name="permission-{{ $permission->id }}">
                                                                                <label for="permission-on-update-{{ $permission->id }}-{{ $user->id }}" class="form-check-label text-bold"> {{ $permission->name }} </label>
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
                                    
                                    <div class="modal fade" id="form-delete-{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin-users-delete', ['id' => $user->id]) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('Delete') {{ $user->name }}?</h4>
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
            <form method="post" action="{{ route('admin-users-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Create a new instance in') @lang('Users')</h4>
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
                        <label for="password">
                            @lang('Password')*
                        </label>
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="image">
                            @lang('Image')
                        </label>
                        <input type="file" id="image" class="form-control" name="image">
                    </div>
                    <div class="form-group">
                        <label>
                            @lang('Roles')
                        </label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="role-on-create-{{ $role->id }}" class="form-check-input" name="role-{{ $role->id }}">
                                        <label for="role-on-create-{{ $role->id }}" class="form-check-label text-bold"> {{ $role->name }} </label>
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


