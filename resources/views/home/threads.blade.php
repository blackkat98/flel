@extends('layouts.home')

@section('title')
    @lang('Threads')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Threads')</legend>
            <ul>
                @foreach ($threads as $thread)
                    <li>
                        <h3>
                            <a href="{{ route('home-thread-show', ['code' => $thread->code]) }}">
                                @if ($thread->attendee->id == Auth::user()->id)
                                    <i class="fa fa-file"></i> @lang('Conversation') @lang('With') @lang('Tutor'): {{ $thread->tutor->tutorContact->real_name }} @lang('At') {{ $thread->created_at }}
                                @else
                                    <i class="fa fa-file"></i> @lang('Conversation') @lang('With'): {{ $thread->attendee->name }} @lang('At') {{ $thread->created_at }}
                                @endif
                            </a>
                        </h3>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
</div>
@endsection

@section('js')

@endsection