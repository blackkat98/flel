@extends('layouts.home')

@section('title')
    @lang('Tutor Contacts') @lang('In') {{ $p_language->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Tutor Contacts') @lang('In') {{ $p_language->name }}</legend>
            @foreach ($p_tutors as $tutor)
                <div class="row">
                    <div class="col-md-2">
                        <img class="img-thumbnail" src="{{ asset($tutor->user->image) }}" alt="">
                    </div>
                    <div class="col-md-4">
                        <h3>{{ $tutor->real_name }}</h3>
                        <p>({{ $tutor->user->name }})</p>
                        <i class="fa fa-phone"></i> {{ $tutor->phone }}<br>
                        <i class="fa fa-commenting"></i> {{ $tutor->user->email }}
                    </div>
                    <div class="col-md-4">
                        @foreach ($tutor->social_networks as $key => $value)
                            <b><i>{{ $key }}</i></b>:<br>
                            {{ $value }}
                            @if ($value == '')
                                @lang('Not provided')
                            @endif
                            <br>
                        @endforeach
                    </div>
                    <div class="col-md-2 text-center">
                        @if ($tutor->user->isOnline())
                            <p class="text-success">
                                <i class="fa fa-circle"></i> @lang('Online')
                            </p>
                        @else
                            <p class="text-danger">
                                <i class="fa fa-circle"></i> @lang('Offline')
                            </p>
                        @endif
                        <form id="js-chat-start-form-{{ $tutor->user->id }}">
                            @csrf
                            <input class="hidden" name="tutor_id" value="{{ $tutor->user->id }}">
                            <button type="button" id="js-chat-start-btn-{{ $tutor->user->id }}" class="btn btn-primary row js-chat-start-btn">
                                @lang('Start') @lang('Conversation')
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var socket = io('http://localhost:6001');

        socket.on('test_socket', function (data) {
            console.log(data);
        });

        var domain = window.location.origin;

        $(document).on('click', '.js-chat-start-btn', function () {
            var url = '{{ route('home-thread-store-ajax') }}';
            var form_data = new FormData($(this).parent()[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    socket.emit('new_thread', received_data.noti_to_tutor);

                    window.location.replace(received_data.noti_to_tutor.link);
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection