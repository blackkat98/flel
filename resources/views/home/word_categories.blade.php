@extends('layouts.home')

@section('title')
    @lang('Words') @lang('In') {{ $p_language->name }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/adminlte3/dist/css/all.min.css') }}">
@endsection

@section('content')
<audio id="js-reader" controls style="display: none;">
    <source src="">
</audio>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            @foreach ($p_word_categories as $category)
                <div class="col-md-12">
                    <fieldset class="form-border">
                        <legend id="category-header-{{ $category->id }}" class="form-border">{{ $category->name }}</legend>

                        @foreach ($p_words[$category->id] as $word)
                            <div class="row">
                                <div class="col-md-2"><b>{{ $word->word }}</b></div>
                                <div class="col-md-2">
                                    <ul>
                                        @foreach ($word_types as $key => $value)
                                            @if (in_array($key, $word->word_type))
                                                <li>({{ $value }})</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    {{ $word->ipa }}<br>
                                    <button id="js-listen-{{ $word->id }}" class="btn btn-outline">
                                        <i class="fa fa-volume-up"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    @if ($word->pronunciation)
                                        <audio controls>
                                            <source src="{{ $word->pronunciation }}">
                                        </audio>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    
                                </div>
                                <div class="col-md-3">
                                    <b>{{ $word->definition }}</b>
                                    <br>
                                    @if ($word->example)
                                        <i>
                                            <i class="fa fa-asterisk"></i> @lang('Example'):
                                            <br>
                                            {{ $word->example }}
                                        </i>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    
                                </div>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-3">
        <fieldset class="form-border">
            <legend class="form-border">@lang('Word Categories')</legend>
            <ul>
                @foreach ($p_word_categories as $category)
                    <li>
                        <a href="#category-header-{{ $category->id }}">
                            <i class="fa fa-caret-right"></i> <b>{{ $category->name }}</b>
                        </a>
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>
</div>
@endsection

@section('js')
<script>
    console.log('{{ config('more_hosts.py_host') }}')
</script>
@foreach ($p_word_categories as $category)
    @foreach ($p_words[$category->id] as $word)
        <script>
            $('#js-listen-' + '{{ $word->id }}').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '{{ config('more_hosts.py_host') }}' + 'read/' + '{{ $word->word }}',
                    dataType: 'json',
                    success: function (s) {
                        var file_path = s.mp3_file;
                        var audio_source = '{{ config('more_hosts.py_domain') }}' + file_path;

                        $('#js-reader').replaceWith(`
                            <audio id="js-reader" controls style="display: none;">
                                <source src="${audio_source}">
                            </audio>
                        `);

                        $('#js-reader').trigger('play');
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
            });
        </script>
    @endforeach
@endforeach
@endsection