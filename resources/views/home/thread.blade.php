@extends('layouts.home')

@section('title')
	@lang('Thread'): @lang('Conversation') @lang('With') {{ $thread->tutor->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Thread') @lang('Code'): <i class="text-success">{{ $thread->code }}</i></legend>

            <div class="row">
                <div class="col-md-5">
                    <fieldset style="background-color: #f0e68c; height: 400px;" class="form-border">
                        @if ($thread->attendee->id == Auth::user()->id)
                            <legend class="form-border">@lang('With') @lang('Tutor'): {{ $thread->tutor->tutorContact->real_name }}</legend>
                        @else
                            <legend class="form-border">@lang('With'): {{ $thread->attendee->name }}</legend>
                        @endif
                        <div class="row">
                            <div id="js-conversation-pane" class="col-md-11" style="overflow-y: auto; overflow-x: hidden;">
                                @foreach ($chats as $chat)
                                    @if ($chat->sender_user_id == Auth::user()->id)
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div style="background-color: #3578e5; color: #ffffff; border-radius: 5px;" class="col-md-10">
                                                {{ $chat->message }}
                                            </div>
                                        </div>
                                        <br>
                                    @else
                                        <div class="row">
                                            <div style="background-color: #cccccc; color: #000000; border-radius: 5px;" class="col-md-10">
                                                {{ $chat->message }}
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-7">
                    <fieldset style="background-color: #f0e68c; height: 400px;" class="form-border">
                        <legend class="form-border">@lang('Workspace')</legend>
                    </fieldset>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <fieldset class="form-border">
                        @if ($thread->status == 0)
                            <form id="js-chat-form" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input class="hidden" name="thread_id" value="{{ $thread->id }}">
                                <textarea class="form-control" name="message"></textarea>
                                <button id="js-chat-btn" type="button" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </form>
                        @endif
                    </fieldset>
                </div>
            </div>
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

        $(document).on('click', '#js-chat-btn', function () {
            var url = '{{ route('home-chat-store-ajax') }}';
            var form_data = new FormData($('#js-chat-form')[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        console.log(received_data.chat);
                        socket.emit('new_chat', received_data.chat);
                        $('textarea[name="message"]').val('');
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection