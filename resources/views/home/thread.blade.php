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
                    <fieldset id="js-conversation-fieldset" style="background-color: #f0e68c; height: 400px; overflow-y: scroll;" class="form-border">
                        @if ($thread->attendee->id == Auth::user()->id)
                            <legend class="form-border">@lang('With') @lang('Tutor'): {{ $thread->tutor->tutorContact->real_name }}</legend>
                        @else
                            <legend class="form-border">@lang('With'): {{ $thread->attendee->name }}</legend>
                        @endif
                        <div class="row">
                            <div id="js-conversation-pane" class="col-md-12">
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
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-7">
                    <fieldset id="js-workspace-fieldset" style="background-color: #f0e68c; height: 400px;" class="form-border">
                        <legend class="form-border">@lang('Workspace')</legend>
                        <div style="height: 100%;" class="row">
                            <div id="js-workspace-pane" style="height: 100%; background-color: #ffffff; color: #000000;" class="col-md-12" contenteditable="true">
                                {!! $thread->sheet !!}
                            </div>
                        </div>
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
                                    <i class="fa fa-paper-plane"></i> @lang('Send')
                                </button>
                            </form>
                        @endif
                    </fieldset>
                </div>

                <div class="col-md-7">
                    <fieldset class="form-border">
                        @if (Auth::user()->id == $thread->tutor_id)
                            <div class="row">
                                <button id="js-highlight-good-btn" class="btn btn-success">
                                    @lang('Highlight') @lang('Good')
                                </button>
                                <button id="js-highlight-bad-btn" class="btn btn-warning">
                                    @lang('Highlight') @lang('Bad')
                                </button>
                                <button id="js-highlight-error-btn" class="btn btn-danger">
                                    @lang('Highlight') @lang('Error')
                                </button>
                            </div>
                            <br>
                            <div class="row">
                                <button id="js-clear-good-btn" class="btn btn-default">
                                    <b class="text-success">@lang('Clear') @lang('Good')</b>
                                </button>
                                <button id="js-clear-bad-btn" class="btn btn-default">
                                    <b class="text-warning">@lang('Clear') @lang('Bad')</b>
                                </button>
                                <button id="js-clear-error-btn" class="btn btn-default">
                                    <b class="text-danger">@lang('Clear') @lang('Error')</b>
                                </button>
                                <button id="js-clear-highlight-btn" class="btn btn-default">
                                    <b class="text-info">@lang('Clear') @lang('Highlight')</b>
                                </button>
                            </div>
                            <br>
                            <div class="row">
                                <button id="js-mark-comment-btn" class="btn btn-default">
                                    <b style="color: #660066;">@lang('Mark as Comment')</b>
                                </button>
                                <button id="js-delete-comment-btn" class="btn btn-default">
                                    <b style="color: #660066;">@lang('Clear Comment')</b>
                                </button>
                            </div>
                            <br>
                        @else
                            <h5>@lang('Color code')</h5>
                            <ul>
                                <li style="color: #00cc00;">@lang('Good')</li>
                                <li style="color: #ff9900;">@lang('Bad')</li>
                                <li style="color: #ff0000;">@lang('Error')</li>
                                <li style="color: #660066;">@lang('Comment')</li>
                            </ul>
                        @endif
                        <div class="row">
                            <button id="js-sheet-update-btn" class="btn btn-success">
                                @lang('Update')
                            </button>
                        </div>
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

        socket.on('update_chat', function (data) {
            if (parseInt('{{ Auth::check() == 1 }}') !== 1) {
                return;
            }

            var thread_id = parseInt('{{ $thread->id }}');
            var auth_id = parseInt('{{ Auth::check() ? Auth::user()->id : 0 }}');

            if (parseInt(data.thread_id) !== thread_id) {
                return;
            }

            if (parseInt(data.sender_user_id) === auth_id) {
                $('#js-conversation-pane').append(`
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div style="background-color: #3578e5; color: #ffffff; border-radius: 5px;" class="col-md-10">
                            ${data.message}
                        </div>
                    </div>
                    <br>
                `);
            } else {
                $('#js-conversation-pane').append(`
                    <div class="row">
                        <div style="background-color: #cccccc; color: #000000; border-radius: 5px;" class="col-md-10">
                            ${data.message}
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <br>
                `);
            }

            $('#js-conversation-fieldset').scrollTop($('#js-conversation-pane').height());
        });

        socket.on('update_thread_sheet', function (data) {
            var thread_id = parseInt('{{ $thread->id }}');

            if (parseInt(data.id) !== thread_id) {
                return;
            }

            $('#js-workspace-pane').html(data.sheet);
        });

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
                        socket.emit('new_chat', received_data.chat);
                        socket.emit('new_chat_noti', received_data.chat_noti);
                        $('textarea[name="message"]').val('');
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

        $(document).on('click', '#js-sheet-update-btn', function () {
            var html_txt = $('#js-workspace-pane').get(0).innerHTML;
            var url = '{{ route('home-thread-update-sheet-ajax', ['id' => $thread->id]) }}';
            var workspace_data = {
                _token: '{{ csrf_token() }}',
                sheet: html_txt
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: workspace_data,
                success: function (received_data) {
                    socket.emit('thread_sheet_changed', received_data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });

        $('#js-highlight-good-btn').click( function() {
            var text = warpBy('em');
            $('em').css({"background": "#00cc00", "color": "#ffffff", "font-weight": "bold"});
        });

        $('#js-highlight-bad-btn').click( function() {
            var text = warpBy('span');
            $('span').css({"background": "#ff9900", "color": "#ffffff", "font-weight": "bold"});
        });

        $('#js-highlight-error-btn').click( function() {
            var text = warpBy('mark');
            $('mark').css({"background": "#ff0000", "color": "#ffffff", "font-weight": "bold"});
        });

        $('#js-clear-good-btn').click( function() {
            for (var dom of $('em')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }
        });

        $('#js-clear-bad-btn').click( function() {
            for (var dom of $('span')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }
        });

        $('#js-clear-error-btn').click( function() {
            for (var dom of $('mark')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }
        });

        $('#js-clear-highlight-btn').click( function() {
            for (var dom of $('em')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }

            for (var dom of $('span')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }

            for (var dom of $('mark')) {
                var text = $(dom).text();
                $(dom).replaceWith(text);
            }
        });

        $('#js-mark-comment-btn').click( function() {
            var text = warpBy('abbr');
            $('abbr').css({"background": "#660066", "color": "#ffffff", "font-weight": "bold"});
        });

        $('#js-delete-comment-btn').click( function() {
            for (var dom of $('abbr')) {
                $(dom).replaceWith(``);
            }
        });

        function warpBy(tag_type)
        {
            try {
                if (window.ActiveXObject) {
                    var c = document.selection.createRange();
                    return c.htmlText;
                }
            
                var nNd = document.createElement(tag_type);
                var w = getSelection().getRangeAt(0);
                w.surroundContents(nNd);

                return nNd.innerHTML;
            } catch (e) {
                if (window.ActiveXObject) {
                    return document.selection.createRange();
                } else {
                    return getSelection();
                }
            }
        }

        $('#js-conversation-fieldset').scrollTop($('#js-conversation-pane').height());
    });
</script>
@endsection