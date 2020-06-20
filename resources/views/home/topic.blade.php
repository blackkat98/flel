@extends('layouts.home')

@section('title')
    @lang('Topic'): {{ $p_topic->title }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border" style="background-color: #f0e68c;">
            <legend class="form-border"></legend>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="form-border">
                        <legend class="form-border">
                            <strong id="js-topic-status-text">
                                @if ($p_topic->is_open == 1)
                                    <h3 class="text-success">@lang('Open')</h3>
                                @else
                                    <h3 class="text-danger">@lang('Close')</h3>
                                @endif
                            </strong>
                        </legend>
                        <div class="col-md-2">
                            <img class="img-thumbnail" src="{{ asset($p_topic->user->image) }}" alt="">
                            <h5 class="text-center">{{ $p_topic->user->name }}</h5>
                        </div>
                        <div class="col-md-10">
                            <h3>{{ $p_topic->title }}</h3>
                            <i>
                                <b>@lang('Since')</b> {{ $p_topic->created_at }} - <b>@lang('Last update')</b> {{ $p_topic->updated_at }}
                            </i>
                            <p class="text-justify">{!! $p_topic->content !!}</p>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2">
                                
                            </div>
                            @if (Auth::check() && Auth::user()->id == $p_topic->user_id)
                                <div class="col-md-10">
                                    <form id="js-topic-status-change">
                                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                        <button id="js-topic-status-btn" type="button" class="btn btn-default col-md-2">
                                            <b id="js-topic-status-btn-txt" class="{{ $p_topic->is_open == 1 ? 'text-danger' : 'text-success' }}">
                                                {{ $p_topic->is_open == 1 ? __('Close') : __('Open') }}
                                            </b>
                                        </button>
                                    </form>
                                    <a href="{{ route('home-topic-edit', ['language_slug' => $p_language->slug, 'id' => $p_topic->id]) }}" class="btn btn-success col-md-2">
                                        @lang('Edit')
                                    </a>
                                    <form method="post" action="{{ route('home-topic-delete', [$p_topic->id]) }}">
                                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                        <button type="submit" class="btn btn-danger col-md-2">
                                            <b>@lang('Delete')</b>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </fieldset>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border"></legend>
            <div class="row" id="js-replies">
                @foreach ($p_replies as $reply)
                    <div id="js-reply-pane-{{ $reply->id }}" class="col-md-12">
                        <fieldset class="form-border">
                            <legend class="form-border"></legend>
                            <div id="js-reply-appr-sign-{{ $reply->id }}" class="col-md-1 text-center">
                                @if ($reply->is_approved)
                                    <i style="font-size: 64px; color: #006400" class="fa fa-star"></i>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <img class="img-thumbnail" src="{{ asset($reply->user->image) }}" alt="">
                                <h5 class="text-center">{{ $reply->user->name }}</h5>
                            </div>
                            <div class="col-md-9">
                                @if ($reply->parent != null)
                                    <div style="border: 2px dashed #00008b" class="col-md-12">
                                        @lang('Reply to') <b>{{ $reply->parent->user->name }}</b>:
                                        <br>
                                        <h3>"</h3>
                                            <i>{!! $reply->parent->content !!}</i><br>
                                        <h3 style="float: right;">"</h3>
                                    </div>
                                @endif
                                &nbsp;
                                <p class="text-justify">{!! $reply->content !!}</p>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-9"> 
                                    @if (Auth::check() && Auth::user()->id == $p_topic->user_id)
                                        <form id="js-reply-appr-{{ $reply->id }}">
                                            <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                            <input class="hidden" name="id" value="{{ $reply->id }}" readonly>
                                            <button type="button" class="btn btn-default col-md-2 js-reply-appr-btn">
                                                <b>@lang('Approve')</b>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-9"> 
                                    @if (Auth::check() && Auth::user()->id == $reply->user_id)
                                        <form id="js-reply-delete-{{ $reply->id }}">
                                            <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                            <input class="hidden" name="id" value="{{ $reply->id }}" readonly>
                                            <button type="button" class="btn btn-danger col-md-2 js-reply-delete-btn">
                                                @lang('Delete')
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-9"> 
                                    <form id="js-reply-to-{{ $reply->id }}">
                                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                        <input class="hidden" name="reply_id" value="{{ $reply->id }}" readonly>
                                        <input class="hidden" name="topic_id" value="{{ $p_topic->id }}" readonly>
                                        <input class="col-md-11" name="content">
                                        <button type="button" class="btn btn-outline col-md-1 js-reply-to-btn">
                                            <i style="color: #0000ff;" class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                @endforeach
            </div>
        </fieldset>
    </div>

    @auth
        <div id="js-rep-create-form-field" class="col-md-12 {{ $p_topic->is_open == 1 ? '' : 'hidden' }}">
            <fieldset class="form-border">
                <legend class="form-border">@lang('Your Reply')</legend>
                <form id="js-rep-create" class="form-horizontal">
                    <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>

                    <input class="hidden" name="topic_id" value="{{ $p_topic->id }}" readonly>

                    <input class="hidden" name="reply_id" value="0" readonly>

                    <div class="form-group row">
                        <textarea class="js-editor form-control" name="content"></textarea>
                    </div>

                    <div class="form-group row">
                        <i class="col-md-12 text-muted">@lang('Add a File')</i>
                        <div class="col-md-12">
                            <input type="file" class="form-control" name="attachment">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <button id="js-rep-create-btn" type="button" class="btn btn-primary col-md-12">
                                @lang('Create')
                            </button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    @else

    @endauth
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

        socket.on('add_reply', function (data) {
            if (parseInt('{{ Auth::check() == 1 }}') !== 1) {
                return;
            }
            
            var page_topic_id = parseInt('{{ $p_topic->id }}');
            var page_topic_user_id = parseInt('{{ $p_topic->user->id }}');
            var auth_id = parseInt('{{ Auth::check() ? Auth::user()->id : 0 }}');
            var approve_txt = '{{ __('Approve') }}';
            var delete_txt = '{{ __('Delete') }}';
            var parent_txt = '{{ __('Reply to') }}';

            if (auth_id === page_topic_user_id) {
                var approve_form = `
                    <div class="col-md-12">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-9"> 
                            <form id="js-reply-appr-${data.id}">
                                <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                <input class="hidden" name="id" value="${data.id}" readonly>
                                <button type="button" class="btn btn-default col-md-2 js-reply-appr-btn">
                                    <b>${approve_txt}</b>
                                </button>
                            </form>
                        </div>
                    </div>
                `;
            } else {
                var approve_form = ``;
            }

            if (auth_id === parseInt(data.user_id)) {
                var crud = `
                    <div class="col-md-12">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-9"> 
                            <form id="js-reply-delete-${data.id}">
                                <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                <input class="hidden" name="id" value="${data.id}" readonly>
                                <button type="button" class="btn btn-danger col-md-2 js-reply-delete-btn">
                                    ${delete_txt}
                                </button>
                            </form>
                        </div>
                    </div>
                `;
            } else {
                var crud = ``;
            }

            if (data.parent !== null) {
                var parent = `
                    <div style="border: 2px dashed #00008b" class="col-md-12">
                        ${parent_txt} <b>${data.parent_owner.name}</b>:
                        <br>
                        <h3>"</h3>
                            <i>${data.parent.content}</i><br>
                        <h3 style="float: right;">"</h3>
                    </div>
                `;
            } else {
                var parent = ``;
            }

            if (page_topic_id === parseInt(data.topic_id)) {
                $('#js-replies').append(`
                    <div id="js-reply-pane-${data.id}" class="col-md-12">
                        <fieldset class="form-border">
                            <legend class="form-border"></legend>
                            <div id="js-reply-appr-sign-${data.id}" class="col-md-1">

                            </div>
                            <div class="col-md-2">
                                <img class="img-thumbnail" src="${domain}/${data.user.image}" alt="">
                                <h5 class="text-center">${data.user.name}</h5>
                            </div>
                            <div class="col-md-9">
                                ${parent}
                                &nbsp;
                                <p class="text-justify">${data.content}</p>
                            </div>
                            ${approve_form}
                            ${crud}
                            <div class="col-md-12">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-9"> 
                                    <form id="js-reply-to-${data.id}">
                                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                        <input class="hidden" name="reply_id" value="${data.id}" readonly>
                                        <input class="hidden" name="topic_id" value="${page_topic_id}" readonly>
                                        <input class="col-md-11" name="content">
                                        <button type="button" class="btn btn-outline col-md-1 js-reply-to-btn">
                                            <i style="color: #0000ff;" class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                `);
            }
        });

        socket.on('update_topic_status', function (data) {
            var page_topic_id = parseInt('{{ $p_topic->id }}');
            var open_txt = '{{ __('Open') }}';
            var close_txt = '{{ __('Close') }}';
            var content = parseInt(data.is_open) === 1 ? `<h3 class="text-success">${open_txt}</h3>` : `<h3 class="text-danger">${close_txt}</h3>`;
            var btn_txt = parseInt(data.is_open) === 1 ? `<b id="js-topic-status-btn-txt" class="text-danger">${close_txt}</b>` : `<b id="js-topic-status-btn-txt" class="text-success">${open_txt}</b>`;

            if (page_topic_id === parseInt(data.id)) {
                $('#js-topic-status-text').html(content);
                $('#js-topic-status-btn-txt').replaceWith(btn_txt);

                if (parseInt(data.is_open) === 0) {
                    $('#js-rep-create-form-field').addClass('hidden');
                } else {
                    $('#js-rep-create-form-field').removeClass('hidden');
                }
            }
        });

        socket.on('update_reply_status', function (data) {
            if (data.is_approved == 1) {
                $('#js-reply-appr-sign-' + data.id).html(`
                    <i style="font-size: 64px; color: #006400" class="fa fa-star"></i>
                `);
            } else {
                $('#js-reply-appr-sign-' + data.id).html(``);
            }
        });

        socket.on('delete_reply', function (data) {
            $('#js-reply-pane-' + data.id).remove();
        });

        $('.js-editor').summernote();

        $('#js-rep-create-btn').on('click', function () {
            var url = '{!! route('home-reply-store-ajax') !!}';
            var form_data = new FormData($('#js-rep-create')[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        socket.emit('new_reply', received_data.reply);
                        $('.note-editable').html(``).css('height', '100px');
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

        $('#js-topic-status-btn').on('click', function () {
            var url = '{{ route('home-topic-available-ajax', ['id' => $p_topic->id]) }}';
            var form_data = new FormData($('#js-topic-status-change')[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        socket.emit('topic_status_changed', received_data.topic);
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

        $(document).on('click', '.js-reply-appr-btn', function () {
            var url = '{{ route('home-reply-approve-ajax') }}';
            var form_data = new FormData($(this).parent()[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        socket.emit('reply_approved', received_data.reply);
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

        $(document).on('click', '.js-reply-delete-btn', function () {
            var url = '{{ route('home-reply-delete-ajax') }}';
            var form_data = new FormData($(this).parent()[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        socket.emit('reply_deleted', received_data.reply);
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

        $(document).on('click', '.js-reply-to-btn', function () {
            var url = '{{ route('home-reply-store-ajax') }}';
            var form_data = new FormData($(this).parent()[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                processData: false,
                contentType: false,
                success: function (received_data) {
                    if (received_data.status === 'successful') {
                        socket.emit('new_reply', received_data.reply);
                        $('input[name="content"]').val('');
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